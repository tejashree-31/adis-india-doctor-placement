<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\JobseekerModel;
use App\Models\HomeModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\I18n\Time;
require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';
use DateTime;

class JobseekerController extends BaseController
{
    public function __construct()
    {
        // parent::__construct();
        $this->db = \Config\Database::connect(); // This connects once
    }
    public function index()
    {
        echo view('jobportal/header');
        echo view('jobportal/footer');
    }
    public function Saveloginform()
    {
        $jobseekerModel = new JobseekerModel();
        $db = \Config\Database::connect();

        $user_type = $this->request->getPost('user_type');
        $otp = $this->request->getPost('otp');
        $activation_code = $this->request->getPost('activation_code');
        $email = $this->request->getPost('email');
        
        // Set Indian timezone
        date_default_timezone_set('Asia/Kolkata');
       

        $email_result = $db->table('tbl_user')
                                ->where('email', $email)
                                ->whereIn('user_type', ['jobseekar', 'recruiter'])
                                ->get()
                                ->getResultArray();

        $existing_types = array_unique(array_column($email_result, 'user_type'));

        // ✅ CASE 1: Email exists with same user_type → update
            if (in_array($user_type, $existing_types) && count($existing_types) === 1) 
            {
                 $data1 = [
                            'user_type' => $user_type,
                            'otp' => $otp,
                            'activation_code' => $activation_code,
                            'email' => $email
                        ];
                $user_id = $email_result[0]['uid'];
                 $user_mobile = $email_result[0]['mobile_no'];
                // =========== jobseeker ======================
                
                $builder = $db->table('tbl_jobseeker');
                $jobseekar_form = $builder->where('uid', $user_id)->get()->getRow();

              if (!isset($jobseekar_full_name) || empty($jobseekar_full_name)) {
              
                    if ($jobseekar_form !== null) {
                        $jobseekar_full_name = $jobseekar_form->full_name;
                    } else {
                        $jobseekar_full_name = ''; // or some default value
                    }
                }

                $jobseekerModel->userupdateDeatails($user_id, $data1);
               
                session()->set([
                        'uid' =>$user_id,
                        'jobseeker_email' => $email,
                        'jobseeker_mobile' => $user_mobile,
                        'jobseeker_user_type' => $user_type,
                        'jobseeker_otp' => $otp,
                        'jobseeker_activation_code' =>$activation_code,
                        'jobseekar_full_name'=>$jobseekar_full_name
                    ]);
                $this->sendOtpMail($email, $otp, $activation_code, $user_type);
                return redirect()->to('jobseeker/job_login_otp');
            }
            elseif (!empty($existing_types)) 
            {
                session()->setFlashdata('error', '❌ Email already registered with another user type.');
                return redirect()->back();
            } 
            else 
            {
                $data = [
                'user_type' => $user_type,
                'otp' => $otp,
                'activation_code' => $activation_code,
                'registered_date'=>date('Y-m-d'),
                'email' => $email
                 ];
                $user_id = $jobseekerModel->userDeatails($data);
                session()->set('uid', $user_id);

                $this->sendOtpMail($email, $otp, $activation_code, $user_type);
                return redirect()->to('jobseeker/job_login_otp');
            }
    }
    private function sendOtpMail($email, $otp, $activation_code, $user_type)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
            require APPPATH . 'Libraries/PHPMailer/SMTP.php';
            require APPPATH . 'Libraries/PHPMailer/Exception.php';
    
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');              // App Password
            $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
            $mail->Port       = 587;
    
            // ✅ ADD THIS BLOCK to disable SSL verification
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
    
            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verification code to verify your Email Address';
            $mail->Body = '
                <p>To verify your email, enter this OTP code: <b>' . $otp . '</b></p>
                <p>Sincerely,<br>Adis India Pvt Ltd</p>';
    
            if ($mail->send()) {
                session()->setFlashdata('message', '✅ OTP sent to your email. Please verify.');
                session()->set([
                    'jobseeker_email' => $email,
                    'jobseeker_user_type' => $user_type,
                    'jobseeker_otp' => $otp,
                    'jobseeker_activation_code' => $activation_code
                ]);
            } else {
                session()->setFlashdata('error', '❌ Mail could not be sent: ' . $mail->ErrorInfo);
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            session()->setFlashdata('error', '❌ Mail error: ' . $e->getMessage());
        }
    }
    public function job_login_otp()
    {
        $session = session();
        $email = session()->get('jobseeker_email');
        $otp = session()->get('jobseeker_otp');
        $uid = $session->get('uid');
        // print_r($session->get());
        // exit();
        return view('jobseeker/job_login_otp');
        // print_r($session->get());
    }
    // public function verify_jobseeker_otp()
    // {
    //     $session = session();
    //     $email = $session->get('jobseeker_email');
    //     $uid = $session->get('uid');
    //     $enteredOtp = $this->request->getPost('otp');
    //     if (!$email) {
    //         session()->setFlashdata('error', '❌ Session expired. Please try logging in again.');
    //         return redirect()->to('jobseeker/job_login_otp');
    //     }
    //     $db = \Config\Database::connect(); 
    //     $user = $db->table('tbl_user')->where('email', $email)->get()->getRowArray();
    //     $jobseeker_profile = $db->table('tbl_jobseeker')->where('uid', $uid)->get()->getRowArray();
    //     if ($user && $user['otp'] == $enteredOtp) {
    //         $name = $user['name'] ?? 'Jobseeker';
    //         $this->sendLoginSuccessMail($email, $name);
    //         $user_status = $user['login_status'] ?? '';
    //         $profile_status = $jobseeker_profile['profile_status'] ?? '';

    //         if ($user_status === 'active' && $profile_status === 'active') {
    //             return redirect()->to('jobseeker/jobseeker_profile');
    //         } else {
    //             return redirect()->to('jobseeker/jobseeker_form');
    //         }
    //     } else {
    //         session()->setFlashdata('error', '❌ Invalid OTP.');
    //         return redirect()->to('jobseeker/job_login_otp');
    //     }
    // }
    
    public function verify_jobseeker_otp()
    {
        $session = session();
        $email = $session->get('jobseeker_email');
        $uid = $session->get('uid');

        $enteredOtp = $this->request->getPost('otp');

        if (!$email) {
            session()->setFlashdata('error', '❌ Session expired. Please try logging in again.');
            return redirect()->to('jobseeker/job_login_otp');
        }

        $db = \Config\Database::connect(); 

        $user = $db->table('tbl_user')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        $jobseeker_profile = $db->table('tbl_jobseeker')
            ->where('uid', $uid)
            ->get()
            ->getRowArray();

        if ($user && trim($user['otp']) === trim($enteredOtp)) {

            // ✅ OTP VERIFIED → DB UPDATE (MAIN PART 🔥)
            $update = $db->table('tbl_user')
                ->where('email', $email)
                ->update([
                    'status' => 'active',
                    'otp' => ''
                   
                ]);

            if (!$update) {
                dd($db->error()); // debug if fails
            }

            // ✅ fresh updated data
            $user = $db->table('tbl_user')
                ->where('email', $email)
                ->get()
                ->getRowArray();

            $name = $user['name'] ?? 'Jobseeker';
            $this->sendLoginSuccessMail($email, $name);

            

            $user_status = $user['status'] ?? '';
            $profile_status = $jobseeker_profile['login_status'] ?? '';

            if ($user_status === 'active' && $profile_status === 'active') {
                return redirect()->to('jobseeker/jobseeker_profile');
            } else {
                return redirect()->to('jobseeker/jobseeker_form');
            }

        } else {
            session()->setFlashdata('error', '❌ Invalid OTP.');
            return redirect()->to('jobseeker/job_login_otp');
        }
    }
    private function sendLoginSuccessMail($email, $candidateName)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');  // Your Gmail
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                 // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
    
            // ✅ Add this block (same as sendOtpMail)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Login Verified - Welcome to Adis India Placement';

            $mail->Body = '
                <p>Hello <strong>' . htmlspecialchars($candidateName) . '</strong>,</p>
                <p>Your OTP has been successfully verified and you\'re now logged in to your <strong>Adis India Placement</strong> account.</p>
                <p>Start exploring new job opportunities tailored to your skills and interests. We wish you the very best in your career journey!</p>
                <p><em>Searching for new jobs? Best of luck for your future – great things await you!</em></p>
                <br>
                <p>Warm regards,<br><strong>Adis India Placement Team</strong></p>
            ';
    
            if ($mail->send()) {
                log_message('info', "Login success email sent to {$email}");
            } else {
                log_message('error', '❌ Mail send failed: ' . $mail->ErrorInfo);
            }

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        log_message('error', '❌ Mail error: ' . $e->getMessage());
    }
}
    public function jobseeker_form()
    {
         $session = session();
      
        if($session->has('jobseeker_email')) 
        {
            echo view('jobportal/header');
            echo view('jobseeker/jobseeker_form');
            echo view('jobportal/footer');
        } else 
        {
               return redirect()->to(base_url('jobseeker-login'));
        }
    }
    public function logout_jobseeker()
    {
        session()->destroy();
        session()->setFlashdata('message', 'You have been logged out successfully.');
        return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');
    }
    public function save_jobseeker_form()
    {
        $session = session();
         
        $db = \Config\Database::connect(); 
        $jobseekerModel = new JobseekerModel();
        $expectedCities = $this->request->getPost('expected_cities');
        $expectedCitiesString = is_array($expectedCities) ? implode(',', $expectedCities) : '';
        $job_role = $this->request->getPost('job_role');
        // $jobRoleString = is_array($job_role) ? implode(',', $job_role) : $job_role;
        $full_name = $this->request->getPost('full_name');
        $education = $this->request->getPost('education');
        $course = $this->request->getPost('course');
        $email = $this->request->getPost('email');
        $mobile_number = $this->request->getPost('mobile_number');
        $current_city = $this->request->getPost('current_city');
        $fellowship=$this->request->getPost('fellowship');
        $resumeFile   = $this->request->getFile('resume');
        // $resumeName = $resumeFile->getRandomName();
        $uid = $session->get('uid');
        
        $marital_status = $this->request->getPost('marital_status');
        $spouse_type    = $this->request->getPost('spouse_type');
        // ========  18-06-2026=========================
        $insurance_policy    = $this->request->getPost('insurance_policy');


        // ================================== 26-06-2026 ==================
        $cvOption   = $this->request->getPost('cv_option');
        $croppedImage = $this->request->getPost('candi_profile_cropped_image');
        $birth_date = $this->request->getPost('birth_date');
        $language_name = $this->request->getPost('language_name');
        $languageNameString = is_array($language_name) ? implode(',', $language_name) : '';
        $lire_id = $this->request->getPost('lire_id');
        $licen_registration_number = $this->request->getPost('licen_registration_number');
        $speci_id = $this->request->getPost('speci_id');
        $experience_years = $this->request->getPost('experience_years');
        $experience_months = $this->request->getPost('experience_months');
        $ug_id = $this->request->getPost('ug_id');
        $pg_id = $this->request->getPost('pg_id');
        $int_degree_id = $this->request->getPost('int_degree_id');
        $sup_id = $this->request->getPost('sup_id');
        $key_skills = $this->request->getPost('key_skills');
        $publications = $this->request->getPost('publications');
        $conference_attended = $this->request->getPost('conference_attended');
        // $resumeFile->move(FCPATH . 'jobseeker/resume/', $resumeName);
        $resumeFile = $this->request->getFile('resume');
        $linkdin_profile = $this->request->getPost('linkdin_profile');
        $linkedin_url    = $this->request->getPost('linkedin_url');

        // ================09/07/2026 ===================================//
        $hq_clg_name = $this->request->getPost('hq_clg_name');
        $hq_year_month = $this->request->getPost('hq_year_month');
        $ug_year_month = $this->request->getPost('ug_year_month');
        $ug_clg_name = $this->request->getPost('ug_clg_name');
        $pg_year_month = $this->request->getPost('pg_year_month');
        $pg_clg_name = $this->request->getPost('pg_clg_name');
        $iq_year_month = $this->request->getPost('iq_year_month');
        $iq_clg_name = $this->request->getPost('iq_clg_name');
        $gender = $this->request->getPost('gender');
        $candidate_full_address = $this->request->getPost('candidate_full_address');
         // echo "<pre>";
         //        print_r($_POST);
         //        exit();
        // ================09/07/2026 ===================================//
        $resumeName = NULL;
        $fileName   = NULL;

        if ($linkdin_profile == 'No') {
            $linkedin_url = NULL;
        }
        if ($cvOption == 'yes') {
            if (!$resumeFile || !$resumeFile->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Please upload your resume.');
            }

            $resumeName = $resumeFile->getRandomName();
            $resumeFile->move(FCPATH . 'jobseeker/resume/', $resumeName);
        }

       if (!empty($croppedImage)) {

            $croppedImage = str_replace('data:image/png;base64,', '', $croppedImage);
            $croppedImage = str_replace(' ', '+', $croppedImage);

            $imageData = base64_decode($croppedImage);

            // Uploaded file
            $profileImage = $this->request->getFile('candidate_job_profile');

            if ($profileImage && $profileImage->isValid()) {

                // Original file name without extension
                $originalName = pathinfo($profileImage->getClientName(), PATHINFO_FILENAME);

                // New file name
                $fileName = $originalName . '_' . time() . '.png';

                $uploadPath = FCPATH . 'jobseeker/candidate_job_profile/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                file_put_contents($uploadPath . $fileName, $imageData);
            }
        }
        $data = [
                
                'job_id'    =>$job_role,
                'full_name'       => $full_name,
                'education'   => $education,
                'course'      => $course,
                'email'           => $email,
                'gender'       => $gender,
                'mobile_number'   => $mobile_number,
                'current_city'    => $current_city,
                'expected_cities' => $expectedCitiesString,
                'fellowship'      => $fellowship,
                'resume'          => $resumeName,
                'marital_status' => $marital_status,
                'spouse_type'    => ($marital_status == 'Married') ? $spouse_type : NULL,
                'uid'=>$uid,
                'insurance_policy'=>$insurance_policy,
                //============26-06-2026===================//
                'cv_option'         => $cvOption,
                'candi_profile_cropped_image' => $fileName,
                'birth_date' => $birth_date,
                'language_name' => $languageNameString,
                'lire_id' => $lire_id,
                'licen_registration_number' => $licen_registration_number,
                'speci_id' => $speci_id,
                'experience_years' => $experience_years,
                'experience_months' => $experience_months,
                'ug_id' => $ug_id,
                'pg_id' => $pg_id,
                'int_degree_id' => $int_degree_id,
                'sup_id'        => $sup_id,
                'key_skills' => $key_skills,
                'publications' => $publications,
                'conference_attended' => $conference_attended,
                'linkdin_profile' => $linkdin_profile,
                'linkedin_url'    => $linkedin_url,
                // ============ 09/07/2026 ================//
                'hq_clg_name'  => $hq_clg_name,
                'hq_year_month'=> $hq_year_month,
                'ug_clg_name'  =>   $ug_clg_name,
                'ug_year_month'=> $ug_year_month,
                'pg_year_month'=> $pg_year_month,
                'pg_clg_name'=> $pg_clg_name,
                'iq_year_month'=> $iq_year_month,
                'iq_clg_name' =>$iq_clg_name,
                'candidate_full_address'=>$candidate_full_address,
                // ============ 09/07/2026 ================//
                'created_date'      => date('Y-m-d H:i:s')
             ];

        $uid_check = $db->table('tbl_jobseeker');
        $uid_result = $uid_check->where('uid',$uid)
          ->get()->getResultArray();
        if (!empty($uid_result)) 
        {
             return redirect()->to('jobseeker/jobseeker_form')->with('error', 'Candidate Alredy exsit!!');
             
        }else
        {
             $posting_data = $jobseekerModel->saveJobseekerForm($data);
                $jobseeker_id = $db->insertID();
                // echo $jobseeker_id;
            $db->table('tbl_user')
                ->where('uid', $uid)
                ->update([
                            'login_status'    => 'active',  // ✅ Add this line
                            'full_name'        => $full_name,
                            'job_id'        => $job_role

                ]);

            if ($posting_data) {

                // Experience save only for Premium CV
                if ($cvOption == 'no') {

                    //$jobseeker_id = $db->insertID();

                    $company_name      = $this->request->getPost('company_name');
                    $designation       = $this->request->getPost('designation');
                    $start_date        = $this->request->getPost('start_date');
                    $end_date          = $this->request->getPost('end_date');
                    $currently_working = $this->request->getPost('currently_working');
                    $job_description   = $this->request->getPost('job_description');

                    if (!empty($company_name)) {

                        foreach ($company_name as $key => $company) {

                            if (trim($company) == '') {
                                continue;
                            }

                            $db->table('tbl_jobseeker_experience')->insert([

                                'jobseeker_id'      => $jobseeker_id,
                                'company_name'      => $company,
                                'designation'       => $designation[$key] ?? '',
                                'start_date'        => $start_date[$key] ?? NULL,
                                'end_date'          => $end_date[$key] ?? NULL,
                                'currently_working' => $currently_working[$key] ?? 0,
                                'job_description'   => $job_description[$key] ?? '',
                                'created_at'        => date('Y-m-d H:i:s')

                            ]);
                        }
                    }
                }

                return redirect()->to('jobseeker/jobseeker_profile')
                                 ->with('success', 'Application submitted successfully!');
            }





            if ($posting_data) {
                return redirect()->to('jobseeker/jobseeker_profile')->with('success', 'Application submitted successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to submit. Try again.');
            }

        }
       

    }

    public function jobseeker_profile()
    {
        $session = session();
        if (!$session->has('jobseeker_email')) {
            return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');
        }
        $jobseekerModel = new JobseekerModel();
        $uid = $session->get('uid');
        $jobseekerData = $this->db->table('tbl_jobseeker')
            ->select('job_id')
            ->where('uid', $uid)
            ->get()
            ->getRowArray();

        if (empty($jobseekerData) || empty($jobseekerData['job_id'])) {
            $qualCoursSerchingData = [];
        } else {
            $job_ids = explode(',', $jobseekerData['job_id']); // e.g., [2,3]
            $qualCoursSerchingData = $jobseekerModel->getjobseekerSearchingDetailsEducationJobid($job_ids, $uid);
        }
        echo view('jobportal/jobseeker_header');
        echo view('jobseeker/jobseeker_profile', [
            'qualCoursSerchingData' => $qualCoursSerchingData
        ]);
        echo view('jobportal/footer');
    }
    public function update_jobseeker_profile()
    {
        $session = session();
        $db = \Config\Database::connect(); 
        $jobseekerModel = new JobseekerModel();
        if ($session->has('jobseeker_email')) 
        {
            $uid = $session->get('uid');
            $jobseeker_display=$jobseekerModel->jobseekerEdit($uid);
            $job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray();
            $qualifications = $db->query("SELECT * FROM tbl_qualification")->getResultArray();
            
            $builder = $db->table('tbl_jobseeker');
            $data_course = $builder
                ->select('tbl_jobseeker.course as course_id, tbl_course.course_name')
                ->join('tbl_course', 'tbl_course.course_id = tbl_jobseeker.course', 'left')
                ->where('tbl_jobseeker.uid', $uid)
                ->get()
                ->getRowArray();


            echo view('jobportal/jobseeker_header');
            echo view('jobseeker/update_jobseeker_profile',['qualifications'=>$qualifications,'job_role' => $job_role,'jobseeker_display'=>$jobseeker_display,'data_course'=>$data_course]);
            echo view('jobportal/footer');
        } else {
                // session not set
               return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');

        }
    }
    public function jobseeker_recruiter_profile($posting_id = null, $uid = null, $jobseeker_id = null, $recruiter_id = null)
    {
        $session = session();
        if ($session->has('jobseeker_email')) 
        {
            if ($posting_id) 
            {
               
                $db = \Config\Database::connect();
                $builder = $db->table('tbl_recruiter_posting');
                $builder->where('posting_id', $posting_id);
                $query = $builder->get();

                $posting = $query->getRowArray();

                $builder2 = $db->table('tbl_recruiter');
                $builder2->where('uid', $posting['user_id']); // uid is recruiter primary key
                $query2 = $builder2->get();
                $recruiter = $query2->getRowArray();

                $builder3 = $db->table('tbl_job_role');
                $builder3->where('job_id', $posting['job_id']); // uid is recruiter primary key
                $query3 = $builder3->get();
                $jobrole = $query3->getRowArray();

                $builder4 = $db->table('cities');
                $builder4->where('id', $posting['city_id']); // uid is recruiter primary key
                $query4 = $builder4->get();
                $cities = $query4->getRowArray();

                $builder5 = $db->table('tbl_qualification');
                $builder5->where('qual_id', $posting['qual_id']); // uid is recruiter primary key
                $query5 = $builder5->get();
                $qualification = $query5->getRowArray();

                $builder6 = $db->table('tbl_course');
                $builder6->where('course_id', $posting['course_id']); // uid is recruiter primary key
                $query6 = $builder6->get();
                $course = $query6->getRowArray();

                $data['posting']   = $posting;
                $data['recruiter'] = $recruiter;
                $data['jobrole'] = $jobrole;
                $data['cities'] =$cities;
                $data['qualification'] = $qualification;
                $data['course'] = $course;
                $data['posting_id'] = $posting_id;
                $data['uid'] = $uid;
                $data['jobseeker_id'] = $jobseeker_id;
                $data['recruiter_id'] = $recruiter_id;
                echo view('jobportal/jobseeker_header');
                echo view('jobseeker/jobseeker_recruiter_profile', $data);
                echo view('jobportal/footer');
            } 
            else 
            {
                return redirect()->to(base_url('jobseeker/jobseeker_profile'));
            }
        } 
        else 
        {
            
            return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');
        }
    }
    public function apply_job()
    {
        $session = session();
        $db = \Config\Database::connect();
        $user_id       = $this->request->getPost('user_id');
        $jobseeker_id  = $this->request->getPost('jobseeker_id');
        $posting_id    = $this->request->getPost('posting_id');
        $recruiter_id  = $this->request->getPost('recruiter_id');
    
        $jobseeker_full_name = $db->table('tbl_jobseeker')->select('full_name,email,job_id')->where('jobseeker_id',$jobseeker_id)->get()->getRow();

         $email = $jobseeker_full_name->email;
         $candidateName = $jobseeker_full_name->full_name;
         $job_id = $jobseeker_full_name->job_id;
    
         $jobrole_name = $db->table('tbl_job_role')->select('job_role')->where('job_id',$job_id)
                                ->get()->getRow();
         $job_role = $jobrole_name->job_role;                      
        //echo $db->getLastQuery();
         $recruiter_comapny_name = $db->table('tbl_recruiter')->select('company_display_name,created_date,recruiter_name')->where('recruiter_id',$recruiter_id)->get()->getRow();
    
        $r_company_name = $recruiter_comapny_name->company_display_name;
        // print_r($_POST);
        $intrested_posting_apply_date = Time::now('Asia/Kolkata')->toLocalizedString('d MMMM yyyy');
        $builder = $db->table('tbl_candidate_job_status');
    
        // Check if candidate already applied or saved
        $existing = $builder->where([
            'user_id'       => $user_id,
            'jobseeker_id'  => $jobseeker_id,
            'posting_id'    => $posting_id
        ])->get()->getRow();
    
        if ($existing) {
            if ($existing->candidate_status == 'Apply Job') {
                return redirect()->back()->with('error', 'You have already applied for this job.');
            } elseif ($existing->candidate_status == 'Save Job') {
                // Update the record to 'Apply Job'
                $builder->where('job_status_id', $existing->job_status_id) // assuming `id` is primary key
                        ->update([
                            'candidate_status' => 'Apply Job',
                            'applied_at'       => date('Y-m-d H:i:s')
                        ]);
    
                return redirect()->back()->with('success', 'Your application has been submitted.');
            }
        } else {
            // Insert new record
            $builder->insert([
                'user_id'          => $user_id,
                'jobseeker_id'     => $jobseeker_id,
                'posting_id'       => $posting_id,
                'recruiter_id'     => $recruiter_id,
                'candidate_status' => 'Apply Job',
                'applied_at'       => date('Y-m-d H:i:s')
            ]);
            $this->sendLoginfinalapplyposting($email,$candidateName,$job_role,$r_company_name,$intrested_posting_apply_date);
            return redirect()->back()->with('success', 'Your application has been submitted.');
        }
    }
    public function update_jobseeker()
    {
        $session = session();
        $db = \Config\Database::connect();
        $jobseekerModel = new JobseekerModel();

        $jobseeker_id = $this->request->getPost('jobseeker_id');
        $full_name = $this->request->getPost('full_name');
        $email = $this->request->getPost('email');
        $mobile_number = $this->request->getPost('mobile_number');
        $education = $this->request->getPost('education');
        $course = $this->request->getPost('course');
        $job_role = $this->request->getPost('job_role'); // array
        $current_city = $this->request->getPost('current_city');
        $expected_cities = $this->request->getPost('expected_cities'); // array
        $fellowship = $this->request->getPost('fellowship');

        // ============= 01-07-2026====================================
        $cv_option = $this->request->getPost('cv_option');
        // $candi_profile_cropped_image = $this->request->getPost('candi_profile_cropped_image');
        $insurance_policy = $this->request->getPost('insurance_policy');
        $birth_date   = $this->request->getPost('birth_date');
        $gender       = $this->request->getPost('gender');
        $language_name = $this->request->getPost('language_name');
        $language_name = !empty($language_name) ? implode(',', $language_name) : '';
        $lire_id                     = $this->request->getPost('lire_id');
        $licen_registration_number   = $this->request->getPost('licen_registration_number');
        $speci_id                    = $this->request->getPost('speci_id');
        $experience_years            = $this->request->getPost('experience_years');
        $experience_months           = $this->request->getPost('experience_months');
        $ug_id          = $this->request->getPost('ug_id');
        $pg_id          = $this->request->getPost('pg_id');
        $int_degree_id  = $this->request->getPost('int_degree_id');
        $sup_id         = $this->request->getPost('sup_id');
        $key_skills           = $this->request->getPost('key_skills');
        $publications         = $this->request->getPost('publications');
        $conference_attended  = $this->request->getPost('conference_attended');
        $linkdin_profile = $this->request->getPost('linkdin_profile');
        $linkedin_url    = $this->request->getPost('linkedin_url');
        $image = $this->request->getFile('candi_profile_image');
        $candidate_full_address = $this->request->getPost('candidate_full_address');
        $hq_clg_name = $this->request->getPost('hq_clg_name');
        $hq_year_month = $this->request->getPost('hq_year_month');
        $ug_year_month = $this->request->getPost('ug_year_month');
        $ug_clg_name = $this->request->getPost('ug_clg_name');
        $pg_year_month = $this->request->getPost('pg_year_month');
        $pg_clg_name = $this->request->getPost('pg_clg_name');
        $iq_year_month = $this->request->getPost('iq_year_month');
        $iq_clg_name = $this->request->getPost('iq_clg_name');
        $sup_year_month = $this->request->getPost('sup_year_month');
        
        // $photoName = $jobseeker_display['candi_profile_cropped_image'] ?? '';

       // जुना फोटो घ्या
        $oldPhoto = $db->table('tbl_jobseeker')
            ->select('candi_profile_cropped_image')
            ->where('jobseeker_id', $jobseeker_id)
            ->get()
            ->getRowArray();

        $photoName = $oldPhoto['candi_profile_cropped_image'] ?? '';

        // Hidden field मधून cropped image
        $croppedImage = $this->request->getPost('candi_profile_cropped_image');

        // नवीन image असेल तरच update
        if (!empty($croppedImage)) {

            $croppedImage = str_replace('data:image/png;base64,', '', $croppedImage);
            $croppedImage = str_replace(' ', '+', $croppedImage);

            $imageData = base64_decode($croppedImage);

            $profileImage = $this->request->getFile('candidate_job_profile');

            if ($profileImage && $profileImage->isValid()) {

                $originalName = pathinfo($profileImage->getClientName(), PATHINFO_FILENAME);
                $fileName = $originalName . '_' . time() . '.png';

                $uploadPath = FCPATH . 'jobseeker/candidate_job_profile/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // नवीन फोटो save
                file_put_contents($uploadPath . $fileName, $imageData);

                // जुना फोटो delete करा
                if (!empty($photoName) && file_exists($uploadPath . $photoName)) {
                    unlink($uploadPath . $photoName);
                }

                // नवीन फोटो DB मध्ये save होईल
                $photoName = $fileName;
            }
        }

        // Update data
        $updateData['candi_profile_cropped_image'] = $photoName;

        
        $marital_status = $this->request->getPost('marital_status');
        $spouse_type    = $this->request->getPost('spouse_type');
   
        $expected_cities_str = !empty($expected_cities) ? implode(',', $expected_cities) : '';

        // Handle resume upload
        $resumeFile = $this->request->getFile('resume');
        $resumeName = null;
        
        if ($resumeFile && $resumeFile->isValid() && !$resumeFile->hasMoved()) {

            $newName = $resumeFile->getRandomName();

            // ✅ CORRECT PATH
            $resumeFile->move(FCPATH . 'jobseeker/resume/', $newName);

            $resumeName = $newName;

        } else {

            // Keep old resume
            $oldResume = $db->table('tbl_jobseeker')
                ->select('resume')
                ->where('jobseeker_id', $jobseeker_id)
                ->get()
                ->getRow();

            $resumeName = $oldResume ? $oldResume->resume : null;
        }

        // Prepare data for update
        $updateData = [
            'full_name' => $full_name,
            'mobile_number' => $mobile_number,
            'education' => $education,
            'course' => $course,
            'job_id'=>$job_role,
            'current_city' => $current_city,
            'expected_cities' => $expected_cities_str,
            'fellowship' => $fellowship,
            'marital_status' => $marital_status,
            'spouse_type' => ($marital_status == 'Married') ? $spouse_type : NULL,
            'insurance_policy'            => $insurance_policy, // Add this
            'birth_date'                  => $birth_date,
            'gender'                      => $gender,
            'language_name'               => $language_name,
            'lire_id'                       => $lire_id,
            'ug_id'                         => $ug_id,
            'pg_id'                         => $pg_id,
            'int_degree_id'                 => $int_degree_id,
            'sup_id'                        => $sup_id,
            'licen_registration_number'     => $licen_registration_number,
            'speci_id'                      => $speci_id,
            'experience_years'              => $experience_years,
            'experience_months'             => $experience_months,
               // CKEditor fields
            'key_skills'                    => $key_skills,
            'publications'                  => $publications,
            'conference_attended'           => $conference_attended,
               // LinkedIn
            'linkdin_profile'               => $linkdin_profile,
            'linkedin_url'                  => $linkedin_url,
            'candidate_full_address'=>$candidate_full_address,
            'hq_clg_name'  => $hq_clg_name,
            'hq_year_month'=> $hq_year_month,
            'ug_clg_name'  =>   $ug_clg_name,
            'ug_year_month'=> $ug_year_month,
            'pg_year_month'=> $pg_year_month,
            'pg_clg_name'=> $pg_clg_name,
            'iq_year_month'=> $iq_year_month,
            'iq_clg_name' =>$iq_clg_name,
            'sup_year_month'=>$sup_year_month,
            'cv_option'         => $cv_option,   // <-- Add this
            'candi_profile_cropped_image' => $photoName,
            'resume' => $resumeName
        ];

        // Update database
        $db->table('tbl_jobseeker')->where('jobseeker_id', $jobseeker_id)->update($updateData);

        // =========================01-07-2026 ====================================

        $experience_id     = $this->request->getPost('experience_id');
            $company_name      = $this->request->getPost('company_name');
            $designation       = $this->request->getPost('designation');
            $start_date        = $this->request->getPost('start_date');
            $end_date          = $this->request->getPost('end_date');
            $currently_working = $this->request->getPost('currently_working');
            $job_description   = $this->request->getPost('job_description');

            if (!empty($company_name)) {

                foreach ($company_name as $key => $company) {

                    if (trim($company) == '') {
                        continue;
                    }

                    $expData = [
                        'jobseeker_id'      => $jobseeker_id,
                        'company_name'      => $company,
                        'designation'       => $designation[$key] ?? '',
                        'start_date'        => $start_date[$key] ?? '',
                        'end_date'          => $end_date[$key] ?? '',
                        'currently_working' => $currently_working[$key] ?? 0,
                        'job_description'   => $job_description[$key] ?? ''
                    ];

                    // Update existing record
                    if (!empty($experience_id[$key])) {

                        $db->table('tbl_jobseeker_experience')
                            ->where('experience_id', $experience_id[$key])
                            ->where('jobseeker_id', $jobseeker_id)
                            ->update($expData);

                    } else {

                        // Insert new record
                        $expData['created_at'] = date('Y-m-d H:i:s');

                        $db->table('tbl_jobseeker_experience')
                            ->insert($expData);
                    }
                }
            }
        
        // ================ 20-02-2026 ======================
        $user_id = $this->request->getPost('user_id');
        $updateusertbl = [
                'mobile_no' => $mobile_number,
                'full_name' => $full_name,
                'job_id' => $job_role
        ];
        // Update tbl_user database
        $db->table('tbl_user')->where('uid', $user_id)->update($updateusertbl);

        $session->setFlashdata('success', 'Profile updated successfully.');
        return redirect()->to(base_url('jobseeker/jobseeker_profile'));
    }
    public function save_job()
    {
        $user_id = $this->request->getPost('user_id');
        $jobseeker_id = $this->request->getPost('jobseeker_id');
        $posting_id = $this->request->getPost('posting_id');
        $recruiter_id = $this->request->getPost('recruiter_id');

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_candidate_job_status');


        // Check if candidate has already applied
            $applied = $builder->where([
                'user_id'       => $user_id,
                'jobseeker_id'  => $jobseeker_id,
                'posting_id'    => $posting_id,
                'candidate_status' => 'Apply Job'
            ])->get()->getRow();

            if ($applied) {
                return redirect()->back()->with('error', 'You have already applied for this job.');
            }

        // Check if the record already exists with candidate_status = 'Save Job'
        $existing = $builder->where([
            'user_id'          => $user_id,
            'jobseeker_id'     => $jobseeker_id,
            'posting_id'       => $posting_id,
            'candidate_status' => 'Save Job'
        ])->get()->getRow();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already saved this job.');
        }

        // Save new record
        $builder->insert([
            'user_id'         => $user_id,
            'jobseeker_id'    => $jobseeker_id,
            'posting_id'      => $posting_id,
            'recruiter_id'    => $recruiter_id,
            'candidate_status'=> 'Save Job',
            'applied_at'      => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Job has been saved successfully.');
    }
    public function jobseeker_save_jobs()
    {
        $session = session();
        $db = \Config\Database::connect();
        if (!$session->has('jobseeker_email')) {
            // Session not set, redirect to login
            return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');
        }

        $jobseekerModel = new JobseekerModel();
        $uid = $session->get('uid');

        // Fetch job_ids for this jobseeker
        $jobseeker_id = $db->table('tbl_jobseeker')
            ->select('jobseeker_id')
            ->where('uid', $uid)
            ->get()
            ->getRow('jobseeker_id');

       

            // Fetch recruiter postings matching these job IDs
            $saveJobs_Jobseeker = $jobseekerModel->save_job_jobseeker($jobseeker_id);
       

        // Load views
        echo view('jobportal/jobseeker_header');
        echo view('jobseeker/jobseeker_save_jobs', [
            'saveJobs_Jobseeker' => $saveJobs_Jobseeker
        ]);
        echo view('jobportal/footer');
    }

    public function jobseeker_applied_jobs()
    {
        $session = session();
        $db = \Config\Database::connect();
        if (!$session->has('jobseeker_email')) {
            // Session not set, redirect to login
            return redirect()->to(base_url('jobseeker-login') . '?activeTab=login');
        }

        $jobseekerModel = new JobseekerModel();
        $uid = $session->get('uid');

        // Fetch job_ids for this jobseeker
        $jobseeker_id = $db->table('tbl_jobseeker')
            ->select('jobseeker_id')
            ->where('uid', $uid)
            ->get()
            ->getRow('jobseeker_id');
     
       

            // Fetch recruiter postings matching these job IDs
            $applied_job_jobseeker = $jobseekerModel->applied_job_jobseeker($jobseeker_id);
       

        // Load views
        echo view('jobportal/jobseeker_header');
        echo view('jobseeker/jobseeker_applied_jobs', [
            'applied_job_jobseeker' => $applied_job_jobseeker
        ]);
        echo view('jobportal/footer');
    }
    
    public function new_Saveloginform()
    {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $user_type = $this->request->getPost('user_type');

        // Check if email exists
        $email_result = $db->table('tbl_user')
                            ->where('email', $email)
                            ->get()
                            ->getResultArray();

        // If no record found → Insert new user
        if (empty($email_result)) {
            return $this->insertUser($user_type, $email);
        }

        // Email exists → check user_type
        $existing_types = array_unique(array_column($email_result, 'user_type'));

        // If same user_type → Block (already signed up)
        if (in_array($user_type, $existing_types)) {
            session()->setFlashdata('error', '❌ You have already signed up with this email.');
            return redirect()->back();
        }

        // If different user_type exists → Block
        session()->setFlashdata('error', '❌ This email is already registered with another user type.');
        return redirect()->back();
    }
    
    private function insertUser($user_type, $email)
    {
        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kolkata');

        $otp = $this->request->getPost('otp');
        $activation_code = $this->request->getPost('activation_code');

        $data = [
            'user_type'       => $user_type,
            'otp'             => $otp,
            'full_name'       => $this->request->getPost('full_name'),
            'job_id'        => $this->request->getPost('job_role'),
            'i_agree'         => $this->request->getPost('i_agree') ? 1 : 0,

            'activation_code' => $activation_code,
            'email'           => $email,
            'mobile_no'       => $this->request->getPost('mobile_no'),
            'registered_date' => date('Y-m-d'),
            'password'        => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        // Insert Data
        $db->table('tbl_user')->insert($data);
        $user_id = $db->insertID();  // ✅ Get UID

        // =========== Fetch Jobseeker Data (if exists) ======================
        $jobseekar_full_name = '';
        if ($user_type == 'jobseekar') {
            $builder = $db->table('tbl_jobseeker');
            $jobseekar_form = $builder->where('uid', $user_id)->get()->getRow();

            if ($jobseekar_form !== null) {
                $jobseekar_full_name = $jobseekar_form->full_name;
            }
        }

        // ✅ Set Session
        session()->set([
            'uid'                     => $user_id,
            'jobseeker_email'         => $email,
            'jobseeker_user_type'     => $user_type,
            'jobseeker_otp'           => $otp,
            'jobseeker_activation_code'=> $activation_code,
            'jobseekar_full_name'     => $jobseekar_full_name
        ]);
       

        // ✅ Send OTP Email
        $this->sendOtpMail_new($email, $otp, $activation_code, $user_type);

        return redirect()->to('jobseeker/job_login_otp_new');
    }
    
    private function sendOtpMail_new($email, $otp, $activation_code, $user_type)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP(); 
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');  // Your Gmail
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                 // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       =  587;

            // ✅ ADD THIS BLOCK to disable SSL verification
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verification code to verify your Email Address';
            $mail->Body = '
                <p>To verify your email, enter this OTP code: <b>' . $otp . '</b></p>
                <p>Sincerely,<br>Adis India Pvt Ltd</p>';

            if ($mail->send()) {
                session()->setFlashdata('message', '✅ OTP sent to your email. Please verify.');
                session()->set([
                    'jobseeker_email' => $email,
                    'jobseeker_user_type' => $user_type,
                    'jobseeker_otp' => $otp,
                    'jobseeker_activation_code' => $activation_code
                ]);
            } else {
                session()->setFlashdata('error', '❌ Mail could not be sent: ' . $mail->ErrorInfo);
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            session()->setFlashdata('error', '❌ Mail error: ' . $e->getMessage());
        }
    }
    
    public function job_login_otp_new()
    {
        $session = session();
        $email = session()->get('jobseeker_email');
        $otp = session()->get('jobseeker_otp');
        $user_id = $session->get('uid');
        // print_r($session->get());
        // exit();
        return view('jobseeker/job_login_otp');
        // print_r($session->get());
    }
    
    // public function jobseeker_new_login() 
    // {
    //     $session = session();
    //     $db = \Config\Database::connect();
    //     $email = $this->request->getPost('email');
    //     $password = $this->request->getPost('password');
    //     $user = $db->table('tbl_user')
    //             ->where('email', $email)
    //             ->where('user_type','jobseekar')
    //             ->get()
    //             ->getRowArray();
    //         if (!$user) {
    //             $session->setFlashdata('error', '❌ Invalid credentials or not a Jobseeker!');
    //             return redirect()->back();
    //         }
            
            

    //         if (!password_verify($password, $user['password'])) {
    //             $session->setFlashdata('error', '❌ Incorrect password!');
    //             return redirect()->back();
    //         }

    //         $uid = $user['uid'];
    //         $jobseeker_form = $db->table('tbl_jobseeker')
    //                              ->where('uid',$user['uid'])
    //                              ->get()
    //                              ->getRowArray();

    //         $jobseeker_full_name = $jobseeker_form['full_name'] ?? '';

    //         $session->set([
    //             'uid' => $uid,
    //             'jobseeker_email' => $email,
    //             'isLoggedIn' => true,
    //             'jobseeker_user_type' => 'jobseekar',
    //             'jobseeker_full_name' => $jobseeker_full_name
    //         ]);

    //         $user_status     = $user['login_status'] ?? '';
    //         $profile_status  = $jobseeker_form['profile_status'] ?? '';

    //         if ($user_status === 'active' && $profile_status === 'active') {
    //             return redirect()->to('jobseeker/jobseeker_profile');
    //         } else {
    //             return redirect()->to('jobseeker/jobseeker_form');
    //         }
    // }
    public function jobseeker_new_login() 
    {
        $session = session();
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
            $user = $db->table('tbl_user')
                       ->where('email', $email)
                       ->where('user_type','jobseekar')
                       // ->where('status', 'active')
                       ->get()
                       ->getRowArray();
                       
            $uid = $user['uid'] ?? null;
            $jobseeker_form = $db->table('tbl_jobseeker')
                                 ->where('uid', $uid)
                                 ->get()
                                 ->getRowArray();

            $jobseeker_full_name = $jobseeker_form['full_name'] ?? '';

            // ✅ Set Session
            $session->set([
                'uid' => $uid,
                'jobseeker_email' => $email,
                'isLoggedIn' => true,
                'jobseeker_user_type' => 'jobseekar',
                'jobseeker_full_name' => $jobseeker_full_name
            ]);

            
            if (!$user) {
                $session->setFlashdata('error', '❌ Invalid credentials or not a Jobseeker!');
                return redirect()->back();
            }

            if (empty($user['status']) || $user['status'] !== 'active') {

               return redirect()->to('jobseeker/job_login_otp_new')
                                 ->with('error', '⚠️ Please verify OTP first!');
             }
            if (!password_verify($password, $user['password'])) {
                $session->setFlashdata('error', '❌ Incorrect password!');
                return redirect()->back();
            }


            // ✅ Fetch jobseeker extra details
            


            // ✅ Check form completion status
            $user_status     = $user['login_status'] ?? '';
            $profile_status  = $jobseeker_form['profile_status'] ?? '';

            if ($user_status === 'active' && $profile_status === 'active') {
                return redirect()->to('jobseeker/jobseeker_profile');
            } else {
                return redirect()->to('jobseeker/jobseeker_form');
            }
    }
    public function forgot_password()
    {
        return view('jobseeker/forgot_password_form_jobseeker');
    }
    
    public function send_reset_link()
    {
        $email = $this->request->getPost('email');
        $db = \Config\Database::connect();
        // Check if email exists in tbl_user table
        $user = $db->table('tbl_user')->where('email', $email)->get()->getRow();
        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }
    
        // Create token
        $token = bin2hex(random_bytes(16));
    
        // Save token in DB
        $db->table('tbl_user')->where('email', $email)->update(['reset_token' => $token]);
    
        // Create reset link
        $resetLink = base_url("jobseeker/reset_password_jobseeker/{$token}");
    
        // Send email (using CI4 Email Library)
         $this->sendPasswordResetMail($email, $resetLink);
         return redirect()->back()->with('success', 'Reset link sent to your email.');
    }
    
    private function sendPasswordResetMail($email, $resetLink)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');  // Your Gmail
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                 // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // SSL options
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request - Adis India Placement';

            $mail->Body = '
                <p>Hello,</p>
                <p>We received a request to reset your password for your <strong>Adis India Placement</strong> account.</p>
                <p>Please click the link below to reset your password:</p>
                <p><a href="' . htmlspecialchars($resetLink) . '" style="color:#1a73e8;">' . htmlspecialchars($resetLink) . '</a></p>
                <p>If you did not request this, you can ignore this email and your password will remain unchanged.</p>
                <br>
                <p>Warm regards,<br><strong>Adis India Placement Team</strong></p>
            ';

            $mail->send();

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            log_message('error', '❌ Password reset mail error: ' . $e->getMessage());
        }
    }
    public function reset_password_jobseeker($token)
    {
              $db = \Config\Database::connect();
    
        $user = $db->table('tbl_user')->where('reset_token', $token)->get()->getRow();
        
        if (!$user) {
            return redirect()->to('/')->with('error', 'Invalid or expired reset link.');
        }
    
        return view('jobseeker/reset_password_form_jobseeker', ['token' => $token]);
    }
    public function update_password()
    {
        $token = $this->request->getPost('token');
        $password = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

        $db = \Config\Database::connect();
        $user = $db->table('tbl_user')->where('reset_token', $token)->get()->getRow();
        
        if (!$user) {
            return redirect()->to('/')->with('error', 'Invalid token.');
        }

        // Update password & clear token
        $db->table('tbl_user')->where('reset_token', $token)->update([
            'password' => $password,
            'reset_token' => null,
            'otp'=>'',
            // 'login_status'=>'',
        ]);

        return redirect()->to('/jobseeker-login')->with('success', 'Password updated successfully.');
    }
    private function sendLoginfinalapplyposting($email,$candidateName,$job_role,$r_company_name,$intrested_posting_apply_date)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   =  env('EMAIL_SMTP_PASSWORD', '');               // App Password
            $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Application Received - ' . $job_role;

            $mail->Body = '
                <p>Dear <strong>' . htmlspecialchars($candidateName) . '</strong>,</p>
                
                <p>Thank you for trusting <strong>ADIS India Placement Pvt. Ltd.</strong> with your job search. 
                We have successfully received your application for the position of 
                <strong>' . htmlspecialchars($job_role) . '</strong> at 
                <strong>' . htmlspecialchars($r_company_name) . '</strong>, submitted on 
                <strong>' . htmlspecialchars($intrested_posting_apply_date) . '</strong>.</p>

                <p>Your application is now under review by the employer. If shortlisted, they will contact you for further steps like interviews or assessments. You can track your application through your account dashboard.</p>

                <p>Meanwhile, feel free to explore more opportunities on our platform and stay updated through our newsletter and social media.</p>

                <p>If you have any questions or need assistance, reach out to us at 
                <a href="mailto:contact@adisindiaplacement.com">contact@adisindiaplacement.com</a> or call 
                <span style="color:red; font-weight:bold;">9607559547</span>. 
                We’re here to support you!</p>

                <p>Wishing you all the best in your job search.</p>

                <br>
                <p>Warm regards,<br>
                <strong>Adis India Placement Team</strong><br>
                <a href="https://www.adisindiaplacement.com" style="color:green; font-weight:bold;">www.adisindiaplacement.com</a></p>
            ';

            if ($mail->send()) {
                log_message('info', "✅ Login success email sent to {$email}");
            } else {
                log_message('error', '❌ Mail send failed: ' . $mail->ErrorInfo);
            }

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            log_message('error', '❌ Mail error: ' . $e->getMessage());
        }
    }
    
    public function new_send_jobseeker()
    {
        $session = session();
    
        $uid   = $session->get('uid');
        $email = $session->get('jobseeker_email');
    
        if (!$email) {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Email not found']);
        }
    
        // ✅ OTP generate
        $otp = rand(100000, 999999);
        // $activation_code = md5($otp . time());
    
        // ✅ DB update
           $db = \Config\Database::connect();
        $db->table('tbl_user')
            ->where('uid', $uid)
            ->update([
                'otp' => $otp,
            ]);
    
        // ✅ PHPMailer include
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';
    
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');
            $mail->Password   =  env('EMAIL_SMTP_PASSWORD', '');  
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
    
            // SSL fix
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
    
            // ✅ Mail setup
            $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Pvt Ltd');
            $mail->addAddress($email);
    
            $mail->isHTML(true);
            $mail->Subject = 'Verification code to verify your Email Address';
            $mail->Body = '
                <p>To verify your email, enter this OTP code:</p>
                <h2>' . $otp . '</h2>
                <p>Sincerely,<br>Adis India Pvt Ltd</p>';
    
            // ✅ Send mail
            $mail->send();
    
            return $this->response->setJSON([
                'status' => 'success',
                'msg' => 'OTP sent successfully to your email'
            ]);
    
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => $mail->ErrorInfo
            ]);
        }
    }

    // ========================== 27-06-2026 ==============================================//
    
    public function resume_builder()
    {
        echo view('jobportal/jobseeker_header');
        echo view('jobseeker/resume_builder');
        echo view('jobportal/footer');
    }

// public function free_download_resume()
// {
//     $session = session();

//     if (!$session->has('uid')) {
//         return redirect()->to(base_url('login'));
//     }

//     $uid = $session->get('uid');
//     $db  = \Config\Database::connect();

//     $jobseeker = $db->table('tbl_jobseeker js')
//         ->select('
//             js.*,
//             c.name as city_name,
//             jr.job_role,
//             tpj.pg_name,
//             tq.qualification_name
//         ')
//         ->join('cities c', 'c.id = js.current_city', 'left')
//         ->join('tbl_job_role jr', 'jr.job_id = js.job_id', 'left')
//         ->join('tbl_post_degree tpj', 'tpj.pg_id = js.pg_id', 'left')
//           ->join('tbl_qualification tq', 'tq.qual_id = js.education', 'left')
//         ->where('js.uid', $uid)
//         ->get()
//         ->getRowArray();

//         $experience = $db->table('tbl_jobseeker_experience')
//         ->where('jobseeker_id', $jobseeker['jobseeker_id'])
//         ->orderBy('start_date', 'DESC')
//         ->get()
//         ->getResultArray();

//         // ================= TCPDF =================

//         $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

//         $pdf->SetCreator('Resume Builder');
//         $pdf->SetAuthor('Your Website');
//         $pdf->SetTitle('Resume');
//         $pdf->SetSubject('Professional Resume');

//         $pdf->setPrintHeader(false);
//         $pdf->setPrintFooter(false);

//         $pdf->SetMargins(10, 10, 10);
//         $pdf->SetAutoPageBreak(true, 10);

//         $pdf->SetFont('helvetica', '', 10);

//         $pdf->AddPage();

//         //================ HEADER =================

//         $pdf->SetTextColor(24,60,120);
//         $pdf->SetFont('helvetica','B',22);
//         $pdf->Cell(0,10,strtoupper($jobseeker['full_name'] ?? ''),0,1,'C');

//         $pdf->SetTextColor(120,120,120);
//         $pdf->SetFont('helvetica','B',11);
//         $pdf->Cell(0,6,strtoupper($jobseeker['job_role'] ?? ''),0,1,'C');

//         $pdf->Ln(3);

//         $pdf->SetFont('dejavusans', '', 10);
//         $pdf->SetTextColor(80,80,80);

//         $contact = '☏ '.$jobseeker['mobile_number'].
//                    '      |     '.
//                    '✉ '.$jobseeker['email'].
//                    '      |      '.
//                    '⌂ '.$jobseeker['city_name'];

//         $pdf->Cell(0,6,$contact,0,1,'C');

//         // Blue Line
//             $pdf->Ln(3);

//            $pdf->SetDrawColor(36,83,168);
//         $pdf->SetLineWidth(1);

//         $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());

//         $pdf->Ln(6);

//     // ================= Next Resume Content =================
//     // ================= Resume Body =================

//         $html = '

//         <table width="100%" cellpadding="5" cellspacing="5">

//         <tr>

//         <td width="33%" valign="top">

//         <table border="1" cellpadding="6">

//         <tr bgcolor="#1F4E9D">
//         <td><font color="#FFFFFF"><b> PERSONAL DETAILS</b></font></td>
//         </tr>

//         <tr><td><b>Full Name</b><br> '.$jobseeker['full_name'].'</td></tr>

//         <tr><td><b>Job Role</b><br>'.$jobseeker['job_role'].'</td></tr>

//         <tr><td><b>Category</b><br>'.$jobseeker['qualification_name'].'</td></tr>

//         <tr><td><b>Email</b><br>'.$jobseeker['email'].'</td></tr>

//         <tr><td><b>Mobile</b><br>'.$jobseeker['mobile_number'].'</td></tr>

//         <tr><td><b>Marital Status</b><br>'.$jobseeker['marital_status'].'</td></tr>

//         <tr><td><b>Current City</b><br>'.$jobseeker['city_name'].'</td></tr>

//         </table>

//         <br><br>

//         <table border="1" cellpadding="6">

//         <tr bgcolor="#1F4E9D">
//         <td><font color="#FFFFFF"><b> EDUCATION</b></font></td>
//         </tr>

//         <tr>
//         <td>'.$jobseeker['pg_name'].'</td>
//         </tr>

//         </table>

//         </td>

//         <td width="67%" valign="top">

//         <table border="1" cellpadding="7">

//         <tr bgcolor="#1F4E9D">
//         <td><font color="#FFFFFF"><b> SPECIALIZATION</b></font></td>
//         </tr>

//         <tr>
//         <td>'.$jobseeker['job_role'].'</td>
//         </tr>

//         </table>

//         <br><br>

//         <table border="1" cellpadding="7">

//         <tr bgcolor="#1F4E9D">
//         <td><font color="#FFFFFF"><b> TOTAL EXPERIENCE</b></font></td>
//         </tr>

//         <tr>
//         <td>'.$jobseeker['experience_years'].' Years</td>
//         </tr>

//         </table>

//         <br><br>

//         <table border="1" cellpadding="7">

//         <tr bgcolor="#1F4E9D">
//         <td><font color="#FFFFFF"><b> KEY SKILLS</b></font></td>
//         </tr>

//         <tr>
//         <td>'.$jobseeker['key_skills'].'</td>
//         </tr>

//         </table>

//         </td>

//         </tr>

//         </table>

//         <br><br>

//         <table width="100%" border="1" cellpadding="7">

//         <tr bgcolor="#1F4E9D">
//         <td colspan="2">
//         <font color="#FFFFFF"><b> WORK EXPERIENCE</b></font>
//         </td>
//         </tr>';
//         if(!empty($experience))
//         {
//             foreach($experience as $exp)
//             {
//                 $endDate = ($exp['currently_working'] == 1)
//                     ? 'Present'
//                     : date('M Y', strtotime($exp['end_date']));

//                 $html .= '

//         <tr>

//         <td width="30%">

//         <b>'.$exp['company_name'].'</b><br><br>

//         '.date('M Y', strtotime($exp['start_date'])).' - '.$endDate.'

//         </td>

//         <td width="70%">

//         <b>'.$exp['designation'].'</b>

//         <br><br>

//         '.$exp['job_description'].'

//         </td>

//         </tr>';

//             }
//         }
//         else
//         {
//             $html .= '

//         <tr>

//         <td colspan="2" align="center">

//         No Work Experience Available

//         </td>

//         </tr>';
//         }

//         $html .= '</table>';

//         $pdf->writeHTML($html, true, false, true, false, '');
//         $pdf->Ln(8);

 

//         // Footer
//         $pdf->SetFont('helvetica', '', 9);
//         $pdf->SetTextColor(90,90,90);

//         // Left - Date
//         $pdf->Cell(95, 6, 'Date : '.date('d M Y'), 0, 0, 'L');

//         // Right - Signature
//         $pdf->Ln(1);

//         $y = $pdf->GetY();

//         $pdf->SetDrawColor(190, 190, 190);   // Light Grey
//         $pdf->SetLineWidth(0.4);

//         $pdf->Line(160, $y, 198, $y);

//         $pdf->Ln(3);

//         $pdf->Cell(95,6,'',0,0);

//         $pdf->Cell(95,6,'Signature',0,1,'R');


//             while (ob_get_level()) {
//                 ob_end_clean();
//             }

//             $pdf->Output('Resume.pdf', 'I');
//             exit;
// }
    
    private function addWatermark($pdf)
    {
        $logo = FCPATH.'assets/jobportal/images/home/newlogo.jpeg';

        if(file_exists($logo))
        {
            $pdf->SetAlpha(0.05);

            $pdf->StartTransform();
            $pdf->Rotate(45,105,148);

            $pdf->Image(
                $logo,
                35,
                70,
                140,
                0,
                'JPEG'
            );

            $pdf->StopTransform();

            $pdf->SetAlpha(1);
        }
    }
    
    public function free_download_resume()
    {
        $session = session();

        if (!$session->has('uid')) {
            return redirect()->to(base_url('login'));
        }

        $uid = $session->get('uid');
        $db  = \Config\Database::connect();
        $jobseeker = $db->table('tbl_jobseeker js')
            ->select("
                js.*,
                c.name AS city_name,
                jr.job_role,
                tpj.pg_name,
                tq.qualification_name,
                tc.course_name,
                GROUP_CONCAT(tl.language_name ORDER BY tl.language_name SEPARATOR ', ') AS language_names
            ")
            ->join('cities c', 'c.id = js.current_city', 'left')
            ->join('tbl_job_role jr', 'jr.job_id = js.job_id', 'left')
            ->join('tbl_post_degree tpj', 'tpj.pg_id = js.pg_id', 'left')
            ->join('tbl_qualification tq', 'tq.qual_id = js.education', 'left')
            ->join('tbl_course tc', 'tc.course_id = js.course', 'left')
            ->join('tbl_languages tl', 'FIND_IN_SET(tl.lang_id, js.language_name) > 0', 'left', false)
            ->where('js.uid', $uid)
            ->groupBy('js.jobseeker_id')
            ->get()
            ->getRowArray();

            if (!$jobseeker) {
                return redirect()->back()->with('error','Candidate not found');
            }

            $experienceList  = $db->table('tbl_jobseeker_experience')
                ->where('jobseeker_id',$jobseeker['jobseeker_id'])
                ->orderBy('start_date','DESC')
                ->get()
                ->getResultArray();
            $maritalStatus = (strcasecmp(trim($jobseeker['marital_status']), 'Never Married') === 0)
            ? 'Unmarried'
            : $jobseeker['marital_status'];

            $fullName = trim($jobseeker['full_name']);

            if (stripos($fullName, 'Dr.') !== 0) {
                $fullName = 'Dr. ' . $fullName;
            }
            // ===================== TCPDF ======================

            $pdf = new \TCPDF('P','mm','A4',true,'UTF-8',false);

            $pdf->SetCreator('Resume Builder');
            $pdf->SetAuthor('Job Portal');
            $pdf->SetTitle('Resume');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(0,0,0);
            $pdf->SetAutoPageBreak(true,10);

            $pdf->SetFont('helvetica','',10);

            $pdf->AddPage();
            // ================= WATERMARK =================

            $this->addWatermark($pdf);

            //================ Initials ===================

            $initials = '';

            if (!empty($jobseeker['full_name']))
            {
                $name = trim($jobseeker['full_name']);

                // Prefixes remove
                $name = preg_replace('/^(Dr\.?|Mr\.?|Mrs\.?|Miss\.?|Ms\.?)\s+/i', '', $name);

                $arr = preg_split('/\s+/', $name);

                foreach ($arr as $a)
                {
                    if (!empty($a))
                    {
                        $initials .= strtoupper(substr($a, 0, 1));
                    }
                }

                $initials = substr($initials, 0, 2);
            }

            //================ HEADER ======================

           
        $pdf->SetFillColor(143, 46, 45);
        $pdf->Rect(0,0,210,34,'F');

        // Initial Box
        $pdf->SetDrawColor(255,255,255);
        $pdf->SetLineWidth(0.5);
        $pdf->Rect(14,8,18,18);

        // Initials
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('helvetica','B',18);
        $pdf->SetXY(14,13);
        $pdf->Cell(18,6,$initials,0,0,'C');

        // Name
        $pdf->SetFont('helvetica','B',24);
        $pdf->SetXY(38,8);
        $pdf->Cell(0,8,strtoupper($fullName),0,1);

        // City
        $pdf->SetFont('helvetica','',10);
        $pdf->SetXY(38,18);
        $pdf->Cell(0,5,$jobseeker['city_name'],0,1);

        // Email + Mobile
        $pdf->SetXY(38,24);
        $pdf->Cell(
            0,
            5,
            $jobseeker['email'].'   |   '.$jobseeker['mobile_number'],
            0,
            1
        );

        // Start body below header
        $pdf->SetY(40);
        //================ PERSONAL DETAILS =================

        $pdf->SetY(45);

        $left = 15;
        $right = 195;

        // Heading
        $pdf->SetTextColor(143, 46, 45);
        $pdf->SetFont('helvetica','B',15);
        $pdf->SetX($left);
        $pdf->Cell(0,8,'PERSONAL DETAILS',0,1);

        // Underline
        $pdf->SetDrawColor(210,210,210);
        $pdf->SetLineWidth(0.3);
        $pdf->Line($left,$pdf->GetY(),$right,$pdf->GetY());

        $pdf->Ln(6);

        // Text
        $pdf->SetTextColor(60,60,60);
        $pdf->SetFont('helvetica','',11);

        $rowHeight = 7;

        // ---------- Row 1 ----------
        $pdf->SetX($left);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Full Name');

        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(55,$rowHeight,$fullName);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Job Role');

        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(45,$rowHeight,$jobseeker['job_role']);

        $pdf->Ln();

        // ---------- Row 2 ----------
        $pdf->SetX($left);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Email');

        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(55,$rowHeight,$jobseeker['email']);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Mobile');

        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(45,$rowHeight,$jobseeker['mobile_number']);

        $pdf->Ln();

        // ---------- Row 3 ----------
        $pdf->SetX($left);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Qualification');

        $pdf->SetFont('helvetica','',10);

        // Current Position
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Course Name (Wrap)
        $pdf->MultiCell(
            55,
            5,
            $jobseeker['course_name'],
            0,
            'L',
            false,
            0
        );

        // Marital Status Label
        $pdf->SetXY($x + 55, $y);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,$rowHeight,'Marital Status');

        // Marital Status Value
        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(45,$rowHeight,$maritalStatus);

        $pdf->Ln();

        // ---------- Row 4 ----------
        // ---------- Row 4 ----------
        $pdf->SetX($left);

        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,5,'Current City');

        $pdf->SetFont('helvetica','',10);
        $pdf->Cell(55,5,$jobseeker['city_name']);

        // Language Names
        $languageNames = '';

        if (!empty($jobseeker['language_name'])) {

            $ids = explode(',', $jobseeker['language_name']);

            $languages = $db->table('tbl_languages')
                ->select('language_name')
                ->whereIn('lang_id', $ids)
                ->get()
                ->getResultArray();

            if (!empty($languages)) {
                $languageNames = implode(', ', array_column($languages, 'language_name'));
            }
        }

        // Language Label
        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(35,5,'Language');

        // Save current position
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Language Value
        $pdf->SetXY($x, $y);
        $pdf->SetFont('helvetica','',10);

        $pdf->MultiCell(
            55,     // Width
            5,      // Height
            $languageNames,
            0,
            'L',
            false,
            1
        );

        // Next section starts after wrapped language
        $pdf->Ln(5);
        //================ EDUCATION =================

        $pdf->SetTextColor(143, 46, 45);
        $pdf->SetFont('helvetica','B',15);
        $pdf->SetX(15);
        $pdf->Cell(0,8,'EDUCATION',0,1);

        // Underline
        $pdf->SetDrawColor(210,210,210);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(15,$pdf->GetY(),195,$pdf->GetY());

        $pdf->Ln(5);

        // Qualification
        $pdf->SetX(15);
        $pdf->SetTextColor(50,50,50);
        $pdf->SetFont('helvetica','B',12);
        $pdf->Cell(0,6,$jobseeker['course_name'],0,1);

        // Post Graduation / Degree
        // $pdf->SetX(15);
        // $pdf->SetFont('helvetica','',10);
        // $pdf->SetTextColor(90,90,90);
        // $pdf->Cell(0,6,$jobseeker['course_name'],0,1);

        $pdf->Ln(5);

        //================ SPECIALIZATION =================

        $pdf->SetTextColor(143, 46, 45);
        $pdf->SetFont('helvetica','B',15);
        $pdf->SetX(15);
        $pdf->Cell(0,8,'SPECIALIZATION',0,1);

        // Underline
        $pdf->SetDrawColor(210,210,210);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(15,$pdf->GetY(),195,$pdf->GetY());

        $pdf->Ln(5);

        // Job Role
        $pdf->SetX(15);
        $pdf->SetTextColor(50,50,50);
        $pdf->SetFont('helvetica','B',12);
        $pdf->Cell(0,6,$jobseeker['job_role'],0,1);

        $pdf->Ln(8);

        //================ TOTAL EXPERIENCE =================

        $pdf->SetTextColor(143, 46, 45);
        $pdf->SetFont('helvetica','B',15);
        $pdf->SetX(15);
        $pdf->Cell(0,8,'WORK EXPERIENCE',0,1);

        // Underline
        $pdf->SetDrawColor(210,210,210);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(15,$pdf->GetY(),195,$pdf->GetY());

        $pdf->Ln(2);

          // $pdf->Ln(5);



        $pdf->SetTextColor(0,0,0);
        $expNo = 1;
        foreach ($experienceList as $exp)
        {
            $startDate = !empty($exp['start_date'])
                ? date('M Y', strtotime($exp['start_date']))
                : '';

            $endDate = ($exp['currently_working'] == 1)
                ? 'Present'
                : (!empty($exp['end_date']) ? date('M Y', strtotime($exp['end_date'])) : '');

            // Designation
            $pdf->SetFont('helvetica','B',12);
            $pdf->SetX(15);
            // $pdf->Cell(120,6,$exp['designation'],0,0,'L');
            $pdf->Cell(120,6,$expNo.'. '.$exp['designation'],0,0,'L');
            // Date
            $pdf->SetFont('helvetica','I',10);
            $pdf->SetTextColor(110,110,110);
            $pdf->Cell(60,6,$startDate.' - '.$endDate,0,1,'R');

            // Company
            $pdf->SetFont('helvetica','',10);
            $pdf->SetTextColor(80,80,80);
            $pdf->SetX(15);
            $pdf->Cell(180,5,$exp['company_name'],0,1);

            // Space
            $pdf->Ln(2);

            // Description
            if(!empty($exp['job_description']))
            {
                $pdf->SetTextColor(50,50,50);
                $pdf->SetFont('helvetica','',10);

                 $description = trim(strip_tags($exp['job_description']));
           

                $pdf->SetX(15);

                $pdf->MultiCell(
                    175,
                    5.5,
                    $description,
                    0,
                    'L',
                    false,
                    1
                );
            }

            // Bottom Space
            $pdf->Ln(3);

            // Separator
            $pdf->SetDrawColor(220,220,220);
            $pdf->Line(15,$pdf->GetY(),195,$pdf->GetY());

            $pdf->Ln(5);
               // Increase Number
    $expNo++;
        }
        
        //================ KEY SKILLS =================
     
        if ($pdf->GetY() > 215) {

            $pdf->AddPage();
            $this->addWatermark($pdf);
            $pdf->SetY(25);
       
        }

       $pdf->SetTextColor(143, 46, 45);
        $pdf->SetFont('helvetica','B',15);
        $pdf->SetX(15);
        $pdf->Cell(0,8,'KEY SKILLS',0,1);

        // Underline
        $pdf->SetDrawColor(210,210,210);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(15,$pdf->GetY(),195,$pdf->GetY());

        $pdf->Ln(1);

        // Get Key Skills
        $keySkills = trim($jobseeker['key_skills']);

        // Plain Text -> Convert into Paragraphs
        if ($keySkills == strip_tags($keySkills))
        {
            $lines = preg_split('/\r\n|\r|\n/', $keySkills);

            $html = '';

            foreach ($lines as $line)
            {
                $line = trim($line);

                if($line != '')
                {
                    $html .= '<p>'.htmlspecialchars($line).'</p>';
                }
            }

            $keySkills = $html;
        }

        $pdf->SetFont('helvetica','',10);
        $pdf->SetTextColor(50,50,50);

        $skills = '
        <style>
        p{
            color:#323232;
            font-size:10px;
            font-weight:normal;
            margin:0 0 0px 0;
            line-height:13px;
        }
        span{
            color:#323232;
            font-size:10px;
            font-weight:normal;
        }
        ul{
            padding-left:18px;

        }
        ol{
            padding-left:18px;
        }
        li{
            line-height:16px;
        }
        </style>

        <span>'.$keySkills.'</span>';

        $pdf->writeHTMLCell(
            180,
            0,
            15,
            $pdf->GetY(),
            $skills,
            0,
            1,
            false,
            true,
            'L',
            true
        );

        // ================= FOOTER =================

         
            $pdf->Ln(10);

            $pdf->SetFont('helvetica','',10);
            $pdf->SetTextColor(80,80,80);

            // Current Y
            $y = $pdf->GetY();

            // ---------------- Left : Date ----------------
            $pdf->SetXY(15, $y);
            $pdf->Cell(90,6,'Date : '.date('d M Y'),0,0,'L');

            // ---------------- Right : Signature Line ----------------
            $pdf->SetXY(130, $y);

            // Signature line
            $pdf->SetDrawColor(150,150,150);
            $pdf->Line(145,$y+5,195,$y+5);

            // Signature Text
            $pdf->SetXY(145,$y+7);
            $pdf->SetFont('helvetica','',9);
            $pdf->Cell(50,5,'Signature',0,0,'C');

            // $pdf->writeHTML($html, true, false, true, false, '');

         

            while (ob_get_level()) {
                    ob_end_clean();
                }

                $pdf->Output('Resume.pdf', 'I');
                exit;

    }

    public function resumePreview()
    {
        $session = session();
        // print_r($_SESSION);
        // exit();
        if ($session->has('jobseeker_email')) 
        {
            $uid = $session->get('uid');
            $db  = \Config\Database::connect();
            $jobseekerModel = new JobseekerModel();

            $data['jobseeker']= $jobseekerModel->getResumePreviewData($uid);
            return view('jobseeker/resume_preview', $data);
        }else
        {
               return redirect()->to(base_url('jobseeker-login'));
        }

    }

    public function resume_gold_download()
    {
            $session = session();

            if (!$session->has('uid')) {
                return redirect()->to(base_url('login'));
            }
            $uid = $session->get('uid');
            $db  = \Config\Database::connect();
            $jobseekerModel = new JobseekerModel();
            $data['jobseeker']= $jobseekerModel->getResumePreviewData($uid);
            $job = $data['jobseeker'];
            $experience = $db->table('tbl_jobseeker_experience')
                     ->where('jobseeker_id', $job['jobseeker_id'])
                     ->orderBy('start_date', 'DESC')
                     ->get()
                     ->getResultArray();
            if (!empty($job['candi_profile_cropped_image']) &&
                file_exists(FCPATH . 'jobseeker/candidate_job_profile/' . $job['candi_profile_cropped_image']))
            {
                $image = FCPATH . 'jobseeker/candidate_job_profile/' . $job['candi_profile_cropped_image'];
            }
            else
            {
                $image = FCPATH . 'assets/images/default-user.png';
            }
            $pdf = new \TCPDF('P','mm','A4',true,'UTF-8',false);

            $pdf->SetCreator('Resume Builder');
            $pdf->SetAuthor('Job Portal');
            $pdf->SetTitle('Resume');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(0,0,0);
            $pdf->SetAutoPageBreak(true,10);

            $pdf->SetFont('helvetica','',10);
            $pdf->AddPage();

            $pageWidth  = $pdf->GetPageWidth();
            $pageHeight = $pdf->GetPageHeight();

            /* LEFT GREY PANEL */
            $pdf->SetFillColor(230,230,230);
            $pdf->Rect(0, 0, 60, $pageHeight, 'F');

            /* PROFILE IMAGE */
            // $image = FCPATH.'uploads/profile.jpg';

            if(file_exists($image))
            {
              $pdf->Image($image, 15, 15, 35, 35);
            }

            /* RIGHT SECTION */

            $pdf->SetXY(70,15);
            $pdf->SetFont('times','B',22);
            $pdf->Cell(0,8,'HELLO');

            $pdf->SetXY(70,30);
            $pdf->SetFont('times','B',16);
            $pdf->Cell(0,8,"I am Dr. ".$job['full_name']);

            $experienceText = "With ".$job['experience_years']." years";

            if (!empty($job['experience_months']) && $job['experience_months'] > 0) {
                $experienceText .= " ".$job['experience_months']." months";
            }

            $experienceText .= " of medical experience, I am committed to delivering compassionate care, accurate diagnosis, and the highest standards of healthcare.";

            $pdf->SetXY(70,40);
            $pdf->SetFont('times','',13);

            $pdf->MultiCell(
                110,
                7,
                $experienceText,
                0,
                'L'
            );
        
            /* Current Y Position */
            $y = $pdf->GetY() + 3;

            /* Horizontal Line */
            $pdf->Line(70, $y, 195, $y);

            /* Contact Details */
            $pdf->SetXY(70, $y + 4);
            $pdf->SetFont('helvetica','',10);

            $pdf->Image(FCPATH.'assets/jobportal/images/home/phone.jpg',70,$y+4,4,4);
            $pdf->SetXY(76,$y+3);
            $pdf->Cell(40,5,'+91 '.$job['mobile_number']);

            $pdf->Image(FCPATH.'assets/jobportal/images/home/gmail1.jpg',125,$y+4,4,4);
            $pdf->SetXY(131,$y+3);
            $pdf->Cell(50,5,$job['email']);

            /* SPECIALIZATION */
            $pdf->SetXY(70,80);
            $pdf->SetFont('helvetica','B',12);
            $pdf->Cell(0,5,'SPECIALIZATION');

            // $pdf->Line(70,86,195,86);

            $pdf->SetXY(70,90);
            $pdf->SetFont('times','',13);
            $pdf->MultiCell(
                120,
                5,
                $job['job_role'],
                0,
                'L'
            );

            // $pdf->Line(70,76,195,76);
            $y = $pdf->GetY() + 7;

            if (!empty($experience))
            {
                $pdf->SetXY(70, $y);
                $pdf->SetFont('helvetica','B',12);
                $pdf->Cell(0,5,'WORK EXPERIENCE');

                $y = $pdf->GetY() + 10;

               if (!empty($job['candi_profile_cropped_image']) &&
                file_exists(FCPATH . 'jobseeker/candidate_job_profile/' . $job['candi_profile_cropped_image']))
            {
                $image = FCPATH . 'jobseeker/candidate_job_profile/' . $job['candi_profile_cropped_image'];
            }
            else
            {
                $image = FCPATH . 'assets/images/default-user.png';
            }
            $pdf = new \TCPDF('P','mm','A4',true,'UTF-8',false);

            $pdf->SetCreator('Resume Builder');
            $pdf->SetAuthor('Job Portal');
            $pdf->SetTitle('Resume');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(0,0,0);
            $pdf->SetAutoPageBreak(true,10);

            $pdf->SetFont('helvetica','',10);
            $pdf->AddPage();

            $pageWidth  = $pdf->GetPageWidth();
            $pageHeight = $pdf->GetPageHeight();

            /* LEFT GREY PANEL */
            $pdf->SetFillColor(230,230,230);
            $pdf->Rect(0, 0, 60, $pageHeight, 'F');

            /* PROFILE IMAGE */
            // $image = FCPATH.'uploads/profile.jpg';

            if(file_exists($image))
            {
              $pdf->Image($image, 15, 15, 35, 35);
            }

            /* DESIGNATION BOX */
            $pdf->SetFillColor(20,20,20);
            $pdf->Rect(14, 55, 38, 8, 'F');

            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont('helvetica','B',10);
            $pdf->SetXY(12,57);
            $pdf->Cell(36,5,$job['job_role'],0,0,'C');

            /* RESET COLOR */
            $pdf->SetTextColor(0,0,0);

            /* EDUCATION DATA */
            $education = '';

            if (!empty($job['sup_id'])) {

                $education .= "Superspeciality Degree\n";
                $education .= $job['superspeciality_name'];

                if (!empty($job['sup_year_month'])) {
                    $education .= "\n".date('F, Y', strtotime($job['sup_year_month']));
                }
                $education .= "\n\n";
            }

            if (!empty($job['int_degree_id']) || !empty($job['iq_clg_name'])) {
                $education .= "International Qualification\n";
                $education .= $job['iq_clg_name'];

                if (!empty($job['iq_year_month'])) {
                    $education .= "\n".date('Y', strtotime($job['iq_year_month']));
                }
                $education .= "\n\n";
            }

            if (!empty($job['pg_id']) || !empty($job['pg_clg_name'])) {
                $education .= "Master Degree\n";
                $education .= $job['pg_clg_name'];

                if (!empty($job['pg_year_month'])) {
                    $education .= "\n".date('Y', strtotime($job['pg_year_month']));
                }
                $education .= "\n\n";
            }

            if (!empty($job['ug_id']) || !empty($job['ug_clg_name'])) {
                $education .= "Bachelor Degree\n";
                $education .= $job['ug_clg_name'];

                if (!empty($job['ug_year_month'])) {
                    $education .= "\n".date('Y', strtotime($job['ug_year_month']));
                }
            }

            $leftY = 75;
            /* EDUCATION */
            if (!empty(trim($education)))
            {
                $pdf->SetFont('helvetica','B',12);
                $pdf->SetXY(8, $leftY);
                $pdf->Cell(0,5,'EDUCATION');

                $pdf->Line(8, $leftY+6, 50, $leftY+6);

                $pdf->SetFont('Times','',11);
                $pdf->SetXY(8, $leftY+10);
                $pdf->MultiCell(45,4,trim($education));

                $leftY = $pdf->GetY() + 8;
            }
            if (!empty($job['language_names']))
            {
                $pdf->SetFont('helvetica','B',12);
                $pdf->SetXY(8, $leftY);
                $pdf->Cell(0,5,'LANGUAGES');

                $pdf->Line(8, $leftY+6, 50, $leftY+6);

                $pdf->SetFont('Times','',11);
                $pdf->SetXY(8, $leftY+10);

                $languages = array_filter(
                    array_map('trim', explode(',', $job['language_names']))
                );

                $langText = '';

                foreach ($languages as $language)
                {
                    $langText .= '- '.$language."\n";
                }

                $pdf->MultiCell(
                    45,
                    4,
                    trim($langText),
                    0,
                    'L',
                    false
                );

                $leftY = $pdf->GetY() + 8;
            }

            if (!empty($job['linkdin_profile']) && strtolower(trim($job['linkdin_profile'])) == 'yes' &&
                !empty($job['linkedin_url']))
            {
                $pdf->SetFont('helvetica','B',12);
                $pdf->SetXY(8, $leftY);
                $pdf->Cell(0,5,'LINKEDIN PROFILE');

                $pdf->Line(8, $leftY+6, 50, $leftY+6);

                $pdf->SetFont('Times','I',11);
                $pdf->SetXY(8, $leftY+10);

                $pdf->MultiCell(
                    45,
                    4,
                    $job['linkedin_url'],
                    0,
                    'L',
                    false
                );

                $leftY = $pdf->GetY() + 5;
            }

            $currentPage = $pdf->getNumPages();
             $details =
                    "Birth Date  : " .
                    (!empty($job['birth_date'])
                        ? date('d F Y', strtotime($job['birth_date']))
                        : 'N/A') .

                    "\nGender : " .
                    (!empty($job['gender'])
                        ? $job['gender']
                        : 'N/A') .

                    "\nMarital Status : " .
                    (!empty($job['marital_status'])
                        ? ($job['marital_status'] == 'Never Married'
                            ? 'Single'
                            : $job['marital_status'])
                        : 'N/A') .

                    "\nMobile No. : " .
                    (!empty($job['mobile_number'])
                        ? $job['mobile_number']
                        : 'N/A') .

                    "\nEmail : " .
                    (!empty($job['email'])
                        ? $job['email']
                        : 'N/A') .

                    "\nLocation : " .
                    (!empty($job['candidate_full_address'])
                        ? $job['candidate_full_address']
                        : 'N/A');
            if ($currentPage == 1)
            {
             
                $pdf->SetXY(8, $leftY);

                $pdf->SetFont('helvetica','B',12);
                $pdf->Cell(45,5,'PERSONAL DETAILS');

                $pdf->Line(8,$leftY+7,52,$leftY+7);

                $pdf->SetFont('Times','',11);
                $pdf->SetXY(8,$leftY+12);
                $pdf->MultiCell(45,5,$details);
            }

            /* RIGHT SECTION */

            $pdf->SetXY(70,15);
            $pdf->SetFont('times','B',22);
            $pdf->Cell(0,8,'HELLO');

            $pdf->SetXY(70,30);
            $pdf->SetFont('times','B',16);
            $pdf->Cell(0,8,"I am Dr. ".$job['full_name']);

            $experienceText = "With ".$job['experience_years']." years";

            if (!empty($job['experience_months']) && $job['experience_months'] > 0) {
                $experienceText .= " ".$job['experience_months']." months";
            }

            $experienceText .= " of medical experience, I am committed to delivering compassionate care, accurate diagnosis, and the highest standards of healthcare.";

            $pdf->SetXY(70,40);
            $pdf->SetFont('times','',13);

            $pdf->MultiCell(
                110,
                7,
                $experienceText,
                0,
                'L'
            );
            
            /* Current Y Position */
            $y = $pdf->GetY() + 3;

            /* Horizontal Line */
            $pdf->Line(70, $y, 195, $y);

            /* Contact Details */
            $pdf->SetXY(70, $y + 4);
            $pdf->SetFont('helvetica','',10);

            $pdf->Image(FCPATH.'assets/jobportal/images/home/phone.jpg',70,$y+4,4,4);
            $pdf->SetXY(76,$y+3);
            $pdf->Cell(40,5,'+91 '.$job['mobile_number']);

            $pdf->Image(FCPATH.'assets/jobportal/images/home/gmail1.jpg',125,$y+4,4,4);
            $pdf->SetXY(131,$y+3);
            $pdf->Cell(50,5,$job['email']);




            /* SPECIALIZATION */
            $pdf->SetXY(70,80);
            $pdf->SetFont('helvetica','B',12);
            $pdf->Cell(0,5,'SPECIALIZATION');

            // $pdf->Line(70,86,195,86);

            $pdf->SetXY(70,90);
            $pdf->SetFont('times','',13);
            $pdf->MultiCell(
                120,
                5,
                $job['job_role'],
                0,
                'L'
            );

            // $pdf->Line(70,76,195,76);
            $y = $pdf->GetY() + 7;

            if (!empty($experience))
            {
                $pdf->SetXY(70, $y);
                $pdf->SetFont('helvetica','B',12);
                $pdf->Cell(0,5,'WORK EXPERIENCE');

                $y = $pdf->GetY() + 10;

                foreach ($experience as $exp)
                {
                    /* Company + Designation */
                    $title = $exp['company_name'];

                    if (!empty($exp['designation'])) {
                        $title .= ' - '.$exp['designation'];
                    }

                    $pdf->SetXY(70, $y);
                    $pdf->SetFont('times','B',12);

                    $pdf->MultiCell(
                        120,
                        5,
                        $title,
                        0,
                        'L'
                    );

                    $y = $pdf->GetY() + 1;

                    /* Date */
                    $dateText = '';

                    if (!empty($exp['start_date'])) {
                        $dateText .= date('M Y', strtotime($exp['start_date']));
                    }

                    if ($exp['currently_working'] == '1') {
                        $dateText .= ' - Present';
                    }
                    elseif (!empty($exp['end_date'])) {
                        $dateText .= ' - '.date('M Y', strtotime($exp['end_date']));
                    }

                    $pdf->SetXY(70, $y);
                    $pdf->SetFont('times','I',10);
                    $pdf->Cell(0,5,$dateText);

                    $y += 8;

                    /* Description */
                    if (!empty($exp['job_description']))
                    {
                        $pdf->SetXY(70, $y);
                        $pdf->SetFont('times','',10);

                        $pdf->MultiCell(
                            120,
                            5,
                            $exp['job_description'],
                            0,
                            'L'
                        );

                        $y = $pdf->GetY() + 8;
                    }
                }
            }


            }
            
            
          
            $y = $pdf->GetY() + 8;

            $details =
                    "Birth Date  : " .
                    (!empty($job['birth_date'])
                        ? date('d F Y', strtotime($job['birth_date']))
                        : 'N/A') .

                    "\nGender : " .
                    (!empty($job['gender'])
                        ? $job['gender']
                        : 'N/A') .

                    "\nMarital Status : " .
                    (!empty($job['marital_status'])
                        ? ($job['marital_status'] == 'Never Married'
                            ? 'Single'
                            : $job['marital_status'])
                        : 'N/A') .

                    "\nMobile No. : " .
                    (!empty($job['mobile_number'])
                        ? $job['mobile_number']
                        : 'N/A') .

                    "\nEmail : " .
                    (!empty($job['email'])
                        ? $job['email']
                        : 'N/A') .

                    "\nLocation : " .
                    (!empty($job['candidate_full_address'])
                        ? $job['candidate_full_address']
                        : 'N/A');

                if (!empty($job['key_skills']))
                {
                    if ($y > 170)
                    {
                        $pdf->AddPage();

                        /* LEFT PANEL */
                       $pdf->Rect(0,0,60,$pageHeight,'F');

                        $pdf->SetXY(8,20);
                        $pdf->SetFont('helvetica','B',11); 
                        $pdf->Cell(0,5,'PERSONAL DETAILS');

                        $pdf->Line(8,27,52,27);

                        $pdf->SetFont('Times','',11);
                        $pdf->SetXY(8,34);
                        $pdf->MultiCell(52,5,$details,0,'L',false);

                        // $y = $pdf->GetY() + 5;

                        $y = 20;
                    }

                    /* Heading */
                    $pdf->SetXY(70,$y);
                    $pdf->SetFont('helvetica','B',12);
                    $pdf->Cell(0,5,'KEY SKILLS');

                    $pdf->Line(70,$y+6,195,$y+6);

                    $y += 10;

                    $skills = html_entity_decode($job['key_skills']);

                    if (strip_tags($skills) == $skills)
                    {
                        $skills = '<p>'.nl2br($skills).'</p>';
                    }

                    $startPage = $pdf->getPage();

                    $pdf->SetFont('times','',11);

                    $pdf->writeHTMLCell(
                        120,
                        0,
                        70,
                        $y,
                        $skills,
                        0,
                        1,
                        false,
                        true,
                        'L',
                        true
                    );

                    $endPage = $pdf->getPage();

                    if ($endPage > $startPage)
                    {
                        for ($p = $startPage + 1; $p <= $endPage; $p++)
                        {
                            $pdf->setPage($p);

                            /* LEFT PANEL */
                            $pdf->SetFillColor(230,230,230);
                            $pdf->Rect(0,0,60,$pageHeight,'F');

                            $pdf->SetXY(8,20);
                            $pdf->SetFont('helvetica','B',12);
                            $pdf->Cell(0,5,'PERSONAL DETAILS');

                            $pdf->Line(8,26,50,26);

                           $pdf->SetFont('Times','',11);
                            $pdf->SetXY(8,34);
                            $pdf->MultiCell(52,5,$details,0,'L',false);
                        }
                        }

                        /* Last page */
                        $pdf->setPage($pdf->getNumPages());

                        $y = $pdf->GetY() - 2;
                }   
                $y = $pdf->GetY() + 5;


                $requiredSpace = 50;

                if (($y + $requiredSpace) > 270)
                {
                    $pdf->AddPage();

                    /* LEFT PANEL */
                    $pdf->SetFillColor(230,230,230);
                    $pdf->Rect(0,0,60,$pageHeight,'F');

                    $pdf->SetXY(8,20);
                    $pdf->SetFont('helvetica','B',12);
                    $pdf->Cell(0,5,'PERSONAL DETAILS');

                    $pdf->Line(8,26,50,26);

                    $pdf->SetFont('Times','',11);
                    $pdf->SetXY(8,34);
                    $pdf->MultiCell(52,5,$details,0,'L',false);

                        $y = 20;
                }
                if (!empty($job['publications']))
                {
                    $pdf->SetXY(70,$y);
                    $pdf->SetFont('helvetica','B',12);
                    $pdf->Cell(0,5,'PUBLICATIONS');

                    $pdf->Line(70,$y+6,195,$y+6);

                    $y += 10;

                    $publications = html_entity_decode($job['publications']);

                    
                    if (strip_tags($publications) == $publications)
                    {
                        $publications = '<p>'.nl2br($publications).'</p>';
                    }

                    $startPage = $pdf->getPage();

                    $pdf->SetFont('times','',11);

                    $pdf->writeHTMLCell(
                        120,
                        0,
                        70,
                        $y,
                        $publications,
                        0,
                        1,
                        false,
                        true,
                        'L',
                        true
                    );

                    $endPage = $pdf->getPage();

                   
                    if ($endPage > $startPage)
                    {
                        for ($p = $startPage + 1; $p <= $endPage; $p++)
                        {
                            $pdf->setPage($p);

                            $pdf->SetFillColor(230,230,230);
                            $pdf->Rect(0,0,60,$pageHeight,'F');

                            $pdf->SetXY(8,20);
                            $pdf->SetFont('helvetica','B',12);
                            $pdf->Cell(0,5,'PERSONAL DETAILS');

                            $pdf->Line(8,27,52,27);

                            $pdf->SetFont('Times','',11);
                            $pdf->SetXY(8,34);
                            $pdf->MultiCell(52,5,$details,0,'L',false);
                        }
                    }

                    $pdf->setPage($pdf->getNumPages());
                    $y = $pdf->GetY() + 5;
                }

                $pdf->setPage($pdf->getNumPages());

                $footerY = 275;

                // Left side - Date
                $pdf->SetFont('helvetica','',10);
                $pdf->SetXY(70, $footerY);
                $pdf->Cell(60,5,'Date : '.date('d M Y'),0,0,'L');

                // Right side - Signature line
                $pdf->Line(150, $footerY-2, 190, $footerY-2);

                // Name below signature
                $pdf->SetXY(145, $footerY);
                $pdf->SetFont('times','I',11);
                $name = trim($job['full_name']);

                if (stripos($name, 'Dr.') !== 0) {
                    $name = 'Dr. ' . $name;
                }
                $pdf->Cell(45,5,$name,0,0,'R');




                    while (ob_get_level()) {
                            ob_end_clean();
                        }

                    $pdf->Output('Resume.pdf', 'I');
                    exit;
    }

    public function googleLogin()
    {
        $session = session();
        $db = \Config\Database::connect();

        $credential = $this->request->getPost('credential');

        $parts = explode('.', $credential);

        $payload = json_decode(
            base64_decode(
                str_replace(
                    ['-', '_'],
                    ['+', '/'],
                    $parts[1]
                )
            ),
            true
        );

        $email = $payload['email'] ?? '';
        $name  = $payload['name'] ?? '';

        // Check Existing User
        $user = $db->table('tbl_user')
                   ->where('email', $email)
                   ->where('user_type', 'jobseekar')
                   ->get()
                   ->getRowArray();

        if ($user)
        {
            $uid = $user['uid'];

            $jobseeker = $db->table('tbl_jobseeker')
                            ->where('uid', $uid)
                            ->get()
                            ->getRowArray();

            $session->set([
                'uid'                    => $uid,
                'jobseeker_email'        => $email,
                'isLoggedIn'             => true,
                'jobseeker_user_type'    => 'jobseekar',
                'jobseeker_full_name'    => $jobseeker['full_name'] ?? $name
            ]);

            return $this->response->setJSON([
                'status'   => 1,
                'redirect' => base_url('jobseeker/jobseeker_profile')
            ]);
        }

        // New User Insert
        $db->table('tbl_user')->insert([

            'email'           => $email,
            'user_type'       => 'jobseekar',
            'status'          => 'active',
            'login_status'    => 'active',
            'password'        => '',
            'otp'             => rand(100000,999999),
            'activation_code' => rand(100000,999999)
        ]);

        $uid = $db->insertID();

        $db->table('tbl_jobseeker')->insert([

            'uid'       => $uid,
            'full_name' => $name,
            'email'     => $email
        ]);

        $session->set([
            'uid'                    => $uid,
            'jobseeker_email'        => $email,
            'isLoggedIn'             => true,
            'jobseeker_user_type'    => 'jobseekar',
            'jobseeker_full_name'    => $name
        ]);

        return $this->response->setJSON([
            'status'   => 1,
            'redirect' => base_url('jobseeker/jobseeker_form')
        ]);
    }
    public function resumeBuilderHome()
    {
        $db = \Config\Database::connect();

        $data['job_role'] = $db->table('tbl_job_role')->orderBy('job_role', 'ASC')->get()->getResultArray();
        // $data['job_role'] = $db->table('tbl_job_role')->orderBy('job_role', 'ASC')->get()->getResultArray();
         $data['locations'] = $db->query("SELECT * FROM cities")->getResultArray();
         $data['qualifications'] = $db->query("SELECT * FROM tbl_qualification")->getResultArray();
        echo view('jobportal/jobseeker_resume_header');
        echo view('jobseeker/jobseeker_resume_home',$data);
        echo view('jobportal/footer');
    }

    public function save_resume_home_form()
    {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        // ============================
        // Profile Photo Upload
        // ============================
        $photoName = "";

        $photo = $this->request->getFile('profile_photo');

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            $photoName = time() . '_' . $photo->getRandomName();

            $photo->move(FCPATH . 'uploads/profile_photo/', $photoName);
        }

         $user = $this->db->table('tbl_user')
                     ->select('uid')
                     ->where('email', $email)
                     ->get()
                     ->getRow();

        if ($user) {
            $uid = $user->uid;
        } else {
            $uid = 0; 
        }
        // ============================
        // Jobseeker Data
        // ============================

        $jobseekerData = [
            'uid'                =>  $uid,
            'full_name'          => $this->request->getPost('full_name'),
            'job_id'           => $this->request->getPost('job_role'),
            'email'              => $email,
            'mobile_number'             => $this->request->getPost('mobile'),
            'education'          => $this->request->getPost('education'),
            'course'             => $this->request->getPost('course'),
            'current_city'       => $this->request->getPost('current_city'),
            'experience_years'   => $this->request->getPost('experience_years'),
            'experience_months'  => $this->request->getPost('experience_months'),
            'linkedin_url'       => $this->request->getPost('linkedin_url'),
            'key_skills'         => $this->request->getPost('key_skills'),
            'profile_image'      => $photoName,
            'created_date'         => date('Y-m-d H:i:s')
        ];
        // print_r($jobseekerData);
        // exit();

        $db->table('tbl_jobseeker')->insert($jobseekerData);

        // Insert ID
        $jobseekerId = $db->insertID();

        // ============================
        // Experience Save
        // ============================

        $company     = $this->request->getPost('company_name');
        $designation = $this->request->getPost('designation');
        $start       = $this->request->getPost('start_date');
        $end         = $this->request->getPost('end_date');
        $working     = $this->request->getPost('currently_working');
        $description = $this->request->getPost('job_description');

        if (!empty($company)) {

            foreach ($company as $key => $value) {
                $isCurrentWorking = isset($working[$key]) ? 1 : 0;
                if (trim($value) == '')
                    continue;

                $db->table('tbl_jobseeker_experience')->insert([

                    'jobseeker_id'      => $jobseekerId,
                    'company_name'      => $value,
                    'designation'       => $designation[$key],
                    'start_date'        => $start[$key],
                    'end_date'          => $isCurrentWorking ? NULL : ($endDate[$key] ?? NULL),
                    'currently_working' => isset($working[$key]) ? 1 : 0,
                    'job_description'   => $description[$key],
                    'created_at'        => date('Y-m-d H:i:s')

                ]);
            }
        }

        $db->table('tbl_user')
        ->where('uid', $uid)
        ->update([
            'full_name'    => $this->request->getPost('full_name'),
            'email'        => $email,
            'mobile_no'    => $this->request->getPost('mobile'),
            'login_status' => 'active'
        ]);

        return redirect()->to('resume-preview/' . $jobseekerId);
    }
    
    
    
    
    
    
    
    
    
    
}
