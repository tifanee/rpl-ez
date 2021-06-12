<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../index.php");
  exit;
}
require 'functions.php';
$id = $_GET["id"];
$user = query("SELECT * FROM tb_user WHERE id = $id")[0];
if (isset($_GET["show"])) {
  $list_resto = query("SELECT * FROM tb_resto ORDER BY (upvotes + downvotes) DESC");
} else if (!isset($_GET["show"]) && !isset($_POST["submit-cari"])) {
  $list_resto = query("SELECT * FROM tb_resto ORDER BY (upvotes + downvotes) DESC");
  $list_resto = array_slice($list_resto, 0, 3);
}
if (isset($_GET["keyword"])) {
  $list_resto = search($_GET["keyword"]);
}
if (isset($_POST["submit-cari"])) {
  $list_resto = search($_POST["cari"]);
}
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
  <link rel="stylesheet" type="text/css" href="../frontend/css/index-loggedin.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
  <title>EzEats</title>
</head>
<style>
    .user-review {
      font-size: 27px;
      font-weight: 600;
      text-decoration: underline;
      color: #DD3131;
    }

    .vertical-center {
      margin: 0;
      position: absolute;
      top: 107%;
      left: 30%;
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }

    .vertical-bottom {
      margin: 0;
      position: absolute;
      top: 475%;
      left: 47%;
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }
  </style>
</head>

<body>
  <!--Start of Navigation Bar-->
  <div class="container-fluid" id="NavBar">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand toplogo" href="#"><img src="../frontend/img/logo ezeats red.png" alt="EzEats"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ms-auto">
            <a class="nav-link active" id="Beranda" aria-current="page" href="index2.php?id=<?= $user["id"]; ?>">Beranda</a>
            <a class="nav-link" id="Kategori" name="kategori" href="kategori-loggedin.php?id=<?= $user["id"]; ?>">Kategori</a>
            <a class="nav-link" id="Photo" href="account.php?id=<?= $user["id"]; ?>"><img src="../database/img/user/<?= $user['gambar']; ?>"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, <?= $fname; ?>!
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item profile" name="profil" href="account.php?id=<?= $user["id"]; ?>">Profil</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item exit"href="logout.php?location=<?= urlencode($_SERVER['REQUEST_URI']); ?>" name="logout">Keluar</a></li>
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

  <!--Start of Search Box-->
  <div class="search-box">
    <div class="container">
      <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">
          <form action="" method="post" enctype="multipart/form-data">
           <div class="search">
            <i class="bi bi-search "></i>
            <input type="text" name="cari" class="form-control" placeholder="Mau makan apa hari ini?">
            <button type="submit" name="submit-cari" class="btn btn-danger">Cari!</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--End of Search Box-->

  <!--Start of Card Items-->
  <div class="container mt-5 pt-5" id="item-cards">
    <div class="main-title"><p style="font-size: 22px; font-weight:550px; text-decoration:underline; color: #DD3131;">
        Restoran kamu belum ada ? <a role="text" style="color: #DD3131; font-weight:800" id="addresto" href="addresto.php?id=<?= $user["id"]; ?>">tambahkan disini!</a><i class="bi bi-pencil-square"></i>
      </p>
    </div>
    <?php
    if (!isset($_POST["submit-cari"]) && !isset($_GET["keyword"])) {
      $rekom = "Rekomendasi";
    } else if (isset($_POST["submit-cari"]) && !isset($_GET["keyword"])) {
      $rekom = "Hasil pencarian dengan kata kunci  `" . $_POST["cari"] . "`";
    } else if (!isset($_POST["submit-cari"]) && isset($_GET["keyword"])) {
      $rekom = "Hasil pencarian dengan kata kunci  `" . $_GET['keyword'] . "`";
    }
    ?>
    <div class="main-title"><?= $rekom; ?></div>

    <div class="row">
      <?php foreach ($list_resto as $resto) : ?>
        <?php
        $idr = $resto["id"];
        $views = $resto["upvotes"] + $resto["downvotes"];
        if ($views != 0) {
          $pro = ($resto["upvotes"] / $views) * 100;
        } else $pro = 0;
        if ($resto["kotakab"] == "Kota") {
          $daerah = "Kota";
        } else if ($resto["kotakab"] == "Kabupaten") {
          $daerah = "Kab.";
        }
        ?>
        <div class="column">
      <div class="col-md card-items" id="items">

        <div class="d-flex justify-content-center">
          <figure class="card card-product-grid card-lg">
            <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>" class="img-wrap" data-abc="true"> <img src="../database/img/resto/<?= $resto['foto_resto']; ?>"> </a>
            <figcaption class="info-wrap">
              <div class="row">
                <div class="col-md-11 col-xs-11">
                  <a href="info2.php?id=<?= $id; ?>&idr=<?= $resto["id"]; ?>" class="title" data-abc="true"><?= $resto["nama"]; ?></a>
                <div class="rating"><i class="bi bi-hand-thumbs-up pl-2"></i><?= (int)$pro . "% (" . $views . " Reviews)"; ?></div>
                 <div class="address"><i class="bi bi-geo-alt"></i><?= $resto["kecamatan"] . ", " . $daerah . " " . $resto["namakabkota"]; ?></div>
                  <div class="review"><i class="bi bi-pencil-square"></i>Telah Diulas oleh <strong>77</strong> Orang</div>
                </div>
                <div class="col-md-1 col-xs-1">
                  <div class="heart1"></div>
                  <script>
                    var animated = false;
                    $('#item-1 .heart1').click(function () {
                      if (!animated) {
                        $(this).addClass('heart-line');
                        animated = true;
                      }
                      else {
                        $(this).removeClass('heart-line').addClass('heart1');
                        animated = false;
                      }
                    });
                  </script>
                </div>
              </div>
            </figcaption>
            <div class="bottom-wrap">
              <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>" class="review">Info Selengkapnya</a>
            </div>
          </figure>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if (!isset($_POST["submit-cari"]) && !isset($_GET["keyword"])) : ?>
        <?php if (!isset($_GET["show"])) : ?>
       <div class="container mt-2 pt-2" id="item-cards">
            <div style="position: relative; top:50%; left:46%;bottom:50%">

              <p style="font-size: 22px; font-weight:720; text-decoration:underline; color: #DD3131;">
                <a role="button" class="btn btn-danger" id="addresto" href="index2.php?id=<?= $user["id"]; ?>&show=true"> Show All </a>
              </p>

            </div>
          </div>
        <?php endif; ?>
        <?php if (isset($_GET["show"])) : ?>
          <div class="container mt-2 pt-2" id="item-cards">
            <div style="position: relative; top:50%; left:46%;bottom:50%">

              <p style="font-size: 22px; font-weight:720; text-decoration:underline; color: #DD3131;">
                <a role="button" class="btn btn-danger" id="addresto" href="index2.php?id=<?= $user["id"]; ?>"> Show Less </a>
              </p>

            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>

    </div>

  </div>

  <br><br><br>

    <!--Start of Pagination-->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#"><i class="bi bi-chevron-double-left"></i></a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#"><i class="bi bi-chevron-double-right"></i></a>
        </li>
      </ul>
    </nav>
    
    <!--End of Pagination--> 

  </div>
  <!--End of Card Items-->

  <div class="container-fluid">
    <div class="add-resto">
      <div class="flat"></div>
      <img src="../frontend/img/background/fluid-1.jpg" alt="">
      <div class="row">
        <div class="content d-flex justify-content-evenly">
          <div class="title">Tidak Menemukan Resto yang Anda Cari?<br>
            <span>Jadilah Kontributor Sekarang!</span></div>
          <a type="button" class="btn btn-danger" href="add resto.html">
            <i class="bi bi-plus"></i>Tambahkan Restoran</a>
        </div>
      </div>
      
    </div>
  </div>
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
            <p> <strong>EzEats Team</strong> </p>
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
              <a class="btn btn-primary rounded-circle m-1" href="https://github.com/tifanee/rpl-ez" role="button"><i class="bi bi-github"></i></a>
            </section>

          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
</body>

</html>