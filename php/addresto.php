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
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.35" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css"
    />
    <link rel="stylesheet" type="text/css" href="../frontend/css/add-resto.css" />
    <link
      rel="stylesheet"
      type="text/css"
      href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200"
    />
    <title>Tambah Restoran - EzEats</title>
  </head>
  <body>
      <div class="profile-body">
        <div class="row justify-content-evenly">
          <div class="col-5">
            <h4>"Makanan bukan hanya masakan yang akan berakhir di perutmu, melainkan sebuah petualangan yang patut dinikmati dan dihargai"</h4>
            <br>
            <h4>--Winda Krisnadefa--</h4>
          </div>
          <div class="col-7 form">
            <form action="" method="post" enctype="multipart/form-data" class="row private-info">
                <img src="../frontend/img/logo ezeats red.png">

                <!--Detail Resto-->
                <h4>Detail Restoran</h4>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Nama Restoran</label>
                <input
                  type="text"
                  class="isian-form"
                  id="namaresto"
                  name="namaresto"
                  placeholder="Nama Restoran"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">No. Telepon</label>
                <input
                  type="tel"
                  class="isian-form"
                  id="no_telp"
                  name="no_telp"
                  placeholder="No. Telepon, eg: 081234567890"
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Website</label>
                <input
                  type="url"
                  class="isian-form"
                  id="Web"
                  name="Web"
                  placeholder="Website"
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Kategori</label>
                <select class="form-select" id="kategori"
                  name="kategori">
                  <option selected disabled> </option>
                  <option value="Fast-Food">Cepat Saji</option>
                  <option value="Indonesian">Kuliner Indonesia</option>
                  <option value="Japanese">Kuliner Jepang</option>
                  <option value="Korean">Kuliner Korea</option>
                  <option value="Chicken">Aneka Ayam</option>
                  <option value="Noodles">Aneka Mie dan Bakso</option>
                  <option value="Drinks">Aneka Minuman</option>
                  <option value="Korean">Makanan Penutup</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Waktu Buka</label>
                <br>
                <input
                  class="form-jambuka"
                  type="time"
                  id="jambuka"
                  name="jambuka"
                  min="00:00"
                  max="23:59"

                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Waktu Tutup</label>
                <br>
                <input
                  class="form-jamtutup"
                  type="time"
                  id="jamtutup"
                  name="jamtutup"
                  min="00:00"
                  max="23:59"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Rentang Harga</label>
                <input
                  type="text"
                  class="isian-form"
                  id="harga"
                  name="harga"
                  placeholder="eg: 50.000-100.000"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Fasilitas</label>
                <input
                  type="text"
                  class="isian-form"
                  id="fasilitas"
                  name="fasilitas"
                  required
                  />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Deskripsi</label>
                <div class="form-floating">
                  <textarea class="isian-form" placeholder="Deskripsi" id="Deskripsi" name="Deskripsi " style="height: 100px"></textarea>
                </div>
              </div>
              <label for="formRestoData" class="form-label">Foto Restauran</label>
              <div class="input-group">
                <input type="file" class="isian-form" id="foto_resto" name="foto_resto" accept="image/*">
              </div>
              <label for="formRestoData" class="form-label" id="foto_menu" accept="image/*">Foto Menu</label>
              <div class="input-group">
                <input type="file" class="form-control" id="input-menuresto" multiple>
              </div>
              <br>

              <!--Alamat Resto-->
              <h4>Alamat Restoran</h4>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Nama Jalan</label>
                <input
                  type="text"
                  class="isian-form"
                  id="jalan"
                  name="jalan"
                  placeholder="Jl..."
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Nama Kecamatan</label>
                <input
                  type="text"
                  class="isian-form"
                  id="kecamatan"
                  name="kecamatan"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Kabupaten/Kota</label>
                <select class="form-select" id="kabkota" name="kabkota">
                  <option selected disabled> </option>
                    <option value="Kabupaten">Kabupaten</option>
                    <option value="Kota">Kota</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Nama Kabupaten/Kota</label>
                <input
                  type="text"
                  class="isian-form"
                  id="kota"
                  name="kota"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="formRestoData" class="form-label">Provinsi</label>
                <input
                  type="text"
                  class="isian-form"
                  id="provinsi"
                  name="provinsi"
                  required
                />
              </div>
              <a href="#" id="addresto" name="addresto" type="submmit" class="button-submit">Tambah Restoran</a>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--End of Restaurant Info-->
  </body>
</html>
