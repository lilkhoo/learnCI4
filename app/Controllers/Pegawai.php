<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
}
