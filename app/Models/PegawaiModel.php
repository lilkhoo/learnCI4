<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
   protected $table = "pegawai";
   protected $useTimestamps = true;

   protected $allowedFields = ["name", "email", "password", "address"];


   // public function insert_batch($data)
   // {
   //    $this->db->insert_batch("pegawai", $data);
   // }
}
