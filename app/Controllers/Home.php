<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\HomeModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DateTime;
class Home extends BaseController
{

    protected $db;
    public function __construct()
    {
        // parent::__construct();
        $this->db = \Config\Database::connect(); // This connects once
    }
    public function index(): string
    {
        return view('welcome_message');
    }
    public function register_form()
    {
    	return view('signup_form');
    }
    public function all_login()
    {
         return view('home/all_login');
    }
    public function recruiter_sign_up()
    {
        $homeModel = new HomeModel();
        $db = \Config\Database::connect();
        
        // Set Indian timezone
        date_default_timezone_set('Asia/Kolkata');
        
        $email = $this->request->getPost('email');
        $data = [
            'user_type'        => $this->request->getPost('user_type'),
            'otp'              => $this->request->getPost('otp'),
            'activation_code'  => $this->request->getPost('activation_code'),
            'email'            => $email,
            'mobile_no'        => $this->request->getPost('mobile_no'),
            'registered_date' => date('Y-m-d'),
            'password'         => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        // ✅ Check if email already exists
        $email_check = $db->table('tbl_user');
        $email_result = $email_check->where('email', $email)->get()->getResultArray();

        if (!empty($email_result)) {
            // If user already exists
            if ($email_result[0]['status'] === 'active') {
                session()->setFlashdata('error', 'Email already exists!');
                session()->setFlashdata('activeTab', 'signup');
                return redirect()->back()->withInput();
            } else {
                // Update existing inactive user
                $user_id = $email_result[0]['uid'];
                $homeModel->userupdateDeatails($user_id, $data);
            }
        } else {
            // Insert new user
            $homeModel->userDeatails($data);
        }

        // ✅ Send OTP Email
        if ($this->sendOtpMail($email, $data['otp'])) {
            session()->setFlashdata('message', '✅ Please check your email for the verification code.');
            return redirect()->to('/home/verify_otp_page?activation_code=' . $data['activation_code']);
        } else {
            session()->setFlashdata('error', '❌ Mail could not be sent. Please try again.');
            return redirect()->back();
        }
    }
    private function sendOtpMail($email, $otp)
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

            $mail->setFrom('tejaswinideshpande17@gmail.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);
        $mail->isHTML(true);
            $mail->Subject = 'Verification code to verify your Email Address';
            $mail->Body    = "
                <p>For verifying your email address, enter this verification code when prompted: <b>$otp</b>.</p>
                <p>Sincerely,<br>Adis India Pvt Ltd</p>";

            return $mail->send();
        } catch (Exception $e) {
            log_message('error', 'Mail Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
    public function verify_otp_page($code = null)
    {
         $code = $this->request->getGet('activation_code');
        
        return view('home/verify_otp_page', ['activation_code' => $code]);

    }
    public function verify_otp()
    {
        $homeModel = new HomeModel();

        $activationCode = $this->request->getPost('activation_code');
        $otp = $this->request->getPost('otp');

        if (!empty($activationCode)) 
        {
            $db = \Config\Database::connect();
            $activation_code_check = $db->table('tbl_user');
            $activation_code_result = $activation_code_check
                        ->where('activation_code', $activationCode)
                        ->get()
                        ->getResultArray();

            if (!empty($activation_code_result)) 
            {
                $rowOtp = $activation_code_result[0]['otp'];

                if ($rowOtp !== $otp) 
                {
                    session()->setFlashdata('error', '❌ Please provide Correct OTP!...');
                    return redirect()->to('/home/verify_otp_page?activation_code=' . $activationCode);
                } 
                else 
                {
                    // OTP is correct — update user
                    $builder = $db->table('tbl_user');
                    $updated = $builder->where('activation_code', $activationCode)
                                       ->where('otp', $otp)
                                       ->update([
                                           'status' => 'active',
                                           'otp' => ''
                                       ]);

                    session()->setFlashdata('message', '🎉 Signup successful! Please check your email to verify your account.');
                    return redirect()->to(base_url('recruiter-login') . '?activeTab=login');
                }

            } 
            else
            {
                echo "❌ Invalid Activation Code.";
            }

        } 
        else 
        {
            echo "❌ No Activation Code provided.";
        }
    }
    public function save_signup()
    {

    	$userModel = new UserModel();
        $request = service('request');

        $sponsor_id = $request->getPost('sponsor_id');
        $name = $request->getPost('name');
        $email = $request->getPost('email');
        $password = password_hash($request->getPost('password'), PASSWORD_BCRYPT);
        
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'sponsor_id' => $sponsor_id,
        ];

        $user_id = $userModel->addUser($sponsor_id, $data);

        if ($user_id) {
            return redirect()->to('/')->with('success', 'User registered successfully!');
        } else {
            return redirect()->to('/')->with('error', 'Sponsor has already two users.');
        }
    }
    public function jobseeeker_login()
    {
        $tab = $this->request->getGet('tab'); // URL madhun tab gheto

        $data['activeTab'] = ($tab === 'signup') ? 'signup' : 'login';

         return view('home/jobseeeker_login_new', $data);
         
    }
    public function resend_otp()
    {
        $db = \Config\Database::connect();

        $old_code = $this->request->getGet('activation_code');

        // 1. Check if activation code exists
        $activation_code_result = $db->table('tbl_user')
                                    ->where('activation_code', $old_code)
                                    ->get()
                                    ->getResultArray();

        if (empty($activation_code_result)) {
            return redirect()->back()->with('error', 'Invalid or expired activation code.');
        }

        // 2. Get user email
        $email = $activation_code_result[0]['email'];

        // 3. Generate new OTP and activation code
        $otp = substr(str_shuffle("0123456789"), 0, 5);
        $random_num = rand(100000, 10000000);
        $activation_code = str_shuffle("abcdefghijklmno" . $random_num);

        // 4. Update OTP and activation code in database
        $updated = $db->table('tbl_user')
                    ->where('activation_code', $old_code)
                    ->update([
                        'otp' => $otp,
                        'activation_code' => $activation_code
                    ]);

        // 5. Send Mail
        if ($updated && $activation_code_result[0]['status'] !== 'active') {
            $mailSent = $this->resendOtpMail($email, $otp);

            if ($mailSent) {
                session()->setFlashdata('message', '✅ OTP has been resent successfully.');
                return redirect()->to('/home/verify_otp_page?activation_code=' . $activation_code);
            } else {
                session()->setFlashdata('error', '❌ Mail could not be sent. Please try again.');
                return redirect()->back();
            }
        } else {
            return redirect()->to('/home/verify_otp_page?activation_code=' . $old_code)
                             ->with('error', 'Failed to resend OTP. Please try again.');
        }
    }
    private function resendOtpMail($email, $otp)
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
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('tejaswinideshpande17@gmail.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verification code for your Email Address';
            $mail->Body    = '
                <p>Hello,</p>
                <p>Your new verification code is: <b>' . $otp . '</b></p>
                <p>Please enter this code to verify your email address.</p>
                <br>
                <p>Thanks,<br>Adis India Pvt Ltd</p>';

            return $mail->send(); // true/false
        } catch (\Exception $e) {
            log_message('error', 'PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
    public function recruiter_login()
    {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $builder = $db->table('tbl_user');
        $user = $builder->where('email', $email)
                        ->where('status', 'active')
                        ->get()
                        ->getRowArray();
    
            if ($user) 
            {
                $storedPassword = $user['password'];
             
                // ✅ Use password_verify instead of direct comparison
                if (password_verify($password, $storedPassword)) 
                {
                    
                    $user_id = session()->get('uid');
                    
                    $recruiterName = $db->table('tbl_recruiter')
                    ->where('uid',$user['uid'])
                    ->get()
                    ->getRowArray();
                    
                    $recruiter_full_name = $recruiterName ? $recruiterName['recruiter_name'] : null;
                    $req_status = $db->table('tbl_recruiter');
                    
                    $req_status = $db->table('tbl_recruiter');
                    $recruiter_form_status = $req_status->where('uid',$user['uid'])
                                                ->where('form_status', 'active')
                                                ->get()
                                                ->getRowArray();

                    session()->set([
                        'email' => $user['email'],
                        'uid'   => $user['uid'],
                        'recruiter_user_type' =>$user['user_type'],
                        'recruiter_full_name' =>$recruiter_full_name,
                    ]);

                    $post_status = $db->table('tbl_recruiter_posting')
                  ->where('user_id',$user['uid'])
                  ->where('posting_form_status', 'active')
                  ->countAllResults();

                    if ($user['login_status'] == 'active') 
                    {
               
                       if (!empty($recruiter_form_status) && $recruiter_form_status['form_status'] === 'active') 
                        {
                            if ($post_status > 0)
                            {
                                    // ✅ At least one active posting exists
                                    return redirect()->to('/recruiter/publishsavedraft');
                            } else
                            {
                                    // ❌ No active postings
                                    return redirect()->to('/recruiter/recruiter_posting_form');
                            }
                        } else {
                         return redirect()->to('/recruiter/register_form');
                        }
                    } else 
                    {
                    // 🔐 OTP Login - Email not verified
                    $otp = substr(str_shuffle("0123456789"), 0, 5);
    
                    $builder->where('email', $email)->update([
                        'otp' => $otp,
                        'login_status' => 'active',
                    ]);

                    $sent = $this->loginsendOtpMail($email, $otp); // 🔁 Call the function

                    if ($sent === true) {
                        session()->setFlashdata('message', '✅ OTP sent to your email. Please verify to complete login.');
                        return redirect()->to('/home/recruter_login_otp');
                    } else {
                        session()->setFlashdata('error', $sent); // error message
                        return redirect()->back();
                    }
                }
                    } else 
                    {
                        session()->setFlashdata('error', '❌ Incorrect password!');
                        session()->setFlashdata('activeTab', 'login');
                        return redirect()->back();
                    }
            } else {
                session()->setFlashdata('error', '❌ User not found!');
                session()->setFlashdata('activeTab', 'login');
                return redirect()->back();
            }
    }
    private function loginsendOtpMail($email, $otp)
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
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');       // App Password
            $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
            $mail->Port       = 587;
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            $mail->setFrom('tejaswinideshpande17@gmail.com', 'Adis India Placement Pvt Ltd');
            $mail->addAddress($email);
            $mail->isHTML(true);

            
            $mail->Subject = 'Verification code for verify Your Email Address';
            $mail->Body    = '
                <p>For Verify Your Email Address, Enter this Verification code when prompted: <b>' . $otp . '</b></p>
                <p>Sincerely,<br>Adis India Pvt Ltd</p>
            ';

            if ($mail->send()) {
                return true;
            } else {
                return '❌ Mail could not be sent: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            return '❌ Mail Exception: ' . $e->getMessage();
        }
    }
    public function recruter_login_otp()
    {
       $session = session();

        if ($session->has('email')) {
            return view('home/recruter_login_otp');
        } else {
           return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

        }
    }
    public function verify_recruter_otp()
    {
        $enteredOtp = $this->request->getPost('otp');
        $email = session()->get('email');

        $db = \Config\Database::connect(); 
        $user = $db->table('tbl_user')->where('email', $email)->get()->getRowArray();  
        if ($user && $user['otp'] == $enteredOtp) 
        {
            $session = session();
             if ($session->has('email'))
            {
                 $user_id = session()->get('uid');

                $req_status = $db->table('tbl_recruiter');
                $recruiter_form_status = $req_status->where('uid', $user_id)
                                                ->where('form_status', 'active')
                                                ->get()
                                                ->getRowArray();
                $post_status = $db->table('tbl_recruiter_posting')
                  ->where('user_id', $user_id)
                  ->where('posting_form_status', 'active')
                  ->countAllResults();
                  if (!empty($recruiter_form_status) && $recruiter_form_status['form_status'] === 'active') {
                // echo "hello";
                    if ($post_status > 0)
                    {
                            return redirect()->to('/recruiter/publishsavedraft');
                    } else
                    {
                            return redirect()->to('/recruiter/recruiter_posting_form');
                    }
                } else {
                   // echo "bye";
                  return redirect()->to('/recruiter/register_form');
                }
                 // return redirect()->to('/recruiter/register_form');
            }else
            {
                    return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
         
        } else {
            session()->setFlashdata('error', '❌ Invalid OTP.');
            return redirect()->to('/home/recruter_login_otp');
        } 
    }
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('message', 'You have been logged out successfully.');
        return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

    }

}
