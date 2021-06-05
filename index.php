<?php
session_start();
// if (isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }
require 'php/functions.php';
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
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.35">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="frontend/css/index.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
    <title>EzEats</title>

</head>

<body>
    <!--Navigation Bar-->
    <div class="container-fluid" id="NavBar">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand toplogo" href=""><img src="frontend/img/ezeatsred.png" alt="EzEats"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" id="Beranda" aria-current="page" href="index.php">Beranda</a>
                        <a class="nav-link" id="Kategori" name="kategori" href="php/kategori.php">Kategori</a>
                        <a class="nav-link" id="SignUp" name="signup" href="php/signup.php?location=index.php">Sign Up</a>
                        <a class="btn btn-danger" id="SignIn" name="login" href="php/login.php?location=index.php" role="button">Sign In</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!--Cover-->
    <div class="jumbotron jumbotron-fluid" style="background-image: url('frontend/img/bgimage.png');">
        <div class="container">
            <div class="text-center">
                <img id="logoEzEats" src="frontend/img/logo.png" class="rounded" alt="EzEats Logo">
            </div>
        </div>
    </div>
    <!--Search Box-->
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Card Items-->
    <div class="container mt-5 pt-5" id="item-cards">
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
            <div class="row">
                <div class="col-md card-items">

                    <div class="d-flex justify-content-center">
                        <figure class="card card-product-grid card-lg"> <a href="php/info.php?idr=<?= $idr; ?>" class="img-wrap" data-abc="true"> <img src="database/img/resto/<?= $resto['foto_resto']; ?>"> </a>
                            <figcaption class="info-wrap">
                                <div class="row">
                                    <div class="col-md-11 col-xs-11">
                                        <a href="php/info.php?idr=<?= $idr; ?>" class="title" data-abc="true"><?= $resto["nama"]; ?></a>
                                        <div class="rating"><i class="bi bi-hand-thumbs-up pl-2"></i><?= (int)$pro . "% (" . $views . " Reviews)"; ?></div>
                                        <div class="address"><i class="bi bi-geo-alt"></i><?= $resto["kecamatan"] . ", " . $daerah . " " . $resto["namakabkota"]; ?></div>
                                    </div>
                                    <div class="col-md-1 col-xs-1">
                                        <div class="heart1"></div>
                                        <script>
                                            var animated = false;
                                            $('.heart1').click(function() {
                                                if (!animated) {
                                                    $(this).addClass('heart-line');
                                                    animated = true;
                                                } else {
                                                    $(this).removeClass('heart-line').addClass('heart1');
                                                    animated = false;
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </figcaption>
                            <div class="bottom-wrap">
                                <a href="php/info.php?idr=<?= $idr; ?>" class="review">Tulis review...</a>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (!isset($_POST["submit-cari"]) && !isset($_GET["keyword"])) : ?>
            <?php if (!isset($_GET["show"])) : ?>
                <div class="container mt-3 pt-2" id="item-cards">
                    <div style="position: relative; top:50%; left:46%;bottom:50%">
                        <p style="font-size: 22px; font-weight:720; text-decoration:underline; color: #DD3131;">
                            <a role="button" class="btn btn-danger" id="addresto" href="index.php?&show=true"> Show All </a>
                        </p>

                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET["show"])) : ?>
                <div class="container mt-3 pt-2" id="item-cards">
                    <div style="position: relative; top:50%; left:46%;bottom:50%">

                        <p style="font-size: 22px; font-weight:720; text-decoration:underline; color: #DD3131;">
                            <a role="button" class="btn btn-danger" id="addresto" href="index.php"> Show Less </a>
                        </p>

                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <br><br><br>
    <!--Footer-->
    <footer>
        <div class="container-fluid" id="footer">
            <div class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-5 p-3 about-us">
                        <h2>Tentang EzEats</h2>
                        <p> EzEats adalah aplikasi berbasis web yang diharapkan dapat membantu masyarakat,
                            khususnya foodhunter untuk saling berinteraksi satu sama lain dengan bertukar
                            informasi mengenai penilaian ataupun ulasan terhadap sebuah rumah makan.
                        </p>
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