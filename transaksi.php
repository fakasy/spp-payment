
<?php
session_start();

// Memastikan bahwa pengguna telah login sebelum mengakses halaman ini
if (!isset($_SESSION['id_petugas'])) {
  header("Location: login.php");
  exit();
}

// Menghubungkan ke database
include('koneksi.php');

// Mendapatkan id_petugas dari sesi
$id_petugas = $_SESSION['id_petugas'];

// Jika ada form yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form
  $nisn = $_POST['nisn'];
  $tgl_bayar = $_POST['tgl_bayar'];
  $bulan_dibayar = $_POST['bulan_dibayar'];
  $tahun_dibayar = $_POST['tahun_dibayar'];
  $id_spp = $_POST['id_spp'];
  $jumlah_bayar = $_POST['jumlah_bayar'];

  // Lakukan proses penyimpanan data transaksi ke database
  // ...



                  $query = "INSERT INTO pembayaran VALUES ('','$id_petugas', '$nisn', '$tgl_bayar', '$bulan_dibayar', '$tahun_dibayar
                  ', '$id_spp', '$jumlah_bayar')";
                $result = mysqli_query($koneksi, $query);
                // periska query apakah ada error
                if(!$result){
                    die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
                          " - ".mysqli_error($koneksi));
                } else {
                  //tampil alert dan akan redirect ke halaman index.php
                  //silahkan ganti index.php sesuai halaman yang akan dituju
                  echo "<script>alert('Data berhasil ditambah.');window.location='transaksi.php';</script>";
                }

// Setelah proses penyimpanan selesai, Anda dapat melakukan redirect atau menampilkan pesan berhasil
// Contoh:
// header("Location: transaksi_berhasil.php");
// exit();
  
}


?>


<?php
// memanggil file koneksi.php untuk membuat koneksi
include 'koneksi.php';




// mengecek apakah di url ada nilai GET id
if (isset($_GET['id'])) {
// ambil nilai id dari url dan disimpan dalam variabel $id
$id = ($_GET["id"]);

// menampilkan data dari database yang mempunyai id=$id
$query = "SELECT * FROM siswa,kelas,spp where siswa.nisn='$id' AND siswa.id_kelas=kelas.id_kelas AND siswa.id_spp=spp.id_spp";
$result = mysqli_query($koneksi, $query);
// jika data gagal diambil maka akan tampil error berikut
if(!$result){
  die ("Query Error: ".mysqli_errno($koneksi).
      " - ".mysqli_error($koneksi));
}
// mengambil data dari database
$data = mysqli_fetch_assoc($result);
  // apabila data tidak ada pada database maka akan dijalankan perintah ini
    if (!count($data)) {
      echo "<script>alert('Data tidak ditemukan pada database');window.location='siswa.php';</script>";
    }
} else {
// apabila tidak ada data GET id pada akan di redirect ke index.php
echo "<script>alert('Masukkan data id.');window.location='siswa.php';</script>";
}         
?>
<!DOCTYPE html>
<html>
<head>
<title>TRANSAKSI</title>

</head>
<body>

<?php

include ('tampilan/header.php');
include ('tampilan/footer.php');
include ('tampilan/sidebar.php');


?>

  <!-- main content -->
  <div class="main-content bg-primary">
      <section class="section">
        <div class="section-header">
          <h1>TRANSAKSI</h1>
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item text-primary">Transaksi</div>
          </div>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
          <h3>TRANSAKSI PEMBAYARAN</h3> 
                  <div class="card-header-form">
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          </div>
        </div>
        <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">id Petugas</span>
              </div>
              <!-- Masukkan nilai id petugas dari sesi dan atur input agar tidak bisa diedit -->
              <input type="text" name="id_petugas" class="form-control" placeholder="id petugas" aria-label="masukkan id petugas" aria-describedby="basic-addon1" value="<?php echo $id_petugas; ?>" readonly>
              </div>

              <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">NISN</span>
              </div>
              <input name="nisn" class="form-control"  value="<?php echo $data['nisn']; ?>"   />
              </div>

              <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Tanggal Bayar</span>
              </div>
              <input type="date" name="tgl_bayar" class="form-control" placeholder="tgl_bayar" aria-label="tanggal" aria-describedby="basic-addon1">
              </div> 

            <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Bulan Bayar</label>
            </div>
            <select class="custom-select" name= "bulan_dibayar" id="inputGroupSelect01">
              <option selected>--pilih bulan--</option>
              <option value="januari">Januari</option>
              <option value="februari">Februari</option>
              <option value="maret">Maret</option>
              <option value="januari">April</option>
              <option value="februari">Mei</option>
              <option value="maret">Juni</option>
              <option value="januari">Juli</option>
              <option value="februari">Agustus</option>
              <option value="maret">September</option>
              <option value="januari">oktober</option>
              <option value="februari">november</option>
              <option value="maret">desember</option>
            </select>
          </div>  

            <div class="input-group mb-1 p-2">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Tahun Bayar</label>
              </div>
              <select class="custom-select" name="tahun_dibayar" id="inputGroupSelect01">
                <option selected>--pilih tahun--</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
              </select>
            </div>

            <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">ID SPP</span>
              </div>
              <input type="text" name="id_spp" class="form-control" placeholder="id spp" aria-label="masukkan id" aria-describedby="basic-addon1 " value="<?php echo $data['id_spp']; ?>"  readonly     >
              </div>

              <div class="input-group mb-1 p-2">
            <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">jumlah</span>
              </div>
              <input type="text" name="jumlah_bayar" class="form-control" placeholder="jumlah bayar" aria-label="masukkan nominal" aria-describedby="basic-addon1" value="<?php echo $data['jumlah_bayar']; ?>">
              </div>

          <div class="d-flex justify-content-center ">
            <button type="submit" class="btn btn-success ">Bayar</button>


          </form>
          </div>
          <br/> 
              <?php 
              // if (isset($_GET['nisn']) && $_GET['nisn']!='') {
              //   $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$_GET[nisn]'");
              //   $data = mysqli_fetch_array($query);
              //   $nisn = $data['nisn'];
            
            ?>
    
            <h2 class="align-center">DATA SISWA</h2>
            <table class="table table-striped  col-12 p-3">
              <thead>
                <tr>
                  <th scope="col">NISN</th>
                  <th scope="col">NAMA SISWA</th>
                  <th scope="col">KELAS</th>
                  
                </tr>
              </thead>
              <tbody>
                <td><?php echo $data['nisn']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['nama_kelas']; ?></td>
              </tbody>
            </table>

            <h2>DATA SPP SISWA</h2>
          <table class="table table-striped  col-12 p-3">
            <thead> 
              <tr>
                <!-- <th scope="col">Id Pembayaran</th> -->
            <th scope="col">id petugas</th>
            <th scope="col"> NISN</th>
            <th scope="col">Tgl Bayar</th>
            <th scope="col">Bulan Bayar</th>
            <th scope="col">Tahun Bayar</th>
            <th scope="col">id spp</th>
            <th scope="col">Jumlah</th>
            
              </tr>
            </thead>

            <tbody>
              <?php 
              $query = mysqli_query($koneksi,"SELECT * FROM pembayaran WHERE nisn='$data[nisn]' ORDER BY bulan_dibayar ASC");
            

              while ($data=mysqli_fetch_array($query)) {
                echo" <tr>
                      
                      <td>$data[id_petugas]</td>
                      <td>$data[nisn]</td>
                      <td>$data[tgl_bayar]</td>
                      <td>$data[bulan_dibayar]</td>
                      <td>$data[tahun_dibayar]</td>
                      <td>$data[id_spp]</td>
                      <td>$data[jumlah_bayar]</td>

                    </tr>";
              }

                ?>

            </tbody>

          </table>  
            
<?php 
// }
?>      
    
    </div>
</body>
</html>