<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\HomeModel;
use App\Models\RecruiterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DateTime;


class RecruiterController extends BaseController
{
    public function index()
    {
       
        echo view('jobportal/header');
         echo view('client/home');
        echo view('jobportal/footer');
    }
    public function about_us()
    {
          echo view('jobportal/header');
          echo view('client/about_us');
          echo view('jobportal/footer');
    }
    public function recruterRegistrationForm()
    {
        $session = session();
            if ($session->has('email')) 
            {
            echo view('jobportal/header');
            echo view('recruiter/recruter_registraion');
            echo view('jobportal/footer');
            } else {
               
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');
            }
        
    }
    public function save_recruiter_form()
    {
        
        $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
        $postData = $this->request->getPost();
     
        $session = session();
        $user_id = session()->get('uid');

        $industry_name = $this->request->getPost('industry_name');
        $type_hospital = $this->request->getPost('type_hospital');
        $company_display_name = $this->request->getPost('company_display_name');
        $city = $this->request->getPost('city');
        $area_name = $this->request->getPost('area_name');
        $pincode = $this->request->getPost('pincode');
        $recruiter_name = $this->request->getPost('recruiter_name');
        $mobile_number = $this->request->getPost('mobile_number');
        $email = $this->request->getPost('email');
        $institute_name = $this->request->getPost('institute_name');
        $logo = $this->request->getFile('logo');
         
         $data = [
            'uid' =>$user_id,
            'industry_name' => $industry_name,
            'type_hospital'  => $type_hospital,
            'company_display_name'   => $company_display_name,
            'institute_name' => $institute_name,
            'city_id' => $city,
            'area_name'  => $area_name,
            'pincode' => $pincode,
            'recruiter_name' => $recruiter_name,
            'mobile_number' => $mobile_number,
            'email' => $email,
            'form_status'=>'active',
         ];

         
        if(!empty($type_hospital))
        {
            $newName = null;
            if ($logo && $logo->isValid() && !$logo->hasMoved()) 
            {
                $newName = $logo->getRandomName();
                $logo->move(ROOTPATH . 'public/uploads', $newName);

            } else {
                        echo "File upload failed.";
                    }
            $data['logo'] = $newName;
            $user_data = $RecruiterModel->recruiterDetails($data);
        }else
        {
            $newName = null;
            if ($logo && $logo->isValid() && !$logo->hasMoved()) 
            {
                   
                $newName = $logo->getRandomName();
                $logo->move(ROOTPATH . 'public/uploads', $newName);

            } else 
            {
                                 echo "File upload failed.";
            }
            $data['logo'] = $newName;
            $user_data = $RecruiterModel->recruiterDetails($data);
        }
                session()->setFlashdata('success', 'Recruiter registered successfully!');
                return redirect()->to('/recruiter/recruiter_posting_form');
           
    }
    public function recruiter_posting_form()
    {
        $session = session();
        if ($session->has('email')) 
        {
             // echo view('jobportal/frontheader');
            echo view('jobportal/header');

            echo view('recruiter/recruiter_posting_form');
            echo view('jobportal/footer');
        } else {
                // session not set
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');
        }
    }
    public function add_job_role()
    {
        $jobRole = $this->request->getPost('job_role');
       
        if (empty($jobRole)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Job role is required.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_job_role');

        // Check for duplicate
        $exists = $builder->where('job_role', $jobRole)->countAllResults();

        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This job role already exists.'
            ]);
        }

        $builder->insert(['job_role' => $jobRole]);
        $insertID = $db->insertID();

        return $this->response->setJSON([
            'status' => 'success',
            'job_id' => $insertID,
            'job_role' => $jobRole
        ]);
    }
    public function add_qualification()
    {
        $qualification_name = $this->request->getPost('qualification_name');

        if (empty($qualification_name)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Qualification name is required.'
            ]);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_qualification');

        // Check if already exists
        $exists = $builder->where('qualification_name', $qualification_name)->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Qualification already exists.'
            ]);
        }

        $builder->insert(['qualification_name' => $qualification_name]);
        $id = $db->insertID();

        return $this->response->setJSON([
            'status' => 'success',
            'qual_id' => $id,
            'qualification_name' => $qualification_name
        ]);
    }
    public function getCourses()
    {
        $qual_id = $this->request->getPost('qual_id');

        if ($qual_id) {
            $RecruiterModel = new RecruiterModel();
            $db = \Config\Database::connect();
            $courses = $RecruiterModel->getCoursesByQualification($qual_id);

            return $this->response->setJSON($courses);
        }

        return $this->response->setJSON([]);
    }
    public function add_course()
    {
        $courseName = $this->request->getPost('course_name');
        $qualificationId = $this->request->getPost('qualification_id');
        
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_course');

        // Check if course already exists
        $exists = $builder->where('course_name', $courseName)->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Course already exists.'
            ]);
        }

        // Insert new course
        $builder->insert([
            'course_name' => $courseName,
            'qual_id'     => $qualificationId
        ]);

        $courseId = $db->insertID();

        return $this->response->setJSON([
            'status'      => 'success',
            'course_id'   => $courseId,
            'course_name' => $courseName
        ]);
    }
    public function add_department()
    {
        $departmentName = $this->request->getPost('department_name');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_department');

        // Check if already exists
        $exists = $builder->where('department_name', $departmentName)->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Department already exists.'
            ]);
        }

        $builder->insert(['department_name' => $departmentName]);
        $id = $db->insertID();

        return $this->response->setJSON([
            'status' => 'success',
            'department_id' => $id,
            'department_name' => $departmentName
        ]);
    }
    public function saveRecruiterPosting()
    {
        $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
        date_default_timezone_set('Asia/Kolkata');

        $request = $this->request;
        $actiona = $request->getPost('action');

        $session = session();
        $user_id = session()->get('uid');
        $jobRole = $this->request->getPost('job_role');
        $city = $this->request->getPost('city');
        $qualification = $this->request->getPost('qualification');
        $course = $this->request->getPost('course');
        $department= $this->request->getPost('department');
        $vacancies = $this->request->getPost('vacancies');
        $employment_type = $this->request->getPost('employment_type');
        $gender = implode(',', $this->request->getPost('gender') ?? []);
        $job_description = $this->request->getPost('job_description');
        $shift_time = $this->request->getPost('shift_time');
        $experience_min = $this->request->getPost('experience_min');
        $experience_max = $this->request->getPost('experience_max');
        $salary_min = $this->request->getPost('salary_min');
        $salary_max = $this->request->getPost('salary_max');
        $action = $this->request->getPost('action'); 
          

            if ($action === 'preview') 
            {
                if(!empty($course))
                {
                    $data = [
                    'user_id' =>$user_id,
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
                    'status'          => 'Preview',
                    'posting_form_status'=>'active',
                     'created_date' => date('Y-m-d H:i:s'),
                 ];

                }else
                {
                    $data = [
                        'user_id' =>$user_id,
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
                         'status'   => 'Preview', 
                         'posting_form_status'=>'active',
                          'created_date' => date('Y-m-d H:i:s'),
                     ];

                }
               
                $posting_data = $RecruiterModel->recruiterPosting($data);
                $lastID = $db->insertID();
               
               return redirect()->to('/recruiter/preview/' . $lastID);

            }elseif($action === 'publish')
            {
                    if(!empty($course))
                    {
                        $data = [
                        'user_id' =>$user_id,
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
                    }else
                    {
                        $data = [
                            'user_id' =>$user_id,
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

                    }
                $posting_data = $RecruiterModel->recruiterPosting($data);
                session()->setFlashdata('success', 'Recruiter Job Post successfully!');
                        return redirect()->to('/recruiter/recruiter_posting_form');
            }elseif($action === 'draft')
            {

                if(!empty($course))
                    {
                                $data = [
                                'user_id' =>$user_id,
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
                                'status'          => 'Draft',
                                'posting_form_status'=>'active',
                                 'created_date' => date('Y-m-d H:i:s'),
                             ];

                    }else
                    {
                        $data = [
                            'user_id' =>$user_id,
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
                             'status'   => 'Draft', 
                             'posting_form_status'=>'active',
                            'created_date' => date('Y-m-d H:i:s'),
                         ];

                    }
                    $posting_data = $RecruiterModel->recruiterPosting($data);
                    session()->setFlashdata('success', 'Recruiter Job Post successfully!');
                    return redirect()->to('/recruiter/recruiter_posting_form');
            }
                 
    }
    public function publishsavedraft()
    {
         $session = session();
        if ($session->has('email')) 
        {
            echo view('jobportal/frontheader');
            echo view('recruiter/publishsavedraft');
            echo view('jobportal/footer');
            } else {
                // session not set
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
    }
    public function preview($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting');
        $data = $builder->where('posting_id', $id)->get()->getRowArray();

        echo view('jobportal/frontheader');
        echo view('recruiter/recruiter_preview_final', ['data' => $data]);
        echo view('jobportal/footer');
    }
    public function saveorupdate()
    {
        $db = \Config\Database::connect();
        $request = $this->request;
        $post_id = $request->getPost('post_id');
        $builder = $db->table('tbl_recruiter_posting');
        $data = $builder->where('posting_id', $post_id)->get()->getRowArray();

        echo view('jobportal/header');
        echo view('recruiter/update_recruiter_posting_form',['data' => $data]);
        echo view('jobportal/footer');



    }
    public function upade_recruiter_posting()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting');

        // Get action from form (publish or draft)
        $action = $request->getPost('action');

        // Get job post ID (from hidden input field)
        $jobPostId = $request->getPost('job_id');

        // Handle gender (array to comma-separated string)
        $gender = $request->getPost('gender') ?? [];
        $genderStr = implode(',', $gender);

        // Prepare data to update
        $data = [
            'job_id'            => $request->getPost('job_role'),
            'city_id'           => $request->getPost('city'),
            'qual_id'           => $request->getPost('qualification'),
            'course_id'         => $request->getPost('course'),
            'department_id'     => $request->getPost('department'),
            'vacancies'         => $request->getPost('vacancies'),
            'employment_type'   => $request->getPost('employment_type'),
            'gender'            => $genderStr,
            'job_description'   => $request->getPost('job_description'),
            'shift_time'        => $request->getPost('shift_time'),
            'experience_min'    => $request->getPost('experience_min'),
            'experience_max'    => $request->getPost('experience_max'),
            'salary_min'        => $request->getPost('salary_min'),
            'salary_max'        => $request->getPost('salary_max'),
            'status'            => ($action === 'publish') ? 'Publish' : 'Draft',
        ];

        $builder->where('posting_id ', $jobPostId);
        $builder->update($data);
         return redirect()->to('recruiter/publishsavedraft')->with('success', 'Job post published successfully.');
    }
    public function recruiter_job_responce()
    {
        $session = session();
        $user_id = $session->get('uid'); // get logged in recruiter

        $db = \Config\Database::connect();
            
        $builder = $db->table('tbl_recruiter_posting rp');
        $builder->select('rp.*, jr.job_role');
        $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left');
        $builder->where('rp.user_id', $user_id);
        $builder->whereIn('rp.status', ['Publish','Draft']);

        $jobs = $builder->get()->getResultArray();
    
        $published_jobs = array_filter($jobs, fn($j) => $j['status'] === 'Publish');
        $draft_jobs     = array_filter($jobs, fn($j) => $j['status'] === 'Draft');
     
        echo view('jobportal/frontheader');
        echo view('recruiter/recruiter_job_responce', [
        'published_jobs' => $published_jobs,
        'draft_jobs'     => $draft_jobs
        ]);
        echo view('jobportal/footer');
     }
    public function view_job_recruiter()
    {
        $session = session();
        $user_id = $session->get('uid');
        $posting_id = $this->request->getGet('id');
    
        $recruiterModel = new RecruiterModel();
        $result = $recruiterModel->getJobPostingWithLogo($user_id,$posting_id);
    
        echo view('jobportal/frontheader');
        echo view('recruiter/view_job_profile', ['result' => $result]);
        echo view('jobportal/footer');
    }
    public function update_recruiter_profile()
    {
        $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
            
        $session = session();
        $user_id = session()->get('uid');
        $builder = $db->table('tbl_recruiter');
        $data = $builder->where('uid', $user_id)->get()->getRowArray();
        echo view('jobportal/frontheader');
        echo view('recruiter/update_recruiter_profile',['data' => $data]);
        echo view('jobportal/footer');
    }
    public function upload_company_profile()
    {
        $file = $this->request->getFile('compny_profile');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/uploads', $newName);
            $userId = session()->get('uid');
            $db = \Config\Database::connect();
            $db->table('tbl_user')
                ->where('uid', $userId)
                ->update(['company_profile' => $newName]);
            return $this->response->setJSON(['status' => 'success']);
        }
    
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Upload failed']);
    }
    public function add_about()
    {
        $about = $this->request->getPost('about_description');
        $session = session();
        $userId = session()->get('uid');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_about');
    
        $exists = $builder->where('uid', $userId)->countAllResults();
    
        if ($exists > 0) {
            
            $builder->where('uid', $userId)->update([
                'about_description' => $about
            ]);
    
    
            return $this->response->setJSON(['status' => 'updated']);
        } else {
            
            $builder->insert([
                'uid' => $userId,
                'about_description' => $about
            ]);
            return $this->response->setJSON(['status' => 'inserted']);
        }
    }
    public function edit_recruiter()
    {
        $request = service('request');
        $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
        
        $session = session();
        $user_id = session()->get('uid');
        $recruiter_id = $this->request->getPost('recruiter_id');
        $req_address = $this->request->getPost('req_address');
        $city = $this->request->getPost('city');
        $area_name = $this->request->getPost('area_name');
        $pincode = $this->request->getPost('pincode');
        $industry_name = $this->request->getPost('industry_name');
        $institute_name = $this->request->getPost('institute_name');
        $type_hospital = $this->request->getPost('type_hospital');
        $company_display_name = $this->request->getPost('company_display_name');
        $recruiter_name = $this->request->getPost('recruiter_name');
        $mobile_number = $this->request->getPost('mobile_number');
           
        $data = [
            'uid'            => $user_id,
            'industry_name'  => $industry_name,
            'req_address'    => $req_address,
            'city_id'         => $city,
            'area_name'     => $area_name,
            'pincode'         => $pincode,
            'institute_name'   => $institute_name,
            'type_hospital'   => $type_hospital,
            'company_display_name' => $company_display_name,
            'recruiter_name'    => $recruiter_name,
            'mobile_number'    => $mobile_number
        ];
            $builder = $db->table('tbl_recruiter');
            $builder->where('recruiter_id', $recruiter_id);
            $builder->update($data);
            return redirect()->to(' recruiter/update_recruiter_profile')->with('success', 'Updae Company Profile successfully.');
    }
    public function add_gallery()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_gallery');
        $session = session();
        $user_id = session()->get('uid');
        $youtube_video = $this->request->getPost('youtube_video');
        $youtube_id = null;
    
        if ($youtube_video) {
            if (strpos($youtube_video, 'youtu.be') !== false) {
                $youtube_id = basename(parse_url($youtube_video, PHP_URL_PATH));
            } else {
                parse_str(parse_url($youtube_video, PHP_URL_QUERY), $params);
                $youtube_id = $params['v'] ?? null;
            }
    
            if ($youtube_id) {
                // ✅ Store full link in DB, not just video ID
                $builder->insert([
                    'type' => 'youtube',
                    'media_value' => $youtube_video,
                    'created_at' => date('Y-m-d H:i:s'),
                    'uid'=>$user_id
                ]);
            }
        }
    
        // ✅ Process multiple image uploads
        $files = $this->request->getFileMultiple('gallery_images');
    
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);
    
                $builder->insert([
                    'type' => 'image',
                    'media_value' => $newName,
                    'created_at' => date('Y-m-d H:i:s'),
                    'uid'=>$user_id
                ]);
            }
        }
    
        // ✅ Return Preview Output
        $output = '';
        if ($youtube_id) {
            $output .= '<iframe width="300" height="200" src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe><br>';
        }
    
        if (!empty($files)) {
            foreach ($files as $file) {
                $output .= '<img src="' . base_url('writable/uploads/' . $file->getName()) . '" width="120" style="margin:5px;">';
            }
        }
    
        echo $output ?: '<p>No media uploaded.</p>';
    }
    public function delete_gallery_item($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_gallery');
    
        // Fetch media row
        $media = $builder->where('id', $id)->get()->getRowArray();
    
        if ($media) {
            
            if ($media['type'] == 'image') {
                $filePath = WRITEPATH . 'uploads/' . $media['media_value'];
                if (file_exists($filePath)) {
                    unlink($filePath); // delete from folder
                }
            }
    
            
            $builder->where('id', $id)->delete();
    
            return $this->response->setJSON(['status' => 'success']);
        }
    
        return $this->response->setJSON(['status' => 'error', 'message' => 'Media not found']);
    }
    public function publishstatusupdate()
    {
        $db = \Config\Database::connect();
        $posting_id = $this->request->getPost('posting_id');
        $action = $this->request->getPost('action'); 
    
        $data = [
               
                'status'=>'Publish',
            ];
            $builder = $db->table('tbl_recruiter_posting');
            $builder->where('posting_id ', $posting_id);
            $builder->update($data);
            return redirect()->to('recruiter/recruiter_job_responce')->with('success', 'published successfully.');
    }
    public function forgot_password()
    {
        return view('recruiter/forgot_password_form');
    }
    public function send_reset_link()
    {
      $email = $this->request->getPost('email');
      $db = \Config\Database::connect();
       
        $user = $db->table('tbl_user')->where('email', $email)->get()->getRow();
        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        $token = bin2hex(random_bytes(16));

        $db->table('tbl_user')->where('email', $email)->update(['reset_token' => $token]);

        $resetLink = base_url("recruiter/reset_password/{$token}");

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
            $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Your Gmail
            $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');              // App password
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
    public function reset_password($token)
    {
        $db = \Config\Database::connect();
        $user = $db->table('tbl_user')->where('reset_token', $token)->get()->getRow();
        if (!$user) {
            return redirect()->to('/')->with('error', 'Invalid or expired reset link.');
        }
        return view('recruiter/reset_password_form', ['token' => $token]);
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

        $db->table('tbl_user')->where('reset_token', $token)->update([
            'password' => $password,
            'reset_token' => null,
            'otp'=>'',
            'login_status'=>'',
        ]);

        return redirect()->to('/recruiter-login')->with('success', 'Password updated successfully.');
    }
    public function publish_page()
    {
        $session = session();
        if ($session->has('email')) 
        {
            $session = session();
            $user_id = $session->get('uid'); // get logged in recruiter
            $db = \Config\Database::connect();
            $RecruiterModel = new RecruiterModel();
            $status = 'Publish';
             $published_jobs = $RecruiterModel->getPublishedJobsByUser($user_id,$status);
            echo view('jobportal/frontheader');
            echo view('recruiter/publish_page', ['published_jobs' => $published_jobs]);
            echo view('jobportal/footer');
        } else {
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
    }
    public function savedraft_page()
    {
        $session = session();
        if ($session->has('email')) 
        {
            $session = session();
            $user_id = $session->get('uid'); // get logged in recruiter
             $status = 'Draft';
            $db = \Config\Database::connect();
            $RecruiterModel = new RecruiterModel();
             $savedraft_jobs = $RecruiterModel->getPublishedJobsByUser($user_id,$status);
            echo view('jobportal/frontheader');
            echo view('recruiter/savedraft_page', ['savedraft_jobs' => $savedraft_jobs]);
            echo view('jobportal/footer');
        } else {
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
    }
    public function edit_job_recruiter()
    {
        $session = session();
        $user_id = $session->get('uid');
        $posting_id = $this->request->getGet('id');

        $recruiterModel = new RecruiterModel();
        $result = $recruiterModel->getJobPostingWithLogo($user_id, $posting_id);
        $db = \Config\Database::connect();
         $builder = $db->table('tbl_recruiter_posting');
        $data = $builder->where('posting_id', $posting_id)->get()->getRowArray();

        echo view('jobportal/frontheader');
        echo view('recruiter/edit_job_profile', ['data' => $data,'result' =>$result]);
        echo view('jobportal/footer');
    }
    public function upade_recruiter_posting_new()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting');
        $action = $request->getPost('action');

        $jobPostId = $request->getPost('job_id');

        $gender = $request->getPost('gender') ?? [];
        $genderStr = implode(',', $gender);

        $data = [
            'job_id'            => $request->getPost('job_role'),
            'city_id'           => $request->getPost('city'),
            'qual_id'           => $request->getPost('qualification'),
            'course_id'         => $request->getPost('course'),
            'department_id'     => $request->getPost('department'),
            'vacancies'         => $request->getPost('vacancies'),
            'employment_type'   => $request->getPost('employment_type'),
            'gender'            => $genderStr,
            'job_description'   => $request->getPost('job_description'),
            'shift_time'        => $request->getPost('shift_time'),
            'experience_min'    => $request->getPost('experience_min'),
            'experience_max'    => $request->getPost('experience_max'),
            'salary_min'        => $request->getPost('salary_min'),
            'salary_max'        => $request->getPost('salary_max'),
            'status'            => $request->getPost('status'),
        ];
    
        $builder->where('posting_id ', $jobPostId);
        $builder->update($data);
        return redirect()->to('recruiter/edit_job_recruiter?id=' . $jobPostId)
                 ->with('success', 'Job post updated successfully.');
    }
    public function preview_recruiter()
    {
        $session = session();
        if ($session->has('email')) 
        {
            $session = session();
            $user_id = $session->get('uid'); // get logged in recruiter
            $status = 'Preview';
            $db = \Config\Database::connect();
            $RecruiterModel = new RecruiterModel();
             $preview_jobs = $RecruiterModel->getpreviewJobsByUser($user_id,$status);
            echo view('jobportal/frontheader');
            echo view('recruiter/preview_page', ['preview_jobs' => $preview_jobs]);
            echo view('jobportal/footer');
        } else {
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
    }
    
    public function previewstatusupdate()
    {
         $db = \Config\Database::connect();
        $action = $this->request->getPost('action');
        $posting_id = $this->request->getPost('posting_id');

        $data = [
           
            'status'=>$action,
        ];
        $builder = $db->table('tbl_recruiter_posting');
        $builder->where('posting_id ', $posting_id);
        $builder->update($data);

        if($action == 'Publish')
        {
            return redirect()->to('recruiter/recruiter_job_responce')->with('success', 'published successfully.');
        }else
        {
            return redirect()->to('recruiter/recruiter_job_responce')->with('success', 'Draft successfully.'); 
        }
        
           

    }
    
}
