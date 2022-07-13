<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
   protected $table = "pegawai";
   protected $useTimestamps = true;

   protected $allowedFields = ["name", "address"];
}
