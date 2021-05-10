<?php 
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

// Ambil data dari URL
$id = $_GET["id"];
// Query data based on id
$user = query("SELECT * FROM tb_user WHERE id = '$id' ")[0];
$email = $user["email"];
$query = "SELECT * FROM tb_user WHERE email = '$email' ";
$result = pg_query($koneksi, $query);

// Check if submit button has been touched or not
if( isset($_POST["submit"]) )  {
    // Check if data is submitted successfully.
    if ( updateUser($_POST) > 0 ) {
        echo "
            <script>
                alert('Data berhasil diubah!');
            </script>
        ";
        header("Refresh:0");
    }
    else {
        // echo pg_errormessage(ubah($_POST));
        echo "
            <script>
                alert('Data gagal diubah');
            </script>
        ";
        header("Refresh:0");
    }
}

if (isset($_POST["submit1"])) {
    if (updatePassword($_POST) > 0) {
        echo "
        <script>
            alert('Password berhasil diubah!');
        </script>
        ";
        header("Refresh:0");        
    }
    else {
        echo "
            <script>
                alert('Password gagal diubah!');
            </script>
        ";     
        header("Refresh:0");   
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>

</head>
<body>
    <a href="index.php">Home</a><br>
    <a href="logout.php">Logout</a><br><br>
    <form action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" name = "id" value="<?= $user["id"]; ?>">
        <input type="hidden" name = "gambarLama" value="<?= $user["gambar"]; ?>">
        <?php 
            // Find Root Directory
            $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
        ?>
        <img src="http://localhost/ezeats/images/<?=$user['gambar'];?>" width="100" height="100">
        <p style="color:black; font-weight:bold;"><?= $user["nama"]; ?></p>
        <p style="color:black;"><?= $user["deskripsi_singkat"]; ?></p>
        <br>
        <input type="file" name ="gambar" id="gambar">
        <p style="color: brown;">Maksimal ukuran foto 5 MB</p>
        <h1>Account Information</h1>
            <ul>
                <label for="nama" > Nama Lengkap </label><br>
                <input type="text" name="nama" id="nama" placeholder="<?= $user["nama"]; ?>"
                required
                value="<?= $user["nama"]; ?>"><br>

                <label for="deskripsi_singkat" > Deskripsi Singkat </label><br>
                <input type="text" name="deskripsi_singkat" id="deskripsi_singkat" placeholder="<?= $user["deskripsi_singkat"]; ?>"
                value="<?= $user["deskripsi_singkat"]; ?>"><br>

                <label for="email" > Alamat Email </label><br>
                <input type="text" name="email" id="email" placeholder="<?= $user["email"]; ?>"
                required
                value="<?= $user["email"]; ?>" readonly><br>

                <label for="no_telp" > No. Telepon </label><br>
                <input type="text" name="no_telp" id="no_telp" placeholder="<?= $user["no_telp"]; ?>"
                value="<?= $user["no_telp"]; ?>" ><br>

                <label for="alamat" > Alamat </label><br>
                <input type="text" name="alamat" id="alamat" placeholder="<?= $user["alamat"]; ?>"
                value="<?= $user["alamat"]; ?>"><br><br>
                <button type="submit" name="submit">Edit Data</button>

            </ul>
        
        <h1>Change Password</h1>
            <ul>
                <label for="password" >Current Password</label><br>
                <input type="password" name="password" id="password"><br>
                <label for="passwordBaru" >New Password</label><br>
                <input type="password" name="passwordBaru" id="passwordBaru"><br>
                <label for="passwordConf" >Confirm Password</label><br>
                <input type="password" name="passwordConf" id="passwordConf"><br><br>
                <button type="submit" name="submit1">Edit Password</button>
            </ul>
    </form>

</body>
</html>

