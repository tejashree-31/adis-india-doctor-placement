<?php
namespace App\Models;
use CodeIgniter\Model;
class ClintModel extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    public function latestJobqueryDetailsData()
    {
        $db = \Config\Database::connect();

        return $this->db->table('tbl_recruiter_posting rp')
        ->select('rp.job_id, jr.job_role, r.company_display_name, c.name AS city_name, rp.experience_min, rp.experience_max, rp.created_date,rp.posting_id,r.recruiter_id,r.uid,rp.salary_min,rp.salary_max,rp.salary_negotiation,td.department_name,id.industry_name')
        ->join('tbl_job_role jr', 'rp.job_id = jr.job_id')
        ->join('cities c', 'rp.city_id = c.id')
        ->join('tbl_recruiter r', 'rp.user_id = r.uid')
        ->join('tbl_department td','rp.department_id = td.department_id')
        ->join('tbl_industry id','r.industry_name = id.industry_id')
        ->where('rp.status','Publish') 
        ->where('rp.admin_status','Open')
        ->where('rp.posting_status','Post Active')
        ->orderBy('rp.created_date', 'DESC')
        ->limit(4)
        ->get()
        ->getResultArray();  // ✅ returns array
    }

    public function latestJobqueryDetailsData_search_posting($posting_id)
    {
         $db = \Config\Database::connect();

        return $this->db->table('tbl_recruiter_posting rp')
        ->select('rp.job_id, jr.job_role, r.company_display_name, c.name AS city_name, 
                  rp.experience_min, rp.experience_max, rp.created_date, 
                  rp.posting_id, r.recruiter_id, r.uid,rp.salary_max,rp.salary_min,rp.salary_negotiation')
        ->join('tbl_job_role jr', 'rp.job_id = jr.job_id')
        ->join('cities c', 'rp.city_id = c.id')
        ->join('tbl_recruiter r', 'rp.user_id = r.uid')
        ->where('rp.posting_id', $posting_id)   // ✅ condition added
        ->orderBy('rp.created_date', 'DESC')
        ->get()
        ->getResultArray();  // ✅ now returns ALL records
    }
    public function searching_display_jobs($jobRole, $locationId, $employmentType)
    {
        $builder = $this->db->table('tbl_recruiter_posting rp');
        $builder->select("rp.posting_id, rp.job_id, jr.job_role, r.company_display_name, c.name AS city_name, rp.experience_min, rp.experience_max, rp.employment_type, rp.created_date,r.recruiter_id,rp.salary_max,rp.salary_min,rp.salary_negotiation,td.department_name,id.industry_name");
        $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
        $builder->join('cities c', 'rp.city_id = c.id');
        $builder->join('tbl_recruiter r', 'rp.user_id = r.uid');
        $builder->join('tbl_department td','rp.department_id = td.department_id');
        $builder->join('tbl_industry id','r.industry_name = id.industry_id');
        if (!empty($jobRole)) {
            $builder->like('LOWER(jr.job_role)', strtolower($jobRole));
        }

        if (!empty($locationId)) {
            $builder->where('rp.city_id', $locationId);
        }

        if (!empty($employmentType)) {
            $builder->where('rp.employment_type', $employmentType);
        }
        $builder->where('rp.status', 'Publish');
        $builder->where('rp.admin_status', 'Open');
        $builder->where('rp.posting_status','Post Active');
        $builder->orderBy('rp.created_date', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function AllJboRoleDispalyData()
    {
        $this->db = \Config\Database::connect(); // Reuse same pattern
        $builder = $this->db->table('tbl_job_role');  // Your actual course table
        $query = $builder->get();
        return $query->getResultArray(); 
    }
    public function trending_jobs_display($job_id)
    {
        $this->db = \Config\Database::connect(); // Reuse same pattern
        
        $builder = $this->db->table('tbl_recruiter_posting rp');
        $builder->select("rp.posting_id, rp.job_id, jr.job_role, r.company_display_name, c.name AS city_name, rp.experience_min, rp.experience_max, rp.employment_type, rp.created_date,r.recruiter_id,rp.salary_max,rp.salary_min,rp.salary_negotiation,td.department_name,id.industry_name");
        $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
        $builder->join('cities c', 'rp.city_id = c.id');
        $builder->join('tbl_recruiter r', 'rp.user_id = r.uid');
        $builder->join('tbl_department td','rp.department_id = td.department_id');
        $builder->join('tbl_industry id','r.industry_name = id.industry_id');
        $builder->where('rp.status', 'Publish');
        $builder->where('rp.posting_status','Post Active');
        $builder->where('rp.admin_status', 'Open');
        $builder->where('rp.job_id', $job_id);
        $query = $builder->get();
      
        return $query->getResultArray();
    }
    public function blogs_data_display()
    {
        $db = \Config\Database::connect();
        $blogs = $db->table('tbl_blogs')
        ->select('*')
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get()
        ->getResultArray();

        return $blogs;
    }
    public function single_blogs_data_display($blog_id)
    {
        return $this->db->table('tbl_blogs')
            ->select('*')
            ->where('blog_id', $blog_id)
            ->get()
            ->getRowArray(); // single row as array
    }
    // public function searching_client_jobs($jobRole = null)
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $this->db->table('tbl_recruiter_posting rp');
    //   $builder->select("
    //         rp.posting_id,
    //         rp.job_id,
    //         jr.job_role,
    //         r.company_display_name,
    //         c.name AS city_name,
    //         rp.experience_min,
    //         rp.experience_max,
    //         rp.employment_type,
    //         rp.created_date,
    //         r.recruiter_id,
    //         rp.salary_max,
    //         rp.salary_min
    //     ");
    //     $builder->join('tbl_job_role jr', 'rp.job_id = jr.job_id');
    //     $builder->join('cities c', 'rp.city_id = c.id');
    //     $builder->join('tbl_recruiter r', 'rp.user_id = r.uid');

       
    //     if (!empty($jobRole)) {
    //         $builder->like('LOWER(jr.job_role)', strtolower($jobRole));
    //     }


    //     $builder->where('rp.status', 'Publish');
    //     $builder->where('rp.admin_status', 'Open');

       
    //     $builder->orderBy('rp.created_date', 'DESC');

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }
    
    public function getPaginatedJobs($jobRole = null, $perPage = 8)
    {
        $this->select("
            rp.posting_id,
            rp.job_id,
            jr.job_role,
            r.company_display_name,
            c.name AS city_name,
            rp.experience_min,
            rp.experience_max,
            rp.employment_type,
            rp.created_date,
            r.recruiter_id,
            rp.salary_max,
            rp.salary_min,
            rp.salary_negotiation,
            td.department_name,
            id.industry_name
        ")
        ->from('tbl_recruiter_posting rp')
        ->join('tbl_job_role jr', 'rp.job_id = jr.job_id')
        ->join('cities c', 'rp.city_id = c.id')
        ->join('tbl_recruiter r', 'rp.user_id = r.uid')
        ->join('tbl_department td','rp.department_id = td.department_id')
        ->join('tbl_industry id','r.industry_name = id.industry_id')
        ->where('rp.status', 'Publish')
        ->where('rp.admin_status', 'Open')
        ->where('rp.posting_status','Post Active')
        ->orderBy('rp.created_date', 'DESC')
        ->groupBy('rp.posting_id');  // ✅ prevents duplicates
    
        if (!empty($jobRole)) {
            $this->like('LOWER(jr.job_role)', strtolower($jobRole));
        }
    
        return $this->paginate($perPage);
    }
      // ===================== 17-10-2025 ============================
    public function saveContact($filedata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_contact')->insert($filedata);
        // echo $this->db->getLastQuery(); exit();
         return $query;
    }
    
     // ============= 28-02-2026 ==============================================

    public function latestThreeBlogsData()
    {
        $db = \Config\Database::connect();

        return $this->db->table('tbl_blogs')
        ->select('*')
        ->orderBy('created_at', 'DESC')
        ->limit(3)
        ->get()
        ->getResultArray();  // ✅ returns array
                   
    }
     public function award_data_display()
    {
        $db = \Config\Database::connect();
        $awards = $db->table('tbl_award')
        ->select('*')
        ->orderBy('created_at', 'DESC')
        ->limit(8)
        ->get()
        ->getResultArray();

        return $awards;
    }
    
     public function single_award_data_display($award_id)
    {
        return $this->db->table('tbl_award')
            ->select('*')
            ->where('award_id', $award_id)
            ->get()
            ->getRowArray(); // single row as array
    }
    
    
    
    
    
    
    

}


