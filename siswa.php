<?php
include('koneksi.php'); //agar index terhubung dengan database, maka koneksi sebagai penghubung harus di include

?>
<!DOCTYPE html>
<html>

<head>
  <title></title>

</head>

<body>

  <?php

  include('tampilan/header.php');
  include('tampilan/sidebar.php');
  include('tampilan/footer.php');
  ?>
  <!-- Main Content -->
  <div class="main-content bg-primary">
    <section class="section">
      <div class="section-header">
        <h1>DATA SISWA</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
          <div class="breadcrumb-item text-primary">Data Siswa</div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>LIST SISWA</h4>
              <div class="card-header-form">
                <form>
                  <div class="input-group-btn">
                    <a href="tambah_siswa.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <form action="" method="get">
                      <table class="table">
                        <tr>
                          <td>PENCARIAN</td>
                          <td>
                            <input class="form-control" type="text" name="nisn" placeholder="Masukkan NISN Siswa">
                          </td>
                          <td>
                            <button class="btn btn-success" type="submit" name="cari">Cari</button>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>


                  <?php
                  if (isset($_GET['nisn']) && $_GET['nisn'] != '') {
                    $query = mysqli_query($koneksi, "SELECT * FROM siswa,kelas WHERE nisn='$_GET[nisn]' AND siswa.id_kelas = kelas.id_kelas");
                    // Periksa apakah hasil query mengembalikan data atau tidak
                    if (mysqli_num_rows($query) > 0) {
                      $data = mysqli_fetch_array($query);
                      $nisn = $data['nisn'];
                  ?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-header">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>NISN</th>
                                    <th>NIS</th>
                                    <th>NAMA</th>
                                    <th>KELAS</th>
                                    <th>ALAMAT</th>
                                    <th>NO TELP</th>
                                    <th>ID SPP</th>
                                    <th>ACTION</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><?php echo $data['nisn']; ?></td>
                                    <td><?php echo $data['nis']; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kelas']; ?></td>
                                    <td><?php echo $data['alamat']; ?></td>
                                    <td><?php echo $data['no_telp']; ?></td>
                                    <td><?php echo substr($data['id_spp'], 0, 20); ?></td>
                                    <td>
                                      <a href="transaksi.php?id=<?php echo $data['nisn']; ?>" class="btn btn-primary"><i class="fas fa-book"></i></a>
                                      <a href="edit_siswa.php?id=<?php echo $data['nisn']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                      <a href="proses_hapussiswa.php?id=<?php echo $data['nisn']; ?>" class="btn btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          <?php
                        } else {
                          ?>
                            <div style="text-align: center;">
                              <p>Siswa tidak ditemukan.</p>
                            </div>
                        <?php
                        }
                      }
                        ?>
                          </div>
                        </div>
                      </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-header">
                            <div class="card-body p-0 ">
                                <div class="table-responsive ">
                                  <h2>DATA SISWA</h2>
                                  <table class="table table-striped ">
                                    <thead>
                                      <tr>
                                        <th>NISN</th>
                                        <th>NIS</th>
                                        <th>NAMA</th>
                                        <th>KELAS</th>
                                        <th>ALAMAT</th>
                                        <th>NO TELP</th>
                                        <th>ID SPP</th>
                                        <th>ACTION</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      // jalankan query untuk menampilkan semua data diurutkan berdasarkan id
                                      $query = "SELECT * FROM siswa,kelas,spp where siswa.id_kelas=kelas.id_kelas AND siswa.id_spp=spp.id_spp ORDER BY nama_kelas ASC";
                                      $result = mysqli_query($koneksi, $query);
                                      //mengecek apakah ada error ketika menjalankan query
                                      if (!$result) {
                                        die("Query Error: " . mysqli_errno($koneksi) .
                                          " - " . mysqli_error($koneksi));
                                      }

                                      //buat perulangan untuk element tabel dari data mahasiswa
                                      $no = 1; //variabel untuk membuat nomor urut
                                      // hasil query akan disimpan dalam variabel $data dalam bentuk array
                                      // kemudian dicetak dengan perulangan while
                                      while ($row = mysqli_fetch_assoc($result)) {
                                      ?>
                                        <tr>
                                          <td><?php echo $row['nisn']; ?></td>
                                          <td><?php echo $row['nis']; ?></td>
                                          <td><?php echo $row['nama']; ?></td>
                                          <td><?php echo $row['nama_kelas']; ?></td>
                                          <td><?php echo $row['alamat']; ?></td>
                                          <td><?php echo $row['no_telp']; ?></td>
                                          <td><?php echo substr($row['id_spp'], 0, 20); ?></td>
                                          <td>
                                            <a href="transaksi.php?id=<?php echo $row['nisn']; ?>" class="btn btn-primary"><i class="fas fa-book"></i></a>
                                            <a href="edit_siswa.php?id=<?php echo $row['nisn']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="proses_hapussiswa.php?id=<?php echo $row['nisn']; ?>" class="btn btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
                                          </td>
                                        </tr>
                                      <?php
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
    </section>
  </div>
</body>

</html>