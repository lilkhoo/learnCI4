<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PegawaiSeeder extends Seeder
{
   public function run()
   {
      // $data = [
      //    [
      //       'name' => 'Eko Setyono Wibowo',
      //       'address' => 'Jln.Veteran III Tapos',
      //       'created_at' => Time::now(),
      //       'updated_at' => Time::now(),
      //    ],
      //    [
      //       'name' => 'Eko Kurniawan Khannedy',
      //       'address' => 'Jln. Pegangsaan Timur',
      //       'created_at' => Time::now(),
      //       'updated_at' => Time::now(),
      //    ],
      //    [
      //       'name' => 'John Hendric Tierison',
      //       'address' => 'Jln.Raden mas kusuma',
      //       'created_at' => Time::now(),
      //       'updated_at' => Time::now(),
      //    ]
      // ];
      $faker = \Faker\Factory::create('id_ID');

      for ($i = 0; $i < 100; $i++) {

         $data = [
            "name" => $faker->name(),
            "email" => $faker->email(),
            "password" => "password",
            "address" => $faker->address(),
            "created_at" => Time::now(),
            "updated_at" => Time::now(),
         ];

         $this->db->table('pegawai')->insert($data);
      }

      // Simple Queries
      // $this->db->query('INSERT INTO pegawai (name, address, created_at, updated_at) VALUES(:name:, :address:, :created_at:, :updated_at:)', $data);

      // Using Query Builder
      // $this->db->table('pegawai')->insert($data);
   }
}
