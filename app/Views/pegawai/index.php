<?= $this->extend("layouts/template"); ?>

<?= $this->section("content"); ?>

<div class="container">
   <div class="row">
      <div class="col-sm-4 my-2">
         <a href="/employee/laporan-pegawai" class="btn btn-danger">EXPORT PDF</a>
         <a href="/employee/pegawai-excel" class="btn btn-success">EXPORT EXCEL</a>
      </div>
   </div>
</div>

<div class="container">
   <div class="row">
      <div class="col">
         <h1 class="mt-2">List Pegawai</h1>

         <table class="table table-striped table-dark">
            <thead>
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">Name</th>
                  <th scope="col">Address</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $i = 1;
               ?>

               <?php foreach ($pegawai as $p) : ?>
                  <tr>
                     <th scope="row"><?= $i++; ?></th>
                     <td><?= $p["name"]; ?></td>
                     <td><?= $p["address"]; ?></td>
                     <td>
                        <a href="" class="btn btn-success">Detail</a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
         <?= $pager->links('pegawai', 'pegawai_pagination'); ?>
      </div>
   </div>
</div>

<?= $this->endSection(); ?>