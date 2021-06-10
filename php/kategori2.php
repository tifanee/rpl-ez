<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../index.php");
  exit;
}
require 'functions.php';
$id = $_GET["id"];
if (isset($_POST["submit-cari"])) {
  $cari = $_POST["cari"];
  header("Location: index2.php?id=$id&keyword=$cari");
  exit;
}
$user = query("SELECT * FROM tb_user WHERE id = $id")[0];

// Extract first name
$fname = explode(' ', $user["nama"])[0];
?>

<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.35">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../frontend/css/category-loggedin.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
  <title>EzEats</title>
</head>

<body>
  <!--Start of Navigation Bar-->
  <div class="container-fluid" id="NavBar">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand toplogo" href="index2.php?id=<?= $user["id"]; ?>"><img src="../frontend/img/logo ezeats red.png" alt="EzEats"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto">
            <a class="nav-link" id="Beranda" href="index2.php?id=<?= $user["id"]; ?>">Beranda</a>
            <a class="nav-link active" id="Kategori" aria-current="page" name="kategori" href="#">Kategori</a>
            <a class="nav-link" id="Photo" href="account.php?id=<?= $user["id"]; ?>"><img src="../database/img/user/<?= $user["gambar"]; ?>"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, <?= $fname; ?>!
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item profile" href="account.php?id=<?= $user["id"]; ?>">Profil</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item exit" href="logout.phplocation=<?= urlencode($_SERVER['REQUEST_URI']); ?>" name="logout">Keluar</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </div>
  <!--End of Navigation Bar-->

  <!--Start of Banner-->
  <div id="carouselBanner" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../frontend/img/background/caro-6.jpg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="../frontend/img/background/caro-2.jpg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="../frontend/img/background/caro-4.jpg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="../frontend/img/background/caro-7.jpg" class="d-block w-100">
      </div>
      <div class="banner text-center"><img src="../frontend/img/logo ezeats white_glow.png" alt=""></div>
    </div>
  </div>
  <div class="divider"></div>
  <!--End of Banner-->

  <!--Search Box-->
  <div class="search-box">
    <div class="container">
      <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">
          <div class="search">
            <i class="bi bi-search "></i>
            <input type="text" class="form-control" placeholder="Mau makan apa hari ini?">
            <button class="btn btn-danger">Cari!</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--Start of Card Categories-->
  <div class="container mt-5 pt-5" id="item-cards">
    <div class="main-title">Kategori</div>

    <div class="d-flex row">

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/fastfood.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Cepat Saji</b></h3>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/indonesian.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Kuliner Indonesia</b></h3>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/japanese.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Kuliner Jepang</b></h3>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/korean.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Kuliner Korea</b></h3>
          </div>
        </div>
      </div>          

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/chicken.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Aneka Ayam</b></h3>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/noodles.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Mie dan Bakso</b></h3>
          </div>
        </div>
      </div>    

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/drinks.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Aneka Minuman</b></h3>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-4 col-xl-3">
        <div class="profile-card">
          <img src="../frontend/img/kategori/sweets.png" class="img img-responsive">
          <div class="container profile-name"></div>
          <div class="title">
            <h3><b>Makanan Penutup</b></h3>
          </div>
        </div>
      </div>

    </div>

  </div>
  <br><br><br><br>

  <!--End of Card Categories-->
  </div>
  <br><br><br>
  <!--Footer-->
  <footer>
    <div class="container-fluid" id="footer">
      <div class="container pt-5 pb-5">
        <div class="row">
          <div class="col-xl-5 p-3 about-us">
            <h2>Tentang EzEats</h2>
            <p>EzEats adalah aplikasi berbasis web yang diharapkan dapat membantu masyarakat,
              khususnya foodhunter untuk saling berinteraksi satu sama lain dengan bertukar
              informasi mengenai penilaian ataupun ulasan terhadap sebuah rumah makan.</p>
            <p><strong>EzEats Team</strong></p>
          </div>
          <div class="col-xl-3 p-3 contact-us">
            <h2>Kontak</h2>
            <ul class="list-unstyled mb-1">
              <li>
                <div class="contact"><i class="bi bi-geo-alt-fill"></i> Jl. Raya Padjadjaran No.37, Bogor</div>
              </li>
              <li>
                <div class="contact"><i class="bi bi-telephone-inbound-fill"></i> Phone: +62 812 3456 7890</div>
              </li>
              <li>
                <div class="contact"><i class="bi bi-envelope-fill"></i> ezeats-team@company.co.id</div>
              </li>
            </ul>
          </div>
          <div class="col-xl-3 p-3 follow-us">
            <h2>Ikuti Kami</h2>
            <section class="mb-4 socmed-icon">
              <!-- Facebook -->
              <a class="btn btn-primary rounded-circle m-1" href="#!" role="button"><i class="bi bi-facebook"></i></a>

              <!-- Twitter -->
              <a class="btn btn-primary rounded-circle m-1" href="#!" role="button"><i class="bi bi-twitter"></i></a>

              <!-- Instagram -->
              <a class="btn btn-primary rounded-circle m-1" href="#!" role="button"><i class="bi bi-instagram"></i></a>

              <!-- Github -->
              <a class="btn btn-primary rounded-circle m-1" href="#!" role="button"><i class="bi bi-github"></i></a>
            </section>

          </div>
        </div>
      </div>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>