<style>
   table th {
      background: #0c1c60 !important;
      color: #fff !important;
      border: 1px solid #ddd !important;
      line-height: 15px !important;
      text-align: center !important;
      vertical-align: middle !important;

   }

   table td {
      line-height: 15px !important;
      text-align: center !important;
      border: 1px solid;
   }
</style>

</head>

<body>
   <div class="container">
      <h2>Report Comics</h2>
      <table class="table table-striped table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Title</th>
               <th>Authors</th>
               <th>Publishers</th>
            </tr>
         </thead>
         <tbody>
            <?php $i = 1; ?>
            <?php foreach ($comic as $c) : ?>
               <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $c["title"]; ?></td>
                  <td><?= $c["author"]; ?></td>
                  <td><?= $c["publisher"]; ?></td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</body>

</html>