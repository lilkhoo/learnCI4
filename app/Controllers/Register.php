<?php

namespace App\Controllers;

class Register extends BaseController
{
   public function index()
   {
      return view('welcome_message');
   }

   public function coba()
   {
      echo "Hello World!";
   }
}
