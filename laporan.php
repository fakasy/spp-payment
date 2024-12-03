<?php
include('koneksi.php'); // Menghubungkan dengan database

?>
<!DOCTYPE html>
<html>

<head>
  <title>LAPORAN</title>
  <style>
    .laporan {
      margin-left: 30px;
      margin-bottom: 10px;
      border-radius: 50%;
      display: flex;
    }

    .laporan label {
      margin-right: 10px;
      /* jarak antara label */
    }

    .laporan button {
      margin-left: 25px;
      /* jarak antara input tanggal dan tombol */
    }
  </style>
</head>

<body>

  <?php
  include('tampilan/header.php');
  include('tampilan/footer.php');
  include('tampilan/sidebar.php');
  ?>

  <!-- Main Content -->
  <div class="main-content bg-primary">
    <section class="section">
      <div class="section-header">
        <h1>LAPORAN</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item text-primary">Laporan</div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4>LAPORAN TRANSAKSI</h4>
          <div class="card-header-form">
          </div>
        </div>
        <form method="POST" action="ekspor.php" enctype="multipart/form-data">
          <div class="laporan">
            <label for="daritanggal">Dari Tanggal</label>
            <input id="daritanggal" type="date" name="daritanggal" autofocus="" required="" />

            <label style="margin-left: 25px;" for="sampaitanggal">Sampai Tanggal</label>
            <input id="sampaitanggal" type="date" name="sampaitanggal" required="" />

            <button class="btn btn-success" type="submit">Ekspor ke Word</button>
          </div>
        </form>
        <br>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <table class="table table-striped">

                <thead>
                  <tr>
                    <th scope="col">Nama Petugas</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Tgl Bayar</th>
                    <th scope="col">ID SPP</th>
                    <th scope="col">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "
                  SELECT pembayaran.id_petugas, petugas.nama_petugas, pembayaran.nisn, pembayaran.tgl_bayar, pembayaran.id_spp, pembayaran.jumlah_bayar, siswa.nama
                  FROM pembayaran
                  JOIN siswa ON pembayaran.nisn = siswa.nisn
                  JOIN petugas ON pembayaran.id_petugas = petugas.id_petugas
                  ";
                  $result = mysqli_query($koneksi, $query);

                  if (!$result) {
                    die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
                  }

                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tr>
                      <td><?php echo $row['nama_petugas']; ?></td>
                      <td><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['nisn']; ?></td>
                      <td><?php echo $row['tgl_bayar']; ?></td>
                      <td><?php echo $row['id_spp']; ?></td>
                      <td><?php echo $row['jumlah_bayar']; ?></td>
                    </tr>
                  <?php
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
    </section>
  </div>
</body>

</html>