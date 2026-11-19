<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{

	protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function daily_training_records()
    {
        $today = date('Y-m-d');
        $db = \Config\Database::connect();

        $query= $this->db->table('tbl_trainer_enquery tre')
        ->select('tre.*,to.*,cty.*')
        ->join('tbl_organisation to', 'tre.o_id = to.o_id')
        ->join('cities cty','tre.city_id = cty.id')
        ->where('DATE(tre.created_at)', $today)
        ->orderBy('tre.id_trainer_enquery','DESC')
        ->get()
        ->getResultArray();

        return $query;

    }
    public function all_training_records()
    {
        $today = date('Y-m-d');
        $db = \Config\Database::connect();
        $query= $this->db->table('tbl_trainer_enquery tre')
        ->select('tre.*,to.*,cty.*')
        ->join('tbl_organisation to', 'tre.o_id = to.o_id')
        ->join('cities cty','tre.city_id = cty.id')
        ->orderBy('tre.id_trainer_enquery','DESC')
        ->get()
        ->getResultArray();

        return $query;

    }
}