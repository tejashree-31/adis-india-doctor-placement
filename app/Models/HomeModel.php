<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    
    public function userDeatails($filedata)
    {
        $this->db = \Config\Database::connect(); // Only needed if not set in constructor
        $query = $this->db->table('tbl_user')->insert($filedata);
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

}
