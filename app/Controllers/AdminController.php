<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\ClintModel;
use App\Models\HomeModel;
use App\Models\RecruiterModel;
require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';



class AdminController extends BaseController
{
    public function index()
    {
        // return view('client/index');
        echo view('jobportal/header');
        // echo view('client/home');
        echo view('jobportal/footer');
    }
    public function adminlogin()
    {
        //echo view('admin/header');
         echo view('admin/adminlogin');
       // echo view('admin/footer');
    }
    public function loginformadmin()
    {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');

        // Get user by email
        $builder = $db->table('tbl_user');
        $user = $builder->where('name', $name)->get()->getRowArray();
         if ($user) {
                    session()->set([
                                     'password' => $user['password'],
                                     'user_type'=> $user['user_type'],
                                      'name'   => $user['name'],
                                    ]);
                $storedPassword = $user['password']; 
                if($password == $storedPassword)
                {
                    //return redirect()->to('admin/admindashboard');
                    if($user['user_type'] != 'Trainer') 
                    {
                        return redirect()->to('admin/admindashboard');
                    }else
                    {
                        return redirect()->to('traning/traningdashboard');
                    }
                }else
                {
                    session()->setFlashdata('error', 'Incorrect password!');
                    return redirect()->to('admin');
                }
         }else
         {
            session()->setFlashdata('error', 'User not found!');
            return redirect()->to('admin');
         }

       // echo $db->getLastQuery();
    }
    public function admindashboard()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }

        $username = session()->get('name');

        // print_r($_SESSION);
        echo view('admin/header');
        echo view('admin/admindashboard');
        echo view('admin/footer');
         
       // echo "Welcome, $username!";
    // Load dashboard view
    }
    public function client_dashboard()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }

        $username = session()->get('name');
        echo view('admin/header');
        echo view('admin/clientdashboard');
        echo view('admin/footer');
    }
    public function client_details()
    {   
        $session = session();
         if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }

        $username = session()->get('name');
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $recuiterData = $AdminModel->getrecruiterDetails();
        echo view('admin/header');
        echo view('admin/client_details',['recuiterData' => $recuiterData]);
        echo view('admin/footer');
    }
    public function viewRecruiterPosting($uid)
    {
        $db = \Config\Database::connect();
        // $builder = $db->table('tbl_recruiter_post');
        // $count = $builder->where('user_id', $uid)->countAllResults();
        $AdminModel = new AdminModel();
        $recuiterPostingData = $AdminModel->getrecruiterPostingDetails($uid);
        // $data['uid'] = $uid;
        // $data['post_count'] = $count;

        echo view('admin/header');
        // echo view('admin/view_recruiter_posting', $data);
        echo view('admin/view_recruiter_posting', [
                                                    'recuiterPostingData' => $recuiterPostingData,
                                                    'uid' => $uid
                                                  ]);
        echo view('admin/footer');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('admin');
    }
    public function update_admin_status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $db = \Config\Database::connect();
        $recruitername = $db->table('tbl_jobseeker js')
            ->select('js.full_name,js.mobile_number,js.email AS candidate_email,rp.job_id, jr.job_role, r.email AS recruiter_email,r.recruiter_name,r.company_display_name AS company_name,cs.applied_at,r.city_id,c.name AS city_name')
            ->join('tbl_candidate_job_status cs', 'cs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter_posting rp', 'rp.posting_id = cs.posting_id')
            ->join('tbl_job_role jr', 'jr.job_id = rp.job_id')   // ✅ corrected join
            ->join('tbl_recruiter r', 'r.uid = rp.user_id')
            ->join('cities c', 'c.id = r.city_id', 'left')
            ->where('cs.job_status_id', $id)
            ->get()
            ->getRowArray();

            // echo  $recruitername['mobile_number'];
            // echo "<pre>";
            // echo $interview_schedule_date = $recruitername['applied_at'];

            
        // exit();
           if ($status === 'Interview Schedule' && $recruitername) 
            {
                $mobile_no = "91" . $recruitername['mobile_number'];
                $interview_schedule_date = date('j F Y', strtotime($recruitername['applied_at']));
                $wa = new WhatsAppService();
                $response = $wa->sendInterviewSchedule(
                    $mobile_no,
                    $recruitername['full_name'],
                    $recruitername['company_name'],
                    $recruitername['job_role'],$interview_schedule_date,$recruitername['city_name']
                );
               $this->sendInterviewScheduleMail(
                    $recruitername['recruiter_email'],  // 1st param → email
                    $recruitername['full_name'],        // 2nd param → candidate name
                    $recruitername['recruiter_name'],   // 3rd param → recruiter name
                    $recruitername['job_role']          // 4th param → job role
                );
            }
            if ($status === 'Closed' && $recruitername) 
            {
                $this->sendCandidateSelectionMail(
                    $recruitername['candidate_email'],   // candidate mail
                    $recruitername['full_name'],         // candidate name
                    $recruitername['company_name'],      // company name
                    $recruitername['job_role']           // job role
                );
                
                // ✅ Update joining_date (current date)
                $db->table('tbl_candidate_job_status')
                    ->where('job_status_id',$id)
                    ->update([
                        'joining_date' => date('Y-m-d')  // current date
                    ]);
                    echo $db->getLastQuery();
                
            }
            if ($status === 'Profile_shared_client' && $recruitername) 
            {
                 $db->table('tbl_candidate_job_status')
                    ->where('job_status_id',$id)
                    ->update([
                        'profile_shared_date' => date('Y-m-d')  // current date
                    ]);
                    echo $db->getLastQuery();
            }
        
            $builder = $db->table('tbl_candidate_job_status');
            $builder->where('job_status_id', $id); // or use correct primary key
            //$builder->update(['admin_candidate_status' => $status]);
             $builder->update([
                            'admin_candidate_status' => $status,
                            'applied_at' =>date('Y-m-d H:i:s')
                        ]);
    
            return $this->response->setJSON(['status' => 'success']);
    }
    private function sendInterviewScheduleMail($email, $candidateName, $RecruiterNames, $jobRole)
    {
            require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
            require APPPATH . 'Libraries/PHPMailer/SMTP.php';
            require APPPATH . 'Libraries/PHPMailer/Exception.php';

            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = env('EMAIL_SMTP_USERNAME', '');
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
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Interview Schedule Notification - Adis India Placement';

                $mail->Body = '
                    <p>Dear ' . htmlspecialchars($RecruiterNames) . ',</p>
                    <p>This is to inform you that an <strong>interview has been scheduled</strong> for the following candidate:</p>
                    <ul>
                        <li><strong>Candidate Name:</strong> ' . htmlspecialchars($candidateName) . '</li>
                        <li><strong>Job Role:</strong> ' . htmlspecialchars($jobRole) . '</li>
                    </ul>
                    <p>Please proceed with the necessary arrangements.</p>
                    <br>
                    <p>Warm regards,<br><strong>Adis India Placement Team</strong></p>
                ';

                $mail->send();

            } catch (\PHPMailer\PHPMailer\Exception $e) {
                log_message('error', '❌ Interview schedule mail error: ' . $e->getMessage());
            }
    }
    private function sendCandidateSelectionMail($email, $candidateName, $companyName, $jobRole)
    {
        require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
        require APPPATH . 'Libraries/PHPMailer/SMTP.php';
        require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', '');
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
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Congratulations! You are Selected - Adis India Placement';

            $mail->Body = '
                <p>Dear ' . htmlspecialchars($candidateName) . ',</p>
                <p>We are delighted to inform you that you have been <strong>selected</strong> for the role of 
                <strong>' . htmlspecialchars($jobRole) . '</strong> at <strong>' . htmlspecialchars($companyName) . '</strong>.</p>
                
                <p>Your skills and experience have impressed the recruiters, and we are excited to welcome you onboard.</p>
                
                <p>Congratulations once again and wishing you all the success in your new role!</p>
                
                <br>
                <p>Warm regards,<br><strong>Adis India Placement Team</strong></p>
            ';

            $mail->send();

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            log_message('error', '❌ Candidate selection mail error: ' . $e->getMessage());
        }
    }
    public function apply_canidate_records($postingId, $userId)
    {   
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $db = \Config\Database::connect();
         $candidates = $db->table('tbl_candidate_job_status cs')
        ->select('cs.admin_candidate_status, cs.job_status_id, js.*, c.name AS current_city_name')
        ->join('tbl_jobseeker js', 'cs.jobseeker_id = js.jobseeker_id')
        ->join('cities c', 'js.current_city = c.id', 'left')
        ->where('cs.posting_id', $postingId)
        ->where('cs.user_id', $userId)
        ->where('cs.admin_candidate_status !=', 'Closed') // ✅ not equal
        ->get()
        ->getResultArray();
       
            echo view('admin/header');
            echo view('admin/apply_canidate_records',['candidates' =>$candidates,'userId'=> $userId ]);
            echo view('admin/footer');
    }
    public function candidate_details()
    {   
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $db = \Config\Database::connect();
        $AdminModel = new AdminModel();
        $candidate_details = $AdminModel->candidateDetailsData();
        echo view('admin/header');
        echo view('admin/candidate_details',['candidate_details' =>$candidate_details]);
        echo view('admin/footer');
    }
    public function display_total_closed_candidate()
    {
        $db = \Config\Database::connect();

        $AdminModel = new AdminModel();
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $candidate_closed_details = $AdminModel->candidateClosedDetailsData();
        echo view('admin/header');
        echo view('admin/display_total_closed_candidate',['candidate_closed_details' =>$candidate_closed_details]);
        echo view('admin/footer');
    }
    public function Add_blogs()
    {   
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        echo view('admin/header');
        echo view('admin/add_blogs');
        echo view('admin/footer');
    }
    public function save_blog()
    {
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('blogs'); // your table name
        $AdminModel = new AdminModel();
        $imageName = null;
        $file = $this->request->getFile('blog_image');
        if ($file && $file->isValid()) {
       $imageName = $file->getRandomName();

        // Move file to 'admin_assets/images' folder
        $file->move(FCPATH.'admin_blog/images', $imageName);
                
        }

        // 2️⃣ Get other form data
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        // 3️⃣ Insert into database
        $data = [
            'blog_title' => $title,
            'blog_comment   ' => $content,
            'blog_image' => $imageName
        ];

       $add_blog_data = $AdminModel->addBlogData($data);

        // 4️⃣ Redirect or show message
       return redirect()->to(base_url('admin/add_blogs'))->with('success', 'Blog added successfully!');
    }
    public function display_blogs()
    {   
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $ClintModel = new ClintModel();
        $blogs_display = $ClintModel->blogs_data_display();
        echo view('admin/header');
        echo view('admin/display_list_blogs',['blogs_display'=>$blogs_display]);
        echo view('admin/footer'); 
    }
    public function delete_blog($blog_id)
    {
        if(!$blog_id){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Blog ID missing']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_blogs');
        $deleted = $builder->delete(['blog_id' => $blog_id]);

        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setStatusCode(404)
                                 ->setJSON(['status' => 'error', 'message' => 'Record not found']);
        }
    }
    public function edit_blog($blog_id)
    {
        $AdminModel = new AdminModel();
        $single_blog_edit = $AdminModel->single_blog_edit($blog_id);
        echo view('admin/header');
        echo view('admin/edit_blog',['single_blog_edit'=>$single_blog_edit]);
        echo view('admin/footer'); 
    }
    public function update_blog()
    {
        $AdminModel = new \App\Models\AdminModel();
        $request = $this->request;
        // Get POST data
        $blog_id = $request->getPost('blog_id'); // make sure your hidden input has name="blog_id"
        $blog_title = $request->getPost('blog_title');
        $blog_comment = $request->getPost('blog_comment');

        $data = [
            'blog_title' => $blog_title,
            'blog_comment' => $blog_comment,
            'created_at'   => date('Y-m-d H:i:s') // update date
        ];

        // Handle image upload
        $image = $request->getFile('blog_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Generate a new random name for the image
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'admin_blog/images', $newName); // folder path
            $data['blog_image'] = $newName;
        }

        // Update blog in database
        $updated = $AdminModel->update_blog_data($blog_id, $data);

        if($updated){
            return redirect()->to(base_url('admin/display_blogs'))->with('success', 'Blog updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function add_employers()
    {   
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        echo view('admin/header');
        echo view('admin/add_employers');
        echo view('admin/footer');
    }
    public function checkInstitute()
    {   
        $instituteName = $this->request->getPost('institute_name');
        $db = \Config\Database::connect();
        
        $exists = $db->table('tbl_recruiter')
                 ->where("LOWER(REPLACE(institute_name, ' ', ''))", strtolower(str_replace(' ', '', $instituteName)))
                 ->countAllResults() > 0;

        return $this->response->setJSON(['exists' => $exists]);
    }
    public function saveEmployeer()
    {
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();

        // Start transaction
        $db->transStart();

        // Post data
        $userType = $this->request->getPost('user_type');
        $activation_code = $this->request->getPost('activation_code');
        $otp = $this->request->getPost('otp');
        $password = $this->request->getPost('password');
        $mobileNumber = $this->request->getPost('mobile_number');
        $email = $this->request->getPost('institute_email');
        $industry_name = $this->request->getPost('industry_name');
        $type_hospital = $this->request->getPost('type_hospital');
        $institute_name = $this->request->getPost('institute_name');
        $company_display_name = $this->request->getPost('company_display_name');
        $pincode = $this->request->getPost('pincode');
        $city_id = $this->request->getPost('city_id');
        $recruiter_name = $this->request->getPost('recruiter_name');
        $area_name = $this->request->getPost('area_name');
        $client_reg_type = $this->request->getPost('company_regis_type');
        $client_reg_fees = $this->request->getPost('company_registraion');
         // Set Indian timezone
        date_default_timezone_set('Asia/Kolkata');
        
        // Check if user already exists
        if ($AdminModel->checkUserExists($email)) {
            return redirect()->to(base_url('admin/add-employer'))
                ->with('error', 'Employer already exists.');
        }

        // Insert user
        $user_id = $AdminModel->insertUser([
            'user_type' => $userType,
            'activation_code' =>$activation_code,
            'otp' =>$otp,
            'email'     => $email,
            'mobile_no' => $mobileNumber,
            'registered_date' => date('Y-m-d'),
            'status' => 'active',

            // 'login_status' =>'active',
            'password'  => password_hash($password, PASSWORD_DEFAULT)
        ]);

        // Check duplicate recruiter
        if ($AdminModel->checkDuplicateRecruiter($email)) {
            return redirect()->to(base_url('admin/add-employer'))
                ->with('error', 'Recruiter with this email already exists.');
        }

        // Handle logo upload
        $logoFile = $this->request->getFile('logo');
        $newName = '';
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move(ROOTPATH . 'public/uploads', $newName);
        }
        
        if ($client_reg_type == 'paid') {

                // MAX invoice no only where paid
                $result = $db->table('tbl_recruiter')
                             ->selectMax('regi_invoice_no')
                             ->where('client_reg_type', 'paid')
                             ->get();

                if ($result && $result->getNumRows() > 0) {
                    $row = $result->getRow();
                    $maxInvoice = $row->regi_invoice_no ?? '';
                } else {
                    $maxInvoice = '';
                }

                // NEXT INVOICE
                if ($maxInvoice === '' || $maxInvoice === null) {
                    $invoice_no = '001';
                } else {
                    $invoice_no = str_pad(intval($maxInvoice) + 1, 3, '0', STR_PAD_LEFT);
                }

            } else {

                $invoice_no = 'N/A';
            }

        
        

        // Insert recruiter
        $AdminModel->insertRecruiter([
            'uid'                  => $user_id,
            'industry_name'        => $industry_name,
            'type_hospital'        => $type_hospital,
            'company_display_name' => $company_display_name,
            'institute_name'       => $institute_name,
            'city_id'              => $city_id,
            'area_name'            => $area_name,
            //'pincode'              => $pincode,
            'recruiter_name'       => $recruiter_name,
            'mobile_number'        => $mobileNumber,
            'email'                => $email,
            'form_status' => 'active',
            'client_reg_type' => $client_reg_type,
            'client_reg_fees' => $client_reg_fees,
            'client_fees_reg_date' => date('Y-m-d'),
            'regi_invoice_no'      =>  $invoice_no,
            'logo'                 => $newName
        ]);
      

        // Complete transaction
        $db->transComplete();

        if ($db->transStatus() === false) {
            // Rollback automatically if any insert fails
            return redirect()->to(base_url('admin/add-employer'))
                ->with('error', 'Something went wrong. Please try again.');
        }

        // Success
        return redirect()->to(base_url('admin/client_details'))
            ->with('success', 'Employer added successfully!');
    }
    public function display_pincode()
    {
        $city_id = $this->request->getPost('city_id');
        $db = \Config\Database::connect();
        
        $builder = $db->table('tbl_pincode');
        $builder->select('pincode');
        $builder->where('cityid', $city_id);
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $this->response->setJSON($query->getRow());
        } else {
            return $this->response->setJSON(['pincode' => '']);
        }
    }
    public function add_post_vacuncy($uid)
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new \App\Models\AdminModel();
        $job_role = $AdminModel->display_job_role();
        $cities = $AdminModel->display_location();
        $qualifications = $AdminModel->display_qualification();
        $depart = $AdminModel->display_depart();

        echo view('admin/header');
        // echo view('admin/add_post_vacuncy');
        echo view('admin/add_post_vacuncy', [
                'job_role' => $job_role,
                'cities' => $cities,
                'qualifications' => $qualifications,
                'depart' => $depart,
                 'uid' =>$uid,
            ]);

        echo view('admin/footer');
    }
    public function edit_emp($uid)
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $single_emp_edit = $AdminModel->single_emp_edit($uid);
         $display_lead = $AdminModel->display_lead_role();
        echo view('admin/header');
        echo view('admin/edit_emp',['single_emp_edit'=>$single_emp_edit,'display_lead'=>$display_lead]);
        echo view('admin/footer'); 
    }
    public function update_emp() 
    {
        $request = $this->request;
        $AdminModel = new \App\Models\AdminModel();
        $uid = $request->getPost('uid');

        if (empty($uid)) {
            return redirect()->back()->with('error', 'UID is missing');
        }

        $single_emp_edit = $AdminModel->single_emp_edit($uid);
        if (!$single_emp_edit) {
            return redirect()->back()->with('error', 'Employee not found');
        }

        $data_user = [
            'email' => $request->getPost('institute_email'),
        ];

        $password = $request->getPost('password');
        if (!empty($password)) {
            $data_user['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $data_recruiter = [
            'recruiter_name'       => $request->getPost('recruiter_name'),
            'institute_name'       => $request->getPost('institute_name'),
            'company_display_name' => $request->getPost('company_display_name'),
            'industry_name'        => $request->getPost('industry_name'),
            'type_hospital'        => $request->getPost('type_hospital'),
            'area_name'            => $request->getPost('area_name'),
            'email'                => $request->getPost('institute_email'),
            'mobile_number'        => $request->getPost('mobile_number'),
            'city_id'              => $request->getPost('city_id'),
            'pincode'              => $request->getPost('pincode'),
            'final_agreement'      => $request->getPost('final_agreement'),
            'advanced_payment'     => $request->getPost('advanced_payment'),
            'lead_id'            => $request->getPost('lead_name'),
            'recruiter_gstin_no'   => $request->getPost('recruiter_gstin_no'),
        ];

        // Handle logo upload
        $file = $request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!empty($single_emp_edit['logo']) && file_exists(FCPATH.'public/uploads/'.$single_emp_edit['logo'])) {
                unlink(FCPATH.'public/uploads/'.$single_emp_edit['logo']);
            }
            $newName = $file->getRandomName();
            $file->move(FCPATH.'public/uploads', $newName);
            $data_recruiter['logo'] = $newName;
        }

        // Update tbl_user
        $builder = $AdminModel->db->table('tbl_user');
        $builder->where('uid', $uid);
        $builder->update($data_user);
        $user_rows = $AdminModel->db->affectedRows();

        // Update tbl_recruiter
        $builder = $AdminModel->db->table('tbl_recruiter');
        $builder->where('uid', $uid);
        $builder->update($data_recruiter);
        $recruiter_rows = $AdminModel->db->affectedRows();

        if ($user_rows || $recruiter_rows) {
            return redirect()->to(base_url('admin/edit-emp/'.$uid))->with('success', 'Employee updated successfully.');
        } else {
            return redirect()->back()->with('error', 'No changes were made or update failed.');
        }
    }
    public function delete_emp($uid = null)
    {
        $AdminModel = new \App\Models\AdminModel();

        if (!$uid) {
            return redirect()->back()->with('error', 'Invalid employee ID.');
        }

        // Check if employee exists
        $employee = $AdminModel->single_emp_edit($uid);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        // Optional: delete logo file
        if (!empty($employee['logo']) && file_exists(FCPATH.'public/uploads/'.$employee['logo'])) {
            unlink(FCPATH.'public/uploads/'.$employee['logo']);
        }

        // Delete from tbl_recruiter
        $builder = $AdminModel->db->table('tbl_recruiter');
        $builder->where('uid', $uid)->delete();

        // Delete from tbl_user
        // $builder = $AdminModel->db->table('tbl_user');
        // $builder->where('uid', $uid)->delete();
        
        //delete tbl_posting
        $builder = $AdminModel->db->table('tbl_recruiter_posting');
        $builder->where('user_id',$uid)->delete();

        return redirect()->to(base_url('admin/client_details'))->with('success', 'Employee deleted successfully.');
    }
    public function savePostvacuncy()
    {
        $RecruiterModel = new RecruiterModel();
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();

        $uid = $this->request->getPost('uid');
        $jobRole = $this->request->getPost('job_role');
        $city = $this->request->getPost('city');
        $qualification = $this->request->getPost('qualification');
        $course = $this->request->getPost('course');
        $department= $this->request->getPost('department_admin');
        $vacancies = $this->request->getPost('vacancies');
        $employment_type = $this->request->getPost('employment_type');
        $gender = implode(',', $this->request->getPost('gender') ?? []);
        $job_description = $this->request->getPost('job_description');
        $shift_time = $this->request->getPost('shift_time');
        $experience_min = $this->request->getPost('experience_min');
        $experience_max = $this->request->getPost('experience_max');
        $salary_min = $this->request->getPost('salary_min');
        $salary_max = $this->request->getPost('salary_max');
        $salary_negotiation = $this->request->getPost('salary_negotiation');

        if(!empty($course))
        {
             $data = [
                        'user_id' =>$uid,
                        'job_id' => $jobRole,
                        'city_id'  => $city,
                        'qual_id'   => $qualification,
                        'course_id' => $course,
                        'department_id'  => $department,
                        'vacancies' => $vacancies,
                        'employment_type' => $employment_type,
                        'gender' => $gender,
                        'job_description' => $job_description,
                        'shift_time' => $shift_time,
                        'experience_min' => $experience_min,
                        'experience_max' => $experience_max,
                        'salary_min' => $salary_min,
                        'salary_max' => $salary_max,
                        'status'          => 'Publish',
                        'posting_form_status'=>'active',
                         'created_date' => date('Y-m-d H:i:s'),
                    ];
                    
                    if ($salary_negotiation !== 'yes') {
                            $data['salary_min'] = $salary_min;
                            $data['salary_max'] = $salary_max;
                        } else {
                            $data['salary_negotiation'] = 'yes';
                        }

        }else
        {
            $data = [
                        'user_id' =>$uid,
                        'job_id' => $jobRole,
                        'city_id'  => $city,
                        'qual_id'   => $qualification,
                        'department_id'  => $department,
                        'vacancies' => $vacancies,
                        'employment_type' => $employment_type,
                        'gender' => $gender,
                        'job_description' => $job_description,
                        'shift_time' => $shift_time,
                        'experience_min' => $experience_min,
                        'experience_max' => $experience_max,
                        'salary_min' => $salary_min,
                        'salary_max' => $salary_max,
                         'status'   => 'Publish', 
                         'posting_form_status'=>'active',
                          'created_date' => date('Y-m-d H:i:s'),
                    ];
                    
                     if ($salary_negotiation !== 'yes') {
                            $data['salary_min'] = $salary_min;
                            $data['salary_max'] = $salary_max;
                        } else {
                            $data['salary_negotiation'] = 'yes';
                        }
        }

        $posting_data = $RecruiterModel->recruiterPosting($data);

        if ($posting_data)
        {
                // Recruiter Details
                $recruiter = $db->table('tbl_recruiter r')
                    ->select('r.company_display_name, jr.job_role,c.name AS city_name')
                    ->join('cities c', 'c.id = r.city_id', 'left')
                    ->where('r.uid', $uid)
                    ->get()
                    ->getRowArray();

                $jobRoleData = $db->table('tbl_job_role')
                                ->select('job_role')
                                ->where('job_id', $jobRole)
                                ->get()
                                ->getRowArray();

                $job_role_name = $jobRoleData['job_role'] ?? '';

                $company_name = $recruiter['company_display_name'] ?? '';
                // $job_role_name = $recruiter['job_role'] ?? '';
                $city_name = $recruiter['city_name'] ?? '';
                // Get all Jobseekers for this Job Role
                $jobseekers = $db->table('tbl_jobseeker')
                    ->select('full_name, mobile_number')
                    ->where('job_id', $jobRole)
                    ->get()
                    ->getResultArray();



                $wa = new WhatsAppService();

                foreach ($jobseekers as $candidate) {

                    if (empty($candidate['mobile_number'])) {
                        continue;
                    }

                    $mobile_no = '91' . $candidate['mobile_number'];

                    $response = $wa->sendNewJobNotification(
                        $mobile_no,
                        $candidate['full_name'],
                        $job_role_name,
                        $company_name,
                        $city_name
                    );

                    log_message('info', json_encode($response));
                }
        }


        return redirect()
        ->to(base_url('admin/view_recruiter_posting/' . $uid))
        ->with('success', 'Employer added successfully!');
    }
    public function upload_company_profile()
    {
        $file = $this->request->getFile('compny_profile');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('jobseeker/profile_image',$newName);

            $userId = session()->get('uid');

            $db = \Config\Database::connect();
            $db->table('tbl_user')
                ->where('uid', $userId)
                ->update(['company_profile' => $newName]);

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setStatusCode(400)->setJSON(['error' => 'Upload failed']);
    }
    // ======= 09-10-2025 =====================
    public function admin_signup_recruiter()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllsignupRecruiter = $AdminModel->all_signup_recruiter();
        echo view('admin/header');
        echo view('admin/admin_signup_recruiter',['AllsignupRecruiter'=>$AllsignupRecruiter]);
        echo view('admin/footer'); 
    }
    public function add_recruiter_front($uid)
    {
        $db = \Config\Database::connect();
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $recuiterfrontFormDataedit = $AdminModel->recuiterfrontFormDataedit($uid);
        echo view('admin/header');
        echo view('admin/edit_recruiter_front_form', [
        'recuiterfrontFormDataedit' => $recuiterfrontFormDataedit,
        'uid' => $uid
         ]);
        echo view('admin/footer');
    }
    public function save_front_employer()
    {
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();

        $uid = $this->request->getPost('uid');
        $userType = $this->request->getPost('user_type');
       
        $email = $this->request->getPost('institute_email');
        $password = $this->request->getPost('password');
        $mobileNumber = $this->request->getPost('mobile_number');
        $industry_name = $this->request->getPost('industry_name');
        
        $type_hospital = $this->request->getPost('type_hospital');
        $institute_name = $this->request->getPost('institute_name');
        $company_display_name = $this->request->getPost('company_display_name');
        $pincode = $this->request->getPost('pincode');
        $city_id = $this->request->getPost('city_id');
        $recruiter_name = $this->request->getPost('recruiter_name');
        $area_name = $this->request->getPost('area_name');
        // Handle logo upload
        $logoFile = $this->request->getFile('logo');
        $newName = '';
        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move(ROOTPATH . 'public/uploads', $newName);
        }

         $data = [
            'uid'=>$uid,
            'email' => $email,
            'mobile_number' => $mobileNumber,
            'industry_name' => $industry_name,
            'type_hospital' => $type_hospital,
            'institute_name' => $institute_name,
            'recruiter_name'=>$recruiter_name,
            'company_display_name' => $company_display_name,
            'pincode' => $pincode,
            'city_id' => $city_id,
            'area_name' => $area_name,
            'form_status'=>'active',
            'logo'                 => $newName
        ];
        // print_r($data);
        // exit();
       $add_blog_data = $AdminModel->add_recruiter_front($data);

     // return redirect()->to(base_url('admin/add_recruiter_front/' . $uid))
     //             ->with('success', 'Recruiter added successfully!');

     return redirect()->to(base_url('admin/client_details'))
                         ->with('success', 'Recruiter added successfully!');
    }
     public function daily_count()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AlldailyCount = $AdminModel->all_daily_count_clientdisply();
        echo view('admin/header');
        echo view('admin/daily_count_details',['AlldailyCount'=>$AlldailyCount]);
        echo view('admin/footer'); 
    }
    public function all_post_vacancies()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();  // Not really needed here unless you use it later
    
        $AllpostVacancy = $AdminModel->all_post_vacancy_disply();
    
        echo view('admin/header');
        echo view('admin/post_vacancy_details',['AllpostVacancy' => $AllpostVacancy]);
        echo view('admin/footer'); 
    }
    public function all_closed_client_details()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();  // Not really needed here unless you use it later

        $ClosedClientDetails = $AdminModel->closedClientdisply();

        echo view('admin/header');
        echo view('admin/closed_client_details',['ClosedClientDetails' => $ClosedClientDetails]);
        echo view('admin/footer'); 
    }
    public function closed_vacuncies_details()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();  // Not really needed here unless you use it later

        $closedPostvaciesdisply = $AdminModel->closedPostvaciesdisply();
        echo view('admin/header');
        echo view('admin/closed_vacancies_details',['closedPostvaciesdisply' => $closedPostvaciesdisply]);
        echo view('admin/footer');  
    }
    
    public function add_city()
    {
        $db = \Config\Database::connect(); 
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $city_name = trim($this->request->getPost('name'));  // ✅ match JS field name
        $country_id   = $this->request->getPost('country_id');
        $state_id     = $this->request->getPost('state_id');
        $district_id  = $this->request->getPost('district_id');

       if (empty($city_name) || empty($country_id) || empty($state_id) || empty($district_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'City name is required.'
            ]);
        }

        $builder = $db->table('cities');

        // ✅ Check if city already exists by name (case-insensitive)
        // $exists = $builder->where('LOWER(name)', strtolower($city_name))->countAllResults();
          $exists = $builder
        ->where('LOWER(name)', strtolower($city_name))
        ->where('country_id', $country_id)
        ->where('state_id', $state_id)
        ->where('district_id', $district_id)
        ->countAllResults();

        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This city already exists.'
            ]);
        }

            // ✅ Insert city name (not ID)
            // $builder->insert(['name' => $city_name]);
              $builder->insert([
            'name'       => $city_name,
            'country_id' => $country_id,
            'state_id'   => $state_id,
            'district_id'=> $district_id,
           
        ]);

        $insertID = $db->insertID();

        return $this->response->setJSON([
            'status' => 'success',
            'id' => $insertID,
            'name' => $city_name
        ]);
    }
    
    public function signup_admin_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllsignupCandidate = $AdminModel->all_signup_candidate();
       
        echo view('admin/header');
        echo view('admin/admin_signup_candidate', ['AllsignupCandidate' => $AllsignupCandidate ]);
        echo view('admin/footer'); 

    }
    public function registration_admin_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllregistraionCandidate = $AdminModel->all_registraion_candidate();
        // echo "<pre>";
        // print_r($AllregistraionCandidate);
        // exit();
        echo view('admin/header');
        echo view('admin/admin_registration_candidate',['AllregistraionCandidate'=>$AllregistraionCandidate]);
        echo view('admin/footer'); 
    }
    public function daily_admin_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AlldailyCandidate = $AdminModel->all_daily_candidate_disply();
        echo view('admin/header');
        echo view('admin/daily_admin_candidate',['AlldailyCandidate'=>$AlldailyCandidate]);
        echo view('admin/footer'); 
    }
    public function interview_schedule_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllinterviewCandidate = $AdminModel->all_interview_scedule_candidate_disply();
    
        echo view('admin/header');
        echo view('admin/interview_schedule_candidate',['AllinterviewCandidate'=>$AllinterviewCandidate]);
        echo view('admin/footer'); 
    }
    public function hold_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllholdCandidate = $AdminModel->all_hold_candidate_disply();
    
        echo view('admin/header');
        echo view('admin/hold_candidate',['AllholdCandidate'=>$AllholdCandidate]);
        echo view('admin/footer'); 
    }
    public function reject_candidate()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllrejectCandidate = $AdminModel->all_reject_candidate_disply();
    
        echo view('admin/header');
        echo view('admin/reject_candidate',['AllrejectCandidate'=>$AllrejectCandidate]);
        echo view('admin/footer'); 
    }
    public function apply_candidate_admin()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllapplyCandidate = $AdminModel->all_apply_candidate_disply();
    
        echo view('admin/header');
        echo view('admin/apply_candidate_admin',['AllapplyCandidate'=>$AllapplyCandidate]);
        echo view('admin/footer'); 
    }
    // public function edit_post_vacuncy($posting_id)
    // {
    //     $session = session();
    //     if (!session()->has('name')) {
    //     return redirect()->to('admin'); 
    //     }
    //     $AdminModel = new AdminModel();
    //     $single_posting_edit = $AdminModel->single_posting_edit($posting_id);
    //     echo view('admin/header');
    //     echo view('admin/edit_post_vacuncy',['single_posting_edit'=>$single_posting_edit]);
    //     echo view('admin/footer'); 
    // }
        public function edit_post_vacuncy($posting_id)
        {
            $session = session();
            if (!session()->has('name')) {
            return redirect()->to('admin'); // redirect if not logged in
            }
            $AdminModel = new AdminModel();
            $job_role = $AdminModel->display_job_role();
    
            $cities = $AdminModel->display_location();
    
            $qualifications = $AdminModel->display_qualification();
    
            $depart = $AdminModel->display_depart();
    
            $single_posting_edit = $AdminModel->single_posting_edit($posting_id);
            // print_r($single_posting_edit);
            // exit();
            echo view('admin/header');
            echo view('admin/edit_post_vacuncy',['single_posting_edit'=>$single_posting_edit,'job_role' => $job_role,'cities' => $cities,'qualifications'=>$qualifications,'depart'=>$depart]);
            echo view('admin/footer'); 
        }
        // public function update_posting_form()
        // {
        //     $AdminModel = new \App\Models\AdminModel();
        //     $request = $this->request;
        //     // Get POST data
        //     $posting_id = $request->getPost('posting_id'); 
        //     $job_description = $request->getPost('job_description');
    
        //     $data = [
        //         'job_description' => $job_description,
        //     ];
           
        //     $updated_posting_data = $AdminModel->update_posting_data($posting_id,$data);
    
        //     if($updated_posting_data){
        //         return redirect()->to(base_url('admin/edit-post-vacuncy/' . $posting_id))->with('success', 'Posting Data updated successfully!');
        //     } else {
        //         return redirect()->back()->with('error', 'Something went wrong!');
        //     }
        // }
        
         public function update_posting_form()
    {
        $AdminModel = new \App\Models\AdminModel();
        $request = $this->request;

        $posting_id = $request->getPost('posting_id');

        if (!$posting_id) {
            return redirect()->back()->with('error', 'Invalid Posting ID');
        }

        // Gender (checkbox → string)
        $gender = $request->getPost('gender');
        $gender_value = !empty($gender) ? implode(',', $gender) : null;

        // Salary Negotiation
        $salary_negotiation = $request->getPost('salary_negotiation'); // yes or null

        $data = [
            'job_id'          => $request->getPost('job_role'),
            'city_id'         => $request->getPost('city'),
            'qual_id'         => $request->getPost('qualification'),
            'course_id'       => $request->getPost('course') ?: null,
            'department_id'   => $request->getPost('department_admin'),
            'vacancies'       => $request->getPost('vacancies'),
            'employment_type' => $request->getPost('employment_type'),
            'gender'          => $gender_value,
            'job_description' => $request->getPost('job_description'),
            'shift_time'      => $request->getPost('shift_time'),
            'experience_min'  => $request->getPost('experience_min'),
            'experience_max'  => $request->getPost('experience_max')
            // 'updated_at'      => date('Y-m-d H:i:s')
        ];
       
        // 🔹 Salary logic
        if ($salary_negotiation === 'yes') {
            $data['salary_negotiation'] = 'yes';
            $data['salary_min'] = null;
            $data['salary_max'] = null;
        } else {
            $data['salary_negotiation'] = 'no';
            $data['salary_min'] = $request->getPost('salary_min');
            $data['salary_max'] = $request->getPost('salary_max');
        }

        // Update DB
        $updated = $AdminModel->update_posting_data($posting_id, $data);

        if ($updated) {
            return redirect()
                ->to(base_url('admin/edit-post-vacuncy/' . $posting_id))
                ->with('success', 'Posting updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update posting');
    }
        public function delete_post_vacuncy($posting_id=null)
        {
            $AdminModel = new \App\Models\AdminModel();
            if(!$posting_id){
                return $this->response->setJSON(['status' => 'error', 'message' => 'Posting ID missing']);
            }
    
            $db = \Config\Database::connect();
             $builder = $AdminModel->db->table('tbl_recruiter_posting');
            $builder->where('posting_id',$posting_id)->delete();
    
            return redirect()->to(base_url('admin/all-post-vacancies'))->with('success', 'Post deleted successfully.');
    
        }
    // ======================== 27/10/2025 ==============================================
    public function fetch_states()
    {
        $country_id = $this->request->getPost('country_id');

        $db = \Config\Database::connect();
        $states = $db->query("SELECT * FROM tbl_states WHERE country_id = '$country_id'")->getResultArray();

        $options = '<option value="">Select State</option>';
        foreach($states as $state){
            $options .= '<option value="'.$state['state_id'].'">'.$state['state_name'].'</option>';
        }

        echo $options;
    }
    
    public function fetch_districts()
    {
        $state_id = $this->request->getPost('state_id');
        $db = \Config\Database::connect();
    
        $districts = $db->table('tbl_district')
                        ->where('state_id', $state_id)
                        ->get()
                        ->getResultArray();
    
        $output = '<option value="">Select District</option>';
    
        foreach ($districts as $dist) {
            $output .= '<option value="'.$dist['district_id'].'">'.$dist['district_name'].'</option>';
        }
    
        return $output;
    }
    public function fetch_cities()
    {
        $district_id = $this->request->getPost('district_id');
    
        $db = \Config\Database::connect();
        $builder = $db->table('cities');
        $builder->where('district_id', $district_id);
        $query = $builder->get();
    
        $data = $query->getResult();
    
        return $this->response->setJSON($data);
    }
    
    public function fetch_states_edit()
    {
        $country_id     = $this->request->getPost('country_id');
        $selected_state = $this->request->getPost('selected_state'); // comes from edit view
    
        $db = \Config\Database::connect();
         $states = $db->table('tbl_states')
                        ->where('country_id', $country_id)
                        ->get()
                        ->getResultArray();
    
        $options = '<option value="">Select State</option>';
        foreach ($states as $state) {
            $selected = ($state['state_id'] == $selected_state) ? 'selected' : '';
            $options .= '<option value="'.$state['state_id'].'" '.$selected.'>'.$state['state_name'].'</option>';
        }
    
        return $options; // returning HTML <option> list
    }
    public function fetch_districts_edit() 
    {
        $state_id = $this->request->getPost('state_id');
    
        $db = \Config\Database::connect();
        $districts = $db->table('tbl_district')
                        ->where('state_id', $state_id)
                        ->get()->getResultArray();
    
        return $this->response->setJSON($districts);
    }
    
    public function fetch_cities_edit()
    {
        $district_id = $this->request->getPost('district_id');
    
        $db = \Config\Database::connect();
        $cities = $db->table('cities')
                     ->where('district_id', $district_id)
                     ->get()->getResultArray();
    
        return $this->response->setJSON($cities);
    }

    public function delete_candidate_signup($uid = null)
    {
        $AdminModel = new \App\Models\AdminModel();

        if (!$uid) {
            return redirect()->back()->with('error', 'Invalid employee ID.');
        }

        // Delete from tbl_recruiter
        $builder = $AdminModel->db->table('tbl_user');
        $builder->where('uid', $uid)->delete();

        return redirect()->to(base_url('admin/signup_admin_candidate'))->with('success', 'Employee deleted successfully.');
    }
    
    public function edit_candidate($uid)
    {


        $AdminModel = new AdminModel();
        $single_candidate_edit = $AdminModel->single_candidate_edit($uid);
        echo view('admin/header');
        echo view('admin/edit_candidate',['single_candidate_edit'=>$single_candidate_edit]);
        echo view('admin/footer'); 
    }
    
    public function update_candidate()
    {
        $request = $this->request;
        $AdminModel = new \App\Models\AdminModel();
        $uid = $request->getPost('uid');
         $expected_cities = $this->request->getPost('expected_cities'); // array
         $expected_cities_str = !empty($expected_cities) ? implode(',', $expected_cities) : '';

        if (empty($uid)) {
            return redirect()->back()->with('error', 'UID is missing');
        }

        $single_candidate_edit = $AdminModel->single_candidate_edit($uid);
        if (!$single_candidate_edit) {
            return redirect()->back()->with('error', 'Employee not found');
        }

        $data_user = [
            'email' => $request->getPost('email'),
            'mobile_no' => $request->getPost('mobile_number'),

        ];

        $data_jobseeker = [
            'full_name'       => $request->getPost('full_name'),
            'email'       => $request->getPost('email'),
            'mobile_number' => $request->getPost('mobile_number'),
            'current_city'        => $request->getPost('city_id'),
             'expected_cities' => $expected_cities_str,
            'job_id'        => $request->getPost('job_role'),
            'fellowship'   => $request->getPost('fellowship'),
        ];

  
        $builder = $AdminModel->db->table('tbl_user');
        $builder->where('uid', $uid);
        $builder->update($data_user);
        $user_rows = $AdminModel->db->affectedRows();

      
        $builder = $AdminModel->db->table('tbl_jobseeker');
        $builder->where('uid', $uid);
        $builder->update($data_jobseeker);
        $jobseeker_rows = $AdminModel->db->affectedRows();

        if ($user_rows || $jobseeker_rows) {
            return redirect()->to(base_url('admin/edit-candidate/'.$uid))->with('success', 'Candidate updated successfully.');
        } else {
            return redirect()->back()->with('error', 'No changes were made or update failed.');
        }
    }
    
    // ======================== 11-11-2025 ==========================//

    
     public function billing_dashboard()
    {
        $session = session();

        if (!session()->has('name')) {
            return redirect()->to('admin/adminlogin');
        }
          $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();

        // ================= EXISTING =================
        $CountPostVaciesdisplay = $AdminModel->CountPostcloseVaciesdisplay($start_date,$end_date);
        $CountInvoiceclosedPostvaciesdisply = $AdminModel->CountInvoiceclosedPostvaciesdisply($start_date,$end_date);
        $CountRecivePaymenteClientdisply = $AdminModel->CountRecivePaymenteClientdisply($start_date,$end_date);
        $CountPendingPaymenteClientdisply = $AdminModel->CountPendingPaymenteClientdisply();
        $CountPaidClientDisplay = $AdminModel->CountPaidClientDisplay($start_date,$end_date);
        $CountFreeClientDisplay = $AdminModel->CountFreeClientDisplay($start_date,$end_date);
        $getAdvancedClientCount = $AdminModel->getAdvancedClientCount();

        // ================= VIEW → CONTROLLER SHIFT =================

        // 🔹 Registration Amount
        $builder = $db->table('tbl_recruiter');
        $builder->select('SUM(REPLACE(client_reg_fees, ",", "")) AS total_fees', false);
        $builder->where('client_reg_type', 'paid');
        //=================== client_fees_reg_date filter =================
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(client_fees_reg_date) >=', $start_date);
            $builder->where('DATE(client_fees_reg_date) <=', $end_date);
        }
        $totalAmount = $builder->get()->getRow()->total_fees ?? 0;

        // 🔹 Advance
        $advanceBuilder = $db->table('tbl_recruiter');
        $advanceBuilder->select('SUM(REPLACE(advanced_payment, ",", "")) AS total_advance', false);
        $advanceBuilder->where('advanced_payment >', 0);
        // ============== date  filer ==============================================
        if (!empty($start_date) && !empty($end_date)) {
            $advanceBuilder->where('DATE(created_date) >=', $start_date);
            $advanceBuilder->where('DATE(created_date) <=', $end_date);
        }
               
        //  $query = $advanceBuilder->get();
        // echo $db->getLastQuery();
        // exit;
         $totalAdvance = $advanceBuilder->get()->getRow()->total_advance ?? 0;
        

        // 🔹 Received
        $builder_recive = $db->table('tbl_candidate_job_status');
        $builder_recive->select('SUM(REPLACE(client_recived_payment, ",", "")) AS total_received', false);
        $builder_recive->where('payment_recived_status', 'Recived_payment');
        // ✅ Date filter add
        if (!empty($start_date) && !empty($end_date)) {
            $builder_recive->where('DATE(payment_recived_date) >=', $start_date);
            $builder_recive->where('DATE(payment_recived_date) <=', $end_date);
        }
        $totalReceived = $builder_recive->get()->getRow()->total_received ?? 0;

        // ================= BAR CHART =================
        $months = [];
        $total_bill_amount = [];
        $total_received_amount = [];

        $monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        $start = new \DateTime('2025-04-01');

        for ($i = 0; $i < 12; $i++) {

            $month = $start->format('m');
            $year  = $start->format('Y');

            $months[] = $monthNames[(int)$month - 1] . " " . substr($year, 2);

            // 👉 IMPORTANT: builder variable
            $builder = $db->table('tbl_candidate_job_status tcjs');
            $builder->select('tcjs.*, rp.*, r.*')
                ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
                ->join('tbl_recruiter r', 'rp.user_id = r.uid')
                ->where('tcjs.admin_candidate_status', 'Closed')
                ->where('tcjs.payment_recived_status', 'Recived_payment')
                ->where('rp.status', 'Publish')
                ->where('YEAR(tcjs.joining_date)', $year)
                ->where('MONTH(tcjs.joining_date)', $month);


            if (!empty($start_date) && !empty($end_date)) {
                $builder->where('DATE(tcjs.joining_date) >=', $start_date);
                $builder->where('DATE(tcjs.joining_date) <=', $end_date);
            }

            $rows = $builder->get()->getResultArray();

            $billAmount = 0;
            $receivedAmount = 0;

            foreach ($rows as $row) {

                if ($row['gst_status'] === 'yes') {
                    $bill = (float)str_replace(',', '', $row['client_payment_gst'] ?? 0);
                } else {
                    $bill = (float)str_replace(',', '', $row['client_payment'] ?? 0);
                }

                $billAmount += $bill;

                $rec = (float)str_replace(',', '', $row['client_recived_payment'] ?? 0);
                $receivedAmount += $rec;
            }

            $total_bill_amount[] = $billAmount;
            $total_received_amount[] = $receivedAmount;

            $start->modify('+1 month');
        }

        // ================= PENDING =================
         $builder = $db->table('tbl_candidate_job_status tcjs')
            ->select('tcjs.*, rp.*, js.*, r.*, jr.job_role')
            ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->where('tcjs.payment_recived_status', 'Recived_payment')
            ->where('rp.status', 'Publish');
                

            // ✅ Date filter
            if (!empty($start_date) && !empty($end_date)) {
                $builder->where('DATE(tcjs.joining_date) >=', $start_date);
                $builder->where('DATE(tcjs.joining_date) <=', $end_date);
            }

            // Execute
            $pendingRows = $builder->get()->getResultArray();

        $totalPending = 0;

        foreach ($pendingRows as $row) {

            $advanced  = (float)str_replace(',', '', $row['advanced_payment'] ?? 0);
            $received  = (float)str_replace(',', '', $row['client_recived_payment'] ?? 0);
            $gstAmount = (float)str_replace(',', '', $row['client_payment_gst'] ?? 0);
            $original  = (float)str_replace(',', '', $row['client_payment'] ?? 0);

            $totalBill = ($advanced > 0) ? ($advanced + $received) : $received;

            $pending = ($row['gst_status'] === 'yes')
                ? ($gstAmount - $totalBill)
                : ($original - $totalBill);

            if (!empty($row['discount_check']) && $row['discount_check'] === 'yes') {
                $discount = (float)str_replace(',', '', $row['discount_amount'] ?? 0);
                $pending -= $discount;
            }

            if ($pending < 0) $pending = 0;

            $totalPending += $pending;
        }

        $totalPendingFormatted = number_format($totalPending, 2);

        // ================= TOTAL BILL =================
        $totalBillPaymentClient = 0;

        foreach ($pendingRows as $row) {

            if ($row['gst_status'] === 'yes') {
                $amount = (float)str_replace(',', '', $row['client_payment_gst'] ?? 0);
            } else {
                $amount = (float)str_replace(',', '', $row['client_payment'] ?? 0);
            }

            $totalBillPaymentClient += $amount;
        }

        $totalBillPaymentClientFormatted = number_format($totalBillPaymentClient, 2);

        // ================= DISCOUNT =================
        $discountRows = $db->table('tbl_candidate_job_status')
            ->select('discount_amount')
            ->where('discount_check', 'yes')
            ->get()
            ->getResultArray();

        $totalDiscount = 0;

        foreach ($discountRows as $d) {
            $totalDiscount += (float)str_replace(',', '', $d['discount_amount'] ?? 0);
        }

        // ================= DONUT =================
        $donutLabels = ["Advance Amt.", "Registration Amt.", "Pending Amt.", "Discount Amt."];
        $donutValues = [(float)$totalAdvance,(float)$totalAmount,(float)$totalPending,(float)$totalDiscount];

        // ================= TOTAL INCOME =================
        $total_income = number_format($totalAdvance + $totalAmount + $totalReceived, 2);

        // ================= FINAL VIEW =================
        echo view('admin/header');
        echo view('admin/billing_dashboard', [
            'CountPostVaciesdisplay' => $CountPostVaciesdisplay,
            'CountInvoiceclosedPostvaciesdisply' => $CountInvoiceclosedPostvaciesdisply,
            'CountRecivePaymenteClientdisply' => $CountRecivePaymenteClientdisply,
            'CountPendingPaymenteClientdisply' => $CountPendingPaymenteClientdisply,
            'CountPaidClientDisplay' => $CountPaidClientDisplay,
            'CountFreeClientDisplay' => $CountFreeClientDisplay,
            'getAdvancedClientCount' => $getAdvancedClientCount,

            // SAME VARIABLES (view change नाही)
            'totalAmount' => $totalAmount,
            'totalAdvance' => $totalAdvance,
            'totalReceived' => $totalReceived,
            'months' => $months,
            'total_bill_amount' => $total_bill_amount,
            'total_received_amount' => $total_received_amount,
            'totalPendingFormatted' => $totalPendingFormatted,
            'totalBillPaymentClientFormatted' => $totalBillPaymentClientFormatted,
            'donutLabels' => $donutLabels,
            'donutValues' => $donutValues,
            'total_income' => $total_income
        ]);
        echo view('admin/footer');
    }
    
    public function billing_admin_closed_vacuncy()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $closedPostvaciesdisply = $AdminModel->closedPostvaciesdisply();
        echo view('admin/header');
        echo view('admin/billing_admin_closed_vacuncy',['closedPostvaciesdisply' => $closedPostvaciesdisply]);
        echo view('admin/footer');

    }
    public function edit_conformed_salary($job_status_id)
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        // $single_emp_edit = $AdminModel->single_emp_edit($uid);
        $single_posting_edit = $AdminModel->single_candidate_status($job_status_id);
        echo view('admin/header');
        echo view('admin/edit_conformed_salary',['single_posting_edit'=>$single_posting_edit]);
        echo view('admin/footer'); 
    }
    // public function update_conformed_salary_form()
    // {
    //     $db = \Config\Database::connect();
    //      $AdminModel = new \App\Models\AdminModel();
    //     $request = $this->request;
    //     $gst_status = $this->request->getPost('gst_status');
    //      $advance_status = $this->request->getPost('advanced_payment_status');
       
    //     $job_status_id = $request->getPost('job_status_id'); // make sure your hidden input has name="blog_id"
    //     $conformed_salary = $request->getPost('conformed_salary');
    //     $client_payment = $request->getPost('client_payment');
    //     $client_payment_gst = $request->getPost('client_payment_gst');
    //     $gst_status = !empty($gst_status) ? 'yes' : 'no';
    //      $advanced_payment_status = !empty($advance_status) ? 'yes' : 'no';
    //     // ============= 14-11-2025 =============
    //     $builder = $db->table('tbl_candidate_job_status');
    //     $current = $builder->select('invoice_number')
    //                        ->where('job_status_id', $job_status_id)
    //                        ->get()
    //                        ->getRowArray();

    //     if (!empty($current['invoice_number'])) {
    //         $invoiceNumber = $current['invoice_number'];

    //     } else {
    //         $builder2 = $db->table('tbl_candidate_job_status');
    //         $builder2->selectMax('invoice_number');
    //         $row = $builder2->get()->getRowArray();

    //         if (!empty($row['invoice_number'])) {
    //             $newNumber = intval($row['invoice_number']) + 1;
    //         } else {
    //             $newNumber = 1;
    //         }
    //         $invoiceNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    //     }
    //     $data = [
    //         'conformed_salary' => $conformed_salary,
    //         'gst_status'=> $gst_status,
    //         'client_payment' =>$client_payment,
    //         'client_payment_gst'=>$client_payment_gst,
    //         'invoice_number' =>$invoiceNumber,
    //          'advanced_payment_status' =>$advanced_payment_status,
    //     ];
       
    //     $updated_posting_data = $AdminModel->update_candidate_job_data($job_status_id,$data);

    //     if($updated_posting_data){
    //         return redirect()->to(base_url('admin/edit-conformed-salary/' . $job_status_id))->with('success', ' updated Conformed Salary  successfully!');
    //     } else {
    //         return redirect()->back()->with('error', 'Something went wrong!');
    //     }
    // }

    public function update_conformed_salary_form()
{
    $db = \Config\Database::connect();
    $AdminModel = new \App\Models\AdminModel();
    $request = $this->request;

    $gst_status = $this->request->getPost('gst_status');
    $advance_status = $this->request->getPost('advanced_payment_status');

    $job_status_id = $request->getPost('job_status_id');
    $conformed_salary = $request->getPost('conformed_salary');
    $client_payment = $request->getPost('client_payment');
    $client_payment_gst = $request->getPost('client_payment_gst');

    $gst_status = !empty($gst_status) ? 'yes' : 'no';
    $advanced_payment_status = !empty($advance_status) ? 'yes' : 'no';

    // Existing Invoice Check
    $current = $db->table('tbl_candidate_job_status')
                  ->select('invoice_number, joining_date')
                  ->where('job_status_id', $job_status_id)
                  ->get()
                  ->getRowArray();

    if (!empty($current['invoice_number'])) {

        $invoiceNumber = $current['invoice_number'];

    } else {

        $joining_date = $current['joining_date'];

        $year = date('Y', strtotime($joining_date));
        $month = date('m', strtotime($joining_date));

        // Financial Year
        if ($month >= 4) {
            $fy_start = $year . '-04-01';
            $fy_end   = ($year + 1) . '-03-31';
        } else {
            $fy_start = ($year - 1) . '-04-01';
            $fy_end   = $year . '-03-31';
        }

        // Same FY max invoice
        $row = $db->table('tbl_candidate_job_status')
                  ->selectMax('invoice_number')
                  ->where('joining_date >=', $fy_start)
                  ->where('joining_date <=', $fy_end)
                  ->get()
                  ->getRowArray();

        $newNumber = !empty($row['invoice_number'])
            ? ((int)$row['invoice_number'] + 1)
            : 1;

        $invoiceNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

        $data = [
            'conformed_salary' => $conformed_salary,
            'gst_status' => $gst_status,
            'client_payment' => $client_payment,
            'client_payment_gst' => $client_payment_gst,
            'invoice_number' => $invoiceNumber,
            'advanced_payment_status' => $advanced_payment_status,
        ];

    $updated_posting_data = $AdminModel->update_candidate_job_data($job_status_id, $data);

    if ($updated_posting_data) {
        return redirect()->to(base_url('admin/edit-conformed-salary/' . $job_status_id))
                         ->with('success', 'Updated Conformed Salary Successfully!');
    } else {
        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
    public function billing_sent_invoice()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $closedPostvaciesdisply = $AdminModel->closedPostvaciesSentInvoicedisply();
        echo view('admin/header');
        echo view('admin/billing_sent_invoice',['closedPostvaciesdisply' => $closedPostvaciesdisply]);
        echo view('admin/footer');
 
    } 
    
    public function generate_pdf($job_status_id)
    {
    $db = \Config\Database::connect();

    /* ================= FETCH DATA (UNCHANGED) ================= */
    $pdf_details = $db->table('tbl_candidate_job_status')
        ->where('job_status_id', $job_status_id)
        ->get()->getRow();

    $client_no      = $pdf_details->user_id;
    $invoice_number = $pdf_details->invoice_number;
    $joining_date   = date("d-m-Y", strtotime($pdf_details->joining_date));

    $client_payment_new = floatval(preg_replace('/[^0-9.]/', '', $pdf_details->client_payment));
    $client_gst_new     = floatval(preg_replace('/[^0-9.]/', '', $pdf_details->client_payment_gst));
    $client_gst_status  = $pdf_details->gst_status;

    $advance = $db->table('tbl_recruiter')->select('advanced_payment')
        ->where('uid', $client_no)->get()->getRow();
    $advance_amt = floatval(preg_replace('/[^0-9.]/', '', $advance->advanced_payment));

    if ($client_gst_status == 'no') {
        
        $gst_amount   = '-';
        $cgst_amount  = '-';
        $sgst_amount  = '-';
        $igst_amount  = '-';
        $grand_total  = $client_payment_new - $advance_amt;
    } else {

        $gst_amount   = $client_gst_new - $client_payment_new;
        $cgst_amount = $gst_amount / 2;
        $sgst_amount = $gst_amount / 2;
        $igst_amount = 0;

        $grand_total  = $client_gst_new - $advance_amt;
    }
    $new_grand_total = number_format($grand_total, 2);
    $client_payment_fmt = number_format($client_payment_new, 2);
   $total_advance_amt = (isset($advance_amt) && $advance_amt !== '')
    ? number_format((float)$advance_amt, 2)
    : '-';

       // $total_cgst_amount =number_format($cgst_amount, 2);
    $total_cgst_amount = (isset($cgst_amount) && $cgst_amount !== '')
    ? number_format((float)$cgst_amount, 2)
    : '-';
     $total_sgst_amount = (isset($sgst_amount) && $sgst_amount !== '')
    ? number_format((float)$sgst_amount, 2)
    : '-';
    
    // $total_sgst_amount =number_format($sgst_amount, 2);

    $client = $db->table('tbl_recruiter')->where('uid', $client_no)->get()->getRow();
    $client_name   = ucwords(strtolower($client->recruiter_name));
    $institute_name = ucwords(strtolower($client->institute_name));
    $client_mobile = $client->mobile_number;

    $client_gstin_no = (!empty($client->recruiter_gstin_no))
    ? $client->recruiter_gstin_no
    : '-';

    $city = $db->table('cities')->where('id', $client->city_id)->get()->getRow();
    $city_name = $city->name;

    $jobseeker = $db->table('tbl_jobseeker')->where('jobseeker_id', $pdf_details->jobseeker_id)->get()->getRow();
    $candidate_name = ucwords(strtolower($jobseeker->full_name));

    $jobrole = $db->table('tbl_job_role')->where('job_id', $jobseeker->job_id)->get()->getRow();
    $position_name = ucwords(strtolower($jobrole->job_role));

    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set margins
         $pdf->SetTitle('Invoice');
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 10);

    // Add a page
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 9);

    // Month & images
    $monthYear = date('MY');
    $signature = base_url('assets/jobportal/images/home/Sirsig.jpeg');

$html = <<<HTML
<style>
table { border-collapse: collapse; width: 100%;}
td, th { border: 1px solid #000; padding: 5px; }
.center { text-align: center; }
.right { text-align: right; }
.bold { font-weight: bold; }
.yellow { background-color: #FF8C73; }
.light { background-color: #eaf2e3; }


</style>

<table>
<tr>
<td colspan="4" class="center bold" style="background-color:#FF8C73; padding:18px; font-size:18px;">
    TAX INVOICE
</td>
</tr>

<tr>
<td colspan="3" style="padding:18px; font-size:11px;line-height:22px;"><b>ADIS INDIA PLACEMENT PVT LTD.</b><br>CIN No.: U78100PN2024PTC231287</td>
<td style="padding:18px; font-size:11px;line-height:22px;"><b>Invoice Number</b><br>Adisindia/{$invoice_number}</td>
</tr>

<tr>
<td colspan="3" style="padding:18px; font-size:11px; line-height:16px;"><br>
<b>Office Address:</b> Office no A303, Gera Imperium Gateway,<br>
Nashik Phata, Pimpri-Chinchwad, Maharashtra 411034<br>
<b>Contact:</b> 9607559547<br>
<b>Email:</b> hr@adisindiaplacement.com
</td>
<td style="padding:18px; font-size:11px;"><b>Invoice Date</b><br>{$joining_date}</td>
</tr>
<tr>
<td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Name:</b> {$institute_name}</td>
<td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Address:</b> {$city_name}</td>
</tr>

<tr>
<td colspan="4" style="padding:18px; font-size:11px;line-height:22px;"><b>GSTIN:</b> {$client_gstin_no}</td>
</tr>
</table>

<br>

<table>
<tr class="yellow light">
<td width="8%" style="padding:18px; font-size:11px;line-height:22px;"><b>Sr No</b></td>
<td width="77%" style="padding:18px; font-size:11px;line-height:22px;"><b>Description of Services</b></td>
<td width="15%" style="padding:18px; font-size:11px;line-height:22px;"><b>Amount (Rs)</b></td>
</tr>

<tr>
<td class="center" style="padding:28px 18px; font-size:11px;"><br><br>1</td>

<td style="padding:28px 18px; font-size:11px; line-height:16px;">
    <b>Candidate Name:</b> {$candidate_name}<br>
    <b>Job Position:</b> {$position_name}<br><br><br><br>
</td>

<td class="right" style="padding:28px 18px; font-size:11px;">
    <br><br>{$client_payment_fmt}
</td>
</tr>

<tr>
<td colspan="2" class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
    Total
</td>
<td class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
    {$client_payment_fmt}
</td>
</tr>
</table>

<br>

<table>
<tr>
<td width="40%" class="no-border"></td>
<td width="45%" style="padding:28px 18px; font-size:11px;">CGST &nbsp;&nbsp;&nbsp;9%</td>
<td width="15%" style="padding:28px 18px; font-size:11px;" class="right">{$total_cgst_amount}</td>
</tr>
<tr>
<td class="no-border"></td>
<td style="padding:28px 18px; font-size:11px;">SGST &nbsp;&nbsp;&nbsp;9%</td>
<td class="right" style="padding:28px 18px; font-size:11px;">{$total_sgst_amount}</td>
</tr>
<tr>
<td class="no-border"></td>
<td style="padding:28px 18px; font-size:11px;">Deposit Recived </td>
<td class="right" style="padding:28px 18px; font-size:11px;">{$total_advance_amt}</td>
</tr>
<tr>
<td class="no-border"></td>
<td style="padding:28px 18px; font-size:11px;">IGST</td>
<td class="right" style="padding:28px 18px; font-size:11px;">0%</td>
</tr>
<tr class="bold yellow light">
<td class="no-border"></td>
<td style="padding:28px 18px; font-size:11px;line-height:16px;">Sub Total</td>
<td class="right" style="padding:28px 18px; font-size:11px;line-height:16px;">{$new_grand_total}</td>
</tr>
</table>

<br>

<table>
        

        <tr>
        <td colspan="2" class="left"  style="padding:28px 18px; font-size:11px;"><b><u>Company's Tax Details</u></b><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>Income Tax PAN No</b>: ABACA7593C </p><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>GST No:</b> 27ABACA7593C1ZO</p><br>
        </td>
        <td colspan="2" class="center" style="padding:28px 18px; font-size:11px;">
        For <b>ADIS INDIA PLACEMENT PVT LTD.</b>
        <p style="line-height:12px;">
        <img src="$signature" style="width:70px;"><br>
        <b>Mr. Jagdish Yadav</b></p>
        <p style=""><b>Managing Director</b></p>
        </td>
        </tr>
        </table>
HTML;

            $pdf->writeHTML($html, true, false, true, false, '');

            if (ob_get_length()) {
                ob_end_clean();
            }

            $pdfContent = $pdf->Output('invoice.pdf', 'S');

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="invoice.pdf"')
                ->setBody($pdfContent);
    }
    
    
    public function client_reg_recip_pdf($uid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter');
        $client_details = $builder->select('*')->where('uid',$uid)->get()->getRow();
        $client_Hospital_name = ucwords(strtolower($client_details->institute_name));
        $client_name = ucwords(strtolower($client_details->recruiter_name));
        $client_invoice_no=$client_details->regi_invoice_no;
        $client_mobile =$client_details->mobile_number;
        $clientCity_id = $client_details->city_id;
        $builder_city = $db->table('cities');
        $tbl_city = $builder_city->select('*')->where('id',$clientCity_id)->get()->getRow();
        $city_name =  $tbl_city->name;

        $client_reg_type =$client_details->client_reg_type; 
        $regi_date = $client_details->client_fees_reg_date;

        $clientregi_date = (!empty($regi_date) && $regi_date !== '0000-00-00')
            ? date('d/m/Y', strtotime($regi_date))
            : 'N/A';
         // $monthYear = date('M') . date('Y');    
         
         
         $amount   = 10000;
            $gst_rate = 18;

            $cgst_rate = $gst_rate / 2; // 9%
            $sgst_rate = $gst_rate / 2; // 9%

            $cgst_amount = ($amount * $cgst_rate) / 100; // 900
            $sgst_amount = ($amount * $sgst_rate) / 100; // 900

            $total_cgst_amount = number_format($cgst_amount, 2); // 900.00
            $total_sgst_amount = number_format($sgst_amount, 2); // 900.00
            
            $total_gst = $cgst_amount + $sgst_amount + $amount; // 1800
             $sub_total_gst =number_format($total_gst, 2); // 900.00
         // ===============================================================

        $date = new \DateTime($regi_date);

        $monthYear = strtoupper($date->format('Y')); 

        if ($client_reg_type == 'paid') {
             $invoice_no = 'Adisindia/'.$client_invoice_no . '/' . $monthYear; 
        }else
        {
            $invoice_no = 'N/A';
        }

        $client_gstin_no = (!empty($client_details->recruiter_gstin_no))
        ? $client_details->recruiter_gstin_no
        : '-';


          $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set margins
             $pdf->SetTitle('Invoice');
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 10);

        // Add a page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);

        // Month & images
        $monthYear = date('MY');
        $signature = base_url('assets/jobportal/images/home/Sirsig.jpeg');


        

        $html = <<<HTML
            <style>
            table { border-collapse: collapse; width: 100%;}
            td, th { border: 1px solid #000; padding: 5px; }
            .center { text-align: center; }
            .right { text-align: right; }
            .bold { font-weight: bold; }
            .yellow { background-color: #FF8C73; }
            .light { background-color: #eaf2e3; }
          
            
            </style>
            
            <table>
            <tr>
            <td colspan="4" class="center bold" style="background-color:#FF8C73; padding:18px; font-size:18px;">
                TAX INVOICE
            </td>
            </tr>

            <tr>
            <td colspan="3" style="padding:18px; font-size:11px;line-height:22px;"><b>ADIS INDIA PLACEMENT PVT LTD.</b><br>CIN No.: U78100PN2024PTC231287</td>
            <td><b style="padding:18px; font-size:11px;line-height:22px;">Reg.Invoice Number</b><br><br><span style="padding:18px; font-size:9px;line-height:22px;">{$invoice_no}</span></td>
            </tr>

            <tr>
            <td colspan="3" style="padding:18px; font-size:11px; line-height:16px;"><br>
            <b>Office Address:</b> Office no A303, Gera Imperium Gateway,<br>
            Nashik Phata, Pimpri-Chinchwad, Maharashtra 411034<br>
            <b>Contact:</b> 9607559547<br>
            <b>Email:</b> hr@adisindiaplacement.com
            </td>
            <td style="padding:18px; font-size:11px;"><b>Invoice Date</b><br>{$clientregi_date}</td>
            </tr>
            <tr>
            <td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Name:</b> {$client_Hospital_name}</td>
            <td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Address:</b> {$city_name}</td>
            </tr>

            <tr>
            <td colspan="4" style="padding:18px; font-size:11px;line-height:22px;"><b>GSTIN:</b> {$client_gstin_no}</td>
            </tr>
            </table>

            <br>

            <table>
            <tr class="yellow light">
            <td width="8%" style="padding:18px; font-size:11px;line-height:22px;"><b>Sr No</b></td>
            <td width="77%" style="padding:18px; font-size:11px;line-height:22px;"><b>Description of Services</b></td>
            <td width="15%" style="padding:18px; font-size:11px;line-height:22px;"><b>Amount (Rs)</b></td>
            </tr>

            <tr>
            <td class="center" style="padding:28px 18px; font-size:11px;"><br><br>1</td>

            <td style="padding:28px 18px; font-size:11px; line-height:16px;">
                <b><br>Comapny Registration Fees</b><br>
                <br><br><br><br>
            </td>

            <td class="right" style="padding:28px 18px; font-size:11px;">
                <br><br>10,000.00
            </td>
            </tr>

            <tr>
            <td colspan="2" class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
                Total
            </td>
            <td class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
               10,000.00
            </td>
            </tr>
            </table>

            <br>

            <table>
            <tr>
            <td width="40%" class="no-border"></td>
            <td width="45%" style="padding:28px 18px; font-size:11px;">CGST &nbsp;&nbsp;&nbsp;9%</td>
            <td width="15%" style="padding:28px 18px; font-size:11px;" class="right">{$total_cgst_amount}</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">SGST &nbsp;&nbsp;&nbsp;9%</td>
            <td class="right" style="padding:28px 18px; font-size:11px;">{$total_sgst_amount}</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">Deposit Recived </td>
            <td class="right" style="padding:28px 18px; font-size:11px;">0</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">IGST</td>
            <td class="right" style="padding:28px 18px; font-size:11px;">0%</td>
            </tr>
            <tr class="bold yellow light">
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;line-height:16px;">Sub Total</td>
            <td class="right" style="padding:28px 18px; font-size:11px;line-height:16px;">{$sub_total_gst}</td>
            </tr>
            </table>

            <br>

            <table>
            

            <tr>
            <td colspan="2" class="left"  style="padding:28px 18px; font-size:11px;"><b><u>Company's Tax Details</u></b><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>Income Tax PAN No</b>: ABACA7593C </p><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>GST No:</b> 27ABACA7593C1ZO</p><br>
            </td>
            <td colspan="2" class="center" style="padding:28px 18px; font-size:11px;">
            For <b>ADIS INDIA PLACEMENT PVT LTD.</b>
            <p style="line-height:12px;">
            <img src="$signature" style="width:70px;"><br>
            <b>Mr. Jagdish Yadav</b></p>
            <p style=""><b>Managing Director</b></p>
            </td>
            </tr>
            </table>

HTML;

                $pdf->writeHTML($html, true, false, true, false, '');

                if (ob_get_length()) {
                    ob_end_clean();
                }

                $pdfContent = $pdf->Output('invoice.pdf', 'S');

                return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'inline; filename="invoice.pdf"')
                    ->setBody($pdfContent);
    }
    public function client_agreement_details()
    {
       $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }

        $username = session()->get('name');
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $recuiterData = $AdminModel->getrecruiterDetails();
        echo view('admin/header');
        echo view('admin/client_agreement_details',['recuiterData' => $recuiterData]);
        echo view('admin/footer');
    }
    public function edit_agreement_emp($uid)
    {
        $AdminModel = new AdminModel();
        $single_emp_edit = $AdminModel->single_emp_edit($uid);
        echo view('admin/header');
        echo view('admin/edit_agreement_emp',['single_emp_edit'=>$single_emp_edit]);
        echo view('admin/footer'); 
    }
    public function update_agreement_form()
    {
        $db = \Config\Database::connect();
        
        $uid = $this->request->getPost('uid');
        // print_r($_POST);
        
        $data = [
            'agreement_description' => $this->request->getPost('agreement_description'),
            'replecement_month'     => $this->request->getPost('replecement_month'),
        ];
        // print_r($data);
        // exit();

        // Update table
        $builder = $db->table('tbl_recruiter');
        $builder->where('uid', $uid);
        $builder->update($data);

        // Check update success
        if ($db->affectedRows() > 0) {
            return redirect()->to('admin/edit_agreement_emp/'.$uid)
                             ->with('success', 'Agreement updated successfully!');
        } else {
            return redirect()->to('admin/edit_agreement_emp/'.$uid)
                             ->with('error', 'No changes made!');
        }
    }
    private function addImageWatermark($pdf, $imagePath)
    {
        // Check if file exists
        if (!file_exists($imagePath)) {
            echo "Watermark Logo Not Found: " . $imagePath;
            return;
        }

        // Opacity for watermark
        $pdf->SetAlpha(0.12);  // हलका पण दिसणारा watermark

        // No Rotate — Direct Image Watermark
        $pdf->Image(
            $imagePath,
            40,    // X position
            80,    // Y position
            120,   // Width (auto height)
            '',
            '',
            '',
            false,
            300
        );

        // Reset opacity
        $pdf->SetAlpha(1);
    }
private function add_pdf_header($pdf)
{
   

    $pdf->SetCreator('ADIS INDIA PLACEMENT PVT LTD');
    $pdf->SetAuthor('ADIS INDIA PLACEMENT PVT LTD');
    $pdf->SetTitle('Client Agreement');
    $pdf->SetSubject('Client Agreement');

    // Start from top
    $pdf->SetY(13);

    // TITLE
    $pdf->SetFont('helvetica', 'B', 14);
    // $pdf->Cell(0, 9, 'ADIS INDIA PLACEMENT PVT LTD.', 0, 1, 'L');

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Write(0, "Mrs. Tejaswini Deshpande Yadav\n", '', false, 'L', true);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Write(0, "CEO – Adis India Placement Pvt Ltd,\n", '', false, 'L', true);



    // CIN NUMBER
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Write(0, "CIN No: U78100PN2024PTC231287\n", '', false, 'L', true);

    $logoPath = FCPATH . 'assets/jobportal/images/home/new_logo_pdf.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 140, 15, 50);
    }

    $pdf->Ln(1); // extra spacing after header
}
    public function client_agreement_pdf($uid)
{
     $db = \Config\Database::connect();
        
    $builder = $db->table('tbl_recruiter');
    $client_details = $builder->select('*')->where('uid',$uid)->get()->getRow();
    $client_Hospital_name = ucwords(strtolower($client_details->institute_name));
    $client_name = ucwords(strtolower($client_details->recruiter_name));
    $client_full_address = ucwords(strtolower($client_details->area_name));
    $client_agreement_description = ucwords(strtolower($client_details->agreement_description));
    $client_mobile =$client_details->mobile_number;
    $client_replecement =$client_details->replecement_month;

    $clientCity_id = $client_details->city_id;
    $builder_city = $db->table('cities');
    $tbl_city = $builder_city->select('*')->where('id',$clientCity_id)->get()->getRow();
    $city_name =  $tbl_city->name;
    $today = date('j M');
    // echo $client_agreement_description;
    // exit();


   $regi_date = $client_details->client_fees_reg_date;

     $clientregi_date = (!empty($regi_date) && $regi_date !== '0000-00-00')
    ? date('d F Y', strtotime($regi_date))
    : 'N/A';
    $clientregi_date_bottom = date('d.m.Y', strtotime($regi_date));
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);   // remove TCPDF default top line
    $pdf->setPrintFooter(false);  
    $pdf->SetMargins(10, 45, 10);  // space for header
    $pdf->SetAutoPageBreak(TRUE, 15);


    // PAGE 1
    $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);              
    // $pdf->writeHTML($html, true, false, true, false, '');

    // BODY CONTENT
   $pdf->Ln(-3);
$pdf->Line(
    $pdf->GetX(),                 // left margin
    $pdf->GetY(),
    $pdf->getPageWidth() - 15,    // page width - right margin
    $pdf->GetY()
);
$pdf->Ln(6);
    $html = '
    
    <p style="text-align:center; line-height:12px; margin:0; padding:0;">
    <b>MASTER RECRUITMENT & NON-CIRCUMVENTION AGREEMENT</b>
    </p><br><br><br>
<p style="text-align:justify; line-height:12px;font-size:10px;">
This Agreement is made between <b>'.$client_Hospital_name.'</b>,having its registered office at <b>'.$client_full_address.'.</b></p>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$html = '<p style="text-align:justify; line-height:12px;">AND</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);

$html = '<p style="text-align:justify; line-height:12px;margin:0; padding:0;"><b>Adis India Placement Pvt Ltd</b>, Doctors Placement Consultancy,CIN No. U78100PN2024PTC231287, having its registered office at <b>Office No A303, Gera Imperium Gateway, Nashik Phata, Metro Station, Pune, MH 411034.</b> </p>'

;

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$html = '<p style="text-align:justify; line-height:11px;"> </p>'
;


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
<b>1. Scope of Services</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Adis India Placement Pvt Ltd shall provide recruitment and placement services by sourcing candidate profiles through advertisements, social media, executive search, or any other lawful means based on requirements shared by the Client. Final selection and appointment shall always remain the sole discretion of the Client.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:18px;">
All communications shall be in writing via email or official correspondence.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
<b>2. Confidentiality</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
All information including candidate profiles, hospital details, salary structures, interview discussions, and business information shall be treated as strictly confidential and shall not be disclosed to any third party without prior written consent, except as required by law.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '
<p style="text-align:justify; line-height:18px;">
All communications shall be in writing via email or official correspondence.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:20px;">
<b>3. Non-Circumvention / No-Bypass</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The Client and/or Candidate shall not directly or indirectly contact, employ, appoint, engage, or refer any party introduced by the Consultancy for a period of <b>12 (twelve) months</b> from the date of introduction without written consent of the Consultancy.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>4. Liquidated Damages</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
In case of breach of the Non-Circumvention clause, the breaching party agrees to pay liquidated damages of <b>INR 5,00,000/- (Rupees Five Lakhs Only) or two times the agreed placement fee, whichever is higher,</b> without prejudice to other legal remedies.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>5. Document Verification & Candidate Responsibility</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The <b>entire responsibility of verification of educational qualifications, professional registrations (including NMC/MCI/State Council), experience certificates, identity documents, and background checks of the candidate shall solely lie with the Client/Hospital.</b>
</p>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Adis India Placement Pvt Ltd shall rely upon documents and information as submitted by the candidate and <b>does not verify or authenticate the same</b>.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>6. No Warranty / No Guarantee</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The Consultancy <b>does not provide any warranty or guarantee regarding the genuineness,</b> authenticity, validity, or accuracy of educational qualifications, professional registrations, experience certificates, conduct, or performance of any candidate.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>7. Behaviour, Performance & Post-Joining Disclaimer</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The behavior, performance, professional conduct, medical practice, negligence, misconduct, financial fraud, criminal acts, or any untoward incident including injury, death, or loss caused by the candidate <b>are not under the direct or indirect control of the Adis india placement pvt ltd.</b>
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
</p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Once the candidate joins the Client organization, Adis India Placement Pvt Ltd shall not be responsible or liable for any act, omission, accident, negligence, financial loss, criminal liability, or regulatory violation committed by the candidate.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->ln(1);
$footer_html = '
<table width="100%" style="font-size:6pt; text-align:center;">
    <tr>
        <td>
       <b>OFFICE ADDRESS</b> – Adis India Placement Pvt Ltd - Office no A303, Gera Imperium Gateway, Nashik Phata, Kasarwadi, Pune, Pimpri-Chinchwad, Maharashtra 411034 | www.adisindiaplacement.com | hr@adisindiaplacement.com | 9607559547 / 7758929522
        </td>
    </tr>
</table>
';

// Move to 15mm from bottom
$pdf->SetY(-22);

// Print footer HTML
$pdf->writeHTML($footer_html, true, false, false, false, '');


     // $this->add_pdf_footer($pdf);
    
    
if ($pdf->GetY() > 250) {

 $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);

$pdf->ln(2);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>8. Employment Relationship</b></p>';


$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;">
Upon joining, the candidate shall be treated as an employee of the Client and shall be governed solely by the Client’s rules, regulations, policies, and applicable laws. The Consultancy shall not be deemed to be the employer, agent, or guarantor of the candidate.
</p>';
//$pdf->writeHTML($next_html, true, false, true, false, '');

$clean = $client_agreement_description;

    // Remove ALL versions of &nbsp;
    $clean = preg_replace('/&nbsp;|&Nbsp;|&#160;|\xc2\xa0/i', ' ', $clean);

    // Remove "&nbsp;" at end of list items:  ... &nbsp;</li>
    $clean = preg_replace('/\s*&nbsp;\s*<\/li>/i', '</li>', $clean);

    // Remove stray &nbsp; inside list items
    $clean = preg_replace('/\s*&nbsp;\s*/i', ' ', $clean);

    // Remove empty <li> created by NBSP
    $clean = preg_replace('/<li>\s*<\/li>/i', '', $clean);

    // Remove lines that contain ONLY &nbsp; or spaces
    $clean = preg_replace('/^\s*(?:&nbsp;)+\s*$/im', '', $clean);

    // Remove extra spaces
    $clean = preg_replace('/\s+/', ' ', $clean);

    // Trim final output
    $clean = trim($clean);

    // FINAL OUTPUT
$styledContent = '
<div style="font-family: helvetica; font-size: 10px; line-height: 12px; background-color:#FFFF00; padding: 10px;">
<ul style="text-transform: capitalize;margin-left: -15px; padding-left: 15px;">'.$clean.'</ul>
</div>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>9. Company Charges</b></p>
' . $styledContent;
$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
</p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>10. Replacement Policy</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;">
If a candidate leaves employment <b style="background-color:#FFFF00">'. $client_replecement.'</b> of joining for reasons other than termination due to misconduct, negligence, fraud, or policy violation, the Consultancy shall provide one replacement at no additional professional fee, subject to timely written intimation.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>11. Resume Validity</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;margin:0; padding:0;">
If a candidate introduced by the <b>Adis india placement pvt ltd</b> is employed by the Client within <b>12 months</b> of introduction, professional fees shall be payable in full, irrespective of termination of this Agreement.
</p>';


$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>12. Term & Termination</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
Either party may terminate this Agreement by providing <b>30 days’ written notice.</b> Obligations relating to professional fees, confidentiality, indemnity, and limitation of liability shall survive termination.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>13. Indemnity </b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
The Client agrees to <b>indemnify, defend, and hold harmless</b> Adis India Placement Pvt Ltd, its directors, officers, employees, and representatives from and against any claims, losses, damages, penalties, legal proceedings, regulatory actions, costs, or expenses arising out of: - Misrepresentation or fraud by the candidate - Submission of false or forged documents - Professional negligence, misconduct, or criminal acts of the candidate - Violation of medical laws, ethics, or regulations by the candidate
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>14. Limitation of Liability</b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
In no event shall the total liability of Adis India Placement Pvt Ltd, whether in contract, tort, or otherwise, <b>exceed the professional fees actually received for the concerned candidate.</b>
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>15. Principal-to-Principal Relationship</b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
The relationship between the parties shall be on a <b>principal-to-principal basis.</b> Nothing herein shall be construed as creating an agency, partnership, joint venture, or employer-employee relationship.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');


$pdf->SetY(-22);
$pdf->writeHTML($footer_html, true, false, false, false, '');
}
if ($pdf->GetY() > 250) {

 $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);

$pdf->ln(2);

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>16. Arbitration</b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html1 = '
<p style="text-align:justify; line-height:12px;">
Any dispute arising out of or in connection with this Agreement shall be resolved through arbitration by a Sole Arbitrator under the Arbitration & Conciliation Act, 1996. The seat of arbitration shall be <b>Pune,</b> and proceedings shall be conducted in English.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>17. Governing Law & Jurisdiction </b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html1 = '
<p style="text-align:justify; line-height:12px;">
This Agreement shall be governed by the laws of India. Courts at <b>Pune, Maharashtra</b> shall have exclusive jurisdiction.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>18. Entire Agreement </b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);

$next_html1 = '
<p style="text-align:justify; line-height:12px;">
This Agreement constitutes the entire understanding between the parties and supersedes all prior communications. Any amendment shall be valid only if made in writing and signed by both parties.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>IN WITNESS WHEREOF,</b> the parties have executed this Agreement on the date mentioned below.</p>';


// ================= SIGN IMAGE =================
$pdf->Ln(2);

$signPath = FCPATH . 'assets/jobportal/images/home/maam_sign.jpeg';
$left_sign = '';

if (file_exists($signPath)) {
    $left_sign = '<img src="' . $signPath . '" width="80">';
}

// ================= LEFT CONTENT =================
$left_html = '
<p style="line-height:14px;">
<b>Mrs. Tejaswini Deshpande Yadav</b><br>
<b>CEO - Adis India Placement Pvt Ltd</b><br>
<b>CIN No:</b> U78100PN2024PTC231287<br>
<b>Address:</b> Office No A303, Gera Imperium Gateway,<br>
Nashik Phata, Metro Station, Pune, MH 411034<br>
<b>Date:</b> '.$clientregi_date_bottom.'
</p>
';

// ================= RIGHT CONTENT =================
$right_html = '
<p style="line-height:16px;">
<b>Sign –</b> _______________________________<br><br>
<b>Stamp –</b> _______________________________<br><br>
<b>'.$client_name.'</b><br>
<b>'.$client_Hospital_name.'</b><br>
<b>Address:</b> '.$client_full_address.'
</p>
';

// ================= LEFT + RIGHT TABLE =================
$main_table = '
<table border="0" cellpadding="6" width="100%">
    <tr>
        <td width="48%" valign="top" align="left">
            '.$left_sign.'
            <br><br>
            '.$left_html.'
        </td>

        <td width="4%"></td>

        <td width="48%" valign="top" align="left">
            '.$right_html.'
        </td>
    </tr>
</table>
';

$pdf->writeHTML($main_table, true, false, true, false, '');

// ================= LEGAL TEAM TITLE =================
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(0); 
$pdf->Cell(0, 8, 'Our Legal Team', 0, 1, 'C');
$pdf->Ln(4);

// ================= LEGAL TEAM MEMBERS =================
$legal_team_table = '
<table border="0" cellpadding="6" width="100%">
<tr>
<td width="48%" valign="top" align="left">
<b>(1) Mr. Anant Deshpande (LLB / LLM)</b><br>
Chairman - Sambhajinagar.<br><br>

</td>

<td width="48%" valign="top" align="left">
<b>(2) Mr. Suresh Rudrawar (LLB / LLM)</b><br>
Member – High Court, Sambhajinagar.<br><br>

</td>
    </tr>
</table>
';

$pdf->writeHTML($legal_team_table, true, false, true, false, '');

// ================= FOOTER =================
$pdf->Ln(10);
$pdf->SetY(-22);
$pdf->writeHTML($footer_html, true, false, false, false, '');

}


    // OUTPUT
    if (ob_get_length()) { @ob_end_clean(); }
    $pdfContent = $pdf->Output('invoice.pdf', 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'inline; filename="Client Agremment '.$today.'.pdf"')
        ->setBody($pdfContent);

}


public function update_admin_email_status()
{
    // echo "hello";
    // exit();
    $request = $this->request;
    $AdminModel = new \App\Models\AdminModel();
    
    $job_status_id = $this->request->getPost('job_status_id');
    $status        = $this->request->getPost('send_email');

    if ($status == 1) {

        // Update DB
        $data_update_invoce_status = [
            'payment_recived_status' => 'Send_invoice',
            'invoice_send_date'      => date('Y-m-d'),
        ];
        $db = \Config\Database::connect();
        //  PDF GENERATED AS STRING (NOT FILE)
        $builder = $db->table('tbl_candidate_job_status');
        $pdf_details = $builder->select('*')->where('job_status_id',$job_status_id)->get()->getRow();

        $client_no = $pdf_details->user_id;
        $builder_client = $db->table('tbl_recruiter');
        $tbl_client = $builder_client->select('*')->where('uid',$client_no)->get()->getRow();
        $client_name = ucwords(strtolower($tbl_client->recruiter_name));
        $client_email = $tbl_client->email;
        // echo $db->getLastQuery();
        // exit();
        $pdf_string = $this->generate_invoice_pdf($job_status_id);

        // Send email with string attachment
        $this->send_invoice_mail($job_status_id, $pdf_string,$client_name,$client_email);

    } else {
        $data_update_invoce_status = [
            'payment_recived_status' => '',
            'invoice_send_date'      => NULL,
        ];
    }

    // Update DB
    $builder = $AdminModel->db->table('tbl_candidate_job_status');
    $builder->where('job_status_id', $job_status_id);
    $builder->update($data_update_invoce_status);

    return "success";
}

private function generate_invoice_pdf($job_status_id)
{
    $db = \Config\Database::connect();

    // ---------------- FETCH DATA ----------------
    $pdf_details = $db->table('tbl_candidate_job_status')
        ->where('job_status_id', $job_status_id)
        ->get()
        ->getRow();

    if (!$pdf_details) {
        return false;
    }

    $client_no        = $pdf_details->user_id;
    $invoice_number   = $pdf_details->invoice_number;
    $joining_date     = date("d-m-Y", strtotime($pdf_details->joining_date));
    $candidate_job_id = $pdf_details->jobseeker_id;

    // recruiter
    $tbl_client = $db->table('tbl_recruiter')->where('uid', $client_no)->get()->getRow();
    $client_name  = ucwords(strtolower($tbl_client->recruiter_name));
    $institute_name=ucwords(strtolower($tbl_client->institute_name));
    $client_gstin_no = !empty($tbl_client->recruiter_gstin_no) ? $tbl_client->recruiter_gstin_no : '-';
    $city_id = $tbl_client->city_id;

    // city
    $tbl_city = $db->table('cities')->where('id', $city_id)->get()->getRow();
    $city_name = $tbl_city->name ?? '-';

    // candidate
    $tbl_jobseeker = $db->table('tbl_jobseeker')->where('jobseeker_id', $candidate_job_id)->get()->getRow();
    $candidate_name = ucwords(strtolower($tbl_jobseeker->full_name));

    // job role
    $tbl_jobrole = $db->table('tbl_job_role')->where('job_id', $tbl_jobseeker->job_id)->get()->getRow();
    $position_name = ucwords(strtolower($tbl_jobrole->job_role));

    // payments
    $client_payment = floatval(preg_replace('/[^0-9.]/', '', $pdf_details->client_payment));
    $client_payment_fmt = number_format($client_payment, 2);

    $advanced_pay = floatval(preg_replace('/[^0-9.]/', '', $tbl_client->advanced_payment));

    $total_cgst_amount = number_format(($client_payment * 9) / 100, 2);
    $total_sgst_amount = number_format(($client_payment * 9) / 100, 2);

    $new_grand_total = number_format(
        ($client_payment + ($client_payment * 0.18)) - $advanced_pay,
        2
    );

    $monthYear = date('M') . date('Y');

    $signature = FCPATH . 'assets/jobportal/images/home/Sirsig.jpeg';

    // ---------------- PDF INIT ----------------
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetMargins(10, 15, 10);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();

    // ---------------- HTML (SAME STRUCTURE) ----------------
$html = <<<HTML
<style>
table { border-collapse: collapse; width: 100%; font-size:11px; }
td, th { border: 1px solid #000; padding: 5px; vertical-align: top; }
.center { text-align: center; }
.right { text-align: right; }
.bold { font-weight: bold; }
.yellow { background-color: #FF8C73; }
.no-border { border: none; }
</style>

<!-- HEADER -->
<table>
<tr>
<td colspan="4" class="center bold yellow" style="font-size:18px; padding:10px;">
TAX INVOICE
</td>
</tr>

<tr>
<td colspan="3">
<b>ADIS INDIA PLACEMENT PVT LTD.</b><br>
CIN No.: U78100PN2024PTC231287
</td>
<td>
<b>Invoice Number</b><br>
Adisindia/{$invoice_number}
</td>
</tr>

<tr>
<td colspan="3">
<b>Office Address:</b> Office no A303, Gera Imperium Gateway,<br>
Nashik Phata, Pimpri-Chinchwad, Maharashtra 411034<br>
<b>Contact:</b> 9607559547<br>
<b>Email:</b> hr@adisindiaplacement.com
</td>
<td>
<b>Invoice Date</b><br>
{$joining_date}
</td>
</tr>

<tr>
<td colspan="2"><b>Name:</b> {$institute_name}</td>
<td colspan="2"><b>Address:</b> {$city_name}</td>
</tr>

<tr>
<td colspan="4"><b>GSTIN:</b> {$client_gstin_no}</td>
</tr>
</table>

<br>

<!-- SERVICE TABLE -->
<table>
<tr class="yellow bold">
    <td width="8%">Sr No</td>
    <td width="72%">Description of Services</td>
    <td width="20%" class="right">Amount (Rs)</td>
</tr>

<tr style="height:140px;">
    <td class="center">1</td>
    <td>
        <b>Candidate Name:</b> {$candidate_name}<br>
        <b>Job Position:</b> {$position_name}
    </td>
    <td class="right" valign="top">{$client_payment_fmt}</td>
</tr>

<tr class="yellow bold">
    <td colspan="2" class="right">Total</td>
    <td class="right">{$client_payment_fmt}</td>
</tr>

<tr>
    <td colspan="2" class="right bold">CGST &nbsp; 9%</td>
    <td class="right">{$total_cgst_amount}</td>
</tr>

<tr>
    <td colspan="2" class="right bold">SGST &nbsp; 9%</td>
    <td class="right">{$total_sgst_amount}</td>
</tr>

<tr>
    <td colspan="2" class="right bold">Deposit Recived</td>
    <td class="right">{$advanced_pay}</td>
</tr>

<tr>
    <td colspan="2" class="right bold">IGST</td>
    <td class="right">0%</td>
</tr>

<tr class="yellow bold">
    <td colspan="2" class="right">Sub Total</td>
    <td class="right">{$new_grand_total}</td>
</tr>
</table>


<br>

<!-- FOOTER -->
<table>
<tr>
<td width="50%">
<b>Company's Tax Details</b><br>
Income Tax PAN No: ABACA7593C<br>
GST No: 27ABACA7593C1ZO
</td>

<td width="50%" class="center">
For <b>ADIS INDIA PLACEMENT PVT LTD.</b><br><br>
<img src="{$signature}" width="70"><br>
<b>Mr. Jagdish Yadav</b><br>
Managing Director
</td>
</tr>
</table>
HTML;


    $pdf->writeHTML($html, true, false, true, false, '');

    if (ob_get_length()) {
        ob_end_clean();
    }

    return $pdf->Output('invoice.pdf', 'S');
}

private function send_invoice_mail($job_status_id,$pdf_string,$client_name,$client_email)
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
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
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

        // FROM / TO
        $mail->setFrom('adishr@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
        $mail->addAddress($client_email);
        //$mail->addAddress("contact@adisindiaplacement.com");

        $mail->isHTML(true);
        $mail->Subject = "Invoice Submission  Kindly Process Payment Within 7 Working Days";
        $mail->Body    = '
        <p>Dear '.$client_name.',</p>

        <p>Greetings from <b>Adis India Placement Pvt. Ltd.</b></p>

        <p>
        This is to inform you that we have sent the invoice for the recent recruitment services 
        provided to your organization.
        </p>

        <p>
        We kindly request you to process the payment within <b>7 working days</b> as per the agreed terms.
        </p>

        <p>
        If you need any clarification or supporting documents, please feel free to contact us. 
        We will be happy to assist you.
        </p>

        <p>Thank you for your continued trust and partnership.</p>

        <p>
        Warm Regards,<br>
        <b>Team Adis India Placement</b><br>
        <b>9607559547</b>
        </p>
        ';

        // ATTACH PDF AS STRING (THIS IS IMPORTANT)
        $mail->addStringAttachment($pdf_string, "invoice_$job_status_id.pdf");

        $mail->send();

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        log_message('error', 'Mail error: ' . $e->getMessage());
    }
}


public function edit_recived_client_payment($job_status_id)
{
        $AdminModel = new AdminModel();
        // $single_emp_edit = $AdminModel->single_emp_edit($uid);
        $single_posting_edit = $AdminModel->single_candidate_status($job_status_id);
        echo view('admin/header');
        echo view('admin/edit_recived_client_payment',['single_posting_edit'=>$single_posting_edit]);
        echo view('admin/footer'); 
}

public function update_client_recived_form()
{
    $request = $this->request;
     $db = \Config\Database::connect();
    // Get post values
    $job_status_id            = $request->getPost('job_status_id');
    $client_recived_payment   = $request->getPost('client_recived_payment');
    $payment_type             = $request->getPost('payment_type');
    $discount_check           = $request->getPost('discount_check');
    $discount_amount          = $request->getPost('discount_amount');
    $tds_status           = $request->getPost('tds_status');
    $tds_amount               = $request->getPost('tds_amount');


    // Prepare update array
    //=====================02-12-2025 =====================
    $builder = $db->table('tbl_candidate_job_status');
    $pdf_details = $builder->select('*')
                       ->where('job_status_id', $job_status_id)
                       ->get()
                       ->getRow();
        $old_client_recived_value = !empty($pdf_details->client_recived_payment) 
                            ? floatval($pdf_details->client_recived_payment)
                            : 0;

        // NEW RECEIVED VALUE (convert to number safely)
        $new_posted_recived_value = floatval($client_recived_payment);
        if ($old_client_recived_value > 0) {
            $total_client_recived_payment = $old_client_recived_value + $new_posted_recived_value;
        } else {
            $total_client_recived_payment = $new_posted_recived_value;
        }

    // $data_update_client_recived = [
    //     'client_recived_payment' => $total_client_recived_payment,
    //     'discount_check' =>$discount_check,
    //     'discount_amount' =>$discount_amount,
    //     'payment_type'   => $payment_type
    // ];
        $old_discount_check = $pdf_details->discount_check;
        $old_tds_check = $pdf_details->tds_status;

    $data_update_client_recived = [
    'client_recived_payment' => $total_client_recived_payment,
    'discount_check'         => $discount_check,
    'tds_status'             => $tds_status,
    'payment_type'           => $payment_type,
    'tds_amount'             => $tds_amount
    ];

     if ($old_discount_check === 'yes') {
            $data_update_client_recived['discount_check'] = 'yes';
    }
    if ($old_tds_check === 'yes') {
            $data_update_client_recived['tds_status'] = 'yes';
    }

        if (!empty($discount_amount)) {
        $data_update_client_recived['discount_amount'] = $discount_amount;
    }

   
    // print_r($data_update_client_recived);
    // exit();

    // DB builder
    $db = \Config\Database::connect();
    $builder = $db->table('tbl_candidate_job_status');

    // Perform update
    $updated_posting_data = $builder->where('job_status_id', $job_status_id)
                                    ->update($data_update_client_recived);

    // Redirect based on result
    if ($updated_posting_data) {
        return redirect()->to(base_url('admin/edit-recived-client-payment/' . $job_status_id))
                         ->with('success', 'Client Received Payment updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Something went wrong!');
    }
}

public function update_recived_client_payment_status()
{
    $request = $this->request;
    $AdminModel = new \App\Models\AdminModel();
    
    $job_status_id = $this->request->getPost('job_status_id');
    $status        = $this->request->getPost('send_email');
   
    if ($status == 1) {

        // Update DB
        $data_update_invoce_status = [
            'payment_recived_status' => 'Recived_payment',
            'payment_recived_date'      => date('Y-m-d'),
        ];
        //  print_r($data_update_invoce_status);
        // exit();
        $db = \Config\Database::connect();
        //  PDF GENERATED AS STRING (NOT FILE)
        $builder = $db->table('tbl_candidate_job_status');
        $pdf_details = $builder->select('*')->where('job_status_id',$job_status_id)->get()->getRow();

        $client_no = $pdf_details->user_id;
        $builder_client = $db->table('tbl_recruiter');
        $tbl_client = $builder_client->select('*')->where('uid',$client_no)->get()->getRow();
        $client_name = ucwords(strtolower($tbl_client->recruiter_name));
        $client_email = $tbl_client->email;
        $pdf_string = $this->generate_invoice_pdf($job_status_id);

        // Send email with string attachment
        $this->send_recived_client_mail($job_status_id,$client_name,$client_email);

    } else {
        $data_update_invoce_status = [
            'payment_recived_status' => '',
            'payment_recived_date'      => NULL,
        ];
    }

    // Update DB
    $builder = $AdminModel->db->table('tbl_candidate_job_status');
    $builder->where('job_status_id', $job_status_id);
    $builder->update($data_update_invoce_status);

    return "success";
}

private function send_recived_client_mail($job_status_id,$client_name,$client_email)
{
    require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require APPPATH . 'Libraries/PHPMailer/SMTP.php';
    require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
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
            $mail->addAddress($client_email);
            //$mail->addAddress("contact@adisindiaplacement.com");
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for the Payment  We Appreciate Your Support';

            $mail->Body = '
                <p>Hello <strong>' . htmlspecialchars($client_name) . '</strong>,</p>

                <p><strong>Greetings from Adis India Placement Pvt. Ltd.</strong></p>

                <p>We sincerely thank you for clearing the payment for our recent invoice.</p>
                <p>We truly appreciate your prompt response and smooth coordination.</p>

                <p>
                    It has been a pleasure working with your esteemed organization, and we are glad to continue this partnership.
                    Our team looks forward to supporting you with more quality recruitment services in the future.
                </p>

                <p>
                    If you require any additional assistance or new doctor requirements, 
                    please feel free to reach out anytime.
                </p>

    <p>Thank you once again for your trust in <strong>Adis India</strong>.</p>
                <br>
                <p>Warm regards,<br><strong>Adis India Placement Team</strong><br>
                <strong>9607559547</strong></p>
            ';

            if ($mail->send()) {
                log_message('info', " success");
            } else {
                log_message('error', '❌ Mail send failed: ' . $mail->ErrorInfo);
            }

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            log_message('error', '❌ Mail error: ' . $e->getMessage());
        }
}

    public function recived_payment_status()
    {
            $AdminModel = new AdminModel();
            $db = \Config\Database::connect();
            $RecivePaymenteClient = $AdminModel->RecivePaymenteClientdisply();
            echo view('admin/header');
            echo view('admin/recive_payment_client_status',['RecivePaymenteClient' => $RecivePaymenteClient]);
            echo view('admin/footer');
    }
    public function pending_client_payment()
    {
         $AdminModel = new AdminModel();
            $db = \Config\Database::connect();
            $pendingPaymenteClient = $AdminModel->PendingPaymenteClientdisply();
            echo view('admin/header');
            echo view('admin/pending_payment_client',['pendingPaymenteClient' => $pendingPaymenteClient]);
            echo view('admin/footer');
    }
    public function paid_payment_client()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
    
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $PaidClientDisplay = $AdminModel->getPaidClientDisplay();
        echo view('admin/header');
        echo view('admin/paid_registraion_client',['PaidClientDisplay' => $PaidClientDisplay]);
        echo view('admin/footer');
    }
    public function free_payment_client()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
    
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $FreeClientDisplay = $AdminModel->getFreeClientDisplay();
        echo view('admin/header');
        echo view('admin/free_registraion_client',['FreeClientDisplay' => $FreeClientDisplay]);
        echo view('admin/footer');
    }
    
    public function advance_payment_client()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
    
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $FreeClientDisplay = $AdminModel->getAdvancedClientDisplay();
        echo view('admin/header');
        echo view('admin/advance_payment_client',['FreeClientDisplay' => $FreeClientDisplay]);
        echo view('admin/footer');
    }
    
    public function total_years_count_billing()
    {
        $session = session();
        if (!session()->has('name')) {
            return redirect()->to('admin');
        }
    
        // -------- Month Names --------
        $monthNames = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];
    
        // -------- CURRENT DATE --------
        $today = new \DateTime();
        $currentMonth = (int)$today->format('n');
        $currentYear  = (int)$today->format('Y');
    
        // -------- Determine Financial Year --------
        if ($currentMonth >= 4) { 
            $startYear = $currentYear;
            $endYear   = $currentYear + 1;
        } else {
            $startYear = $currentYear - 1;
            $endYear   = $currentYear;
        }
    
        // -------- USER POST INPUT --------
        $start_date = $this->request->getPost('start_date'); // YYYY-MM
        $end_date   = $this->request->getPost('end_date');   // YYYY-MM
    
        $months = [];
    
        // -------- If user selected custom months --------
        if (!empty($start_date) && !empty($end_date)) {
    
            $start = new \DateTime($start_date . "-01");
            $end   = new \DateTime($end_date . "-01");
            $end->modify('last day of this month');
    
            while ($start <= $end) {
                $months[] = [
                    'month' => $start->format('F'),
                    'year'  => $start->format('Y')
                ];
                $start->modify('+1 month');
            }
    
        } else {
    
            // -------- Default: Financial Year (April → March) --------
            for ($i = 0; $i < 12; $i++) {
    
                $monthIndex = ($i + 3) % 12; // April index = 3
                $year = ($monthIndex >= 3) ? $startYear : $endYear;
    
                $months[] = [
                    'month' => $monthNames[$monthIndex],
                    'year'  => $year
                ];
            }
        }
    
        return view('admin/header')
             . view('admin/total_years_count_billing', [
                    'months'     => $months,
                    'start_date' => $start_date,
                    'end_date'   => $end_date
             ])
             . view('admin/footer');
    }
    
    public function update_client_email_status()
    {
        $request = $this->request;
        $AdminModel = new \App\Models\AdminModel();
        $email_send_id = $this->request->getPost('email_send_id');
        $status        = $this->request->getPost('send_email');
    
          if ($status == 1) {
    
            // Update DB
            $data_update_email_status = [
                'send_agreement_client' => 'yes',
                'agreement_send_date'      => date('Y-m-d'),
            ];
            $db = \Config\Database::connect();
            //  PDF GENERATED AS STRING (NOT FILE)
            $builder = $db->table('tbl_recruiter');
            $client_details = $builder->select('*')->where('uid',$email_send_id)->get()->getRow();
    
    
            $client_name = ucwords(strtolower($client_details->recruiter_name));
            $client_email = $client_details->email;
            $pdf_string = $this->generate_client_email_send_agreement($email_send_id);
    
            // Send email with string attachment
            $this->send_agreement_client_mail($email_send_id, $pdf_string,$client_name,$client_email);
    
        } else {
            $data_update_email_status = [
                'send_agreement_client' => '',
                'agreement_send_date'      => NULL,
            ];
        }
    
        // Update DB
        $builder = $AdminModel->db->table('tbl_recruiter');
        $builder->where('uid', $email_send_id);
        $builder->update($data_update_email_status);
    
        return "success";
    
    
    }
    
//     private function generate_client_email_send_agreement($email_send_id)
//     {
//         $db = \Config\Database::connect();
        
//         $builder = $db->table('tbl_recruiter');
//         $client_details = $builder->select('*')->where('uid',$email_send_id)->get()->getRow();
//         $client_Hospital_name = ucwords(strtolower($client_details->institute_name));
//         $client_name = ucwords(strtolower($client_details->recruiter_name));
//         $client_full_address = ucwords(strtolower($client_details->area_name));
//         $client_agreement_description = ucwords(strtolower($client_details->agreement_description));
//         $client_mobile =$client_details->mobile_number;
//         $client_replecement =$client_details->replecement_month;
    
//         $clientCity_id = $client_details->city_id;
//         $builder_city = $db->table('cities');
//         $tbl_city = $builder_city->select('*')->where('id',$clientCity_id)->get()->getRow();
//         $city_name =  $tbl_city->name;
//         $today = date('j M');
      
    
    
//       $regi_date = $client_details->client_fees_reg_date;
    
//          $clientregi_date = (!empty($regi_date) && $regi_date !== '0000-00-00')
//         ? date('d F Y', strtotime($regi_date))
//         : 'N/A';
//         $clientregi_date_bottom = date('d.m.Y', strtotime($regi_date));
//         $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//         $pdf->setPrintHeader(false);   // remove TCPDF default top line
//         $pdf->setPrintFooter(false);  
//         $pdf->SetMargins(10, 45, 10);  // space for header
//         $pdf->SetAutoPageBreak(TRUE, 15);
    
    
//         // PAGE 1
//         $pdf->AddPage();
//         $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
//         $this->add_pdf_header($pdf); // header first
//         $pdf->SetY(39);              
//         // $pdf->writeHTML($html, true, false, true, false, '');
    
//         // BODY CONTENT
//         $pdf->SetFont('helvetica', '', 10);
//         $html = '
//     <p style="text-align:center; line-height:12px; margin:0; padding:0;">
//     <b>RECRUITMENT SERVICE AGREEMENT</b>
//     </p>
// <p style="text-align:justify; line-height:12px;">
// This Recruitment Services Agreement <b>(“Agreement”)</b> is made and executed on this '.$clientregi_date.' by
// and between:</p>';
// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->Ln(1);
// $pdf->SetFont('helvetica', '', 10);
// $html = '<p style="text-align:justify; line-height:12px;">First party,<b> Adis India Placement Pvt Ltd</b> a company incorporated under
// the laws of India and having its registered office at Office No A303, Gera Imperium Gateway, Nashik Phata, Metro Station, Pune, MH 411034  through its authorized signatory <b>Mrs.Tejaswini Deshpande Yadav - CEO</b>
// (hereinafter referred to as “First Party” which expression shall unless repugnant to the context or
// meaning there of include its successors and assigns) OF <b>THE FIRST PARTY</b></p>';

// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->Ln(1);
// $pdf->SetFont('helvetica', '', 10);
// $html = '
// <p style="text-align:center; line-height:12px; margin:0; padding:0;">
// <b>AND</b>
// </p>';
// $pdf->writeHTML($html, true, false, true, false, '');

// $pdf->SetFont('helvetica', '', 10);
// $html = '
// <p style="text-align:justify; line-height:12px;">
// Second party <b><b>'.$client_Hospital_name.'</b> </b>, a company incorporated under the laws of India and
// having its registered office at @ '.$client_full_address.' through its authorized signatory <b>'.$client_name.' – Director</b>
// (hereinafter Called the “Second Party” which expression include its successors, assigns and
// Directors) OF <b>THE SECOND PARTY</b>
// </p>';
// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->Ln(1);

// $pdf->SetFont('helvetica', '', 10);


// $html = '
// <p style="text-align:justify; line-height:12px;">
// Profile selection by <b>Adis India Placement Pvt Ltd</b> can be made by any of the methods like advertising or social media or executive search or any other appropriate method for requirements received from the 
//     <b>'.$client_Hospital_name.'</b>. 
//     The hospital shall nominate one of the <b>'.$client_Hospital_name.'</b> executives to work with 
//     <b>Adis India Placement Pvt Ltd</b> so as to provide all the necessary information.<br>

// The hospital shall provide detailed feedback about the services rendered by 
// <b>Adis India Placement Pvt Ltd</b> on a monthly basis.
// </p>
// ';
// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->Ln(1);
// $html = '
// <p style="text-align:justify; line-height:12px;">
// Find and inform the <b>Adis India Placement Pvt Ltd</b> of any issues pertaining to duplication of profiles or mismatch of profile to the job role, within 24 hours (1 day) of sharing of the resume. 
//     Profiles that are not selected by the <b>'.$client_Hospital_name.'</b> are to be reverted / returned across mail. 
//     All the communication regarding any aspect at any time should be in writing (or Mail).
// </p>
// ';

// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->ln(1);
// $html = '
// <p style="text-align:justify; line-height:12px;">
// Responsibility of document verification solely lies with the <b>'.$client_Hospital_name.'</b> Behavior & performance of a candidate at any time is not under direct or indirect control of <b>Adis India Placement Pvt Ltd.</b> Once the candidate joins Adis India Placement Pvt Ltd is not responsible for the promotion / developments / progress / achievements / accidents / death / any untoward incidents of candidates.
// <br>
// Once the candidate joins <b>'.$client_Hospital_name.'</b> organization, they are bound by <b>'.$client_Hospital_name.'</b>Organization’s rules & regulations as employees. It is mandatory on the part of <b>'.$client_Hospital_name.'</b> organization to mail copy of the offer letter duly signed by the management & the candidate, before joining of the candidate.
// </p>
// ';
// $styledContent = '<div style="font-family: helvetica; font-size: 10px; line-height: 10px;background-color:#FFFF00">'
//                  .$client_agreement_description.
//                  '</div>';
// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->ln(1);
// $html = '
// <p style="text-align:justify;font-family: helvetica; line-height:12px;">
// <b>Professional Fees:</b>
// </p>
// ' . $styledContent;
// $pdf->writeHTML($html, true, false, true, false, '');
// $pdf->ln(1);
// $pdf->SetFont('helvetica', '', 10);


// // --- FIRST PARAGRAPH ---
// $html = '

// <p style="text-align:justify; line-height:12px; font-size:10pt; font-weight:normal;">
// Any changes to this agreement will be valid if signed separately by both parties i.e. between <b>'.$client_Hospital_name.'</b>
// and <b>Adis India Placement Pvt. Ltd.</b><br>
// That the Recruitment Service charges for candidates hired on partial salary & complete incentive basis then consultancy
// charges will be 150,000/- fix + 18% GST Service Tax. Any or all information shared by <b>Adis India Placement Pvt. Ltd.</b> with
// <b>'.$client_Hospital_name.'</b>
// should be treated as strictly confidential and should not be shared with any other party/person or for any purpose other than for which
// it is meant.';
// $pdf->writeHTML($html, true, false, true, false, '');


// $pdf->ln(1);
// $footer_html = '
// <table width="100%" style="font-size:6pt; text-align:center;">
//     <tr>
//         <td>
//       <b>OFFICE ADDRESS</b> – Adis India Placement Pvt Ltd - Office no A303, Gera Imperium Gateway, Nashik Phata, Kasarwadi, Pune, Pimpri-Chinchwad, Maharashtra 411034 | www.adisindiaplacement.com | hr@adisindiaplacement.com | 9607559547 / 7758929522
//         </td>
//     </tr>
// </table>
// ';

// // Move to 15mm from bottom
// $pdf->SetY(-22);

// // Print footer HTML
// $pdf->writeHTML($footer_html, true, false, false, false, '');


//      // $this->add_pdf_footer($pdf);
    
    
// if ($pdf->GetY() > 250) {

//  $pdf->AddPage();
//     $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
//     $this->add_pdf_header($pdf); // header first
//     $pdf->SetY(39);

// $pdf->ln(2);
// $next_html = '
// <p style="text-align:justify; line-height:12px; font-size:10pt; font-weight:normal;">
// <b>Replacement:</b>
//  If any candidate referred by <b>Adis India Placement Pvt. Ltd.</b>leaves the <b>'.$client_Hospital_name.'</b>organization <b style="background-color:#FFFF00">'. $client_replecement.',</b> then
// <b>Adis India Placement Pvt. Ltd.</b>shall arrange for other candidate for replacement without any extra Professional Fee provided.
// <b>'.$client_Hospital_name.'</b> informs <b>Adis India Placement Pvt Ltd</b> within a week of the candidates resignation.However, there will not be any free replacement service if a candidate is sacked/forced to resign by <b>'.$client_Hospital_name.'</b>
// ';

// $pdf->writeHTML($next_html, true, false, true, false, '');
// $pdf->Ln(2);

// $pdf->SetFont('helvetica','',10);
// $next_html ='
// <b>Resume Validity:</b>
// Once a candidate is referred by <b>Adis India Placement Pvt Ltd</b> for any position and is selected 
// within one year, then the professional fees will have to be paid in full to 
// <b>Adis India Placement Pvt Ltd</b> as mentioned above.
// </p>';

// $pdf->SetFont('helvetica', '', 10);
// $pdf->writeHTML($next_html, true, false, true, false, '');
// $next_html ='
// <p style="text-align:justify; line-height:12px; font-weight:normal;">
// <b>Term/Termination:</b><br><br>
// The terminating party must provide 30 days’ notice to the other party. However, 
// <b>Adis India Placement Pvt Ltd</b> full (Complete) Professional Fee shall survive if any 
// candidate referred by <b>Adis India Placement Pvt Ltd</b> is employed by 
// <b>'.$client_Hospital_name.'</b> within one year of reference in spite 
// of termination of this agreement. The relationship between 
// <b>Adis India Placement Pvt Ltd</b> and <b>'.$client_Hospital_name.'</b> 
// will be that of Principal to Principal. Any notice required by this MO or given in connection with it 
// shall be in writing and shall be given to the appropriate party by personal delivery or by registered 
// post address, or recognized overnight delivery services with proof of delivery on address mentioned 
// in first para of this agreement..
// </p>';
// $pdf->writeHTML($next_html, true, false, true, false, '');
// $pdf->Ln(2);
// $next_html ='
// <p style="text-align:justify; line-height:12px;">
// <b>Arbitration:</b><br><br>
// Any dispute or controversy between the Parties which may arise out of or in connection with this 
// Agreement, or any breach thereof shall unless amicably settled, be referred to arbitration by a Sole 
// Arbitrator, to be appointed by mutual consent. In case of difference of opinion regarding nomination 
// of Arbitrator, the Arbitrator will be appointed through the Court of Law. The place of arbitration 
// will be Pune. The arbitration shall proceed in accordance with the (India) Arbitration and 
// Conciliation Act, 1996. Arbitration shall be conducted in English language. All costs of the arbitration 
// (including attorneys’ fees and fees for witnesses and expert witnesses) shall be borne by the respective Parties.
// </p>';
// $pdf->writeHTML($next_html, true, false, true, false, '');
// $pdf->Ln(2);
// $next_html ='
// <p style="text-align:justify; line-height:12px;">
// <b>Governing Law:</b><br>
// This Agreement shall be governed and construed in accordance with the laws of India and the Parties 
// consent to the exclusive jurisdiction of the courts in Aurangabad for any dispute arising out of 
// this agreement.
// </p>
// <p style="text-align:justify; line-height:12px;">
// <b>Headings:</b><br>
// Headings used in this Agreement are provided for convenience only and shall not be used to construe 
// meaning or intent.
// <b>IN WITNESS WHEREOF,</b> the parties have executed this Agreement as of the date first above written.
// </p>';

// $pdf->writeHTML($next_html, true, false, true, false, '');
// $pdf->Ln(2);
// $signPath = FCPATH . 'assets/jobportal/images/home/maam_sign.jpeg';

// $left_sign = '';
// if (file_exists($signPath)) {
//     // store image HTML (TCPDF supports base64 image or file path)
//     $left_sign = '<img src="' . $signPath . '" width="80">';
// }

// // ---------- LEFT SIDE HTML ----------
// $left_html = '
// <p style="line-height:14px;">
// <b>Mrs. Tejaswini Deshpande Yadav</b><br>
// <b>CEO - Adis India Placement Pvt Ltd </b><br>
// <b>CIN No: U78100PN2024PTC231287</b><br>
// <b>Address:</b> Office No A303, Gera Imperium Gateway,<br>
// Nashik Phata, Metro Station, Pune, MH 411034<br>
// <b>Date:</b> '.$clientregi_date_bottom.'
// </p>';

// // ---------- RIGHT SIDE HTML ----------
// $right_html = '
// <p style="line-height:14px;"><br><br><br><br>
// <b>Sign –</b> _______________________________<br><br>
// <b>Stamp –</b> _______________________________<br><br>
// <b>'.$client_name.'</b><br>
// <b>'.$client_Hospital_name.'</b><br>
// <b>Address:</b> '.$client_full_address.'

// </p>';

// // ---------- TABLE FOR SIDE-BY-SIDE LAYOUT ----------
// $table = '
// <table border="0" cellpadding="4" width="100%">
//     <tr>

//         <td width="48%" valign="top">
//             '.$left_sign.'
//             <br><br>
//             '.$left_html.'
//         </td>

//         <td width="4%"></td> <!-- small gap -->

//         <td width="48%" valign="top">
//             '.$right_html.'
//         </td>
//     </tr>
// </table>
// ';

// $pdf->Ln(10);
// $pdf->writeHTML($table, true, false, true, false, '');
// $pdf->SetY(-22);
// $pdf->writeHTML($footer_html, true, false, false, false, '');
// }
//     if (ob_get_length()) { @ob_end_clean(); }

//     $pdfContent = $pdf->Output('agreement.pdf', 'S');

//     return $pdfContent;
        
        
        
// }


 private function generate_client_email_send_agreement($email_send_id)
 {
     $db = \Config\Database::connect();
        
    $builder = $db->table('tbl_recruiter');
    $client_details = $builder->select('*')->where('uid',$email_send_id)->get()->getRow();
    $client_Hospital_name = ucwords(strtolower($client_details->institute_name));
    $client_name = ucwords(strtolower($client_details->recruiter_name));
    $client_full_address = ucwords(strtolower($client_details->area_name));
    $client_agreement_description = ucwords(strtolower($client_details->agreement_description));
    $client_mobile =$client_details->mobile_number;
    $client_replecement =$client_details->replecement_month;

    $clientCity_id = $client_details->city_id;
    $builder_city = $db->table('cities');
    $tbl_city = $builder_city->select('*')->where('id',$clientCity_id)->get()->getRow();
    $city_name =  $tbl_city->name;
    $today = date('j M');
    // echo $client_agreement_description;
    // exit();


   $regi_date = $client_details->client_fees_reg_date;

     $clientregi_date = (!empty($regi_date) && $regi_date !== '0000-00-00')
    ? date('d F Y', strtotime($regi_date))
    : 'N/A';
    $clientregi_date_bottom = date('d.m.Y', strtotime($regi_date));
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);   // remove TCPDF default top line
    $pdf->setPrintFooter(false);  
    $pdf->SetMargins(10, 45, 10);  // space for header
    $pdf->SetAutoPageBreak(TRUE, 15);


    // PAGE 1
    $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);              
    // $pdf->writeHTML($html, true, false, true, false, '');

    // BODY CONTENT
   $pdf->Ln(-3);
$pdf->Line(
    $pdf->GetX(),                 // left margin
    $pdf->GetY(),
    $pdf->getPageWidth() - 15,    // page width - right margin
    $pdf->GetY()
);
$pdf->Ln(6);
    $html = '
    
    <p style="text-align:center; line-height:12px; margin:0; padding:0;">
    <b>MASTER RECRUITMENT & NON-CIRCUMVENTION AGREEMENT</b>
    </p><br><br><br>
<p style="text-align:justify; line-height:12px;font-size:10px;">
This Agreement is made between <b>'.$client_Hospital_name.'</b>,having its registered office at <b>'.$client_full_address.'.</b></p>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$html = '<p style="text-align:justify; line-height:12px;">AND</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);

$html = '<p style="text-align:justify; line-height:12px;margin:0; padding:0;"><b>Adis India Placement Pvt Ltd</b>, Doctors Placement Consultancy,CIN No. U78100PN2024PTC231287, having its registered office at <b>Office No A303, Gera Imperium Gateway, Nashik Phata, Metro Station, Pune, MH 411034.</b> </p>'

;

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$html = '<p style="text-align:justify; line-height:11px;"> </p>'
;


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
<b>1. Scope of Services</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Adis India Placement Pvt Ltd shall provide recruitment and placement services by sourcing candidate profiles through advertisements, social media, executive search, or any other lawful means based on requirements shared by the Client. Final selection and appointment shall always remain the sole discretion of the Client.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:18px;">
All communications shall be in writing via email or official correspondence.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
<b>2. Confidentiality</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
All information including candidate profiles, hospital details, salary structures, interview discussions, and business information shall be treated as strictly confidential and shall not be disclosed to any third party without prior written consent, except as required by law.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '
<p style="text-align:justify; line-height:18px;">
All communications shall be in writing via email or official correspondence.
</p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:20px;">
<b>3. Non-Circumvention / No-Bypass</b></p>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The Client and/or Candidate shall not directly or indirectly contact, employ, appoint, engage, or refer any party introduced by the Consultancy for a period of <b>12 (twelve) months</b> from the date of introduction without written consent of the Consultancy.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>4. Liquidated Damages</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
In case of breach of the Non-Circumvention clause, the breaching party agrees to pay liquidated damages of <b>INR 5,00,000/- (Rupees Five Lakhs Only) or two times the agreed placement fee, whichever is higher,</b> without prejudice to other legal remedies.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>5. Document Verification & Candidate Responsibility</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The <b>entire responsibility of verification of educational qualifications, professional registrations (including NMC/MCI/State Council), experience certificates, identity documents, and background checks of the candidate shall solely lie with the Client/Hospital.</b>
</p>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Adis India Placement Pvt Ltd shall rely upon documents and information as submitted by the candidate and <b>does not verify or authenticate the same</b>.
</p>';


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>6. No Warranty / No Guarantee</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The Consultancy <b>does not provide any warranty or guarantee regarding the genuineness,</b> authenticity, validity, or accuracy of educational qualifications, professional registrations, experience certificates, conduct, or performance of any candidate.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:22px;">
<b>7. Behaviour, Performance & Post-Joining Disclaimer</b></p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
The behavior, performance, professional conduct, medical practice, negligence, misconduct, financial fraud, criminal acts, or any untoward incident including injury, death, or loss caused by the candidate <b>are not under the direct or indirect control of the Adis india placement pvt ltd.</b>
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$html = '
<p style="text-align:justify; line-height:18px;">
</p>';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$html = '
<p style="text-align:justify; line-height:12px;">
Once the candidate joins the Client organization, Adis India Placement Pvt Ltd shall not be responsible or liable for any act, omission, accident, negligence, financial loss, criminal liability, or regulatory violation committed by the candidate.
</p>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->ln(1);
$footer_html = '
<table width="100%" style="font-size:6pt; text-align:center;">
    <tr>
        <td>
       <b>OFFICE ADDRESS</b> – Adis India Placement Pvt Ltd - Office no A303, Gera Imperium Gateway, Nashik Phata, Kasarwadi, Pune, Pimpri-Chinchwad, Maharashtra 411034 | www.adisindiaplacement.com | hr@adisindiaplacement.com | 9607559547 / 7758929522
        </td>
    </tr>
</table>
';

// Move to 15mm from bottom
$pdf->SetY(-22);

// Print footer HTML
$pdf->writeHTML($footer_html, true, false, false, false, '');


     // $this->add_pdf_footer($pdf);
    
    
if ($pdf->GetY() > 250) {

 $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);

$pdf->ln(2);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>8. Employment Relationship</b></p>';


$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;">
Upon joining, the candidate shall be treated as an employee of the Client and shall be governed solely by the Client’s rules, regulations, policies, and applicable laws. The Consultancy shall not be deemed to be the employer, agent, or guarantor of the candidate.
</p>';
//$pdf->writeHTML($next_html, true, false, true, false, '');

$clean = $client_agreement_description;

    // Remove ALL versions of &nbsp;
    $clean = preg_replace('/&nbsp;|&Nbsp;|&#160;|\xc2\xa0/i', ' ', $clean);

    // Remove "&nbsp;" at end of list items:  ... &nbsp;</li>
    $clean = preg_replace('/\s*&nbsp;\s*<\/li>/i', '</li>', $clean);

    // Remove stray &nbsp; inside list items
    $clean = preg_replace('/\s*&nbsp;\s*/i', ' ', $clean);

    // Remove empty <li> created by NBSP
    $clean = preg_replace('/<li>\s*<\/li>/i', '', $clean);

    // Remove lines that contain ONLY &nbsp; or spaces
    $clean = preg_replace('/^\s*(?:&nbsp;)+\s*$/im', '', $clean);

    // Remove extra spaces
    $clean = preg_replace('/\s+/', ' ', $clean);

    // Trim final output
    $clean = trim($clean);

    // FINAL OUTPUT
$styledContent = '
<div style="font-family: helvetica; font-size: 10px; line-height: 12px; background-color:#FFFF00; padding: 10px;">
<ul style="text-transform: capitalize;margin-left: -15px; padding-left: 15px;">'.$clean.'</ul>
</div>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>9. Company Charges</b></p>
' . $styledContent;
$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
</p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>10. Replacement Policy</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;">
If a candidate leaves employment <b style="background-color:#FFFF00">'. $client_replecement.'</b> of joining for reasons other than termination due to misconduct, negligence, fraud, or policy violation, the Consultancy shall provide one replacement at no additional professional fee, subject to timely written intimation.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>11. Resume Validity</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html = '
<p style="text-align:justify; line-height:12px;margin:0; padding:0;">
If a candidate introduced by the <b>Adis india placement pvt ltd</b> is employed by the Client within <b>12 months</b> of introduction, professional fees shall be payable in full, irrespective of termination of this Agreement.
</p>';


$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>12. Term & Termination</b></p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
Either party may terminate this Agreement by providing <b>30 days’ written notice.</b> Obligations relating to professional fees, confidentiality, indemnity, and limitation of liability shall survive termination.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>13. Indemnity </b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
The Client agrees to <b>indemnify, defend, and hold harmless</b> Adis India Placement Pvt Ltd, its directors, officers, employees, and representatives from and against any claims, losses, damages, penalties, legal proceedings, regulatory actions, costs, or expenses arising out of: - Misrepresentation or fraud by the candidate - Submission of false or forged documents - Professional negligence, misconduct, or criminal acts of the candidate - Violation of medical laws, ethics, or regulations by the candidate
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>14. Limitation of Liability</b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
In no event shall the total liability of Adis India Placement Pvt Ltd, whether in contract, tort, or otherwise, <b>exceed the professional fees actually received for the concerned candidate.</b>
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');

$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:22px;">
<b>15. Principal-to-Principal Relationship</b></p>';
$pdf->writeHTML($next_html, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);
$next_html = '
<p style="text-align:justify; line-height:12px;">
The relationship between the parties shall be on a <b>principal-to-principal basis.</b> Nothing herein shall be construed as creating an agency, partnership, joint venture, or employer-employee relationship.
</p>';

$pdf->writeHTML($next_html, true, false, true, false, '');


$pdf->SetY(-22);
$pdf->writeHTML($footer_html, true, false, false, false, '');
}
if ($pdf->GetY() > 250) {

 $pdf->AddPage();
    $this->addImageWatermark($pdf, FCPATH . 'assets/jobportal/images/home/new_pdf_logo.jpeg');
    $this->add_pdf_header($pdf); // header first
    $pdf->SetY(39);

$pdf->ln(2);

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>16. Arbitration</b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html1 = '
<p style="text-align:justify; line-height:12px;">
Any dispute arising out of or in connection with this Agreement shall be resolved through arbitration by a Sole Arbitrator under the Arbitration & Conciliation Act, 1996. The seat of arbitration shall be <b>Pune,</b> and proceedings shall be conducted in English.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>17. Governing Law & Jurisdiction </b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 10);


$next_html1 = '
<p style="text-align:justify; line-height:12px;">
This Agreement shall be governed by the laws of India. Courts at <b>Pune, Maharashtra</b> shall have exclusive jurisdiction.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>18. Entire Agreement </b></p>';


$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->Ln(1);

$pdf->SetFont('helvetica', '', 10);

$next_html1 = '
<p style="text-align:justify; line-height:12px;">
This Agreement constitutes the entire understanding between the parties and supersedes all prior communications. Any amendment shall be valid only if made in writing and signed by both parties.
</p>';
$pdf->writeHTML($next_html1, true, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);
$next_html1 = '
<p style="text-align:justify; line-height:22px;">
<b>IN WITNESS WHEREOF,</b> the parties have executed this Agreement on the date mentioned below.</p>';


// ================= SIGN IMAGE =================
$pdf->Ln(2);

$signPath = FCPATH . 'assets/jobportal/images/home/maam_sign.jpeg';
$left_sign = '';

if (file_exists($signPath)) {
    $left_sign = '<img src="' . $signPath . '" width="80">';
}

// ================= LEFT CONTENT =================
$left_html = '
<p style="line-height:14px;">
<b>Mrs. Tejaswini Deshpande Yadav</b><br>
<b>CEO - Adis India Placement Pvt Ltd</b><br>
<b>CIN No:</b> U78100PN2024PTC231287<br>
<b>Address:</b> Office No A303, Gera Imperium Gateway,<br>
Nashik Phata, Metro Station, Pune, MH 411034<br>
<b>Date:</b> '.$clientregi_date_bottom.'
</p>
';

// ================= RIGHT CONTENT =================
$right_html = '
<p style="line-height:16px;">
<b>Sign –</b> _______________________________<br><br>
<b>Stamp –</b> _______________________________<br><br>
<b>'.$client_name.'</b><br>
<b>'.$client_Hospital_name.'</b><br>
<b>Address:</b> '.$client_full_address.'
</p>
';

// ================= LEFT + RIGHT TABLE =================
$main_table = '
<table border="0" cellpadding="6" width="100%">
    <tr>
        <td width="48%" valign="top" align="left">
            '.$left_sign.'
            <br><br>
            '.$left_html.'
        </td>

        <td width="4%"></td>

        <td width="48%" valign="top" align="left">
            '.$right_html.'
        </td>
    </tr>
</table>
';

$pdf->writeHTML($main_table, true, false, true, false, '');

// ================= LEGAL TEAM TITLE =================
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(0); 
$pdf->Cell(0, 8, 'Our Legal Team', 0, 1, 'C');
$pdf->Ln(4);

// ================= LEGAL TEAM MEMBERS =================
$legal_team_table = '
<table border="0" cellpadding="6" width="100%">
<tr>
<td width="48%" valign="top" align="left">
<b>(1) Mr. Anant Deshpande (LLB / LLM)</b><br>
Chairman - Sambhajinagar.<br><br>

</td>

<td width="48%" valign="top" align="left">
<b>(2) Mr. Suresh Rudrawar (LLB / LLM)</b><br>
Member – High Court, Sambhajinagar.<br><br>

</td>
    </tr>
</table>
';

$pdf->writeHTML($legal_team_table, true, false, true, false, '');

// ================= FOOTER =================
$pdf->Ln(10);
$pdf->SetY(-22);
$pdf->writeHTML($footer_html, true, false, false, false, '');
}

  if (ob_get_length()) { @ob_end_clean(); }

    $pdfContent = $pdf->Output('agreement.pdf', 'S');

    return $pdfContent;

     
 }

private function send_agreement_client_mail($email_send_id, $pdf_string, $client_name, $client_email)
{
   require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require APPPATH . 'Libraries/PHPMailer/SMTP.php';
    require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
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
            $mail->addAddress($client_email);
            //->addAddress("contact@adisindiaplacement.com");

        $mail->isHTML(true);

        // ATTACH PDF
        $mail->addStringAttachment($pdf_string, "client_agreement_$email_send_id.pdf");

        // SUBJECT
        $mail->Subject = "Agreement Document  $client_name";

        // EMAIL BODY
        $body = "
            <p>Dear <strong>$client_name</strong>,</p>

            <p>Please find attached the Agreement Document as requested.</p>
            
            <p>Kindly review, sign, and resend the signed copy to us at your earliest convenience.</p>

            <br>
            <p>Warm regards,<br><strong>Adis India Placement Team</strong>
        ";

        $mail->isHTML(true);
        $mail->Body = $body;

        // SEND
        $mail->send();

        return true; // SUCCESS

    } catch (\Exception $e) {
        log_message('error', 'Agreement Mail Error: ' . $mail->ErrorInfo);
        return false; // FAILED
    }
}

public function update_Resume_Client_email_Status()
{

    $request = $this->request;
    $AdminModel = new \App\Models\AdminModel();
    $email_send_id = $this->request->getPost('user_id');
    $status        = $this->request->getPost('send_email');
    $jobseeker_id = $this->request->getPost('jobseeker_id');
      if ($status == 1) {

        // Update DB
        $data_update_email_status = [
            'send_resume_client' => 'yes',
            'send_resume_date'      => date('Y-m-d'),
        ];
        $db = \Config\Database::connect();
        //  PDF GENERATED AS STRING (NOT FILE)

        // ================== table candidate ======================

        $builder = $db->table('tbl_candidate_job_status');
        $candidate_tbl_details = $builder
            ->select('*')
            ->where('user_id',$email_send_id)
            ->where('jobseeker_id', $jobseeker_id)
            ->get()
            ->getRow();

        $jobseeker_id = $candidate_tbl_details->jobseeker_id;
        $posting_id = $candidate_tbl_details->posting_id;

        // ============ posting ==================================
        $builder = $db->table('tbl_recruiter_posting');
        $posting_details = $builder->select('*')->where('posting_id',$posting_id)->get()->getRow();

        $job_id = $posting_details->job_id;

        $builder = $db->table('tbl_job_role');
        $posting_details = $builder->select('*')->where('job_id',$job_id)->get()->getRow();
        // echo $db->getLastQuery();exit();

        $candidate_position = $posting_details->job_role;



        $builder = $db->table('tbl_recruiter');
        $client_details = $builder->select('*')->where('uid',$email_send_id)->get()->getRow();


        $client_name = ucwords(strtolower($client_details->recruiter_name));
        $client_email = $client_details->email;
        // ================= table jobseeker ==============================
        $builder = $db->table('tbl_jobseeker');
        $candidate_details = $builder->select('*')->where('jobseeker_id',$jobseeker_id)->get()->getRow();
        // echo $db->getLastQuery();exit();
        $candidate_name = ucwords(strtolower($candidate_details->full_name));
        $candidate_resume = $candidate_details->resume;
        $candidate_mobile = $candidate_details->mobile_number;

        $pdf_string = $this->send_resume_to_client($email_send_id,$candidate_name,$candidate_resume,$client_email,$candidate_position,$candidate_mobile);

        // Send email with string attachment
        // $this->send_agreement_client_mail($email_send_id, $pdf_string,$client_name,$client_email);

    } else {
        $data_update_email_status = [
            'send_resume_client' => '',
            'agreement_send_date'      => NULL,
        ];
    }

    // Update DB
    $builder = $AdminModel->db->table('tbl_candidate_job_status');
    $builder->where('user_id', $email_send_id);
    $builder->update($data_update_email_status);

    return "success";
    
}

private function send_resume_to_client($email_send_id, $candidate_name, $candidate_resume_file,$client_email,$candidate_position,$candidate_mobile)
{
    $db = \Config\Database::connect();

    // =============================
    // Get Client Name
    // =============================
    $client = $db->table('tbl_recruiter')
                 ->where('uid', $email_send_id)
                 ->get()
                 ->getRow();

    $client_name = $client ? ucwords(strtolower($client->recruiter_name)) : "Client";

    // =============================
    // Resume Path
    // =============================
    $resumePath = FCPATH . "jobseeker/resume/" . $candidate_resume_file;

    if (!file_exists($resumePath)) {
        return "Resume file not found: " . $resumePath;
    }

    // =============================
    // PHPMailer Load
    // =============================
    require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require APPPATH . 'Libraries/PHPMailer/SMTP.php';
    require APPPATH . 'Libraries/PHPMailer/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
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
             $mail->addAddress($client_email);
            //$mail->addAddress('tejashreekulkarni3126@gmail.com');

             $mail->isHTML(true);
            $mail->Subject = "CV of {$candidate_name} for {$candidate_position} Position";

                $mail->Body = "
                    Dear Sir,<br><br>

                    As discussed, please find attached the CV of <b>{$candidate_name}</b> for the role of <b>{$candidate_position}</b>.<br><br>

                    You may directly connect with the candidate for further discussion.<br>
                    <b>Contact Number:</b> {$candidate_mobile}<br><br>

                    Kindly review the profile and let me know if you would like to schedule an interview.<br><br>

                    Thank you,<br>
                    <b>ADIS INDIA Placement Pvt. Ltd.</b>
                ";

        // =============================
        // ATTACH RESUME (ANY FORMAT)
        // =============================
        $mail->addAttachment($resumePath);

        // =============================
        // SEND EMAIL
        // =============================
        if ($mail->send()) {
            return "success";
        } else {
            return "Email sending failed";
        }

    } catch (\Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}

public function advanced_payment_recip_pdf($uid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter');
        $client_details = $builder->select('*')->where('uid',$uid)->get()->getRow();
        $client_Hospital_name = ucwords(strtolower($client_details->institute_name));
        $client_name = ucwords(strtolower($client_details->recruiter_name));
        $client_invoice_no=$client_details->regi_invoice_no;
        $client_mobile =$client_details->mobile_number;
        $clientCity_id = $client_details->city_id;
        $builder_city = $db->table('cities');
        $tbl_city = $builder_city->select('*')->where('id',$clientCity_id)->get()->getRow();
        $city_name =  $tbl_city->name;

        $client_reg_type =$client_details->client_reg_type; 
        $regi_date = $client_details->client_fees_reg_date;

        $advance_payment = floatval($client_details->advanced_payment);
        $adv_pay = number_format($advance_payment, 2);

        $clientregi_date = (!empty($regi_date) && $regi_date !== '0000-00-00')
            ? date('d/m/Y', strtotime($regi_date))
            : 'N/A';
         // $monthYear = date('M') . date('Y');    
         // ===============================================================

        $date = new \DateTime($regi_date);

        $monthYear = strtoupper($date->format('MY')); 

        if ($client_reg_type == 'paid') {
             $invoice_no = 'Adisindia/Reg' . $client_invoice_no . '/' . $monthYear; 
        }else
        {
            $invoice_no = 'N/A';
        }

        $client_gstin_no = (!empty($client_details->recruiter_gstin_no))
        ? $client_details->recruiter_gstin_no
        : '-';


          $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set margins
             $pdf->SetTitle('Advance Payment Receipt');
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 10);

        // Add a page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);

        // Month & images
        $monthYear = date('MY');
        $signature = base_url('assets/jobportal/images/home/Sirsig.jpeg');


        

        $html = <<<HTML
            <style>
            table { border-collapse: collapse; width: 100%;}
            td, th { border: 1px solid #000; padding: 5px; }
            .center { text-align: center; }
            .right { text-align: right; }
            .bold { font-weight: bold; }
            .yellow { background-color: #FF8C73; }
            .light { background-color: #eaf2e3; }
          
            
            </style>
            
            <table>
            <tr>
            <td colspan="4" class="center bold" style="background-color:#FF8C73; padding:18px; font-size:18px;">
                TAX INVOICE
            </td>
            </tr>

            <tr>
            <td colspan="3" style="padding:18px; font-size:11px;line-height:22px;"><b>ADIS INDIA PLACEMENT PVT LTD.</b><br>CIN No.: U78100PN2024PTC231287</td>
            <td><b style="padding:18px; font-size:11px;line-height:22px;">Reg.Invoice Number</b><br><br><span style="padding:18px; font-size:9px;line-height:22px;">{$invoice_no}</span></td>
            </tr>

            <tr>
            <td colspan="3" style="padding:18px; font-size:11px; line-height:16px;"><br>
            <b>Office Address:</b> Office no A303, Gera Imperium Gateway,<br>
            Nashik Phata, Pimpri-Chinchwad, Maharashtra 411034<br>
            <b>Contact:</b> 9607559547<br>
            <b>Email:</b> hr@adisindiaplacement.com
            </td>
            <td style="padding:18px; font-size:11px;"><b>Invoice Date</b><br>08-01-2025</td>
            </tr>
            <tr>
            <td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Name:</b> {$client_Hospital_name}</td>
            <td colspan="2" style="padding:18px; font-size:11px;line-height:22px;"><b>Address:</b> {$city_name}</td>
            </tr>

            <tr>
            <td colspan="4" style="padding:18px; font-size:11px;line-height:22px;"><b>GSTIN:</b> {$client_gstin_no}</td>
            </tr>
            </table>

            <br>

            <table>
            <tr class="yellow light">
            <td width="8%" style="padding:18px; font-size:11px;line-height:22px;"><b>Sr No</b></td>
            <td width="77%" style="padding:18px; font-size:11px;line-height:22px;"><b>Description of Services</b></td>
            <td width="15%" style="padding:18px; font-size:11px;line-height:22px;"><b>Amount (Rs)</b></td>
            </tr>

            <tr>
            <td class="center" style="padding:28px 18px; font-size:11px;"><br><br>1</td>

            <td style="padding:28px 18px; font-size:11px; line-height:16px;">
                <b><br>Advanced Fees</b><br>
                <br><br><br><br>
            </td>

            <td class="right" style="padding:28px 18px; font-size:11px;">
                <br><br>{$adv_pay}
            </td>
            </tr>

            <tr>
            <td colspan="2" class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
                Total
            </td>
            <td class="right bold yellow light" style="padding:18px; font-size:11px;line-height:16px;">
               {$adv_pay}
            </td>
            </tr>
            </table>

            <br>

            <table>
            <tr>
            <td width="40%" class="no-border"></td>
            <td width="45%" style="padding:28px 18px; font-size:11px;">CGST &nbsp;&nbsp;&nbsp;9%</td>
            <td width="15%" style="padding:28px 18px; font-size:11px;" class="right">0</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">SGST &nbsp;&nbsp;&nbsp;9%</td>
            <td class="right" style="padding:28px 18px; font-size:11px;">0</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">Deposit Recived </td>
            <td class="right" style="padding:28px 18px; font-size:11px;">0</td>
            </tr>
            <tr>
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;">IGST</td>
            <td class="right" style="padding:28px 18px; font-size:11px;">0%</td>
            </tr>
            <tr class="bold yellow light">
            <td class="no-border"></td>
            <td style="padding:28px 18px; font-size:11px;line-height:16px;">Sub Total</td>
            <td class="right" style="padding:28px 18px; font-size:11px;line-height:16px;">{$adv_pay}</td>
            </tr>
            </table>

            <br>

            <table>
            

            <tr>
            <td colspan="2" class="left"  style="padding:28px 18px; font-size:11px;"><b><u>Company's Tax Details</u></b><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>Income Tax PAN No</b>: ABACA7593C </p><p style="padding:28px 18px; font-size:11px;line-height:12px;"><b>GST No:</b> 27ABACA7593C1ZO</p><br>
            </td>
            <td colspan="2" class="center" style="padding:28px 18px; font-size:11px;">
            For <b>ADIS INDIA PLACEMENT PVT LTD.</b>
            <p style="line-height:12px;">
            <img src="$signature" style="width:70px;"><br>
            <b>Mr. Jagdish Yadav</b></p>
            <p style=""><b>Managing Director</b></p>
            </td>
            </tr>
            </table>

HTML;

                $pdf->writeHTML($html, true, false, true, false, '');

                if (ob_get_length()) {
                    ob_end_clean();
                }

                $pdfContent = $pdf->Output('advanced_payment.pdf', 'S');

                return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'inline; filename="invoice.pdf"')
                    ->setBody($pdfContent);
    }

public function candidate_agreement_pdf($job_status_id)
{
        $db = \Config\Database::connect();
       $can_details = \Config\Database::connect()
                    ->table('tbl_candidate_job_status tcjs')
                    ->select('tcjs.*, tj.*')
                    ->join('tbl_jobseeker tj', 'tcjs.jobseeker_id = tj.jobseeker_id')
                    ->where('tcjs.job_status_id', $job_status_id)
                    ->get()
                    ->getRow();
        // echo $db->getLastQuery();
        // exit();
        $full_name = ucwords(strtolower($can_details->full_name));
        $cand_agredate = $can_details->candi_agree_date;
        // $candidate_agree_date = date("d/m/Y", strtotime($can_details->candi_agree_date));
        $candidate_agree_date = (!empty($cand_agredate) && $cand_agredate !== '0000-00-00')
            ? date('d/m/Y', strtotime($cand_agredate))
            : 'N/A';
            
        $candi_join_date = $can_details->joining_date;

        $candidate_joingdate = (!empty($candi_join_date) && $candi_join_date !== '0000-00-00')
            ? date('d/m/Y', strtotime($candi_join_date))
            : 'N/A';
        $candidate_full_address = $can_details->candidate_full_address;
       $candidate_placement_salary = !empty($can_details->candidate_placement_salary)
    ? number_format((float)$can_details->candidate_placement_salary, 2)
    : '0.00';
    
    
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
      // ================= BASIC SETTINGS =================
    $pdf->SetTitle('Candidate Agreement Pdf');
    $pdf->SetMargins(15, 50, 15);   // TOP margin header साठी fix
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    // ================= HEADER START =================

    // Top line
    $pdf->SetLineWidth(0.4);
    // $pdf->Line(15, 15, 195, 15);

    // LEFT TEXT (proper aligned block)
    $pdf->SetXY(15, 18);
    $pdf->SetFont('dejavusans', 'B', 11);
    $pdf->Cell(120, 6, 'Mrs. Tejaswini Deshpande Yadav', 0, 1, 'L');

    $pdf->SetX(15);
    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Cell(120, 5, 'CEO – Adis India Placement Pvt Ltd', 0, 1, 'L');

    $pdf->SetX(15);
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->Cell(120, 5, 'CIN No: U78100PN2024PTC231287', 0, 1, 'L');

    // RIGHT LOGO (always aligned)
    $logoPath = FCPATH . 'assets/jobportal/images/home/new_lodo_pdf.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 150, 18, 35);
    }

    // Bottom line
    $pdf->Line(15, 42, 195, 42);

    // Cursor strictly below header
    $pdf->SetY(50);

    // ================= HEADER END =================


    // ================= HTML CONTENT (UNCHANGED) =================
    $html = <<<HTML


<p style="color:#000; font-weight:bold; text-transform:uppercase;">
DOCTOR REGISTRATION & CONSENT AGREEMENT</p>

<p style="text-align:justify; line-height:13px;">
This Agreement is made on <b>{$candidate_agree_date}</b> between
<b>Adis India Placement Pvt. Ltd.</b>, having its registered office at
A303, Gera Imperium Gateway, Nashik Phata, Kasarwadi, Pune, Pimpri-Chinchwad, Maharashtra 411034
(hereinafter referred to as “the Company”),
AND<br>
<b>{$full_name}</b>, residing at <b>{$candidate_full_address}</b> (hereinafter referred to as “the Candidate”).
</p>



<p><b style="color:#000;">1. Scope of Services</b><br>
The Company shall assist the Candidate in identifying suitable employment
opportunities in hospitals, clinics, or overseas medical institutions.
</p>

<p><b style="color:#000;">2. Candidate Obligations</b><br>
• Provide accurate educational, professional, and registration documents.<br>
• Attend interviews as scheduled by the Company.<br>
• Not bypass or directly approach any employer introduced by the Company.
</p>

<p><b style="color:#000;">3. Placement Fee</b><br>
The Candidate agrees to pay a placement fee of <b>₹{$candidate_placement_salary}</b>
after receiving the first month’s salary. The fee shall be payable within
30 days from the date of joining.
</p>

<p><b style="color:#000;">4. Confidentiality</b><br>
All employer, hospital, and client details shared by the Company shall be treated
as confidential and shall not be disclosed to any third party.
</p>

<p><b style="color:#000;">5. Non-Circumvention</b><br>
The Candidate shall not directly contact, negotiate with, or join any employer
introduced by the Company for a period of 12 months from the date of introduction.
</p>

<p><b style="color:#000;">6. Governing Law and Jurisdiction</b><br>
This Agreement shall be governed and construed in accordance with the laws of India.
The courts at Pune, Maharashtra shall have exclusive jurisdiction.
</p>

<p><b>Signatures</b></p>

<p><br><br>
<b>Candidate Signature:</b> _______________________<br>
<b>Name:</b> {$full_name}<br>
<b>Date:</b> __________
</p>

<p>
<b>For Adis India Placement Pvt. Ltd.</b><br>
<img src="assets/jobportal/images/home/maam_sign.jpeg" width="60"><br>
<b>Name:</b> Mrs. Tejaswini Deshpande Yadav<br>
<b>Designation:</b> Chief Executive Officer (CEO)<br>
<b>Date:</b> {$candidate_joingdate}
</p>

<p style="color:red; font-size:9px; line-height:12px;">
<b>Important Declaration</b><br>
I, {$full_name}, hereby declare that all the information and documents
provided by me are true and correct. In case any information or document is found
to be false, incorrect, or fraudulent, Adis India Placement Pvt. Ltd. shall not
be held responsible. The entire responsibility shall rest solely with me.
</p>
HTML;

    $pdf->SetFont('dejavusans', '', 10);
    $pdf->writeHTML($html, true, false, true, false, '');

    // ================= OUTPUT =================
    if (ob_get_length()) {
        ob_end_clean();
    }

    $pdfContent = $pdf->Output('candidate_agreement.pdf', 'S');

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'inline; filename="candidate_agreement.pdf"')
        ->setBody($pdfContent);
}  

public function edit_candidate_agreement_salary($jobseeker_id,$job_status_id)
{
   
    $AdminModel = new AdminModel();
    $single_candidate_edit_agreement = $AdminModel->single_candidate_agreement_salary_edit($jobseeker_id,$job_status_id);
    echo view('admin/header');
    echo view('admin/edit_candidate_agreement_salary',['single_candidate_edit_agreement'=>$single_candidate_edit_agreement]);
    echo view('admin/footer'); 

}
    public function update_candidate_agreement()
    {
        $request = $this->request;
        $db = \Config\Database::connect();

        $job_status_id               = $request->getPost('job_status_id');
        $jobseeker_id                = $request->getPost('jobseeker_id');
        $candidate_placement_salary = $request->getPost('candidate_placement_salary');
        $candidate_full_address      = $request->getPost('candidate_full_address');


        // Update salary
        $builder = $db->table('tbl_candidate_job_status');
        $update1 = $builder->where('jobseeker_id', $jobseeker_id)
                           ->where('job_status_id', $job_status_id)
                           ->update([
                               'candidate_placement_salary' => $candidate_placement_salary,
                               'candi_agree_date'         => date('Y-m-d'),
                           ]);

        // Update address
        $builder2 = $db->table('tbl_jobseeker');
        $update2 = $builder2->where('jobseeker_id', $jobseeker_id)
                            ->update([
                                'candidate_full_address' => $candidate_full_address
                            ]);

        if ($update1 || $update2) {
            return redirect()->to(
                base_url('admin/edit-candidate-agreement-salary/' . $jobseeker_id . '/' . $job_status_id)
            )->with('success', 'Candidate Agreement updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    
    public function sendagreementCandidate()
    {
        $request    = $this->request;
        $AdminModel = new \App\Models\AdminModel();
        $db         = \Config\Database::connect();
    
        $job_status_id = $request->getPost('job_status_id');
        $status        = $request->getPost('send_email');
     
        if (empty($job_status_id) || $status != 1) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Invalid request'
            ]);
        }
    
        $can_details = $db->table('tbl_candidate_job_status tcjs')
            ->select('tcjs.*, tj.*')
            ->join('tbl_jobseeker tj', 'tcjs.jobseeker_id = tj.jobseeker_id')
            ->where('tcjs.job_status_id', $job_status_id)
            ->get()
            ->getRow();
    
        if (!$can_details) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Candidate not found'
            ]);
        }
    
        $full_name = ucwords(strtolower($can_details->full_name));
    
        $cand_agredate = $can_details->candi_agree_date;
        $candidate_agree_date = (!empty($cand_agredate) && $cand_agredate !== '0000-00-00')
            ? date('d/m/Y', strtotime($cand_agredate))
            : 'N/A';
            
        $candi_join_date = $can_details->joining_date;

        $candidate_joingdate = (!empty($candi_join_date) && $candi_join_date !== '0000-00-00')
            ? date('d/m/Y', strtotime($candi_join_date))
            : 'N/A';
    
        $candidate_full_address = $can_details->candidate_full_address;
    
        $candidate_placement_salary = !empty($can_details->candidate_placement_salary)
            ? number_format((float)$can_details->candidate_placement_salary, 2)
            : '0.00';
    
        $jobseeker_mail = $can_details->email;
    
        $pdf_string = $this->generate_candidate_agreement_pdf(
            $full_name,
            $candidate_agree_date,
            $candidate_full_address,
            $candidate_placement_salary,
            $candidate_joingdate
        );
    
        $this->send_agreement_candidate_mail(
            $jobseeker_mail,
            $pdf_string,
            $full_name
        );
    
        $builder = $AdminModel->db->table('tbl_candidate_job_status');
        $builder->where('job_status_id', $job_status_id);
        $builder->update([
            'candidte_agre_status' => 'yes'
        ]);
    
        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Candidate agreement sent successfully'
        ]);
    }
 private function generate_candidate_agreement_pdf($full_name,$candidate_agree_date,$candidate_full_address,$candidate_placement_salary,$candidate_joingdate)
 {
    // Create PDF
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // ================= BASIC SETTINGS =================
    $pdf->SetTitle('Candidate Agreement Pdf');
    $pdf->SetMargins(15, 50, 15);
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    // ================= HEADER =================
    $pdf->SetXY(15, 18);
    $pdf->SetFont('dejavusans', 'B', 11);
    $pdf->Cell(120, 6, 'Mrs. Tejaswini Deshpande Yadav', 0, 1, 'L');

    $pdf->SetFont('dejavusans', '', 10);
    $pdf->SetX(15);
    $pdf->Cell(120, 5, 'CEO – Adis India Placement Pvt Ltd', 0, 1, 'L');

    $pdf->SetFont('dejavusans', '', 9);
    $pdf->SetX(15);
    $pdf->Cell(120, 5, 'CIN No: U78100PN2024PTC231287', 0, 1, 'L');

    // Logo
    $logoPath = FCPATH . 'assets/jobportal/images/home/new_lodo_pdf.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 150, 18, 35);
    }

    // Header line
    $pdf->Line(15, 42, 195, 42);
    $pdf->SetY(50);

    // ================= CONTENT =================
    $html = <<<HTML


<p style="color:#000; font-weight:bold; text-transform:uppercase;">
DOCTOR REGISTRATION & CONSENT AGREEMENT</p>

<p style="text-align:justify; line-height:13px;">
This Agreement is made on <b>{$candidate_agree_date}</b> between
<b>Adis India Placement Pvt. Ltd.</b>, having its registered office at
A-303, Gera Imperium Gateways, Near Nashik Phata, PCMC, Pune – 411034
(hereinafter referred to as “the Company”),
AND<br>
<b>{$full_name}</b>, residing at <b>{$candidate_full_address}</b> (hereinafter referred to as “the Candidate”).
</p>



<p><b style="color:#000;">1. Scope of Services</b><br>
The Company shall assist the Candidate in identifying suitable employment
opportunities in hospitals, clinics, or overseas medical institutions.
</p>

<p><b style="color:#000;">2. Candidate Obligations</b><br>
• Provide accurate educational, professional, and registration documents.<br>
• Attend interviews as scheduled by the Company.<br>
• Not bypass or directly approach any employer introduced by the Company.
</p>

<p><b style="color:#000;">3. Placement Fee</b><br>
The Candidate agrees to pay a placement fee of <b>₹{$candidate_placement_salary}</b>
after receiving the first month’s salary. The fee shall be payable within
30 days from the date of joining.
</p>

<p><b style="color:#000;">4. Confidentiality</b><br>
All employer, hospital, and client details shared by the Company shall be treated
as confidential and shall not be disclosed to any third party.
</p>

<p><b style="color:#000;">5. Non-Circumvention</b><br>
The Candidate shall not directly contact, negotiate with, or join any employer
introduced by the Company for a period of 12 months from the date of introduction.
</p>

<p><b style="color:#000;">6. Governing Law and Jurisdiction</b><br>
This Agreement shall be governed and construed in accordance with the laws of India.
The courts at Pune, Maharashtra shall have exclusive jurisdiction.
</p>

<p><b>Signatures</b></p>

<p><br><br>
<b>Candidate Signature:</b> _______________________<br>
<b>Name:</b> {$full_name}<br>
<b>Date:</b> __________
</p>

<p>
<b>For Adis India Placement Pvt. Ltd.</b><br>
<img src="assets/jobportal/images/home/maam_sign.jpeg" width="60"><br>
<b>Name:</b> Mrs. Tejaswini Deshpande Yadav<br>
<b>Designation:</b> Chief Executive Officer (CEO)<br>
<b>Date:</b> {$candidate_joingdate}
</p>

<p style="color:red; font-size:9px; line-height:12px;">
<b>Important Declaration</b><br>
I, {$full_name}, hereby declare that all the information and documents
provided by me are true and correct. In case any information or document is found
to be false, incorrect, or fraudulent, Adis India Placement Pvt. Ltd. shall not
be held responsible. The entire responsibility shall rest solely with me.
</p>
HTML;

    $pdf->SetFont('dejavusans', '', 10);
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clear buffer
    if (ob_get_length()) {
        ob_end_clean();
    }

    // RETURN PDF STRING
    return $pdf->Output('Candidate_Agreement.pdf', 'S');
}

private function send_agreement_candidate_mail(
    $jobseeker_mail,
    $pdf_string,
    $full_name
) {
    require APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
    require APPPATH . 'Libraries/PHPMailer/SMTP.php';
    require APPPATH . 'Libraries/PHPMailer/Exception.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = env('EMAIL_SMTP_USERNAME', '');
        $mail->Password   = env('EMAIL_SMTP_PASSWORD', ''); // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom('tejashreekulkarni3126@gmail.com', 'Adis India Pvt Ltd');
        $mail->addAddress($jobseeker_mail);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = 'Candidate Agreement – Confirmation Required';
        $mail->Body = '
            <p>Dear '.$full_name.',</p>

            <p>Greetings from Adis India Placement Pvt. Ltd.<br></p>

            <p>Please find attached the <b>Candidate Agreement (Doctor Registration & Consent Agreement)</b> for your reference.</p>

            <p>Kindly go through the document carefully. If everything is in order, please confirm the same by replying to this email.</p>
            <p>In case of any queries or clarifications, feel free to contact us.</p><br>

            <p>Thank you for your cooperation.</p>

            <p>Warm Regards,<br>
            <b>Team Adis India Placement</b><br>
            9607559547</p>
        ';

        // ✅ FIXED (NO job_status_id)
        $mail->addStringAttachment(
            $pdf_string,
            'Candidate_Agreement.pdf',
            'base64',
            'application/pdf'
        );

        $mail->send();
        return true;

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        log_message('error', 'Mail error: ' . $e->getMessage());
        return false;
    }
    
    
}

public function contact_details()
{
     $session = session();
    if (!session()->has('name')) {
    return redirect()->to('admin'); // redirect if not logged in
    }
    $AdminModel = new AdminModel();
    $db = \Config\Database::connect();
    $Allcontact_details = $AdminModel->all_contact_details();
    // echo "<pre>";
    // print_r($Allcontact_details);
    // exit();
    echo view('admin/header');
    echo view('admin/contact_details',['Allcontact_details'=>$Allcontact_details]);
    echo view('admin/footer'); 
}

public function candidate_agreement_deatil()
{
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $closedPostvaciesdisply = $AdminModel->closedPostvaciesdisply();
        
        echo view('admin/header');
        echo view('admin/candiadte_agreement_dash',['closedPostvaciesdisply' => $closedPostvaciesdisply]);
        echo view('admin/footer');
}

public function uploadAgreementAjax()
{
    $jobStatusId = $this->request->getPost('job_status_id');
    $file        = $this->request->getFile('agreement_file');

    if (!$jobStatusId || !$file) {
        return $this->response->setJSON(['status' => 'error']);
    }

    if ($file->isValid() && !$file->hasMoved()) {

        // 📁 upload path
        $uploadPath = FCPATH . 'uploads_candidate/agreements/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // 📄 file name
        $newName = 'agreement_' . $jobStatusId . '_' . time() . '.pdf';
        $file->move($uploadPath, $newName);

        // 🔥 DB update (DIRECT TABLE)
        $db = \Config\Database::connect();

        $db->table('tbl_candidate_job_status')
            ->where('job_status_id', $jobStatusId)
            ->update([
                'candidate_sign_agre' => $newName   // correct column
            ]);

        return $this->response->setJSON([
            'status'    => 'success',
            'file_name' => $newName,
            'file_url'  => base_url('uploads_candidate/agreements/' . $newName)
        ]);
    }

    return $this->response->setJSON(['status' => 'error']);
}

public function delete_contact($id)
{
    if (!$id) {
        return redirect()->back()->with('error', 'Invalid Contact ID');
    }

    $db = \Config\Database::connect();

    $delete = $db->table('tbl_contact')
                 ->where('id', $id)
                 ->delete();

    if ($delete) {
        return redirect()->back()->with('success', 'Contact deleted successfully');
    }

    return redirect()->back()->with('error', 'Delete failed');
}

public function update_ChangeToggle_status()
{
    $posting_id     = $this->request->getPost('posting_id');
    $posting_status = $this->request->getPost('posting_status');

    $db = \Config\Database::connect();
    $builder = $db->table('tbl_recruiter_posting');

    $builder->where('posting_id', $posting_id);
    $update = $builder->update([
        'posting_status' => $posting_status
    ]);

    return $this->response->setJSON([
        'status' => $update ? true : false
    ]);
}

public function award_recon()
{
    $session = session();
    if (!session()->has('name')) {
    return redirect()->to('admin'); // redirect if not logged in
    }
    echo view('admin/header');
    echo view('admin/award_recon');
    echo view('admin/footer');
}

public function save_award()
{
    $session = session();
    $db = \Config\Database::connect();
    $builder = $db->table('tbl_award'); // your table name
    $AdminModel = new AdminModel();
    $imageName = null;
    $file = $this->request->getFile('award_image');
    if ($file && $file->isValid()) {
   $imageName = $file->getRandomName();

    // Move file to 'admin_assets/images' folder
    $file->move(FCPATH.'award_image/images', $imageName);
            
    }

    // 2️⃣ Get other form data
    $award_title = $this->request->getPost('award_title');
    $content = $this->request->getPost('content');

    // 3️⃣ Insert into database
    $data = [
        'award_title' => $award_title,
        'content   ' => $content,
        'award_image' => $imageName
    ];

   $add_award_data = $AdminModel->addawardData($data);

    // 4️⃣ Redirect or show message
   return redirect()->to(base_url('admin/award_recon'))->with('success', 'Award added successfully!');
}

public function display_award_recons()
{
     $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $ClintModel = new ClintModel();
        $award_display = $ClintModel->award_data_display();
        echo view('admin/header');
        echo view('admin/display_list_award',['award_display'=>$award_display]);
        echo view('admin/footer'); 
}
public function delete_award($award_id)
{
    if(!$award_id){
        return $this->response->setJSON(['status' => 'error', 'message' => 'Blog ID missing']);
    }

    $db = \Config\Database::connect();
    $builder = $db->table('tbl_award');
    $deleted = $builder->delete(['award_id' => $award_id]);

    if ($deleted) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        return $this->response->setStatusCode(404)
                             ->setJSON(['status' => 'error', 'message' => 'Record not found']);
    }
}

public function edit_award($award_id)
{
    $session = session();
    if (!session()->has('name')) {
    return redirect()->to('admin'); // redirect if not logged in
    }
    $AdminModel = new AdminModel();
    $single_award_edit = $AdminModel->single_award_edit($award_id);
    echo view('admin/header');
    echo view('admin/edit_award',['single_award_edit'=>$single_award_edit]);
    echo view('admin/footer'); 
}
public function update_award()
{
    $request = $this->request;
    $db = \Config\Database::connect();

    $award_id = $request->getPost('award_id');
    $award_title = $request->getPost('award_title');
    $content = $request->getPost('content');

    $data = [
        'award_title' => $award_title,
        'content'     => $content,
        'created_at'  => date('Y-m-d H:i:s')
    ];

    // Image upload
    $image = $request->getFile('blog_image');

    if ($image && $image->isValid() && !$image->hasMoved()) {

        $newName = $image->getRandomName();
        $image->move(FCPATH . 'award_image/images', $newName);

        $data['award_image'] = $newName;
    }

    $db->table('tbl_award')
        ->where('award_id', $award_id)
        ->update($data);

    return redirect()->to(base_url('admin/display_award_recon'))
                     ->with('success','Award updated successfully');
}


    public function add_lead_url()
    {
        $lead_name = $this->request->getPost('lead_name');
        // echo $jobRole;
        // exit();
        if (empty($lead_name)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Lead From is required.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_lead');

        // Check for duplicate
        $exists = $builder->where('lead_name', $lead_name)->countAllResults();

        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This lead from already exists.'
            ]);
        }

        $builder->insert(['lead_name' => $lead_name]);
        $insertID = $db->insertID();

        return $this->response->setJSON([
            'status' => 'success',
            'lead_id' => $insertID,
            'lead_name' => $lead_name
        ]);
    }

    public function tblUserOtpStatus()
    {
        $request = service('request');

        $id = $request->getPost('uid');
        $status = $request->getPost('status');

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user'); 

        $builder->where('uid', $id);

        if ($status === 'active') {
            $builder->update([
                'status' => 'active'
            ]);
        } else {
            $builder->update([
                'status' => null 
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'status'  => $status
        ]);
    }
    
      public function insurancy_policy_data()
    {
         $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $AdminModel = new AdminModel();
        $db = \Config\Database::connect();
        $AllregistraionCandidate = $AdminModel->all_registraion_candidate_insurance_policy();
        echo view('admin/header');
        echo view('admin/insurancy_policy_data',['AllregistraionCandidate'=>$AllregistraionCandidate]);
        echo view('admin/footer');

    }

    // ============================== 02-07-2026 =========================

    public function edit_candidate_form_id($uid)
    {
           $session = session();
            if (!session()->has('name')) {
            return redirect()->to('admin'); // redirect if not logged in
        }
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');
        $user = $builder->where('uid', $uid)->get()->getRowArray();
        $AdminModel = new AdminModel();
        $job_role = $AdminModel->display_job_role();
        $qualifications = $AdminModel->display_qualification();
        echo view('admin/header');
        echo view('admin/edit_candidate_form_id',['job_role'=>$job_role,'qualifications'=>$qualifications, 'uid' => $uid,  'user'      => $user]);
        echo view('admin/footer'); 
    }

    public function update_signup_candidate_new()
    {
        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kolkata');

        $login_status = $this->request->getPost('login_status');
        $uid = $this->request->getPost('uid');
        $full_name = $this->request->getPost('full_name');
        $job_role = $this->request->getPost('job_role');
        $qualification = $this->request->getPost('qualification');
        $course = $this->request->getPost('course');
        $email = $this->request->getPost('email');
        $mobile_number = $this->request->getPost('mobile_number');
        

        $data_user = ['login_status'=> $login_status,'full_name'=>$full_name,'job_id'=>$job_role];
        $db->table('tbl_user')
               ->where('uid', $uid)
               ->update($data_user);
        $data_jobseeker = [
            'uid'             => $uid,
            'full_name' => $full_name,
            'job_id'   => $job_role,
            'education'       => $qualification,
            'created_date' => date('Y-m-d'),
            'course'        => $course,
            'email'     => $email,
            'mobile_number'=>$mobile_number
        ];  

        // Insert Data
        $db->table('tbl_jobseeker')->insert($data_jobseeker);
         return redirect()->to(base_url('admin/signup_admin_candidate'))
                     ->with('success','Award updated successfully');
    }


      
    





















    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 



}
