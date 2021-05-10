<?php 
require 'functions.php';
if( isset($_POST["register"]) ) {
    if(signup($_POST) > 0) {
        echo "<script>
                alert('Akun anda sudah terdaftar!')
              </script>";
        // header("Location: login.php");
    } else {
        echo pg_errormessage($koneksi);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
<h1>Sign Up</h1>

    <form action="" method="post"> 
        <ul>
            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap"><br>
            <input type="text" name="email" id="email" placeholder="Email"><br>  
            <input type="password" name="password" id="password" placeholder="Password"><br>
            <input type="password" name="password2" id="password2" placeholder="Retype Password"><br><br>
            <button type="submit" name="register"> Continue </button>

        </ul>
    </form>
        <p style="color: black;">Sudah memiliki akun? <a style="color: red; font-weight: bold; " href="login.php">Sign In</a></p>
        


</body>
</html>