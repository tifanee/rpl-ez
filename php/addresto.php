<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: ../index.php");
  exit;
}
require 'functions.php';

// Ambil data dari URL
$id = (int)$_GET["id"];

$user = query("SELECT * FROM tb_user WHERE id = $id")[0];

if (isset($_POST["addresto"])) {
  if (addResto($_POST, $id) > 0) {
    echo "<script LANGUAGE='JavaScript'>
              window.alert('Restoran kesayanganmu telah didaftarkan!');
              window.location.href='index2.php?id=$id';
              </script>";
  } else {
    echo pg_errormessage($koneksi);
  }
}

?>



<!DOCTYPE html>
<html>

<head>
  <title>Tambah Resto</title>
  <link rel="stylesheet" href="../frontend/css/addresto.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="ezeats">
    <br /><br /><br /><br />
    <h1>Restoran kesayanganmu belum ada di EzEats?</h1>
    <h2>Tambah Sekarang!</h2>
  </div>
  <div class="container-form">
    <form action="" method="post" enctype="multipart/form-data">
      <img src="../frontend/img/ezeatsred.png" />
      <h3>Detail Restoran</h3>
      <input type="text" class="isian-form" id="namaresto" name="namaresto" placeholder="Nama Restoran" required />
      <input type="tel" class="isian-form" id="notelpon" name="no-telp" placeholder="No. Telepon, eg: 081234567890" required />
      <div class="select">
        <select name="kategori" id="kategori" required>
          <option selected disabled>Kategori Resto</option>
          <option value="Japanese" name="japanese">Japanese</option>
          <option value="Chicken" name="chicken">Chicken</option>
          <option value="Indonesian" name="indonesian">Indonesian</option>
          <option value="Fast-Food" name="fastfood">Fast Food</option>
          <option value="Noodles" name="noodles">Noodles</option>
          <option value="Drinks" name="drinks">Drinks</option>
          <option value="Korean" name="korean">Korean</option>
        </select>
      </div>
      <input class="isian-form-jambuka" type="time" id="jambuka" name="jambuka" min="00:00" max="23:59" required />
      <label for="isian-form-jambuka">Waktu Buka</label>
      <input class="isian-form-jambuka" type="time" id="jamtutup" name="jamtutup" min="00:00" max="23:59" required />
      <label for="isian-form-jambuka">Waktu Tutup</label>
      <input type="text" class="isian-form" id="fasilitas" name="fasilitas" placeholder="Fasilitas" />

      <input type="text" class="isian-form" id="harga" name="harga" placeholder="Rentang Harga, eg: 100.000 - 150.000" required />
      <input type="text" class="isian-form" id="deskripsi" name="deskripsi" placeholder="Deskripsi" />
      <h3>Foto Restoran</h3>
      <input type="file" class="foto-resto" id="file" name="fotoresto" />
      <h3>Foto Menu</h3>
      <div class="inputmenu">
        <input type="file" class="foto-menu" name="fotomenu" id="file" />
      </div>
      <h3>Alamat</h3>
      <input type="text" class="isian-form" name="jalan" id="namajalanresto" placeholder="Nama Jalan" required />
      <input type="text" class="isian-form" id="namakec" name="namakec" placeholder="Nama Kecamatan" required />
      <div class="select">
        <select name="kotakab" id="kategori" required>
          <option selected disabled>Kota/Kabupaten</option>
          <option value="Kota" name="kota">Kota</option>
          <option value="Kabupaten" name="kabupaten">Kabupaten</option>
        </select>
      </div>
      <input type="text" class="isian-form" id="kotaresto" name="namakabkota" placeholder="Nama Kota/Kabupaten" required />
      <br />
      <button type="submit" name="addresto" class="button-submit">Submit</button>
    </form>
  </div>
</body>

</html>