<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPExcel;
use PHPExcel_IOFactory;

class Pegawai extends BaseController
{

   protected $pegawaiModel;

   public function __construct()
   {
      $this->pegawaiModel = new PegawaiModel();
   }

   public function index()
   {

      $currentPage = $this->request->getVar("page_pegawai") ? $this->request->getVar("page_pegawai") : 1;

      $data = [
         "title" => "List Pegawai",
         // "pegawai" => $this->pegawaiModel->findAll(),
         "pegawai" => $this->pegawaiModel->paginate(10, 'pegawai'),
         "pager" => $this->pegawaiModel->pager,
         "current_page" => $currentPage
      ];

      return view("pegawai/index", $data);
   }

   public function generate()
   {
      $dompdf = new \Dompdf\Dompdf();
      $data = [
         "pegawai" => $this->pegawaiModel->findAll() //data dari tabel pegawai
      ];

      // dd($data);

      $dompdf->loadHtml(view('pdf/pegawai-pdf', $data));
      $dompdf->setPaper('A4', 'portrait'); //ukuran kertas dan orientasi
      $dompdf->render();
      $dompdf->stream("laporan-pegawai"); //nama file pdf

      return redirect()->to("pages/employee"); //arahkan ke halaman pegawai index
   }

   public function exportExcel()
   {
      $pegawai = new PegawaiModel();
      $dataPegawai = $pegawai->findAll();

      $spreadsheet = new Spreadsheet();
      // tulis header/nama kolom 
      $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue('A1', 'Name')
         ->setCellValue('B1', 'Address');

      $column = 2;
      // tulis data pegawai ke cell
      foreach ($dataPegawai as $data) {
         $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, $data['name'])
            ->setCellValue('B' . $column, $data['address']);
         $column++;
      }
      // tulis dalam format .xlsx
      $writer = new Xlsx($spreadsheet);
      $fileName = 'Data Pegawai';

      // Redirect hasil generate xlsx ke web client
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
   }

   public function spreadsheet_import()
   {
      $upload_file = $_FILES['upload_file']['name'];
      $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
      if ($extension == 'csv') {
         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
      } elseif ($extension == 'xls') {
         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
      } else {
         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }

      $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
      $sheetdata = $spreadsheet->getActiveSheet()->toArray();

      $sheetcount = count($sheetdata);
      if ($sheetcount > 1) {

         $data = array();
         for ($i = 1; $i < $sheetcount; $i++) {
            $pegawai_name = $sheetdata[$i][0];
            $pegawai_email = $sheetdata[$i][1];
            $pegawai_address = $sheetdata[$i][2];
            $pegawai_password = $sheetdata[$i][3];
            $pegawai_createdAt = $sheetdata[$i][4];
            $pegawai_updatedAt = $sheetdata[$i][5];

            $data[] = array(
               "name" => $pegawai_name,
               "email" => $pegawai_email,
               "address" => $pegawai_address,
               "password" => $pegawai_password,
               "created_at" => $pegawai_createdAt,
               "updated_at" => $pegawai_updatedAt
            );
         }

         $insertdata = $this->pegawaiModel->insertBatch($data);

         if ($insertdata) {
            session()->setFlashdata("message", "AYEY");

            return redirect()->to("/pages/employee");
         } else {
            session()->setFlashdata("message", "gagal");

            return redirect()->to("/pages/employee");
         }
      }
   }
}
