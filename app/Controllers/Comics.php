<?php

namespace App\Controllers;

use App\Models\ComicModel;

class Comics extends BaseController
{

   protected $comicModel;

   public function __construct()
   {
      $this->comicModel = new ComicModel();
   }


   public function index()
   {
      // $comic = $this->comicModel->findAll();

      $data = [
         "title" => "Daftar Komik",
         "comic" => $this->comicModel->getComic(),
      ];

      // $comicModel = new ComicModel();

      return view("comic/index", $data);
   }

   public function detail($slug)
   {
      $data = [
         "title" => "Detail Comic",
         "comic" => $this->comicModel->getComic($slug),
      ];

      //  Jika Komik Tidak Ada di Tabel
      if (empty($data["comic"])) {
         // Throw Error
         throw new \CodeIgniter\Exceptions\PageNotFoundException("Comic slug " . $slug . " Not Found");
      }


      return view("comic/detail", $data);
   }


   public function create()
   {
      // session();  Tidak Perlu ditulis karena sudah ada di base controller
      $data = [
         "title" => "Create Comic",
         "validation" => \Config\Services::validation()
         // "comic" => $this->comicModel->findAll()
      ];

      return view("comic/create", $data);
   }

   public function save()
   {

      // Validasi Input
      if (!$this->validate([
         "title" => [
            "rules" => "required|is_unique[comic.title]",
            "errors" => [
               "required" => "The Comic {field} Must be Filled",
               "is_unique" => "Comic {field} Already Exist"
            ]
         ],
         "author" => [
            "rules" => "required",
            "errors" => [
               "required" => "The {field} Must be Filled",
            ]
         ],
         "publisher" => [
            "rules" => "required",
            "errors" => [
               "required" => "The {field} Must be Filled"
            ]
         ],
         "cover" => [
            "rules" => "max_size[cover,10024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]",
            "errors" => [
               "max_size" => "Size images is too Large",
               "is_image" => "What You Choosen is not Image",
               "mime_in" => "What You Choosen is not Image",
            ]
         ],

      ])) {
         return redirect()->to("/pages/comic/create")->withInput();
      }
      // Ambil Gambar untuk di input kedalam database
      $coverFile = $this->request->getFile("cover");

      // Jika user tidak upload gambar, maka masukkan gambar default
      if ($coverFile->getError() == 4) {
         $coverName = "default.jpg";
      } else {
         // Generate coverName random
         $coverName = $coverFile->getRandomName();

         // Pindahkan File Ke Folder IMG
         $coverFile->move("img", $coverName);
      }



      $slug = url_title($this->request->getVar("title"), '-', true);

      $this->comicModel->save([
         "title" => $this->request->getVar("title"),
         "slug" => $slug,
         "author" => $this->request->getVar("author"),
         "publisher" => $this->request->getVar("publisher"),
         "cover" => $coverName,
      ]);

      session()->setFlashdata("message", "Added Comic Successfully");

      return redirect()->to("/pages/comic");
   }

   public function delete($id)
   {
      // Cari Gambar Berdasarkan ID
      $comic = $this->comicModel->find($id);

      // Cek Jika File Gambarnya Default
      if ($comic["cover"] != "default.jpg") {

         // Hapus Gambar 
         unlink("img/" . $comic["cover"]);
      }


      $this->comicModel->delete($id);

      session()->setFlashdata("message", "Deleted Comic Successfully");

      return redirect()->to("/pages/comic");
   }

   public function edit($slug)
   {
      $data = [
         "title" => "Edit Comic",
         "validation" => \Config\Services::validation(),
         "comic" => $this->comicModel->getComic($slug)
      ];

      return view("comic/edit", $data);
   }

   public function update($id)
   {


      // Cek Validasi jika judul lama tidak diganti
      $oldComic = $this->comicModel->getComic($this->request->getVar("slug"));
      if ($oldComic["title"] == $this->request->getVar("title")) {
         $rule_title = "required";
      } else {
         $rule_title = "required|is_unique[comic.title]";
      }


      // Validasi Input
      if (!$this->validate([
         "title" => [
            "rules" => $rule_title,
            "errors" => [
               "required" => "The Comic {field} Must be Filled",
               "is_unique" => "Comic {field} Already Exist"
            ]
         ],
         "author" => [
            "rules" => "required",
            "errors" => [
               "required" => "The {field} Must be Filled",
            ]
         ],
         "publisher" => [
            "rules" => "required",
            "errors" => [
               "required" => "The {field} Must be Filled"
            ]
         ],
         "cover" => [
            "rules" => "max_size[cover,10024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]",
            "errors" => [
               "max_size" => "Size images is too Large",
               "is_image" => "What You Choosen is not Image",
               "mime_in" => "What You Choosen is not Image",
            ]
         ],
      ])) {


         return redirect()->to("/comic/edit/" . $this->request->getVar("slug"))->withInput();
      }

      $coverFile =  $this->request->getFile("cover");

      // Cek gambar, apakah tetap gambar lama
      if ($coverFile->getError() == 4) {
         $coverName = $this->request->getVar("oldCover");
      } else {
         // Generate Nama File Random
         $coverName = $coverFile->getRandomName();

         // Pindahkan gambar
         $coverFile->move("img", $coverName);

         // Hapus File Yang Lama
         unlink("img/" . $this->request->getVar("oldCover"));
      }

      $slug = url_title($this->request->getVar("title"), '-', true);

      $this->comicModel->save([
         "id" => $id,
         "title" => $this->request->getVar("title"),
         "slug" => $slug,
         "author" => $this->request->getVar("author"),
         "publisher" => $this->request->getVar("publisher"),
         "cover" => $coverName,
      ]);

      session()->setFlashdata("message", "Edited Comic Successfully");

      return redirect()->to("/pages/comic");
   }

   public function generatePDF()
   {
      $dompdf = new \Dompdf\Dompdf();
      $data = [
         "comic" => $this->comicModel->findAll() //data dari tabel pegawai
      ];

      // dd($data);

      $dompdf->loadHtml(view('pdf/comic-pdf', $data));
      $dompdf->setPaper('A4', 'portrait'); //ukuran kertas dan orientasi
      $dompdf->render();
      $dompdf->stream("report-comic"); //nama file pdf

      return redirect()->to("pages/comic"); //arahkan ke halaman pegawai index
   }
}
