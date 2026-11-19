<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\HomeModel;
use App\Models\RecruiterModel;

// namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DateTime;

class Cron extends BaseController
{
    public function sendVacancyMail()
    {
         // 🔐 SECURITY CHECK
        if ($this->request->getGet('key') !== 'adis123') {
            exit('Unauthorized');
        }
        date_default_timezone_set('Asia/Kolkata');
        $db = db_connect();
        $today = date('Y-m-d');

        // ✅ LIMIT CONTROL
        $limitPerRun = 5;
        $count = 0;

        // Fetch latest 5 open & published jobs
        $jobs = $db->table('tbl_recruiter_posting')
            ->select('tbl_recruiter_posting.*, cities.name AS city_name, tbl_job_role.job_role')
            ->join('cities', 'cities.id = tbl_recruiter_posting.city_id', 'left')
            ->join('tbl_job_role', 'tbl_job_role.job_id = tbl_recruiter_posting.job_id', 'left')
            ->where('tbl_recruiter_posting.admin_status', 'Open')
            ->where('tbl_recruiter_posting.status', 'Publish')
            ->orderBy('tbl_recruiter_posting.posting_id', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $candidateJobs = [];

        // Map candidates to jobs (LOGIC SAME)
        foreach ($jobs as $job) {

            $referenceDate = (!empty($job['last_mail_sent_date']) && $job['last_mail_sent_date'] != '0000-00-00')
                ? date('Y-m-d', strtotime($job['last_mail_sent_date']))
                : date('Y-m-d', strtotime($job['created_date']));

            $nextMailDate = date('Y-m-d', strtotime($referenceDate . ' +1 days'));

            if ($today == $nextMailDate && $job['mail_sent'] == 0) {

                $candidates = $db->table('tbl_jobseeker')
                    ->where('job_id', $job['job_id'])
                    ->where('profile_status', 'active')
                    ->get()
                    ->getResultArray();

                foreach ($candidates as $candidate) {
                    $email = $candidate['email'];
                    $candidateJobs[$email]['candidateName'] = $candidate['full_name'];
                    $candidateJobs[$email]['jobs'][] = $job;
                }
            }
        }

        // ✅ Send one email per candidate (WITH LIMIT + DELAY)
        foreach ($candidateJobs as $email => $data) {

            if ($count >= $limitPerRun) break;

            $this->sendMailToCandidates($data['candidateName'], $email, $data['jobs']);
            $count++;

            sleep(10); // ✅ VERY IMPORTANT (Spam avoid)
        }

        // ✅ Update DB after sending
        foreach ($candidateJobs as $data) {
            foreach ($data['jobs'] as $job) {
                $db->table('tbl_recruiter_posting')
                    ->where('posting_id', $job['posting_id'])
                    ->update([
                        'mail_sent' => 1,
                        'last_mail_sent_date' => $today
                    ]);
            }
        }
    }

    private function sendMailToCandidates($candidateName, $email, $jobs)
    {
        require_once APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require_once APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require_once APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');

            // ✅ SECURE PASSWORD (.env मधून)
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');

            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email, $candidateName);

            $message = view('email/mailtemplate', [
                'candidateName' => $candidateName,
                'jobs' => $jobs
            ]);

            $mail->isHTML(true);
            $mail->Subject = "Top Job Alerts Matching Your Profile";
            $mail->Body    = $message;

            $mail->send();

            echo "Mail sent to: {$email}<br>";

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            echo "Mail Error for {$email}: " . $mail->ErrorInfo . "<br>";
        }
    }
}
