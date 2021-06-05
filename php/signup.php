<?php
require 'functions.php';

// Get previous URL
if (isset($_GET["location"])) {
  $location = $_GET["location"];
}

if (isset($_GET["idr"])) {
  $idr = $_GET["idr"];
  $location .= "&idr=$idr";
}


if (isset($_POST["register"])) {
  if (signup($_POST) > 0) {
    echo "<script LANGUAGE='JavaScript'>
              window.alert('Selamat, Akun kamu telah didaftarkan!');
              window.location.href='login.php?location=$location';
              </script>";
  } else {
    echo pg_errormessage($koneksi);
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="../frontend/css/sign_up.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet" />
  <style>
    body {
      background-image: url('../frontend/img/begron.png');
    }
  </style>

</head>

<body>
  <div class="judul-form">
    <img src="../frontend/img/ezeats_item.png" />
    <h1>Sign Up</h1>
    <form action="" method="post">
      <input type="Name" name="nama" class="form-input" id="Name" placeholder="Full Name" required />

      <br />
      <input type="email" class="form-input" name="email" id="email" placeholder="Email" />
      <br />
      <input type="password" name="password" class="form-input" id="Password" placeholder="Password" required />
      <br />
      <input type="password" class="form-input" name="password2" id="Password" placeholder="Retype Password" required />
      <br />
      <button type="submit" name="register" id="register" class="button-continue">Continue</button>
      <p class="punya-akun-ga">
        Sudah memiliki akun?
        <a class="sign-in-click" href="login.php?location=<?= $location; ?>">Sign In</a>
      </p>
    </form>
  </div>
</body>

</html>