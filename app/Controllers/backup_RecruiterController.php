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


class RecruiterController extends BaseController
{
    // public function index(): string
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
                // session not set
               return redirect()->to(base_url('recruiter-login') . '?activeTab=login');

            }
        
    }
    public function save_recruiter_form()
    {
        $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
        // $postData = $this->request->getPost();
         $session = session();
         $user_id = session()->get('uid');

      
        $industry_name = $this->request->getPost('industry_name');
        // $user_id = $this->request->getPost('uid');
        $type_hospital = $this->request->getPost('type_hospital');
        $company_display_name = $this->request->getPost('company_display_name');
        $city = $this->request->getPost('city');
        $area_name = $this->request->getPost('area_name');
        $pincode = $this->request->getPost('pincode');
        $recruiter_name = $this->request->getPost('recruiter_name');
        $mobile_number = $this->request->getPost('mobile_number');
        $email = $this->request->getPost('email');
         $logo = $this->request->getFile('logo');
         $data = [
            'uid' =>$user_id,
            'industry_name' => $industry_name,
            'type_hospital'  => $type_hospital,
            'company_display_name'   => $company_display_name,
            'city_id' => $city,
            'area_name'  => $area_name,
            'pincode' => $pincode,
            'recruiter_name' => $recruiter_name,
            'mobile_number' => $mobile_number,
            'email' => $email,
            'form_status'=>'active',
            // 'logo' => $logo,
         ];

         
        if(!empty($type_hospital))
        {
            // echo "hello";

            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                    // Create a random filename and move it to 'uploads' folder
                        $newName = $logo->getRandomName();
                        $logo->move(ROOTPATH . 'public/uploads', $newName);

                         // You can now save $newName to the database, if needed
                        // echo "File uploaded successfully: " . $newName;
                    } else {
                                 echo "File upload failed.";
                            }
            $data['logo'] = $newName;
            $user_data = $RecruiterModel->recruiterDetails($data);
        }else
        {
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                    // Create a random filename and move it to 'uploads' folder
                        $newName = $logo->getRandomName();
                        $logo->move(ROOTPATH . 'public/uploads', $newName);

                         // You can now save $newName to the database, if needed
                        // echo "File uploaded successfully: " . $newName;
                    } else {
                                 echo "File upload failed.";
                            }
            $data['logo'] = $newName;
            $user_data = $RecruiterModel->recruiterDetails($data);
        }
                session()->setFlashdata('success', 'Recruiter registered successfully!');
                return redirect()->to('/recruiter/recruiter_posting_form');

         // echo "<pre>";
         // print_r($data);

         // exit();
           
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
        // echo $jobRole;
        // exit();
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
        'dept_id' => $id,
        'department_name' => $departmentName
    ]);
}
public function saveRecruiterPosting()
{
     $RecruiterModel = new RecruiterModel();
        $db = \Config\Database::connect();
        
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
        $action = $this->request->getPost('action'); // "publish" or "draft"

        $status = ($action === 'publish') ? 'Publish' : 'Draft';

       if ($action === 'preview') 
       {
            $formData = $request->getPost();
            echo view('jobportal/frontheader');
            echo view('recruiter/recruiter_preview', ['data' => $formData]);
            echo view('jobportal/footer');
        }else{
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
                            'status'          => $status,
                            'posting_form_status'=>'active',
                         ];

            }else
            {
                    $data = [
                        'user_id' =>$user_id,
                        'job_id' => $jobRole,
                        'city_id'  => $city,
                        'qual_id'   => $qualification,
                        // 'course_id' => $course,
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
                         'status'   => $status ?? 'Draft', 
                         'posting_form_status'=>'active',
                        // 'logo' => $logo,
                     ];

            }
             $posting_data = $RecruiterModel->recruiterPosting($data);
            session()->setFlashdata('success', 'Recruiter Job Post successfully!');
                    return redirect()->to('/recruiter/recruiter_posting_form');
        }




        // $postData = $this->request->getPost();
        // print_r($data);
        // exit();
             
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
    public function preview()
    {
        $session = session();
        $userId = $session->get('uid');

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter');

        $data['recruiter'] = $builder->where('uid', $userId)->get()->getRowArray();
        echo view('jobportal/frontheader');
        echo view('recruiter/recruiter_preview', $data);
        echo view('jobportal/footer');
    }



    
}
