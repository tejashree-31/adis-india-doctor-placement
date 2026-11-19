<?php
namespace App\Models;
use CodeIgniter\Model;
class JobseekerModel extends Model
{
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function userDeatails($filedata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $this->db->table('tbl_user')->insert($filedata);
        return $this->db->insertID();
    }
    public function userupdateDeatails($user_id,$data)
    {
        $this->db = \Config\Database::connect(); 
        $update_query = $this->db->table('tbl_user');
                        $update_query->set($data); // set values to update
                        $update_query->where('uid', $user_id); 
                        $update_query->update();
        return $update_query; 
    }
    public function saveJobseekerForm($jobseekerForm)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_jobseeker')->insert($jobseekerForm);
        return $query;
    }
    public function getjobseekerSearchingDetailsEducation($education,$course,$uid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_jobseeker AS js');
                $builder->select('
                    js.course AS jobseeker_course,
                    js.education AS jobseeker_education,
                    js.jobseeker_id,
                    rp.*,
                    r.*,
                    u.*,
                    jr.job_role,
                    q.qualification_name,
                    c.course_name,
                    city.name AS city_name
                ');
                $builder->join(
                    'tbl_recruiter_posting AS rp',
                    'js.education = rp.qual_id AND js.course = rp.course_id',
                    'left'
                );
                $builder->join('tbl_recruiter AS r', 'rp.user_id = r.uid', 'left');
                $builder->join('tbl_user AS u', 'r.uid = u.uid', 'left');
                $builder->join('tbl_job_role AS jr', 'rp.job_id = jr.job_id', 'left');
                $builder->join('tbl_qualification AS q', 'rp.qual_id = q.qual_id', 'left');
                $builder->join('tbl_course AS c', 'rp.course_id = c.course_id', 'left');
                $builder->join('cities AS city', 'rp.city_id = city.id', 'left');

                // 🔹 Exclude jobs if already in tbl_candidate_job_status
               $builder->join(
                    'tbl_candidate_job_status AS cjs',
                    'cjs.posting_id = rp.posting_id AND cjs.jobseeker_id = js.jobseeker_id',
                    'left'
                );
                $builder->where('cjs.posting_id IS NULL'); 
                $builder->where('js.uid', $uid);

                // dynamic where
                $builder->where('js.education', $education);
                $builder->where('js.course', $course);

                $query = $builder->get();  
                return $query->getResultArray();

    }
      public function getjobseekerSearchingDetailsEducationJobid($job_ids, $uid)
    {
        $db = \Config\Database::connect();

        if (!is_array($job_ids)) {
            $job_ids = explode(',', $job_ids); // convert comma-separated string to array
        }

        $keywords = [];

        // Step 1: Fetch job_role for each job_id
        foreach ($job_ids as $id) {
            $id = trim($id);
            if (!empty($id)) {
                $jobRoleRow = $db->table('tbl_job_role')
                                 ->select('job_role')
                                 ->where('job_id', $id)
                                 ->get()
                                 ->getRow();

                if ($jobRoleRow) {
                    $keywords = array_merge($keywords, explode(' ', $jobRoleRow->job_role));
                }
            }
        }

        // Remove duplicate and empty keywords
        $keywords = array_filter(array_unique(array_map('trim', $keywords)));

        if (empty($keywords)) {
            return [];
        }

        // Step 2: Find all job_ids that match the keywords, restrict only to given job_ids
        $subQuery = $db->table('tbl_job_role')->select('job_id');
        $subQuery->groupStart();
        foreach ($keywords as $word) {
            $subQuery->orLike('job_role', $word);
        }
        $subQuery->groupEnd();
        $subQuery->whereIn('job_id', $job_ids); 

        $jobIdsArray = array_column($subQuery->get()->getResultArray(), 'job_id');

        if (empty($jobIdsArray)) {
            return [];
        }

        // Step 3: Fetch recruiter postings for matched job_ids
        $builder = $db->table('tbl_recruiter_posting AS rp');
        $builder->select('rp.*, jr.job_role, u.uid, r.*, cities.name AS city_name');
        $builder->join('tbl_job_role AS jr', 'rp.job_id = jr.job_id', 'left');
        $builder->join('tbl_user AS u', 'rp.user_id = u.uid', 'left');
        $builder->join('tbl_recruiter AS r', 'rp.user_id = r.uid', 'left');
        $builder->join('cities', 'rp.city_id = cities.id', 'left');

        $builder->whereIn('rp.job_id', $jobIdsArray);
        // ✅ Add this condition to only get published jobs
        $builder->where('rp.status', 'Publish');
        $builder->where('rp.admin_status', 'Open');
        $builder->where('rp.posting_status','Post Active');
        $query = $builder->get();
        // echo $db->getLastQuery();
        // exit();
        return $query->getResultArray();
    }
    
    public function jobseekerEdit($uid)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_jobseeker as js')
            ->select('js.*, c.name as city_name')
            ->join('cities as c', 'c.id = js.current_city', 'left') // left join to include jobseeker even if city is null
            ->where('js.uid', $uid)
            ->get()
            ->getRowArray();

    }
    
    public function save_job_jobseeker($jobseeker_id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_recruiter_posting AS rp');
        $builder->select('rp.*,jr.job_role,r.*,u.*,cities.name AS city_name,cjs.candidate_status '); $builder->join('tbl_job_role AS jr', 'rp.job_id = jr.job_id', 'left');
        $builder->join('tbl_recruiter AS r', 'rp.user_id = r.uid', 'left');
        $builder->join('tbl_user AS u', 'r.uid = u.uid', 'left'); // 👈 join recruiter with user
        $builder->join('cities', 'rp.city_id = cities.id', 'left');
        $builder->join('tbl_candidate_job_status AS cjs', 'cjs.posting_id = rp.posting_id', 'left');
        $builder->where('cjs.jobseeker_id', $jobseeker_id);
        $builder->where('cjs.candidate_status','Save Job');
         $builder->where('rp.status', 'Publish');
        $builder->orderBy('rp.posting_id', 'DESC');

        $query = $builder->get();
        // echo $db->getLastQuery();
        // exit();
        // Debug if needed:
        // echo '<pre>'; print_r($db->getLastQuery()->getQuery()); die;
        return $query->getResultArray();
    }
   
    public function applied_job_jobseeker($jobseeker_id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_recruiter_posting AS rp');
        $builder->select('rp.*,jr.job_role,r.*,u.*,cities.name AS city_name,cjs.candidate_status '); $builder->join('tbl_job_role AS jr', 'rp.job_id = jr.job_id', 'left');
        $builder->join('tbl_recruiter AS r', 'rp.user_id = r.uid', 'left');
        $builder->join('tbl_user AS u', 'r.uid = u.uid', 'left'); // 👈 join recruiter with user
        $builder->join('cities', 'rp.city_id = cities.id', 'left');
        $builder->join('tbl_candidate_job_status AS cjs', 'cjs.posting_id = rp.posting_id', 'left');
        $builder->where('cjs.jobseeker_id', $jobseeker_id);
        $builder->where('cjs.candidate_status', 'Apply Job');
         $builder->where('rp.status', 'Publish');
         $builder->where('rp.posting_status','Post Active');
        $builder->orderBy('rp.posting_id', 'DESC');
     
        $query = $builder->get();
    
        return $query->getResultArray();
    }

    public function getResumePreviewData($uid)
    {
        $db = \Config\Database::connect();

        return $db->table('tbl_jobseeker js')
        ->select("
            js.*,
            c.name AS city_name,
            jr.job_role,
            tq.qualification_name,
            tc.course_name,

            ug.ug_name,
            pg.pg_name,
            intd.inq_name,
            sup.superspeciality_name,

            GROUP_CONCAT(tl.language_name ORDER BY tl.language_name SEPARATOR ', ') AS language_names
        ")
        ->join('cities c', 'c.id = js.current_city', 'left')
        ->join('tbl_job_role jr', 'jr.job_id = js.job_id', 'left')
        ->join('tbl_qualification tq', 'tq.qual_id = js.education', 'left')
        ->join('tbl_course tc', 'tc.course_id = js.course', 'left')

        ->join('tbl_ug_medical_degree ug', 'ug.ug_id = js.ug_id', 'left')
        ->join('tbl_post_degree pg', 'pg.pg_id = js.pg_id', 'left')
        ->join('tbl_international_degree intd', 'intd.int_degree_id = js.int_degree_id', 'left')
        ->join('tbl_superspeciality_degree sup', 'sup.sup_id = js.sup_id', 'left')

        ->join('tbl_languages tl', 'FIND_IN_SET(tl.lang_id, js.language_name) > 0', 'left', false)

        ->where('js.uid', $uid)
        ->groupBy('js.jobseeker_id')
        ->get()
        ->getRowArray();
    }

















    
}
