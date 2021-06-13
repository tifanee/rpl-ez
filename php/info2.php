<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET["id"];
$idr = $_GET["idr"];
if (isset($_POST["submit-cari"])) {
    $cari = $_POST["cari"];
    header("Location: index2.php?id=$id&keyword=$cari");
    exit;
}
$review_user = query("SELECT * FROM tb_review WHERE user_id = $id AND resto_id = $idr");
if ($review_user) {
    // Untuk voting (recommended or not)
    $review_user = $review_user[0];
    if (isset($_GET["thumb"])) {
        $thumb = $_GET["thumb"];
        if (addVote($_GET["thumb"], $_GET["d1"], $idr, $review_user["id"]) <= 0) {
            echo pg_errormessage($koneksi);
        }
    }
} else {
    if (isset($_GET["thumb"])) {
        $thumb = $_GET["thumb"];
        if (addreviewVote($_GET["thumb"], $_GET["d1"], $idr, $id) <= 0) {
            echo pg_errormessage($koneksi);
        }
    }
}

$user = query("SELECT * FROM tb_user WHERE id = $id")[0];
$resto = query("SELECT * FROM tb_resto WHERE id = $idr")[0];
$reviews = query("SELECT * FROM tb_review WHERE resto_id = $idr");
$count = count($reviews);

$views = $resto["upvotes"] + $resto["downvotes"];
if ($views != 0) {
    $pro = ($resto["upvotes"] / $views) * 100;
} else $pro = 0;

$no_telp = implode(' ', str_split($resto["no_telp"], 4));
$fname = explode(' ', $user["nama"])[0];

// Untuk daerah
if ($resto["kotakab"] == "Kota") {
    $daerah = "Kota";
} else if ($resto["kotakab"] == "Kabupaten") {
    $daerah = "Kab.";
}

// Untuk Ulasan
if (isset($_POST["submit-review"])) {
    if (addReview($_POST, $idr, $id) > 0) {
        header("Refresh: 0");
    } else {
        echo pg_errormessage($koneksi);
    }
}

// // Untuk voting
// if (isset($_GET["vote"])) {
//     if ($_GET["vote"] == "upvote") {
//         if (addvote("upvote", $resto["upvotes"], $idr) > 0) {
//             header("Location: info.php?idr=$idr");
//             exit;
//         } else {
//             echo pg_errormessage($koneksi);
//         }
//     } else if ($_GET["vote"] == "downvote") {
//         if (addvote("downvote", $resto["downvotes"], $idr) > 0) {
//             header("Location: info.php?idr=$idr");
//             exit;
//         } else {
//             echo pg_errormessage($koneksi);
//         }
//     }
// }
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.35">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <link rel="stylesheet" type="text/css" href="../frontend/css/info-loggedin.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
    <title><?= $resto["namaresto"] . " " . $resto["kecamatan"]; ?></title>
</head>

<body>
    <!--Start of Navigation Bar-->
    <div class="container-fluid" id="NavBar">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand toplogo" href="index2.php?id=<?= $id; ?>"><img src="../frontend/img/ezeatsred.png" alt="EzEats"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <form action="" class="d-inline-flex flex-fill justify-content-center align-items-center searchbar" method="post" enctype="multipart/form-data">
                        <input class="form-control me-2 inputbox" name="cari" type="search" placeholder="Mau makan apa hari ini?" aria-label="Search">
                        <button class="btn btn-outline-danger" name="submit-cari" type="submit"><i class="bi bi-search "></i></button>
                    </form>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" id="Beranda" name="beranda" href="index2.php?id=<?= $id; ?>" style="color:black"><strong>Beranda</strong></a>
                        <a class="nav-link" id="Photo" href=""><img src="../database/img/user/<?= $user["gambar"]; ?>" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?= "Halo, " . $fname . "!"; ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="account.php?id=<?= $id; ?>">Profil</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item exit" href="logout.php?location=info2.php&idr=<?= $idr; ?>">Keluar</a></li>
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
    <br><br>

    <!--Start of Restaurant Info-->
    <div class="container info">
        <div class="info-header">
            <div class="images-header">
                <img class="resto-cover" src="../frontend/img/kategori/<?= coverImage($resto['kategori']); ?>" alt="Category Food Cover">
                <img class="resto-image" src="../database/img/resto/<?= $resto['foto_resto']; ?>" alt="Restaurant Image">
            </div>
            <h2 class="resto-name"><?= $resto["namaresto"] . " " . $resto["kecamatan"]; ?></h2>
            <h3 class="resto-rate">Direkomendasikan oleh <strong><?= $resto["upvotes"]; ?></strong> dari <strong><?= $views; ?></strong> Orang
                <i class="bi bi-dot"></i><span class="rating"><i class="bi bi-hand-thumbs-up"></i><?= (int)$pro . "%"; ?></span>
            </h3>
            <h3 class="resto-review">Telah Diulas oleh <strong><?= $count; ?></strong> Orang</h3>
            <br>
        </div>
        <div class="info-body">
            <ul class="nav nav-tabs" id="info-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="true">Detail</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="descript-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Deskripsi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab" aria-controls="menu" aria-selected="false">Menu</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">Galeri</button>
                </li>
            </ul>
            <div class="tab-content" id="info-tab-content">
                <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="attribute category">Kategori</div>
                                <div class="attribute address">Alamat</div>
                                <div class="attribute telephone">No. Telepon</div>
                                <div class="attribute web">Alamat Web</div>
                                <div class="attribute workhour">Jam Buka</div>
                                <div class="attribute price">Rentang Harga</div>
                                <div class="attribute facilities">Fasilitas</div>
                            </div>
                            <div class="col-md-9">
                                <div class="value category"><?= $resto["kategori"]; ?></div>
                                <div class="value address"><?= $resto["jalan"] . ", Kec. " . $resto["kecamatan"] . ", " . $daerah . " " . $resto["kota"]; ?></div>
                                <?php
                                if ($resto["no_telp"] == NULL) {
                                    $no_telp = "-";
                                } else {
                                    $no_telp = $resto["no_telp"];
                                }
                                ?>
                                <div class="value telephone"><?= $no_telp; ?></div>
                                <?php
                                if ($resto["web"] == NULL) {
                                    $web = "-";
                                    $href = "";
                                } else {
                                    $web = $resto["web"];
                                    $href = "href = https://" . $web;
                                }
                                ?>
                                <div class="value website"><a <?= $href; ?>> <?= $web; ?> </a></div>
                                <div class="value workhour"><?= $resto["jambuka"] . " - " . $resto["jamtutup"]; ?></div>
                                <div class="value price"><?= "IDR " . $resto["harga"]; ?></div>
                                <div class="value facilities"><?= $resto["fasilitas"]; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="descript-tab">
                    <div class="container">
                        <?= $resto["deskripsi"]; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                    <img src="../database/img/menu/<?= $resto['foto_menu']; ?>" width="200" height="300">
                </div>
                <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">

                </div>
            </div>
            <script>
                var firstTabEl = document.querySelector('#info-tab li:last-child a')
                var firstTab = new bootstrap.Tab(firstTabEl)
                firstTab.show()
            </script>
            <div class="button">
                <button type="button" class="btn btn-danger" id="favorite-button"><i class="bi bi-heart"></i>Tambah ke Favorit</button>
            </div>
            <div id="message">
                <div class="alert alert-danger alert-dismissible" id="favorite-alert" role="alert">
                    <i class="bi bi-heart-fill"></i>Restoran telah ditambahkan ke <a href="">Daftar Favorit</a>!
                    <hr>
                    <p class="mb-0">Restoran dapat Dihapus dari Daftar Favorit pada <a href="">Menu Profil</a></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#favorite-button').click(function() {
                        $('#favorite-alert').show()
                    })
                });
            </script>
        </div>
    </div>
    <!--End of Restaurant Info-->

    <!--Start of User Ratings and Reviews-->
    <div class="container">
        <div class="rate-divider"> </div>
        <div class="user-rating" id="user-rating"> Apakah Anda Merekomendasikan Resto Ini?
            <div class="button">
                <?php
                $disableya = "";
                $disableno = "";
                $review_user = query("SELECT * FROM tb_review WHERE user_id = $id AND resto_id = $idr");
                if ($review_user) {
                    $review_user = $review_user[0];
                    if ($review_user["rekomendasi"] != "") {
                        if ((isset($_GET["thumb"]) && ($_GET["thumb"] == "ya")) || $review_user["rekomendasi"] == "Merekomendasikan") {
                            $disableya = "disabled";
                        } else if ((isset($_GET["thumb"]) && ($_GET["thumb"] == "tidak")) || $review_user["rekomendasi"] == "Tidak Merekomendasikan") {
                            $disableno = "disabled";
                        }
                    }
                }
                if ($disableya == "" && $disableno == "") {
                    $d1 = 0;
                } else {
                    $d1 = 1;
                }
                ?>
                <a class="btn btn-success yes <?= $disableya; ?>" href="info2.php?id=<?= $id ?>&idr=<?= $idr ?>&thumb=ya&d1=<?= $d1; ?>" role="button">
                    <i class="bi bi-hand-thumbs-up"></i>Ya
                </a>
                <a class="btn btn-danger nope <?= $disableno; ?>" href="info2.php?id=<?= $id ?>&idr=<?= $idr ?>&thumb=tidak&d1=<?= $d1; ?>" role="button">
                    <i class="bi bi-hand-thumbs-down"></i>Tidak
                </a>
            </div>
        </div>
        <?php if (!$review_user) : ?>
            <a class="user-review" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Tulis Ulasan<i class="bi bi-pencil-square"></i>
            </a>
        <?php endif; ?>
        <?php if ($review_user) : ?>
            <p class="user-review" color>
                Ulasan kamu telah tersimpan, cek historimu <a class="user-review" href="profilulasan.php?id=<?= $id; ?>" color="red"><strong>disini</strong></a>
            </p>
        <?php endif; ?>
    </div>
    <!--Start of Modal-->
    <form action="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tulis Ulasan Anda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form>
                                <div class="mb-3">
                                    <label for="review-title" class="col-form-label">Judul Ulasan</label>
                                    <input type="text" class="form-control" name="judul-ulasan" id="judul-ulasan" placeholder="Maksimal 35 Karakter" maxlength="35" required>
                                </div>
                                <div class="mb-3">
                                    <label for="review-description" class="col-form-label">Deskripsi Ulasan</label>
                                    <textarea class="form-control" name="ulasan-resto" oninput="auto_grow(this)" id="ulasan-resto" placeholder="Maksimal 2000 Karakter" maxlength="2000" review></textarea>
                                    <script>
                                        function auto_grow(element) {
                                            element.style.height = "5px";
                                            element.style.height = (element.scrollHeight) + "px";
                                        }
                                    </script>
                                </div>
                                <div class="mb-3">
                                    <label for="review-attachment" class="col-form-label">Tambahkan Gambar</label><br>
                                    <input type="file" id="gambar-ulasan" name="gambar-ulasan">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="submit-review" class="btn btn-danger">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--End of Modal-->
    <!--End of User Ratings and Reviews-->


    <!--Start of Reviews-->
    <div class="container">
        <div class="card-divider"> </div>
        <?php if ($review_user) : ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 profile">
                            <img src="../database/img/user/<?= $user["gambar"]; ?>" />
                            <div class="name"><?= $user["nama"]; ?></div>
                            <div class="nick"><?= $user["deskripsi_singkat"]; ?></div>
                        </div>
                        <div class="col-xl-9 justify-content-end review">
                            <div class="row">
                                <div class="col-md-7 subject"><?= $review_user["judul"]; ?></div>
                                <?php
                                if ($review_user["rekomendasi"] == "Merekomendasikan") {
                                    $status = $review_user["rekomendasi"];
                                    $var1 = "good";
                                    $var2 = "up";
                                } else if ($review_user["rekomendasi"] == "Tidak Merekomendasikan") {
                                    $status = $review_user["rekomendasi"];
                                    $var1 = "bad";
                                    $var2 = "down";
                                }
                                ?>
                                <?php if ($review_user["rekomendasi"] != "") : ?>
                                    <div class="col-md-5 rating" id="<?= $var1; ?>">
                                        <span class="icon"><i class="bi bi-hand-thumbs-<?= $var2; ?>"></i></span>
                                        <span class="info"><?= $status; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="detail">
                                <p>
                                    <?= $review_user["ulasan"]; ?>
                                </p>
                            </div>
                            <div class="timestamp"><?= $review_user["jam"] . "   " . $review_user["tanggal"]; ?></div>
                        </div>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-bottom">

                        <div class="row">
                            <div class="col-md-6 vote-review">Terbantu dengan ulasan ini?
                                <input type="hidden" name="upvotes-review" value="<?= $review_user["upvotes"]; ?>">
                                <input type="hidden" name="downvotes-review" value="<?= $review_user["downvotes"]; ?>">
                                Ya<i class="bi bi-hand-thumbs-up-fill 1" name="ya" onclick="like()"></i>
                                Tidak<i class="bi bi-hand-thumbs-down-fill 1" name="tidak" onclick="dislike()"></i>
                                <script>
                                    var color1 = document.getElementsByClassName('bi-hand-thumbs-up-fill 1')[0];
                                    var color2 = document.getElementsByClassName('bi-hand-thumbs-down-fill 1')[0];

                                    function like() {
                                        color1.style.color = color1.style.color === '#24923D' ? 'gray' : '#24923D';
                                        color2.style.color = 'gray';
                                    }

                                    function dislike() {
                                        color1.style.color = 'gray';
                                        color2.style.color = color2.style.color === 'red' ? 'gray' : 'red';
                                    }
                                </script>
                            </div>
                            <div class="col-md-5 voter-info"><strong><?= $review_user["upvotes"]; ?></strong> dari <strong><?= $review_user["upvotes"] + $review_user["downvotes"]; ?></strong> Voter Terbantu</div>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        <?php foreach ($reviews as $review) : ?>
            <?php if ($review["user_id"] != $id) : ?>
                <?php
                $id_user = $review["user_id"];
                $user_review = query("SELECT * FROM tb_user WHERE id = $id_user")[0];
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2 profile">
                                <img src="../database/img/user/<?= $user_review["gambar"]; ?>" />
                                <div class="name"><?= $user_review["nama"]; ?></div>
                                <div class="nick"><?= $user_review["deskripsi_singkat"]; ?></div>
                            </div>
                            <div class="col-xl-9 justify-content-end review">
                                <div class="row">
                                    <div class="col-md-7 subject"><?= $review["judul"]; ?></div>
                                    <?php
                                    if (isset($_GET["thumb"])) {
                                        $thumb = $_GET["thumb"];
                                        $review_id = $review['id'];
                                        if ($thumb == "ya" && $id_user == $_GET["id"]) {
                                            $check = "Merekomendasikan";
                                            $query = "UPDATE tb_review SET rekomendasi = '$check' WHERE id = $review_id";
                                            $haha = pg_query($koneksi, $query);
                                        } else if ($thumb == "tidak" && $id_user == $_GET["id"]) {
                                            $check = "Tidak Merekomendasikan";
                                            $query = "UPDATE tb_review SET rekomendasi = '$check' WHERE id = $review_id";
                                            $haha = pg_query($koneksi, $query);
                                        }
                                    }
                                    ?>
                                    <?php

                                    if ($review["rekomendasi"] == "Merekomendasikan") {
                                        $status = $review["rekomendasi"];
                                        $var1 = "good";
                                        $var2 = "up";
                                    } else if ($review["rekomendasi"] == "Tidak Merekomendasikan") {
                                        $status = $review["rekomendasi"];
                                        $var1 = "bad";
                                        $var2 = "down";
                                    }
                                    ?>
                                    <?php if ($review["rekomendasi"] != "") : ?>
                                        <div class="col-md-5 rating" id="<?= $var1; ?>">
                                            <span class="icon"><i class="bi bi-hand-thumbs-<?= $var2; ?>"></i></span>
                                            <span class="info"><?= $status; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="detail">
                                    <p>
                                        <?= $review["ulasan"]; ?>
                                    </p>
                                </div>
                                <div class="timestamp"><?= $review["jam"] . "   " . $review["tanggal"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="card-bottom">

                            <div class="row">
                                <?php
                                $i = 1;
                                $i++;
                                ?>
                                <div class="col-md-6 vote-review">Terbantu dengan ulasan ini?
                                    <input type="hidden" name="upvotes-review" value="<?= $review["upvotes"]; ?>">
                                    <input type="hidden" name="downvotes-review" value="<?= $review["downvotes"]; ?>">
                                    <input type="hidden" name="review_id" value="<?= $review["id"]; ?>">
                                    Ya<i class="bi bi-hand-thumbs-up-fill 1" name="ya" onclick="like()"></i>
                                    Tidak<i class="bi bi-hand-thumbs-down-fill 1" name="tidak" onclick="dislike()"></i>
                                    <script>
                                        var color1 = document.getElementsByClassName('bi-hand-thumbs-up-fill 1')[<?= $i; ?>];
                                        var color2 = document.getElementsByClassName('bi-hand-thumbs-down-fill 1')[<?= $i; ?>];

                                        function like() {
                                            color1.style.color = color1.style.color === '#24923D' ? 'gray' : '#24923D';
                                            color2.style.color = 'gray';
                                        }

                                        function dislike() {
                                            color1.style.color = 'gray';
                                            color2.style.color = color2.style.color === 'red' ? 'gray' : 'red';
                                        }
                                    </script>
                                </div>
                                <div class="col-md-5 voter-info"><strong><?= $review["upvotes"]; ?></strong> dari <strong><?= $review["upvotes"] + $review["downvotes"]; ?></strong> Voter Terbantu</div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <br><br>
    <!--End of Start of Reviews-->

    <!-- Start of Footer-->
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
    <!-- End of Footer-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>