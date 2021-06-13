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

if (isset($_POST["submit-status"])) {
    if (updateReview($_POST) > 0) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
  <link rel="stylesheet" type="text/css" href="../frontend/css/profil-penilaian.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,1200" />
  <title><?= $fname; ?> - EzEats</title>
</head>

<body>
  <!--Start of Navigation Bar-->
  <div class="container-fluid" id="NavBar">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand toplogo" href="index2.php?id=<?= $id; ?>"><img src="../frontend/img/logo ezeats red.png" alt="EzEats"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <form action="" class="d-inline-flex flex-fill justify-content-center align-items-center searchbar" method="post" enctype="multipart/form-data">
            <input class="form-control me-2 inputbox" name="cari" type="search" placeholder="Mau makan apa hari ini?"
              aria-label="Search">
            <button class="btn btn-outline-danger" name="submit-cari" type="submit"><i class="bi bi-search "></i></button>
          </form>
          <div class="navbar-nav ms-auto">
            <a class="nav-link" id="Photo" href="#"><img src="../database/img/user/<?= $user["gambar"]; ?>" alt="Chou Tzu-yu"></a>
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
                    <li><a class="dropdown-item exit" href="logout.php?location=profilpenilaian.php">Keluar</a></li>
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
        <img class="profile-cover" src="../frontend/img/twice-wide.jpg" alt="Fast Food Cover">
        <img class="profile-image" src="../database/img/user/<?= $user["gambar"]; ?>" alt="McDonalds Dramaga">
        <img class="profile-image-bg" src="../img/white.jpg" alt="">
      </div>
      <h2 class="resto-name"><?= $user["nama"]; ?></h2>
      <h3 class="resto-rate"><?= $user["deskripsi_singkat"]; ?></h3>
      <h3 class="resto-review"><strong><?= $count_nilai; ?></strong> Penilaian<strong><i class="bi bi-dot"></i><?= $count_ulasan; ?></strong> Ulasan</h3>
      <br><br><br>
    </div>

    <div class="profile-body">
      <div class="row">
        <div class="col-3 bar">
          <div class="sidebar edit-profile"><a href="account.php?id=<?= $id; ?>">Edit Profil</a></div>
          <div class="sidebar activities"><span class="active">Aktivitas</span> 
            <div class="items user-recently"><a href="profil-histori.html">Baru Dilihat</a></div>
            <div class="items user-ratings active"><a href="profilpenilaian.php">Penilaian</a></div>
            <div class="items last user-reviews"><a href="profilulasan.php">Ulasan</a></div>           
          </div>
          <div class="sidebar collection"><span class="">Koleksi Saya</span>
            <div class="items favorite-resto"><a href="">Favorit</a></div>
            <div class="items last black-listed"><a href="">Daftar Hitam</a></div>
          </div>
        </div>
        <div class="col-9">
          <div class="rating-cards">

            <ul class="nav nav-tabs" id="rating-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="recommended-tab" data-bs-toggle="tab" data-bs-target="#recommended" type="button"
                  role="tab" aria-controls="recommended" aria-selected="true">Merekomendasikan</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="unrecommended-tab" data-bs-toggle="tab" data-bs-target="#unrecommended" type="button"
                  role="tab" aria-controls="unrecommended" aria-selected="false">Tidak Merekomendasikan</button>
              </li>
            </ul>
            <div class="tab-content" id="info-tab-content">
              <div class="tab-pane fade show active" id="recommended" role="tabpanel" aria-labelledby="recommended-tab">
                <form class="d-flex tab-searchbar" method="post">
                  <input class="form-control inputbox-recommended" type="search" id="keyword1" placeholder="Cari Resto"
                    aria-label="Search">
                    <input type="hidden" id="user_id" value="<?= $id; ?>">
                  <button class="btn btn-outline-danger" type="submit"><i class="bi bi-search "></i></button>
                </form>        
                <div class="container row row-cols-1 row-cols-xl-2 g-3">
                    <?php foreach ($reviews as $review) : ?>
                <?php if ($review["rekomendasi"] == "Merekomendasikan") : ?>
                <?php
                $idr = $review["resto_id"];
                $resto = query("SELECT * FROM tb_resto WHERE id = $idr")[0];
                // Untuk daerah
                if ($resto["kotakab"] == "Kota") {
                $daerah = "Kota";
                } else if ($resto["kotakab"] == "Kabupaten") {
                $daerah = "Kab.";
                }
                $views = $resto["upvotes"] + $resto["downvotes"];
                if ($views != 0) {
                $pro = ($resto["upvotes"] / $views) * 100;
                } else $pro = 0;
                ?>
                  <div class="col">
                    <div class="card h-100" id="">
                      <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>"><img src="../database/img/resto/<?= $resto["foto_resto"]; ?>" class="card-img-top" alt="Susu Mbok Darmi"></a>
                      <div class="card-body">
                        <h5 class="card-title"> <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>"><?= $resto["namaresto"]; ?></a> </h5>
                        <div class="card-rating"><i class="bi bi-hand-thumbs-up pl-2"></i><strong><?= (int)$pro; ?> %</strong> (<?= $views; ?> Penilaian)</div>
                        <div class="card-address"><i class="bi bi-geo-alt"></i><?= $resto["kecamatan"]; ?>, <?= $daerah; ?> <?= $resto["kota"]; ?></div>
                        <div class="d-flex user-rating good" id="">
                          <span class="icon"><i class="bi bi-hand-thumbs-up"></i></span>
                          <span class="info"><?= $review["rekomendasi"]; ?></span>
                        </div>
                        <div class="btn-group dropup">
                          <a class="btn btn-light" href="#" role="button" 
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i></a>                        
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Batalkan Penilaian</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">Ubah menjadi Tidak Rekomendasi</a></li>                            
                          </ul>
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="row justify-content-between">
                          <div class="col-4 time"><?= $review["jam"]; ?></div>
                          <div class="col-4 date"><?= $review["tanggal"]; ?></div>
                        </div>                        
                      </div>
                    </div>
                  </div>

                <br>
                <!--Start of Pagination-->
                <nav aria-label="Page navigation recommended-page">
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
                <?php endif; ?>
               <?php endforeach; ?>
              </div>

              <div class="tab-pane fade" id="unrecommended" role="tabpanel" aria-labelledby="unrecommended-tab">

                <form class="d-flex tab-searchbar" method="post"action="">
                  <input class="form-control inputbox-unrecommended" type="search" placeholder="Cari Resto" id="keyword2" name="keyword" 
                    aria-label="Search">
                  <button class="btn btn-outline-danger"  type="submit"><i class="bi bi-search "></i></button>
                </form>

                <div class="container row row-cols-1 row-cols-xl-2 g-3">
                    <?php foreach ($reviews as $review) : ?>
                                            <?php if ($review["rekomendasi"] == "Tidak Merekomendasikan") : ?>
                                                <?php
                                                $idr = $review["resto_id"];
                                                $resto = query("SELECT * FROM tb_resto WHERE id = $idr")[0];
                                                // Untuk daerah
                                                if ($resto["kotakab"] == "Kota") {
                                                    $daerah = "Kota";
                                                } else if ($resto["kotakab"] == "Kabupaten") {
                                                    $daerah = "Kab.";
                                                }
                                                $views = $resto["upvotes"] + $resto["downvotes"];
                                                if ($views != 0) {
                                                    $pro = ($resto["upvotes"] / $views) * 100;
                                                } else $pro = 0;
                                                ?>
                  <div class="col">
                    <div class="card h-100" id="">
                      <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>">"><img src="../database/img/resto/<?= $resto["foto_resto"]; ?>" class="card-img-top" alt="Taco Bell"></a>  
                      <div class="card-body">
                        <h5 class="card-title"> <a href="info2.php?id=<?= $id; ?>&idr=<?= $idr; ?>"><?= $resto["namaresto"]; ?></a> </h5>
                        <div class="card-rating"><i class="bi bi-hand-thumbs-up pl-2"></i><strong>93%</strong><?= (int)$pro; ?>%</strong> (<?= $views; ?> Penilaian)</div>
                        <div class="card-address"><i class="bi bi-geo-alt"></i><?= $resto["kecamatan"]; ?>, <?= $daerah; ?> <?= $resto["kota"]; ?></div>
                        <div class="d-flex user-rating bad" id="">
                          <span class="icon"><i class="bi bi-hand-thumbs-down"></i></span>
                          <span class="info"><?= $review["rekomendasi"]; ?></span>
                        </div>
                        <div class="btn-group dropup">
                          <a class="btn btn-light" href="#" role="button" 
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i></a>                        
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Batalkan Penilaian</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">Ubah menjadi Rekomendasi</a></li>                            
                          </ul>
                        </div>
                      </div>
                      <div class="card-footer">                        
                        <div class="row justify-content-between">
                          <div class="col-4 time"><?= $review["jam"]; ?></div>
                          <div class="col-4 date"><?= $review["tanggal"]; ?></div>
                        </div>   
                      </div>
                    </div>
                  </div>
                
                <!--Start of Pagination-->
                <nav aria-label="Page navigation unrecommended-page">
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

              <!-- Modal -->
              <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel1">Konfirmasi Pembatalan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h6>Apakah Anda Yakin Ingin Menghapus Penilaian untuk Resto ini?</h6>
                    </div>
                    <div class="d-flex modal-footer justify-content-between">
                        <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="review-id" value="<?= $review["id"]; ?>">
                        <input type="hidden" name="resto-id" value="<?= $review["resto_id"]; ?>">
                        <input type="hidden" name="judul-review" value="<?= $review["judul"]; ?>">
                        <input type="hidden" name="review-resto" value="<?= $review['ulasan']; ?>">
                        <input type="hidden" name="prev-status" value="<?= $review["rekomendasi"]; ?>">
                        <input type="hidden" name="status" value="<?= ""; ?>">
                        <div class="d-flex modal-footer justify-content-between">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-danger open-modal2" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#staticBackdrop2">Hapus</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdropLabel2">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">               
                    <div class="modal-body">
                      <h6>Penilaian Resto Telah Berhasil Dihapus!</h6>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary close-modal2" data-bs-dismiss="modal">Mengerti</button>                      
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel3">Konfirmasi Perubahan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h6>Apakah Anda Yakin Ingin Mengubah Penilaian untuk Resto ini?</h6>
                      <img src="../frontend/img/rec-to-unrec.png" alt="">
                    </div>
                    <div class="d-flex modal-footer justify-content-between">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-danger open-modal5" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#staticBackdrop5">Ubah</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel4">Konfirmasi Perubahan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h6>Apakah Anda Yakin Ingin Mengubah Penilaian untuk Resto ini?</h6>
                      <img src="../frontend/img/unrec-to-rec.png" alt="">
                    </div>
                    <div class="d-flex modal-footer justify-content-between">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-danger open-modal5" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#staticBackdrop5">Ubah</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="staticBackdrop5" tabindex="-1" aria-labelledby="staticBackdropLabel4">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">               
                    <div class="modal-body">
                      <h6>Penilaian Resto Telah Berhasil Diubah!</h6>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary close-modal5" data-bs-dismiss="modal">Mengerti</button>                      
                    </div>
                  </div>
                </div>
              </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <script>
              var firstTabEl = document.querySelector('#rating-tab li:last-child a')
              var firstTab = new bootstrap.Tab(firstTabEl)
              firstTab.show()

            </script>
            
            
            <br><br>
            
          </div>
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