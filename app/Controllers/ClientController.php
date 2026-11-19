<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\ClintModel;
use CodeIgniter\Controller;
use App\Models\JobseekerModel;
use CodeIgniter\I18n\Time;

class ClientController extends BaseController
{
    
    public function index()
    {
        $db = \Config\Database::connect();
        $ClintModel = new ClintModel();
        $latestJobquery = $ClintModel->latestJobqueryDetailsData();
        $AllJobRoleDisplay = $ClintModel->AllJboRoleDispalyData();
        $latest_blogs = $ClintModel->latestThreeBlogsData();
        $award_display = $ClintModel->award_data_display();
            echo view('jobportal/header');
            echo view('client/home', [
        'latestJobquery'   => $latestJobquery,
        'AllJobRoleDisplay' => $AllJobRoleDisplay,
        'latest_blogs' =>$latest_blogs,
        'award_display'=>$award_display
        ]);
        echo view('jobportal/footer');
    }
    
    public function about_us()
    {
          echo view('jobportal/header');
          echo view('client/about_us');
          echo view('jobportal/footer');
    }
    public function gallery()
    {
        echo view('jobportal/header');
          echo view('client/gallery');
          echo view('jobportal/footer');
    }
    public function contact_us()
    {
        echo view('jobportal/header');
          echo view('client/contact_us');
          echo view('jobportal/footer');
    }
    public function apply_candidate_job($posting_id,$job_id)
    {
        $session = session();
         // echo $posting_id;
         // echo "<br>";
         //  echo $job_id;
         // exit();

        if ($session->has('jobseeker_user_type')) {
            //echo "hello";
            //echo $posting_id;

            //echo $job_id;
           return redirect()->to(base_url('client/jobseeker_profile_front/' . $posting_id . '/' . $job_id));
        }else
        {
            // 

             return view('client/jobseeeker_login_id',[
                'posting_id' => $posting_id,
                'job_id'     => $job_id
            ]);
        }
    }
    public function saveLoginFormCandidate()
    {
 
       
        $jobseekerModel = new JobseekerModel();
        $db = \Config\Database::connect();
        $user_type = $this->request->getPost('user_type');
        $otp = $this->request->getPost('otp');
        $activation_code = $this->request->getPost('activation_code');
        $email = $this->request->getPost('email');
        $job_id = $this->request->getPost('job_id');
        $posting_id = $this->request->getPost('posting_id');


        $data = [
            'user_type'       => $user_type,
            'otp'             => $otp,
            'activation_code' => $activation_code,
            'email'           => $email
        ];

        // Check email in both recruiter/jobseeker
        $email_result = $db->table('tbl_user')
            ->where('email', $email)
            ->whereIn('user_type', ['jobseekar', 'recruiter'])
            ->get()
            ->getResultArray();

        $existing_types = array_unique(array_column($email_result, 'user_type'));

        // ✅ CASE 1: Email exists with same user_type → update
        if (in_array($user_type, $existing_types) && count($existing_types) === 1) {
            $user_id = $email_result[0]['uid'];
            
            //whatsuppcall
            $user_mobile_no = $db->table('tbl_user')
                       ->select('mobile_no')
                       ->where('uid', $user_id)   // किंवा ->where('user_id', $user_id)
                       ->get()->getRow();

            $user_ph_no = $user_mobile_no->mobile_no;

            
            
            $jobseekerModel->userupdateDeatails($user_id, $data);
            session()->set('uid', $user_id);
             // session()->set('mobile_no', $mobile_number);
            session()->set('jobseeker_email', $email);

                $mobile_no = "91" . $user_ph_no;
            // $wa = new WhatsAppService();
            // $response = $wa->sendOtp($mobile_no,$otp);
            // return redirect with job_id
            $this->sendOtpMail($email, $otp, $activation_code, $user_type);

            // return redirect()->to('client/job_login_otp_front/' . $job_id);
            return redirect()->to('client/job_login_otp_front/' . $posting_id . '/' . $job_id);

        } 
        // ❌ CASE 2: Email exists with different user_type → block
        elseif (!empty($existing_types)) {
            session()->setFlashdata('error', '❌ Email already registered with another user type.');
            return redirect()->back();

        } 
        // ✅ CASE 3: Email is new → insert
        else {
            session()->setFlashdata('warning', 'Please Sign Up First!');
            return redirect()->to('apply-job/' . $posting_id . '/' . $job_id);

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
                session()->setFlashdata('message', '✅ OTP sent to your WhatsApp / email. Please verify.');
                session()->set([
                    'jobseeker_email' => $email,
                    'logged_in'           => true,
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
    public function jobLoginOtpFront($posting_id,$job_id)
    {
        $session = session();
        $email = session()->get('jobseeker_email');
        $otp = session()->get('jobseeker_otp');
        $uid = $session->get('uid');
        return view('client/job_login_otp_front',[
            'posting_id' => $posting_id,
            'job_id'     => $job_id
        ]);
    }
    public function saVeverifyOtpFront()
    {
        $session = session();
        $email = $session->get('jobseeker_email');
        $enteredOtp = $this->request->getPost('otp');
        $job_id = $this->request->getPost('job_id');
        $posting_id = $this->request->getPost('posting_id');
        if (!$email) {
            session()->setFlashdata('error', '❌ Session expired. Please try logging in again.');
            return view('client/jobseeeker_login_id',[
            'posting_id' => $posting_id,
            'job_id'     => $job_id
        ]);
        }else
        {
            $db = \Config\Database::connect(); 
            $user = $db->table('tbl_user')->where('email', $email)->get()->getRowArray();  
            $job = $db->table('tbl_job_role')->select('job_role')->where('job_id', $job_id)
            ->get()->getRow();
            $recruiter_user_id = $db->table('tbl_recruiter_posting')->select('user_id')
                                ->where('job_id', $job_id)
                                ->where('posting_id',$posting_id) // 🔹 additional condition
                                ->get()
                                ->getRow();
            $job_role = $job->job_role;
            $user_id = $recruiter_user_id->user_id;
            $recruiter_comapny_name = $db->table('tbl_recruiter')->select('company_display_name,created_date')->where('uid', $user_id)->get()->getRow();
            $r_company_name = $recruiter_comapny_name->company_display_name;
            $r_created_date = $recruiter_comapny_name->created_date;
            $recruiter_Date = date("d-m-Y", strtotime($r_created_date));
            $intrested_posting_apply_date = Time::now('Asia/Kolkata')->toLocalizedString('d MMMM yyyy');
            if ($user && $user['otp'] == $enteredOtp) 
            {
                if (isset($user['name'])) {
                    $this->sendLoginSuccessMail($email, $user['name'],$job_role,$r_company_name,$intrested_posting_apply_date);
                } else {
                    $this->sendLoginSuccessMail($email, $user['name'],$job_role,$r_company_name,$intrested_posting_apply_date);
                }
                if ($user['login_status'] === 'active') {
                  return redirect()->to('client/jobseeker_profile_front/' . $posting_id . '/' . $job_id);

                } else {
                    return redirect()->to('jobseeker/jobseeker_form');
                }
            } else {
                session()->setFlashdata('error', '❌ Invalid OTP.');
                 return view('client/jobseeeker_login_id',[
            'posting_id' => $posting_id,
            'job_id'     => $job_id
            ]);

            } 

        }
    }
    private function sendLoginSuccessMail($email, $candidateName, $job_role, $r_company_name, $intrested_posting_apply_date)
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
                $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');               // App password
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
            $mail->addAddress($email);
    
            $mail->isHTML(true);
             $mail->Subject = 'Welcome to ADIS INDIA Get Your Next Opportunity!';
    
            $mail->Body = '
            <p>Dear <strong>' . htmlspecialchars($candidateName) . '</strong>,</p>

            <p>Thank you for registering with <strong>ADIS India Placement Pvt. Ltd.</strong></p>

            <p>We are thrilled to support you in finding the right hospital or organization that values your skills and experience.</p>

            <p>We noticed that you recently showed interest in the role of 
            <strong>' . htmlspecialchars($job_role) . '</strong> at 
            <strong>' . htmlspecialchars($r_company_name) . '</strong> on 
            <strong>' . htmlspecialchars($intrested_posting_apply_date) . '</strong>.</p>

            <p>Your journey to your dream job starts here!<br>
            Explore and apply to the positions that suit you best our recruitment team will get in touch soon with the next steps.</p>

            <p>If you need any assistance, we are just a message or call away.</p>

            <br>
            <p>Warm regards,<br>
            <strong>Team ADIS INDIA Placement Pvt. Ltd.</strong><br>
            <a href="https://www.adisindiaplacement.com" style="color:green; font-weight:bold;">www.adisindiaplacement.com</a><br>
                 <a href="mailto:contact@adisindiaplacement.com">contact@adisindiaplacement.com</a><br>
                 <span style="font-weight:bold;">9607559547</span></p>
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
    public function jobseeker_profile_front($posting_id = null, $job_id = null) 
    {
        if (!session()->get('logged_in')) {
            // Not logged in → redirect to login page
            return redirect()->to(base_url('/'))->with('error', 'Please login first.');
        }

        $db = \Config\Database::connect();
        $session = session();
        $uid = $session->get('uid');  

        $ClintModel = new ClintModel();

        // 🔹 Store applied job in session
        if ($posting_id && $job_id) {
            $session->set('applied_posting_id',$posting_id);
            $session->set('applied_job_id', $job_id);
        }

        $latestJobquery = $ClintModel->latestJobqueryDetailsData_search_posting($posting_id);
        echo view('jobportal/client_header');
        echo view('client/clentjobseek_display_jobs', [
            'latestJobquery' => $latestJobquery
        ]);
         echo view('jobportal/footer');
    }
    public function home_logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('success', 'Logged out successfully.');
    }
    public function jobseeker_view_profile($recruiter_id = null, $posting_id = null)
    {
        
        $session = session();
        $db = \Config\Database::connect();
        if ($session->get('jobseeker_user_type') !== 'jobseekar') {
                    return redirect()->to(base_url('/'))->with('error', 'Please login first.');
        }
        // ✅ check if token in session matches DB
        $uid = $session->get('uid');
        $user = $db->table('tbl_user')->where('uid', $uid)->get()->getRowArray();

         $db = \Config\Database::connect();
                $builder = $db->table('tbl_recruiter_posting');
                $builder->where('posting_id',$posting_id);
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
                
                 $jobseeker_id = $db->table('tbl_jobseeker')
                    ->select('jobseeker_id')
                    ->where('uid', $uid)
                    ->get()
                    ->getRow('jobseeker_id');

                // === new recruiter table user_id ============
                    $tbl_recruiter_user_id = $db->table('tbl_recruiter')
                    ->select('uid')
                    ->where('recruiter_id', $recruiter_id)
                    ->get()
                     ->getRow('uid');
               
                $data['posting_id']   = $posting_id;
                $data['recruiter_id'] = $recruiter_id;
                $data['jobseeker_id'] = $jobseeker_id;
                $data['posting']   = $posting;
                $data['recruiter'] = $recruiter;
                $data['jobrole'] = $jobrole;
                $data['cities'] =$cities;
                $data['qualification'] = $qualification;
                $data['course'] = $course;
               $data['user_id']= $tbl_recruiter_user_id;
             
                echo view('jobportal/jobseeker_header');
                echo view('client/latest_job_profile_jobseeker',$data);
                echo view('jobportal/footer');
    }
    public function get_search_job()
    {
        $jobRole       = $this->request->getGet('job_role');
        $locationId    = $this->request->getGet('location_id');
        $employmentType = $this->request->getGet('employment_type');

        $ClintModel = new ClintModel();

        // ✅ Only search if at least one filter is filled
        if (!empty($jobRole) || !empty($locationId) || !empty($employmentType)) {
            $search_jobs = $ClintModel->searching_display_jobs($jobRole, $locationId, $employmentType);
        } else {
            $search_jobs = []; // nothing if all empty
        }

        echo view('jobportal/search_jobseeker_header', [
            'jobRole'        => $jobRole,
            'locationId'     => $locationId,
            'employmentType' => $employmentType,
        ]);
        echo view('client/job_search_list', ['search_jobs' => $search_jobs]);
        echo view('jobportal/footer');
    }
    public function trending_job($job_id)
    {
        $job_id       = $job_id;
        $ClintModel = new ClintModel();
        $trending_jobs = $ClintModel->trending_jobs_display($job_id);
        echo view('jobportal/header');
        echo view('client/trending_job_list', ['trending_jobs' => $trending_jobs]);
        echo view('jobportal/footer');
    }
    public function display_blogs()
    {
        $ClintModel = new ClintModel();
        $blogs_display = $ClintModel->blogs_data_display();

        echo view('jobportal/header');
        echo view('client/front_blog',['blogs_display'=>$blogs_display]);
        echo view('jobportal/footer');
    }
    public function single_blog_display($blog_id)
    {
        $ClintModel = new ClintModel();
         $data['single_blog']  = $ClintModel->single_blogs_data_display($blog_id);

        echo view('jobportal/header');
        echo view('client/single_blog_display',$data);
        echo view('jobportal/footer');

    }
     public function terms_of_service()
    {
        echo view('jobportal/header');
        echo view('client/terms_of_service');
        echo view('jobportal/footer');
    }
    public function privacy()
    {
        echo view('jobportal/header');
        echo view('client/privacy');
        echo view('jobportal/footer');
    }
    // public function all_jobs()
    // {
    //     $jobRole = $this->request->getGet('job_role');
    //     $ClintModel = new ClintModel();
    //      $data['jobs'] = $ClintModel->searching_client_jobs($jobRole);
      
    //     echo view('jobportal/header');
    //     echo view('client/all_jobs',$data);
    //     echo view('jobportal/footer');
        
    // }
    public function all_jobs()
    {
        $ClintModel = new \App\Models\ClintModel(); // make sure namespace is correct
    
        // Get search keyword (from GET request)
        $jobRole = $this->request->getGet('job_role');
    
        // Fetch jobs with pagination (5 per page)
        $jobs = $ClintModel->getPaginatedJobs($jobRole, 8);
    
        // Get pagination object
        $pager = $ClintModel->pager;
    
        // Load views
        echo view('jobportal/header');
        echo view('client/all_jobs', [
            'jobs' => $jobs,
            'pager' => $pager,
            'jobRole' => $jobRole,
        ]);
        echo view('jobportal/footer');
    }
    
    public function contact_save()
    {
        date_default_timezone_set('Asia/Kolkata');
        $ClintModel = new ClintModel();
        $contact_email = $this->request->getPost('contact_email');
        // Get form data
        $data = [
            'name'          => $this->request->getPost('name'),
            'contact_email' => $contact_email,
            'subject'       => $this->request->getPost('subject'),
            'message'       => $this->request->getPost('message'),
             'contact_registered_date' => date('Y-m-d'),
        ];
    
        // Insert into DB
          if ($ClintModel->saveContact($data)) {
    
        // Send admin email
        $this->sendContactMail($data['contact_email'], $data['name'], $data['subject'], $data['message']);
    
        // Send auto-reply to user
        $this->sendContactMail_user($data['contact_email'], $data['name']);
    
        // After sending emails, redirect back
        return redirect()->back()->with('success', 'Thank you! Your message has been sent.');
    
            } else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again.');
            }
    }
    
    private function sendContactMail($contact_email, $contact_name, $subject, $message)
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
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');
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
            $mail->addAddress('contact@adisindiaplacement.com');
            $mail->isHTML(true);

            
            $mail->Subject = 'New Contact Us Message: ' . $subject;
    
            $mail->Body = "
                <p>Hello Admin,</p>
                <p>You have received a new message from <strong>{$contact_name}</strong> ({$contact_email}) via Contact Us form.</p>
                <p><b>Subject:</b> {$subject}</p>
                <p><b>Message:</b><br>{$message}</p>
                <br>
                <p>Warm regards,<br><strong>Adis India Placement Team</strong></p>
            ";

            if ($mail->send()) {
                return true;
            } else {
                return '❌ Mail could not be sent: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            return '❌ Mail Exception: ' . $e->getMessage();
        }
    }
    
    
    // ===================== 23-01-2026 ==============================================

private function sendContactMail_user($contact_email, $contact_name)
{
     require_once APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require_once APPPATH . 'Libraries/PHPMailer/SMTP.php';
    require_once APPPATH . 'Libraries/PHPMailer/Exception.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Your Gmail
        $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');               // App password
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

        // Sender
        $mail->setFrom('contact@adisindiaplacement.com', 'Adis India Pvt Ltd');

        // Recipient (user)
        $mail->addAddress($contact_email);

        // Email format
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for contacting ADIS India Placement';
        $mail->Body = "
            <p>Dear {$contact_name},</p>
            <p>Thank you for contacting us.</p>
            <p>If you need more information, please contact us at <b>9607559547</b></p>
            <p>or sign up to your account for complete details.</p>
            <p>We will get back to you if any further assistance is required.</p>
            <br>
            <p>Thank you,<br><strong>Team ADIS India Placement</strong></p>
        ";

        // Send email
        $mail->send();

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        log_message('error', '❌ Contact Us auto-reply mail error: ' . $e->getMessage());
    }
}

    
    
    
    
    
    
    // ===================  01-11-2025 ===========================================
    public function signUpCandidate($posting_id, $job_id)
    {
        $data = [
            'posting_id' => $posting_id,
            'job_id'     => $job_id,
            'email'      => session()->get('email') 
            // if passed earlier
        ];
    
        return view('client/sign_up_candidate', $data);
    }
    
    public function client_jobseeker_signup()
    {
    
           $db = \Config\Database::connect();
            $email = $this->request->getPost('email');
            $user_type = $this->request->getPost('user_type');
            // $job_id = $this->request->getPost('job_id');
            $posting_id = $this->request->getPost('posting_id');
            $full_name = $this->request->getPost('full_name');
            // print_r($_POST);
            // exit();
            // Check if email exists
            $email_result = $db->table('tbl_user')
                                ->where('email', $email)
                                ->get()
                                ->getResultArray();
    
            // If no record found → Insert new user
            if (empty($email_result)) {
                return $this->insertUserClient($user_type, $email);
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
    
    private function insertUserClient($user_type, $email)
    {
        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kolkata');

        $otp = $this->request->getPost('otp');
        $activation_code = $this->request->getPost('activation_code');
        $job_id = $this->request->getPost('job_role');
        $posting_id = $this->request->getPost('posting_id');
        $full_name = $this->request->getPost('full_name');
        

        $data = [
            'user_type'       => $user_type,
            'otp'             => $otp,
            'activation_code' => $activation_code,
            'email'           => $email,
            'full_name'       => $full_name,
            'job_id'          => $job_id,
            'i_agree'         => $this->request->getPost('i_agree') ? 1 : 0,
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

        return redirect()->to('client-sign-otp_new/' . $job_id . '/' . $posting_id);
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
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');
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
                     // 'jobseekar_full_name'     => $jobseekar_full_name
                ]);
            } else {
                session()->setFlashdata('error', '❌ Mail could not be sent: ' . $mail->ErrorInfo);
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            session()->setFlashdata('error', '❌ Mail error: ' . $e->getMessage());
        }
    }
    
    public function client_sign_otp_new($job_id = null, $posting_id = null)
    {
        $data = [
            'job_id' => $job_id,
            'posting_id' => $posting_id,
        ];

            return view('client/client_sign_otp_new', $data);
    }
    
    public function verify_client_jobseeker_otp()
    {
        $session = session();
        $email = $session->get('jobseeker_email');
        $uid = $session->get('uid');

        $enteredOtp = $this->request->getPost('otp');
        $job_id = $this->request->getPost('job_id');
        $posting_id = $this->request->getPost('posting_id');


       
        if (!$email) {
            session()->setFlashdata('error', '❌ Session expired. Please try logging in again.');
            return redirect()->to('client-sign-otp_new/' . $job_id . '/' . $posting_id);
        }

        $db = \Config\Database::connect(); 
        $user = $db->table('tbl_user')->where('email', $email)->get()->getRowArray();
        $jobseeker_profile = $db->table('tbl_jobseeker')->where('uid', $uid)->get()->getRowArray();

            if ($user && $user['otp'] == $enteredOtp) {
                 // echo "hello";
        // exit();
                 $db->table('tbl_user')
                   ->where('email', $email)
                   ->update([
                       'status' => 'active',
                       'otp' =>''
                   ]);
        
                $name = $user['name'] ?? 'Jobseeker';
                $job = $db->table('tbl_job_role')->select('job_role')->where('job_id', $job_id)
                        ->get()->getRow();
          
        
                $this->sendLoginSuccess($email);
                // ========== 01-10-2025 =====================
                $user_status = $user['login_status'] ?? '';
                $profile_status = $jobseeker_profile['profile_status'] ?? '';

                // if ($user_status === 'active' && $profile_status === 'active') {
                    return redirect()->to('client/jobseeker_form_client/'. $job_id . '/' . $posting_id);
                // }

            } else {
                session()->setFlashdata('error', '❌ Invalid OTP.');
                return redirect()->to('client-sign-otp_new/' . $job_id . '/' . $posting_id);
            }
    }
    
    private function sendLoginSuccess($email)
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
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');            // App Password
            $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
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
                <p>Dear ,</p>
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
    
    public function jobseeker_form_client($job_id, $posting_id)
    {
        $session = session();

        if($session->has('jobseeker_email')) 
        {
            $data = [
                'job_id' => $job_id,
                'posting_id' => $posting_id
            ];

            echo view('jobportal/header');
            echo view('client/jobseeker_form_client_view', $data);
            echo view('jobportal/footer');
            
        } else {
            return redirect()->to(base_url('/'));
        }
    }
    
    public function save_jobseeker_form_client()
    {
         $session = session();
   
        $db = \Config\Database::connect(); 
        $jobseekerModel = new JobseekerModel();
        $expectedCities = $this->request->getPost('expected_cities');
        $expectedCitiesString = is_array($expectedCities) ? implode(',', $expectedCities) : '';

        $job_id = $this->request->getPost('job_role');
        //$jobRoleString = is_array($job_role) ? implode(',', $job_role) : $job_role;
        $full_name = $this->request->getPost('full_name');
        $education = $this->request->getPost('education');
        $course = $this->request->getPost('course');
        $email = $this->request->getPost('email');
        $mobile_number = $this->request->getPost('mobile_number');
        $current_city = $this->request->getPost('current_city');
        $apply_job_id = $this->request->getPost('apply_job_id');
        $apply_posting_id = $this->request->getPost('apply_posting_id');
        $fellowship=$this->request->getPost('fellowship');

        // ================================= 13-07-2026 =========
        $resumeFile   = $this->request->getFile('resume');
        $marital_status = $this->request->getPost('marital_status');
        $spouse_type    = $this->request->getPost('spouse_type');
        $insurance_policy    = $this->request->getPost('insurance_policy');
        // $resumeName = $resumeFile->getRandomName();
        $uid = $session->get('uid');
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
        $candidate_full_address = $this->request->getPost('candidate_full_address');
        
        // ================09/07/2026 ===================================//
        // $resumeFile->move(FCPATH . 'jobseeker/resume/', $resumeName);

        $resumeName = NULL;
        $fileName   = NULL;

        if ($linkdin_profile == 'No') 
        {
            $linkedin_url = NULL;
        }
        if ($cvOption == 'yes') 
        {
            if (!$resumeFile || !$resumeFile->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Please upload your resume.');
            }

            $resumeName = $resumeFile->getRandomName();
            $resumeFile->move(FCPATH . 'jobseeker/resume/', $resumeName);
        }

        if (!empty($croppedImage)) 
        {

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
                        'job_id'    =>$job_id,
                        'full_name'       => $full_name,
                        'education'   => $education,
                        'course'      => $course,
                        'email'           => $email,
                        'mobile_number'   => $mobile_number,
                        'current_city'    => $current_city,
                        'expected_cities' => $expectedCitiesString,
                        'fellowship'      => $fellowship,
                        'resume'          => $resumeName,
                        'marital_status' => $marital_status,
                        'spouse_type'    => ($marital_status == 'Married') ? $spouse_type : NULL,
                        'uid'=>$uid,
                        'insurance_policy'=>$insurance_policy,
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
                        'created_date'      => date('Y-m-d H:i:s')
                    ];

                    $uid_check = $db->table('tbl_jobseeker');
                    $uid_result = $uid_check->where('uid',$uid)->get()->getResultArray();
                    if (!empty($uid_result)) 
                    {
                        return redirect()->to('jobseeker/jobseeker_form')->with('error', 'Candidate Alredy exsit!!');
             
                    }else
                    {
                        // echo "bye";
                        $job = $db->table('tbl_job_role')->select('job_role')->where('job_id',$apply_job_id)
                            ->get()->getRow();
                        $candidateName = $full_name;
                          $recruiter_user_id = $db->table('tbl_recruiter_posting')->select('user_id')
                                                ->where('job_id', $apply_job_id)
                                                ->where('posting_id',$apply_posting_id) 
                                                ->get()
                                                ->getRow();
                            $job_role = $job->job_role;

                            $user_id = $recruiter_user_id->user_id;

                            $recruiter_comapny_name = $db->table('tbl_recruiter')->select('company_display_name,created_date')->where('uid', $user_id)->get()->getRow();
                            $r_company_name = $recruiter_comapny_name->company_display_name;
                            $intrested_posting_apply_date = Time::now('Asia/Kolkata')->toLocalizedString('d MMMM yyyy');
                         $posting_data = $jobseekerModel->saveJobseekerForm($data);

                         $this->sendLogininrestedapplyposting($email,$candidateName,$job_role,$r_company_name,$intrested_posting_apply_date);
                        $db->table('tbl_user')
                            ->where('uid', $uid)
                            ->update([
                             
                                'login_status'    => 'active', // ✅ Add this line
                                'full_name'        => $full_name,
                                'job_id'        => $job_role
                            ]);


                        if ($posting_data) {
                         return redirect()
                            ->to('client/jobseeker_view_profile/'.$apply_job_id.'/'.$apply_posting_id)
                            ->with('success', 'Application submitted successfully!');
                        } else {
                            return redirect()->back()->withInput()->with('error', 'Failed to submit. Try again.');
                        }

                    }

       
    }
    
    private function sendLogininrestedapplyposting($email,$candidateName,$job_role,$r_company_name,$intrested_posting_apply_date)
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
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');             // App Password
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
            $mail->Subject = 'Welcome to ADIS INDIA Get Your Next Opportunity!';

            $mail->Body = '
            <p>Dear <strong>' . htmlspecialchars($candidateName) . '</strong>,</p>

            <p>Thank you for registering with <strong>ADIS India Placement Pvt. Ltd.</strong></p>

            <p>We are thrilled to support you in finding the right hospital or organization that values your skills and experience.</p>

            <p>We noticed that you recently showed interest in the role of 
            <strong>' . htmlspecialchars($job_role) . '</strong> at 
            <strong>' . htmlspecialchars($r_company_name) . '</strong> on 
            <strong>' . htmlspecialchars($intrested_posting_apply_date) . '</strong>.</p>

            <p>Your journey to your dream job starts here!<br>
            Explore and apply to the positions that suit you best our recruitment team will get in touch soon with the next steps.</p>

            <p>If you need any assistance, we are just a message or call away.</p>

            <br>
            <p>Warm regards,<br>
            <strong>Team ADIS INDIA Placement Pvt. Ltd.</strong><br>
            <a href="https://www.adisindiaplacement.com" style="color:green; font-weight:bold;">www.adisindiaplacement.com</a><br>
                 <a href="mailto:contact@adisindiaplacement.com">contact@adisindiaplacement.com</a><br>
                 <span style="font-weight:bold;">9607559547</span></p>
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
    
     public function award_details($award_id)
    {
        $ClintModel = new ClintModel();
         $data['single_award_data']  = $ClintModel->single_award_data_display($award_id);
        echo view('jobportal/header');
        echo view('client/single_award_display',$data);
        echo view('jobportal/footer');

    }










    

}
