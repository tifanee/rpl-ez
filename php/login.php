<?php
session_start();
// Get previous URL
if (isset($_GET["location"])) {
    $urlreq = explode('/', $_GET["location"]);
    $urlreq = explode('?', end($urlreq));
    $location = $urlreq[0];
}

$idr = NULL;
if (isset($_GET["idr"])) {
    $idr = $_GET["idr"];
    $idr = "&idr=" . $idr;
}

require 'functions.php';

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $query = "SELECT * FROM tb_user WHERE email = '$email' ";
    $result = pg_query($koneksi, $query);
    // Check if email exists
    if (pg_num_rows($result) === 1) {
        // Check password
        $row = pg_fetch_assoc($result);
        // Add Superglobal variable
        if (password_verify($password, $row["password"])) {
            // Set Session
            $_SESSION["login"] = true;
            $id = $row["id"];
            // $_SESSION["password"] = $password;
            if (isset($_SESSION['login'])) {
                login($location, $id, $idr);
                exit;
            }
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EzEats</title>
    <link rel="stylesheet" href="../frontend/css/sign_in.css" />
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
        <h1>Sign In</h1>
        <?php if (isset($error)) : ?>
            <script>
                alert('Email/Password Salah!')
            </script>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="email" class="form-input" id="email" placeholder="Email"><br>
            <input type="password" class="form-input" name="password" id="password" placeholder="Password"><br><br>
            <button type="submit" class="button-continue" name="login">Continue</button>
            <p class="punya-akun-ga">
                Belum memiliki akun?
                <a class="sign-up-click" href="signup.php">Sign Up</a>
            </p>
        </form>
    </div>


</body>

</html>