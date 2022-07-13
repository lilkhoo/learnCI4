<?php

namespace App\Controllers;

class Pages extends BaseController
{
   public function index()
   {
      // $faker = \Faker\Factory::create();
      // dd($faker->address());
      
      $data = [
         "title" => "Home | WeBowoCI",
         "test" => ["satu", "dua", "tiga"],
      ];

      return view("pages/home", $data);
   }

   public function about()
   {
      $data = [
         "title" => "About | WeBowoCI",
      ];

      return view("pages/about", $data);
   }

   public function contact()
   {
      $data = [
         "title" => "Contact Me | WeBowoCI",
         "alamat" => [
            [
               "tipe" => "Rumah",
               "alamat" => "Jln.Veteran",
               "kota" => "Bogor"
            ],
            [
               "tipe" => "Kantor",
               "alamat" => "Jln.Fatmawati",
               "kota" => "Jakarta Selatan"
            ],
         ]
      ];

      return view("pages/contact", $data);
   }
}
