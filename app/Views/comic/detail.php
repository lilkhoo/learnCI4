<?= $this->extend("layouts/template"); ?>

<?= $this->section("content"); ?>

<div class="container">
   <div class="row">
      <div class="col">

         <h2 class="mt-2">Detail Comic | <?= $comic["title"]; ?></h2>

         <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
               <div class="col-md-4">
                  <img src="/img/<?= $comic["cover"]; ?>" class="card-img" alt="...">
               </div>
               <div class="col-md-8">
                  <div class="card-body">
                     <h5 class="card-title"><?= $comic["title"]; ?></h5>
                     <p class="card-text"><b>Author : </b><?= $comic["author"]; ?></p>
                     <p class="card-text"><b>Publisher : </b><?= $comic["publisher"]; ?></p>
                     <!-- <p class="card-text"><small class="text-muted"></small></p> -->

                     <a href="/comic/edit/<?= $comic["slug"]; ?>" class="btn btn-warning">Edit</a>

                     <!-- FORM DELETE -->
                     <form action="/comic/<?= $comic["id"]; ?>" method="post" class="d-inline" onclick="return confirm('Delete This Comic?');">

                        <?= csrf_field(); ?>

                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">Delete</button>
                     </form>

                     <br><br><br>
                     <a href="/pages/comic" class="btn btn-primary">Back</a>

                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>
</div>

<?= $this->endSection(); ?>