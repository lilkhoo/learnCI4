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
      <h2>Laporan Data Karyawan</h2>
      <table class="table table-striped table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Address</th>
            </tr>
         </thead>
         <tbody>
            <?php $i = 1; ?>
            <?php foreach ($pegawai as $p) : ?>
               <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $p["name"]; ?></td>
                  <td><?= $p["address"]; ?></td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</body>

</html>