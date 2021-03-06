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


?>


<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.35">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../forntend/css/profil-ulasan.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
  <title><?= $fname; ?> - EzEats</title>
</head>

<body>
  <!--Start of Navigation Bar-->
  <div class="container-fluid" id="NavBar">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand toplogo" href="index2.php"><img src="../forntend/img/logo ezeats red.png" alt="EzEats"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <form action="" class="d-inline-flex flex-fill justify-content-center align-items-center searchbar" method="post" enctype="multipart/form-data">
            <input class="form-control me-2 inputbox" name="cari" type="search" placeholder="Mau makan apa hari ini?"
              aria-label="Search">
            <button class="btn btn-outline-danger" name="submit-cari"type="submit"><i class="bi bi-search "></i></button>
          </form>
          <div class="navbar-nav ms-auto">
            <a class="nav-link" id="Photo" href="#"><img src="../database/img/user/<?= $user["gambar"]; ?>" alt="<?= $fname; ?>"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Halo, <?= $fname; ?>!
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="account.php?id=<?= $id; ?>">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item exit" href="logout.php?location=profilulasan.php">Keluar</a></li>
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
    <div class="profile-header">
      <div class="images-header">
        <img class="profile-cover" src="../frontend/img/begron.png" alt="Fast Food Cover">
        <img class="profile-image" src="../database/img/user/<?= $user["gambar"]; ?>" alt="McDonalds Dramaga">
        <img class="profile-image-bg" src="../forntend/img/white.jpg" alt="">
      </div>
      <h2 class="resto-name"><?= $user["nama"]; ?></h2>
      <h3 class="resto-rate"><?= $user["deskripsi_singkat"]; ?></h3>
      <h3 class="resto-review"><strong><?= $count_nilai; ?></strong> Penilaian<strong><i class="bi bi-dot"></i><?= $count_ulasan; ?></strong> Ulasan</h3>
      <br><br><br>
    </div>

    <div class="profile-body">
      <div class="row">
        <div class="col-3">
          <div class="sidebar edit-profile"><a href="account.php?id=<?= $id; ?>">Edit Profil</a></div>
          <div class="sidebar activities"><span class="active">Aktivitas</span> 
            <div class="items user-recently"><a href="profil-histori.html">Baru Dilihat</a></div>
            <div class="items user-ratings"><a href="profilpenilaian.php?id=<?= $id; ?>">Penilaian</a></div>
            <div class="items last user-reviews active"><a href="#">Ulasan</a></div>           
          </div>
          <div class="sidebar collection"><span class="">Koleksi Saya</span>
            <div class="items favorite-resto"><a href="profil-favorit.html">Favorit</a></div>
            <div class="items last black-listed"><a href="profil-blacklist.html">Daftar Hitam</a></div>
          </div>
        </div>
        <div class="col-9">
          <div class="cards">
            <?php foreach ($reviews as $review) : ?>
                <?php if ($review["judul"] != NULL) : ?>
                        <?php
                        $resto_id = $review["resto_id"];
                        $resto = query("SELECT * FROM tb_resto WHERE id = $resto_id")[0];
                        // Untuk daerah
                        if ($resto["kotakab"] == "Kota") {$daerah = "Kota";} 
                        else if ($resto["kotakab"] == "Kabupaten") {$daerah = "Kab.";
                        }?>
            <div class="card">
              <div class="card-head">
                <div class="row">                  
                  <div class="col-md-7 resto">
                    <img src="../database/img/resto/<?= $resto["foto_resto"]; ?>" alt="">
                    <span class="title">
                      <div class="resto-name"><a href="info2.php?id=<?= $id; ?>&idr=<?= $resto_id; ?>"><?= $resto["namaresto"]; ?></a></div>
                      <div class="resto-address"><i class="bi bi-geo-alt"></i>?= $resto["kecamatan"] . ", " . $daerah . " " . $resto["kota"]; ?></div>
                    </span>
                  </div>
                  <?php if ($review["rekomendasi"] != "") : ?>
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
                  <div class="col-md-5 rating" id="<?= $var1; ?>">
                    <span class="icon"><i class="bi bi-hand-thumbs-<?= $var2; ?>"></i></span>
                    <span class="info"><?= $status; ?></span>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-body">                
                <div class="subject"><strong><?= $review["judul"]; ?></strong></div>
                <div class="detail">
                  <p>
                    <?= $review["ulasan"]; ?>
                  </p>
                </div>
                <div class="img-wrap">
                  <img src="../database/img/resto/<?=resto["foto_resto"]?>" alt="<?= $review["judul"]; ?>" class="review-image">
                </div>
                <div class="btn-group dropstart">
                  <a class="btn btn-light" href="#" role="button" 
                    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-pencil-fill"></i></a>                        
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-edit">Edit Ulasan</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete-modal">Hapus Ulasan</a></li>                            
                  </ul>
                </div>                        
              </div> 
              <div class="card-bottom">
                <div class="row justify-content-between">
                  <div class="col-md-5 timestamp"><?= $review["jam"] . " " . $review["tanggal"]; ?></div>  
                  <div class="col-md-5 voter-info"><strong><?= $review["upvotes"]; ?></strong> dari <strong><?= $review["upvotes"] + $review["downvotes"]; ?></strong> Voter Terbantu</div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>

          <div id="images-modal" class="modal zoom-image">
            <span class="close">&times;</span>
            <img class="modal-content" id="img-zoom">
            <div id="caption"></div>
          </div>

          <div class="modal modal-edit fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">
                    Edit Ulasan Anda
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <form>
                      <div class="mb-3">
                        <label for="review-title" class="col-form-label">Judul Ulasan</label>
                        <input type="text" class="form-control" id="review-title" placeholder="Maksimal 35 Karakter"
                          maxlength="35" />
                      </div>
                      <div class="mb-3">
                        <label for="review-description" class="col-form-label">Deskripsi Ulasan</label>
                        <textarea class="form-control" oninput="auto_grow(this)" id="review-description"
                          placeholder="Maksimal 2000 Karakter" maxlength="2000"></textarea>
                        <script>
                          function auto_grow(element) {
                            element.style.height = "5px";
                            element.style.height = element.scrollHeight + "px";
                          }
                        </script>
                      </div>
                      <div class="mb-3">
                        <label for="review-attachment" class="col-form-label">Tambahkan Gambar</label><br />
                        <input type="file" id="upload-file" name="filename" accept="image/jpg image/jpeg image/png" />
                      </div>
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <div class="container">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      Tutup
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                      data-bs-dismiss="modal" data-bs-target="#modal-edit-2">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal modal-edit fade" id="modal-edit-2" tabindex="-1" aria-labelledby="staticBackdropLabel2">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">               
                <div class="modal-body">
                  <h6>Ulasan Anda Telah Berhasil Diubah!</h6>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-modal2" data-bs-dismiss="modal">Mengerti</button>                      
                </div>
              </div>
            </div>
          </div>

          <div class="modal modal-delete fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabe1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel1">Konfirmasi Menghapus</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <h6>Apakah Anda Yakin Ingin Menghapus Ulasan Resto Ini?</h6>
                </div>
                <div class="d-flex modal-footer justify-content-between">              
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-danger open-modal2" data-bs-toggle="modal" 
                      data-bs-dismiss="modal" data-bs-target="#delete-modal-2">Hapus</button>             
                </div>
              </div>
            </div>
          </div>
    
          <div class="modal modal-delete fade" id="delete-modal-2" tabindex="-1" aria-labelledby="staticBackdropLabel2">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">               
                <div class="modal-body">
                  <h6>Ulasan Anda Telah Berhasil Dihapus!</h6>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-modal2" data-bs-dismiss="modal">Mengerti</button>                      
                </div>
              </div>
            </div>
          </div>

          <script>
            // If src Null, Div Hide
            $('img[src=""]').parents('.img-wrap').hide();

            // create references to the modal...
            var modal = document.getElementById('images-modal');
            // to all images -- note I'm using a class!
            var images = document.getElementsByClassName('review-image');
            // the image in the modal
            var modalImg = document.getElementById("img-zoom");
            // and the caption in the modal
            var captionText = document.getElementById("caption");

            // Go through all of the images with our custom class
            for (var i = 0; i < images.length; i++) {
              var img = images[i];
              // and attach our click listener for this image.
              img.onclick = function(evt) {
                modal.style.display = "flex";
                modal.style.flexDirection = "column";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
              }
            }

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
              modal.style.display = "none";
            }

          </script>

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

      </div>
    </div>
      
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
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>