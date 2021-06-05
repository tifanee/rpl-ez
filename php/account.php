<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}
require 'functions.php';

// Ambil data dari URL
$id = $_GET["id"];
if (isset($_POST["submit-cari"])) {
    $cari = $_POST["cari"];
    header("Location: index2.php?id=$id&keyword=$cari");
    exit;
}
// Query data based on id
$user = query("SELECT * FROM tb_user WHERE id = '$id' ")[0];
$email = $user["email"];
$query = "SELECT * FROM tb_user WHERE email = '$email' ";
$result = pg_query($koneksi, $query);
$reviews = query("SELECT * FROM tb_review WHERE user_id = $id");
$fname = explode(' ', $user["nama"])[0];

$count_ulasan = 0;
$count_nilai = 0;
foreach ($reviews as $rev) {
    if ($rev["rekomendasi"] != "" && $rev["judul"] == NULL) {
        $count_nilai++;
    } else if ($rev["rekomendasi"] != "" && $rev["judul"] != NULL) {
        $count_nilai++;
        $count_ulasan++;
    } else if ($rev["judul"] != NULL && $rev["rekomendasi"] == "") {
        $count_ulasan++;
    }
}

// Check if submit button has been touched or not
if (isset($_POST["submit"], $id)) {
    // Check if data is submitted successfully.
    if (updateUser($_POST, $id) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
            </script>
        ";
        header("Refresh:0");
    } else {
        // echo pg_errormessage(ubah($_POST));
        echo "
            <script>
                alert('Data gagal diubah');
            </script>
        ";
        header("Refresh:0");
    }
}

if (isset($_POST["submit1"], $id)) {
    if (updatePassword($_POST, $id) > 0) {
        echo "
        <script>
            alert('Password berhasil diubah!');
        </script>
        ";
        header("Refresh:0");
    } else {
        echo "
            <script>
                alert('Password gagal diubah!');
            </script>
        ";
        header("Refresh:0");
    }
}

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
    <link rel="stylesheet" type="text/css" href="../frontend/css/profil-edit.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
    <title><?= $fname; ?> - EzEats</title>
</head>

<body>
    <!--Start of Navigation Bar-->
    <div class="container-fluid" id="NavBar">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand toplogo" href="index2.php"><img src="../frontend/img/ezeatsred.png" alt="EzEats"></a>
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
                        <a class="nav-link" id="Photo" href=""><img src="../database/img/user/<?= $user['gambar']; ?>" alt="Chou Tzu-yu"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Halo, <?= $fname; ?>!
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="account.php?id=<?= $id; ?>">Profil</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item exit" href="logout.php?location=account.php">Keluar</a></li>
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

    <!--Start of Profile-->
    <div class="container profile">
        <form action="" method="post" enctype="multipart/form-data" class="row private-info">
            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?= $user["gambar"]; ?>">
            <input type="hidden" name="coverLama" value="<?= $user["cover"]; ?>">
            <div class="profile-header">
                <div class="images-header">
                    <img class="profile-cover" src="../database/img/user/cover/<?= $user["cover"]; ?>" alt="Fast Food Cover">
                    <img class="profile-image" src="../database/img/user/<?= $user["gambar"]; ?>" alt="McDonalds Dramaga">
                    <img class="profile-image-bg" src="../frontend/img/white.jpg" alt="">
                    <div id="upload-profile-image">
                        <label for="image-input">
                            <img class="upload-image" src="../frontend/img/editphoto_white.png" />
                        </label>
                        <input type="file" name="gambar" id="image-input" accept="image/*">
                    </div>
                    <div>
                        <label for="cover-input">
                            <a class="btn btn-outline-light">Edit Sampul</a>
                        </label>
                        <input type="file" name="cover-image" id="cover-input" accept="image/*">
                    </div>
                </div>

                <h2 class="resto-name"><?= $user["nama"]; ?></h2>
                <h3 class="resto-rate"><?= $user["deskripsi_singkat"]; ?></h3>
                <h3 class="resto-review"><strong><?= $count_nilai; ?></strong> Penilaian<strong><i class="bi bi-dot"></i><?= $count_ulasan; ?></strong> Ulasan</h3>
                <br><br><br>
            </div>

            <div class="profile-body">
                <div class="row">
                    <div class="col-3">
                        <div class="sidebar edit-profile active"><a href="account.php?id=<?= $id; ?>">Edit Profil</a></div>
                        <div class="sidebar activities"><span class="">Aktivitas</span>
                            <div class="items user-recently"><a href="">Baru Dilihat</a></div>
                            <div class="items user-ratings"><a href="">Penilaian</a></div>
                            <div class="items last user-reviews"><a href="profilulasan.php?id=<?= $id; ?>"><strong>Ulasan</strong></a></div>
                        </div>
                        <div class="sidebar collection"><span class="">Koleksi Saya</span>
                            <div class="items favorite-resto"><a href="">Favorit</a></div>
                            <div class="items last black-listed"><a href="">Daftar Hitam</a></div>
                        </div>
                    </div>

                    <div class="col-8 form">
                        <div class="row title">
                            <div class="col-auto me-auto">
                                <h4>Informasi Pribadi</h4>
                            </div>
                        </div>

                        <div class="col-10 mb-3">
                            <label for="formUserData" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control edit-info" id="formUserData-name" placeholder="<?= $user["nama"]; ?>" required value="<?= $user["nama"]; ?>">
                        </div>

                        <div class="col-10 mb-3">
                            <label for="formUserData" class="form-label">Deskripsi Singkat</label>
                            <input type="text" name="deskripsi_singkat" class="form-control edit-info" id="formUserData-nick" placeholder="<?= $user["deskripsi_singkat"]; ?>" value="<?= $user["deskripsi_singkat"]; ?>">
                        </div>

                        <div class="col-10 mb-3">
                            <label for="formUserData" class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control edit-info" id="formUserData-email" placeholder="<?= $user["email"]; ?>" required value="<?= $user["email"]; ?>" readonly>
                        </div>

                        <div class="col-10 mb-3">
                            <label for="formUserData" class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telp" class="form-control edit-info" id="formUserData-phone" placeholder="<?= $user["no_telp"]; ?>" value="<?= $user["no_telp"]; ?>">
                        </div>

                        <div class="col-10 mb-3">
                            <label for="formUserData" class="form-label">Alamat Rumah</label>
                            <input type="text" name="alamat" class="form-control edit-info" id="formUserData-address" placeholder="<?= $user["alamat"]; ?>" value="<?= $user["alamat"]; ?>">
                        </div>
                        <button id="save-button" type="submit" name="submit" class="btn btn-danger float-end">Edit Data</button>
                        <div>
                            <h4>

                            </h4>
                        </div>
                        <div class="row title">
                            <div class="col-auto me-auto">
                                <h4>Ganti Password</h4>
                            </div>

                        </div>
                        <div class="col-10 mb-3">
                            <label for="currentPassword" class="form-label">Password Sekarang</label>
                            <input type="password" name="password" id="currentPassword" class="form-control edit-password">
                        </div>

                        <div class="col-10 mb-3">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password" name="passwordBaru" id="newPassword" class="form-control edit-password" minlength="8">
                        </div>

                        <div class="col-10 mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="passwordConf" id="confirmPassword" class="form-control edit-password" minlength="8">
                            <div style="position: absolute;" id='message'></div>
                        </div>
                        <button id="save-button" type="submit" name="submit1" class="btn btn-danger float-end">Edit Password</button>
                        <script>
                            $('#newPassword, #confirmPassword').on('keyup', function() {
                                if ($('#newPassword').val().length > 7) {
                                    if ($('#newPassword').val() == $('#confirmPassword').val()) {
                                        $('#message').html('Password Cocok').css('color', '#24923D');
                                    } else
                                        $('#message').html('Password Tidak Cocok!').css('color', '#DD3131');
                                } else $('#message').html('Password Minimal Terdiri dari 8 Karakter!').css('color', '#DD3131')
                            });
                        </script>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End of Restaurant Info-->


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