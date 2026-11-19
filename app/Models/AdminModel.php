<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    
     protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function getrecruiterDetails()
    {
           $builder = $this->db->table('tbl_recruiter');

    $builder->select('
        tbl_recruiter.*,
        tbl_user.email,
        tbl_user.mobile_no,
        tbl_industry.industry_name,
         tbl_lead.lead_id,
        tbl_lead.lead_name,
        cities.name
    ');

    $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left');
    $builder->join('tbl_industry', 'tbl_industry.industry_id = tbl_recruiter.industry_name', 'left');
    $builder->join('cities', 'cities.id = tbl_recruiter.city_id', 'left');
    $builder->join('tbl_lead', 'tbl_lead.lead_id = tbl_recruiter.lead_id', 'left');
     $builder->orderBy('tbl_recruiter.recruiter_id', 'DESC');
    $query = $builder->get();
    return $query->getResultArray();

    }

    public function getrecruiterPostingDetails($uid)
    {
        $builder = $this->db->table('tbl_recruiter_posting');

        $builder->select('
            tbl_recruiter_posting.*,
            tbl_user.email,
            tbl_user.mobile_no,
            tbl_user.name AS user_name,
            cities.name,
            tbl_job_role.job_role,
            tbl_department.department_name
        ');

        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter_posting.user_id', 'left');
        $builder->join('cities', 'cities.id = tbl_recruiter_posting.city_id', 'left');
        $builder->join('tbl_job_role', 'tbl_job_role.job_id = tbl_recruiter_posting.job_id', 'left');
        $builder->join('tbl_department', 'tbl_department.department_id = tbl_recruiter_posting.department_id', 'left');

        // Apply the WHERE condition
        $builder->where('tbl_recruiter_posting.user_id', $uid);
         $builder->where('tbl_recruiter_posting.admin_status', 'Open');
         $builder->where('tbl_recruiter_posting.status', 'Publish');
        $query = $builder->get();
        // echo $this->db->getLastQuery(); exit();
        return $query->getResultArray();

    }

     public function candidateDetailsData()
    {
       $builder = $this->db->table('tbl_candidate_job_status cs');

            $builder->select('cs.*, js.*, rp.*, jr.job_role');
            $builder->join('tbl_jobseeker js', 'cs.jobseeker_id = js.jobseeker_id');
            $builder->join('tbl_recruiter_posting rp', 'cs.posting_id = rp.posting_id');
            $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
            $builder->where('cs.admin_candidate_status !=', 'Rejected');
            $query = $builder->get();
            return $query->getResultArray();  // ✅ return result

    }
    public function addBlogData($data)
    {
        // $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_blogs')->insert($data);
        // echo $this->db->getLastQuery(); exit();
           return $query;
    }
    public function single_blog_edit($blog_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_blogs');

        $row = $builder->where('blog_id', $blog_id)->get()->getRowArray();

        return $row;
    }
    public function update_blog_data($blog_id, $data)
    {
        $query=  $this->db->table('tbl_blogs')
                        ->where('blog_id',$blog_id)
                        ->update($data);
        return $query;    
        // echo $this->db->getLastQuery(); exit();
    }
    public function checkRecruiterByName($recruiter_name)
    {
        // Normalize recruiter_name in PHP
        $normalized_name = strtolower(str_replace(' ', '', $recruiter_name));

        $builder = $this->db->table('tbl_user u');
        $builder->select('u.*,r.*');
        $builder->join('tbl_recruiter r', 'u.uid = r.uid', 'inner');

        // Compare normalized values
        $builder->where("LOWER(REPLACE(r.recruiter_name, ' ', ''))", $normalized_name);

        // Hardcoded email (you can pass as parameter if needed)
        $builder->where("LOWER(TRIM(u.email))", strtolower(trim('adisjobsplacement@gmail.com')));

        $query = $builder->get()->getResultArray();;
        return $query;
        // Debug SQL
        // echo $this->db->getLastQuery();
        // exit();

        // return $query->getResultArray();
    }
    public function userDeatails($filedata)
    {
        $this->db = \Config\Database::connect(); 
        $this->db->table('tbl_user')->insert($filedata);

        // ✅ return only the last insert ID
        return $this->db->insertID();
    }
    public function recruiterDetails($filedata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_recruiter')->insert($filedata);
        // echo $this->db->getLastQuery(); exit();
           return $query;
    }

    // 🔹 Check if user exists by email
    public function checkUserExists($email)
    {
          
        return $this->db->table('tbl_user')
            ->select('uid')
            ->where('email', $email)
            ->get()
            ->getRow();
    }

    public function insertUser($data)
    {
          
        $this->db->table('tbl_user')->insert($data);
        return $this->db->insertID();
    }
    public function checkDuplicateRecruiter($email)
    {

        return $this->db->table('tbl_recruiter r')
            ->join('tbl_user u', 'u.uid = r.uid')
            ->where('u.email', $email)
            ->countAllResults();
    }
    public function insertRecruiter($data)
    {
        return $this->db->table('tbl_recruiter')->insert($data);
    }
    public function display_job_role()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_job_role');
        $query = $builder->get()->getResultArray();;
        return $query;
    }
    public function display_location()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cities');
        $query = $builder->get()->getResultArray();;
        return $query;
    }
    public function display_qualification()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_qualification');
        $query = $builder->get()->getResultArray();;
        return $query;
    }
    public function display_depart()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_department');
        $query = $builder->get()->getResultArray();;
        return $query;
    }
    public function single_emp_edit($uid)
    {
        $builder = $this->db->table('tbl_user u');
        $builder->select('u.*, r.*, c.*');
        $builder->join('tbl_recruiter r', 'u.uid = r.uid');
        $builder->join('cities c', 'r.city_id = c.id', 'left');
        $builder->where('u.uid', $uid);

        $query = $builder->get();  // run the query first
        // echo $this->db->getLastQuery(); // now you can see the executed query

        return $query->getRowArray();
    }
    public function all_signup_recruiter()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');
        $builder->where('user_type','recruiter');

        $query = $builder->get()->getResultArray();;
        return $query;
    }
    public function recuiterfrontFormDataedit($uid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');

        $row = $builder->where('uid', $uid)->get()->getRowArray();
        // echo $this->db->getLastQuery();
        return $row;
    }
    
    public function add_recruiter_front($data)
    {
        // $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_recruiter')->insert($data);
        // echo $this->db->getLastQuery(); exit();
       return $query;
    } 
    public function all_daily_count_clientdisply()
    {
        $today = date('Y-m-d');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');

        $builder->where('user_type', 'recruiter');
        $builder->where('registered_date', $today);  

        $query = $builder->get()->getResultArray();

        // To see last executed query
        // echo $db->getLastQuery();

        return $query;
    }

    public function all_post_vacancy_disply()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting AS trp');
        
        $builder->select('trp.*, 
                          jr.job_role, 
                          c.name AS city_name, 
                          q.qualification_name, 
                          r.recruiter_name, 
                          d.department_name');
        $builder->join('tbl_job_role AS jr', 'trp.job_id = jr.job_id', 'left');
        $builder->join('cities AS c','trp.city_id = c.id', 'left');
        $builder->join('tbl_qualification AS q', 'trp.qual_id = q.qual_id', 'left');
        $builder->join('tbl_recruiter AS r', 'trp.user_id = r.uid', 'left');
        $builder->join('tbl_department AS d', 'trp.department_id = d.department_id', 'left');
        $builder->where('trp.admin_status','Open');
        $builder->where('trp.status', 'Publish');
        $builder->orderBy('trp.created_date', 'DESC');
        $query = $builder->get()->getResultArray();
        // echo $db->getLastQuery();
        return $query;
    }
    public function closedClientdisply()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting AS trp');
        
        $builder->select('trp.*, 
                          jr.job_role, 
                          c.name AS city_name, 
                          q.qualification_name, 
                          r.recruiter_name, 
                          d.department_name');
        $builder->join('tbl_job_role AS jr', 'trp.job_id = jr.job_id', 'left');
        $builder->join('cities AS c','trp.city_id = c.id', 'left');
        $builder->join('tbl_qualification AS q', 'trp.qual_id = q.qual_id', 'left');
        $builder->join('tbl_recruiter AS r', 'trp.user_id = r.uid', 'left');
        $builder->join('tbl_department AS d', 'trp.department_id = d.department_id', 'left');
        $builder->where('trp.admin_status','closed');
        $builder->where('trp.status', 'Publish');
        $query = $builder->get()->getResultArray();
        // echo $db->getLastQuery();
        return $query;
    }
    public function closedPostvaciesdisply()
    {
           $db = \Config\Database::connect();

            $builder = $db->table('tbl_candidate_job_status tcjs')
                ->select('tcjs.*, rp.*, js.*, r.*, jr.job_role')
                ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
                ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
                ->join('tbl_recruiter r', 'rp.user_id = r.uid')
                ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
                ->where('tcjs.admin_candidate_status', 'Closed')
                ->where('rp.status', 'Publish')
                 ->orderBy('tcjs.joining_date', 'DESC');
        
            $query = $builder->get()->getResultArray();
            return $query;
    }
    
    public function all_signup_candidate()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');
        $builder->where('user_type', 'jobseekar');

        // ✅ Active → bottom
        //$builder->orderBy("CASE WHEN login_status = 'active' THEN 1 ELSE 0 END", 'ASC', false);
        $builder->orderBy('registered_date', 'DESC');
        // Optional second sorting inside active/inactive group
        // $builder->orderBy('register_date', 'DESC');

        $query = $builder->get()->getResultArray();
        return $query;
    }

    public function all_registraion_candidate()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_jobseeker js');
        $builder->select('
            js.*,
            c.name AS current_city_name,
            jr.job_role,
            cou.*,
            GROUP_CONCAT(ec.name SEPARATOR " ,") AS expected_city_names
        ');
        $builder->join('cities c', 'js.current_city = c.id', 'left');
        $builder->join('tbl_job_role jr', 'js.job_id = jr.job_id', 'left');
        $builder->join('tbl_course cou', 'js.course = cou.course_id', 'left');
        // ✅ Join for expected cities
        $builder->join('cities ec','FIND_IN_SET(ec.id, js.expected_cities)','left');

        $builder->groupBy('js.jobseeker_id');
        $builder->orderBy('js.jobseeker_id', 'DESC');

        $query = $builder->get()->getResultArray();
        return $query;
    }
    public function all_daily_candidate_disply()
    {
        $today = date('Y-m-d');
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_user');

        $builder->where('user_type', 'jobseekar');
        $builder->where('registered_date',$today);  
        $builder->orderBy('uid','DESC'); 
        $query = $builder->get()->getResultArray();
        // To see last executed query
        // echo $db->getLastQuery();
        return $query;
    }
    public function all_interview_scedule_candidate_disply()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_candidate_job_status cjs');
        $builder->select('
            cjs.jobseeker_id,
            cjs.posting_id,
            cjs.admin_candidate_status,
            js.full_name,
            js.mobile_number,
            js.email as jobseeker_email,
            js.resume,
            c.name AS city_name,
            jr.job_role,
            rp.posting_id,
            rp.employment_type,
            rp.created_date,
            r.recruiter_id,
            r.recruiter_name,
            r.company_display_name
        ');
        $builder->join('tbl_jobseeker js', 'cjs.jobseeker_id = js.jobseeker_id', 'left');
        $builder->join('cities c','js.current_city = c.id', 'left');
        $builder->join('tbl_job_role jr', 'js.job_id = jr.job_id', 'left');
        $builder->join('tbl_recruiter_posting rp', 'cjs.posting_id = rp.posting_id', 'left');
        $builder->join('tbl_recruiter r', 'cjs.recruiter_id = r.recruiter_id', 'left');
        $builder->where('cjs.admin_candidate_status', 'Interview Schedule');
        $builder->orderBy('js.jobseeker_id', 'DESC'); // sort latest first
            
        $query = $builder->get()->getResultArray();
           return $query;
        // echo $db->getLastQuery();
    }
    
    public function all_hold_candidate_disply()
    {
        $db = \Config\Database::connect();

            $builder = $db->table('tbl_candidate_job_status cjs');
            $builder->select('
                cjs.jobseeker_id,
                cjs.posting_id,
                cjs.admin_candidate_status,
                js.full_name,
                js.mobile_number,
                js.email as jobseeker_email,
                js.resume,
                c.name AS city_name,
                jr.job_role,
                rp.posting_id,
                rp.employment_type,
                rp.created_date,
                r.recruiter_id,
                r.recruiter_name,
                r.company_display_name,
                cjs.applied_at
            ');
            $builder->join('tbl_jobseeker js', 'cjs.jobseeker_id = js.jobseeker_id', 'left');
            $builder->join('cities c','js.current_city = c.id', 'left');
            $builder->join('tbl_job_role jr', 'js.job_id = jr.job_id', 'left');
            $builder->join('tbl_recruiter_posting rp', 'cjs.posting_id = rp.posting_id', 'left');
            $builder->join('tbl_recruiter r', 'cjs.recruiter_id = r.recruiter_id', 'left');
            $builder->where('cjs.admin_candidate_status', 'Hold');
            $builder->orderBy('js.jobseeker_id', 'DESC'); // sort latest first
                
            $query = $builder->get()->getResultArray();
               return $query;
    }
    public function all_reject_candidate_disply()
    {
        $db = \Config\Database::connect();

            $builder = $db->table('tbl_candidate_job_status cjs');
            $builder->select('
                cjs.jobseeker_id,
                cjs.posting_id,
                cjs.admin_candidate_status,
                cjs.applied_at,
                js.full_name,
                js.mobile_number,
                js.email as jobseeker_email,
                js.resume,
                c.name AS city_name,
                jr.job_role,
                rp.posting_id,
                rp.employment_type,
                rp.created_date,
                r.recruiter_id,
                r.recruiter_name,
                r.company_display_name
            ');
            $builder->join('tbl_jobseeker js', 'cjs.jobseeker_id = js.jobseeker_id', 'left');
            $builder->join('cities c','js.current_city = c.id', 'left');
            $builder->join('tbl_job_role jr', 'js.job_id = jr.job_id', 'left');
            $builder->join('tbl_recruiter_posting rp', 'cjs.posting_id = rp.posting_id', 'left');
            $builder->join('tbl_recruiter r', 'cjs.recruiter_id = r.recruiter_id', 'left');
            $builder->where('cjs.admin_candidate_status', 'Rejected');
            $builder->orderBy('js.jobseeker_id', 'DESC'); // sort latest first
                
            $query = $builder->get()->getResultArray();
               return $query;
    }
    public function candidateClosedDetailsData()
    {
        $builder = $this->db->table('tbl_candidate_job_status cs');

            $builder->select('cs.*, js.*, rp.*,r.*, jr.job_role,c.*,c.name AS city_name');
            $builder->join('tbl_jobseeker js', 'cs.jobseeker_id = js.jobseeker_id');
            $builder->join('tbl_recruiter_posting rp', 'cs.posting_id = rp.posting_id');
            $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
            $builder->join('tbl_recruiter r', 'cs.recruiter_id = r.recruiter_id', 'left');
              $builder->join('cities c','js.current_city = c.id', 'left');
            $builder->where('cs.admin_candidate_status', 'Closed');
            $query = $builder->get();
          
            return $query->getResultArray();  // ✅ return result
    }
    public function all_apply_candidate_disply()
    {
        $builder = $this->db->table('tbl_candidate_job_status cs');

            $builder->select('cs.*, js.*,js.email as jobseeker_email, rp.*,r.*, jr.job_role,c.*');
            $builder->join('tbl_jobseeker js', 'cs.jobseeker_id = js.jobseeker_id');
            $builder->join('tbl_recruiter_posting rp', 'cs.posting_id = rp.posting_id');
            $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
            $builder->join('tbl_recruiter r', 'cs.recruiter_id = r.recruiter_id', 'left');
            $builder->join('cities c','js.current_city = c.id', 'left');
            $builder->where('cs.admin_candidate_status', 'Open');
             $builder->orderBy('cs.job_status_id', 'DESC');
            $query = $builder->get();
            return $query->getResultArray();  // ✅ return result
    }
    public function single_posting_edit($posting_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_recruiter_posting');
        $row = $builder->where('posting_id ',$posting_id)->get()->getRowArray();
        return $row;
    }
    public function update_posting_data($posting_id, $data)
    {
        $query=  $this->db->table('tbl_recruiter_posting')
                        ->where('posting_id',$posting_id)
                        ->update($data);
        return $query;    
        // echo $this->db->getLastQuery(); exit();
    }
     public function single_candidate_edit($uid)
    {
        $builder = $this->db->table('tbl_user u');
        $builder->select('u.*, tj.*, tjr.job_id,tjr.job_role');
        $builder->join('tbl_jobseeker tj', 'u.uid = tj.uid');
        $builder->join('tbl_job_role tjr', 'tj.job_id = tjr.job_id', 'left');
        $builder->where('u.uid', $uid);

        $query = $builder->get();  // run the query first
        // echo $this->db->getLastQuery(); // now you can see the executed query
        // exit();
        return $query->getRowArray();
    }
    
    // ================ 12-11-2025 =============================

    public function single_candidate_status($job_status_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_candidate_job_status');
        $row = $builder->where('job_status_id',$job_status_id)->get()->getRowArray();
        return $row;
    }
    public function update_candidate_job_data($job_status_id,$data)
    {
         $query=  $this->db->table('tbl_candidate_job_status')
                        ->where('job_status_id',$job_status_id)
                        ->update($data);
        return $query;    
    }
    
    public function closedPostvaciesSentInvoicedisply()
    {
           $db = \Config\Database::connect();

        $builder = $db->table('tbl_candidate_job_status tcjs')
            ->select('tcjs.*, rp.*, js.*, r.*, jr.job_role')
            ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->where('tcjs.payment_recived_status', 'Send_invoice')
            ->orwhere('tcjs.payment_type', 'Part Payment')
            ->where('rp.status', 'Publish');

        $query = $builder->get()->getResultArray();
        return $query;
    }
    public function RecivePaymenteClientdisply()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_candidate_job_status tcjs')
            ->select('tcjs.*, rp.*, js.*, r.*, jr.job_role')
            ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->where('tcjs.payment_recived_status', 'Recived_payment')
            ->where('rp.status', 'Publish');

        $query = $builder->get()->getResultArray();
        return $query;

    }
    public function PendingPaymenteClientdisply()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_candidate_job_status tcjs')
            ->select('tcjs.*, rp.*, js.*, r.*, jr.job_role')
            ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->where('tcjs.payment_type', 'Part Payment')
            ->where('rp.status', 'Publish');
        //  echo $db->getLastQuery();
        //  exit();
        $query = $builder->get()->getResultArray();
        return $query;
    }
    public function getPaidClientDisplay()
    {
        $builder = $this->db->table('tbl_recruiter');
        $builder->select('tbl_recruiter.*,tbl_user.email, tbl_user.mobile_no,cities.name');
        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left');
        $builder->join('cities', 'cities.id = tbl_recruiter.city_id', 'left');
        $builder->where('tbl_recruiter.client_reg_type', 'paid');

        $builder->orderBy('tbl_recruiter.recruiter_id', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();

    }
    public function getFreeClientDisplay()
    {
        $builder = $this->db->table('tbl_recruiter');
        $builder->select('tbl_recruiter.*,tbl_user.email, tbl_user.mobile_no,cities.name');
        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left');
        $builder->join('cities', 'cities.id = tbl_recruiter.city_id', 'left');
        $builder->where('tbl_recruiter.client_reg_type', 'free');

        $builder->orderBy('tbl_recruiter.recruiter_id', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();

    }
    public function getAdvancedClientDisplay()
    {
        $builder = $this->db->table('tbl_recruiter');
        $builder->select('tbl_recruiter.*,tbl_user.email, tbl_user.mobile_no,cities.name');
        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left');
        $builder->join('cities', 'cities.id = tbl_recruiter.city_id', 'left');
            $builder->where('tbl_recruiter.advanced_payment >', 0);

        $builder->orderBy('tbl_recruiter.recruiter_id', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();

    }
    
    public function CountPostVaciesdisplay()
    {
        return $this->db->table('tbl_recruiter_posting')
                        ->where('admin_status', 'Closed')
                        ->countAllResults();
    }
    public function CountInvoiceclosedPostvaciesdisply($start_date = null, $end_date = null)
    {
        $db = \Config\Database::connect();

        // ✅ builder variable मध्ये store कर
        $builder = $db->table('tbl_candidate_job_status tcjs');

        $builder->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->groupStart()
                ->where('tcjs.payment_recived_status', 'Send_invoice')
                ->orWhere('tcjs.payment_type', 'Part Payment')
            ->groupEnd()
            ->where('rp.status', 'Publish');

        // ✅ date filter
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tcjs.invoice_send_date) >=', $start_date);
            $builder->where('DATE(tcjs.invoice_send_date) <=', $end_date);
        }

        // ✅ single return
        return $builder->countAllResults();
    }

     public function CountRecivePaymenteClientdisply($start_date = null, $end_date = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_candidate_job_status tcjs');

        $builder->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
            ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
            ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
            ->where('tcjs.admin_candidate_status', 'Closed')
            ->where('tcjs.payment_recived_status', 'Recived_payment')
            ->where('rp.status', 'Publish');

        // ✅ date filter (optional)
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tcjs.payment_recived_date) >=', $start_date);
            $builder->where('DATE(tcjs.payment_recived_date) <=', $end_date);
        }

        return $builder->countAllResults();
    }

    public function CountPendingPaymenteClientdisply()
    {
        $db = \Config\Database::connect();

        return $db->table('tbl_candidate_job_status tcjs')
        ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
        ->join('tbl_jobseeker js', 'tcjs.jobseeker_id = js.jobseeker_id')
        ->join('tbl_recruiter r', 'rp.user_id = r.uid')
        ->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left')
        ->where('tcjs.admin_candidate_status', 'Closed')
        ->where('tcjs.payment_type', 'Part Payment')
        ->where('rp.status', 'Publish')
        ->countAllResults();
    }

    public function CountPaidClientDisplay($start_date = null, $end_date = null)
    {
        $builder = $this->db->table('tbl_recruiter');

        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left')
            ->join('cities', 'cities.id = tbl_recruiter.city_id', 'left')
            ->where('tbl_recruiter.client_reg_type', 'paid');

        // ✅ date filter using client_fees_reg_date
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tbl_recruiter.client_fees_reg_date) >=', $start_date);
            $builder->where('DATE(tbl_recruiter.client_fees_reg_date) <=', $end_date);
        }

        return $builder->countAllResults();
    }

    public function CountFreeClientDisplay($start_date = null, $end_date = null)
    {
        $builder = $this->db->table('tbl_recruiter');

        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left')
            ->join('cities', 'cities.id = tbl_recruiter.city_id', 'left')
            ->where('tbl_recruiter.client_reg_type', 'free');

        // ✅ date filter
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(tbl_recruiter.created_date) >=', $start_date);
            $builder->where('DATE(tbl_recruiter.created_date) <=', $end_date);
        }

        return $builder->countAllResults();
    }
    public function getAdvancedClientCount()
    {
        $builder = $this->db->table('tbl_recruiter');
        $builder->join('tbl_user', 'tbl_user.uid = tbl_recruiter.uid', 'left');
        $builder->join('cities', 'cities.id = tbl_recruiter.city_id', 'left');
        $builder->where('tbl_recruiter.advanced_payment >', 0);

        return $builder->countAllResults();
    }
    
    public function CountPostcloseVaciesdisplay($start_date = null,$end_date = null)
    {
        $builder = $this->db->table('tbl_candidate_job_status')
                            ->where('admin_candidate_status', 'Closed');

        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(joining_date) >=', $start_date);
            $builder->where('DATE(joining_date) <=', $end_date);
        }

        $query = $builder->get();
        return $query->getNumRows();
    }
    public function single_candidate_agreement_salary_edit($jobseeker_id,$job_status_id)
    {
        $builder = $this->db->table('tbl_candidate_job_status tcjs');
        $builder->select('tcjs.*, tj.*');
        $builder->join('tbl_jobseeker tj', 'tcjs.jobseeker_id = tj.jobseeker_id');
        $builder->where('tcjs.jobseeker_id', $jobseeker_id);
        $builder->where('tcjs.job_status_id ', $job_status_id);
        

        $query = $builder->get();  // run the query first
        
        return $query->getRowArray();
    }
    
    public function all_contact_details()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_contact');
        $builder->orderBy('tbl_contact.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function addawardData($data)
    {
        // $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_award')->insert($data);
        // echo $this->db->getLastQuery(); exit();
           return $query;
    }
      public function single_award_edit($award_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_award');

        $row = $builder->where('award_id', $award_id)->get()->getRowArray();

        return $row;
    }
    
     public function display_lead_role()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_lead');
        $query = $builder->get()->getResultArray();;
        return $query;
    }
    // ===================22-07-2026 =========================

    public function all_registraion_candidate_insurance_policy()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_jobseeker js');
        $builder->select('
            js.*,
            c.name AS current_city_name,
            jr.job_role,
            cou.*,
            GROUP_CONCAT(ec.name SEPARATOR " ,") AS expected_city_names
        ');

        $builder->join('cities c', 'js.current_city = c.id', 'left');
        $builder->join('tbl_job_role jr', 'js.job_id = jr.job_id', 'left');
        $builder->join('tbl_course cou', 'js.course = cou.course_id', 'left');

        // Expected cities join
        $builder->join(
            'cities ec',
            'FIND_IN_SET(ec.id, js.expected_cities)',
            'left'
        );

        // Only education = 39 candidates
        $builder->where('js.education', 1);

        $builder->groupBy('js.jobseeker_id');
        $builder->orderBy('js.jobseeker_id', 'DESC');

        return $builder->get()->getResultArray();
    }
  

    

}