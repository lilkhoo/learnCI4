<?= $this->extend("layouts/template"); ?>

<?= $this->section("content"); ?>

<div class="container">
   <div class="row">
      <div class="col">
         <a href="/pages/comic/create" class="btn btn-primary mt-3">Create Comic</a>
         <a href="/comic/report-comic" class="btn btn-danger mt-3">EXPORT PDF</a>
         <h1 class="mt-2">List Comics</h1>

         <?php if (session()->getFlashdata("message")) : ?>
            <div class="alert alert-success" role="alert">
               <?= session()->getFlashdata("message"); ?>
            </div>
         <?php endif; ?>

         <table class="table table-striped table-dark">
            <thead>
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">Cover</th>
                  <th scope="col">Title</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $i = 1;
               ?>

               <?php foreach ($comic as $c) : ?>
                  <tr>
                     <th scope="row"><?= $i++; ?></th>
                     <td><img src="/img/<?= $c["cover"]; ?>" alt="" class="cover"></td>
                     <td><?= $c["title"]; ?></td>
                     <td>
                        <a href="/comic/<?= $c["slug"]; ?>" class="btn btn-success">Detail</a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<?= $this->endSection(); ?>