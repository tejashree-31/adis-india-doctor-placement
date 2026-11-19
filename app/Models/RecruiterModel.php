<?php
namespace App\Models;
use CodeIgniter\Model;
class RecruiterModel extends Model
{
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function recruiterDetails($filedata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_recruiter')->insert($filedata);
        return $query;
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
    // public function getCoursesByQualification($qual_id)
    // {
    //     $this->db = \Config\Database::connect(); // Reuse same pattern
    //     $builder = $this->db->table('tbl_course');  // Your actual course table
    //     $builder->where('qual_id', $qual_id);
    //     $query = $builder->get();
    //     return $query->getResultArray(); // Returns course list
    // }
    
      public function getCoursesByQualification($qual_id)
        {
            $cacheKey = 'courses_' . $qual_id;
        
            if ($cachedData = cache($cacheKey)) {
                return $cachedData;
            }
        
            $db = \Config\Database::connect();
        
            $response = $db->table('tbl_course')
                            ->select('course_id, course_name')
                            ->where('qual_id', $qual_id)
                            ->orderBy('course_name', 'ASC')
                            ->get()
                            ->getResultArray();
        
            cache()->save($cacheKey, $response, 3600); // 1 Hour
            return $response;
        }
    public function recruiterPosting($postingdata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_recruiter_posting')->insert($postingdata);
        return $query;
    }
    public function getJobPostingWithLogo($user_id, $posting_id)
    {
        $builder = $this->db->table('tbl_recruiter_posting rp');
        $builder->select('
            rp.posting_id,
            rp.user_id,
            r.logo AS recruiter_logo,
            jr.job_role,
            c.name AS city_name,
            q.qualification_name,
            cr.course_name,
            d.department_name,
            rp.*
        ');
        $builder->join('tbl_recruiter r', 'r.uid = rp.user_id', 'left');
        $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id', 'left');
        $builder->join('cities c', 'rp.city_id = c.id', 'left');
        $builder->join('tbl_qualification q', 'rp.qual_id = q.qual_id', 'left');
        $builder->join('tbl_course cr', 'rp.course_id = cr.course_id', 'left');
        $builder->join('tbl_department d', 'rp.department_id = d.department_id', 'left');

        $builder->where('rp.user_id', $user_id);
        $builder->where('rp.posting_id', $posting_id);
        $builder->limit(1);

        return $builder->get()->getRowArray();
    }
    public function getPublishedJobsByUser($user_id, $status)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_recruiter_posting')
                  ->select('tbl_recruiter_posting.*, tbl_job_role.job_role')
                  ->join('tbl_job_role', 'tbl_recruiter_posting.job_id = tbl_job_role.job_id', 'left')
                  ->where('tbl_recruiter_posting.user_id', $user_id)
                  ->where('tbl_recruiter_posting.status', $status)
                  ->get()
                  ->getResultArray();
    }
    public function getpreviewJobsByUser($user_id, $status)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_recruiter_posting')
                  ->select('tbl_recruiter_posting.*, tbl_job_role.job_role')
                  ->join('tbl_job_role', 'tbl_recruiter_posting.job_id = tbl_job_role.job_id', 'left')
                  ->where('tbl_recruiter_posting.user_id', $user_id)
                  ->where('tbl_recruiter_posting.status', $status)
                  ->get()
                  ->getResultArray();
    }
}
