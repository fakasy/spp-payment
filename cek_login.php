<?php 
// Mengaktifkan session pada PHP
session_start();

// Menghubungkan PHP dengan koneksi database
include 'koneksi.php';

// Menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Menyeleksi data petugas dengan username dan password yang sesuai
$login = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// Cek apakah username dan password ditemukan pada database
if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);
    
    // Memasukkan informasi id_petugas ke dalam sesi
    $_SESSION['id_petugas'] = $data['id_petugas'];

    // Cek level user yang login
    if ($data['level'] == "admin") {
        // Buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        // Alihkan ke halaman dashboard admin
        header("location:dashboard.php");
    } elseif ($data['level'] == "petugas") {
        // Buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "petugas";
        // Alihkan ke halaman dashboard petugas
        header("location:dashboard.php");
    } elseif ($data['level'] == "siswa") {
        // Buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "siswa";
        // Alihkan ke halaman dashboard siswa
        header("location:history.php");
    } else {
        // Alihkan ke halaman login kembali jika level tidak valid
        header("location:index.php?pesan=gagal");
    }
} else {
    // Alihkan ke halaman login kembali jika username atau password tidak cocok
    header("location:index.php?pesan=gagal");
}
?>
