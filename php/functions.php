<?php
// Set Parameters. Note : Adjust them first with your settings.
$host = "localhost";
$port = "5432";
$dbname = "db_ezeats";
$user = "postgres";
$password = "database256";

// Heroku
// $host = "ec2-34-193-112-164.compute-1.amazonaws.com";
// $port = "5432";
// $dbname = "d9st9c2rk8hpff";
// $user = "zutlzvfhjrhhdd";
// $password = "b967f5538cedbd71197eca4d7fba9058a81ca954837d91383885fcd931480839";

// Create connection.
$dbconn = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";

// Turn on connection.
$koneksi = pg_connect($dbconn);

function query($query)
{
    global $koneksi;
    $result = pg_query($koneksi, $query);
    $rows = [];
    while ($row = pg_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function login($loc, $uid, $idr)
{
    if ($loc == 'kategori.php') {
        echo "<script LANGUAGE='JavaScript'>
                 window.alert('Login Successfully!');
                 window.location.href='kategori2.php?id=$uid';
              </script>";
    } else if ($loc == 'index.php') {
        echo "<script LANGUAGE='JavaScript'>
                 window.alert('Login Successfully!');
                 window.location.href='index2.php?id=$uid';
              </script>";
    } else if ($loc == 'info.php') {
        echo "<script LANGUAGE='JavaScript'>
                 window.alert('Login Successfully!');
                 window.location.href='info2.php?id=$uid$idr';
              </script>";
    }
}

function logout($loc, $idr)
{
    if ($loc == 'index2.php') {
        header("Location: ../index.php");
    } else if ($loc == 'kategori2.php') {
        header("Location: kategori.php");
    } else if ($loc == 'account.php') {
        header("Location: ../index.php");
    } else if ($loc == 'info2.php') {
        header("Location: info.php?idr=$idr");
    } else if ($loc == 'profilulasan.php') {
        header("Location: ../index.php");
    }
}

function addTerbantu($check, $uvotes, $dvotes, $idr)
{
    global $koneksi;
    if ($check == "ya") {
        $upvotes = $uvotes + 1;
        if ($dvotes > 0) {
            $downvotes = $dvotes - 1;
        }
    } else if ($check == "tidak") {
        $downvotes = $dvotes + 1;
        if ($uvotes > 0) {
            $upvotes = $uvotes - 1;
        }
    }
    $query = "UPDATE tb_resto SET upvotes = $upvotes, downvotes = $dvotes WHERE resto_id = $idr";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}

function addResto($data, $uid)
{
    global $koneksi;
    $user_id = $uid;
    $nama = htmlspecialchars($data["namaresto"]);
    $no_telp = htmlspecialchars($data["no-telp"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $fasilitas = htmlspecialchars($data["fasilitas"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $jambuka = htmlspecialchars($data["jambuka"]);
    $jamtutup = htmlspecialchars($data["jamtutup"]);
    $jalan = htmlspecialchars($data["jalan"]);
    $kec = htmlspecialchars($data["namakec"]);
    $kotakab = htmlspecialchars($data["kotakab"]);
    $namakabkota = htmlspecialchars($data["namakabkota"]);
    $upvotes = 0;
    $downvotes = 0;
    // Check if user wants to upload image or not.
    if ($_FILES['fotoresto']['error'] === 4) {
        $foto_resto = 'resto-default.jpg';
    } else {
        $foto_resto = upload('fotoresto');
    }

    if ($_FILES['fotomenu']['error'] === 4) {
        $foto_menu = 'menu-default.jpg';
    } else {
        $foto_menu = upload('fotomenu');
    }

    // Check jika ada file yg diupload
    if (!$foto_resto || !$foto_menu) {
        return FALSE;
    }
    // Query insert data
    $query = "INSERT INTO tb_resto(user_id, nama, kategori, no_telp, fasilitas, harga, 
                                   jambuka, jamtutup, deskripsi, jalan, kecamatan, kotakab, namaKabKota, 
                                   foto_resto, foto_menu, upvotes, downvotes)
                    VALUES
             ($user_id, '$nama', '$kategori', '$no_telp', '$fasilitas', '$harga', 
              '$jambuka', '$jamtutup', '$deskripsi', '$jalan', '$kec','$kotakab', '$namakabkota', 
              '$foto_resto', '$foto_menu', $upvotes, $downvotes)";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}

function addReview($data, $idr, $id)
{
    global $koneksi;
    $user_id = $id;
    $resto_id = $idr;
    $judul = htmlspecialchars($data["judul-ulasan"]);
    $ulasan = htmlspecialchars($data["ulasan-resto"]);
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = (string)(date("d/m/Y"));
    $jam = (string)(date('H:i'));
    $rekomendasi = "";
    $upvotes = 0;
    $downvotes = 0;
    // Check if user wants to upload image or not.
    if ($_FILES['gambar-ulasan']['error'] === 4) {
        $gambar = '';
    } else {
        $gambar = upload('gambar-ulasan');
    }
    $query = "INSERT INTO tb_review(user_id, resto_id, judul, ulasan, gambar, jam, tanggal, upvotes, downvotes, rekomendasi)
              VALUES ($user_id, $resto_id, '$judul', '$ulasan', '$gambar', '$jam', '$tanggal', $upvotes, $downvotes, '$rekomendasi')";

    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}

function addVote($vote, $status, $resto_id, $review_id)
{
    global $koneksi;
    if ($status == 0) {
        if ($vote == "ya") {
            $query = "UPDATE tb_resto SET upvotes = upvotes + 1 WHERE id = $resto_id";
            $query1 = "UPDATE tb_review SET rekomendasi = 'Merekomendasikan' WHERE id = $review_id";
        } else if ($vote == "tidak") {
            $query = "UPDATE tb_resto SET downvotes = downvotes + 1 WHERE id = $resto_id";
            $query1 = "UPDATE tb_review SET rekomendasi = 'Tidak Merekomendasikan' WHERE id = $review_id";
        }
    } else if ($status == 1) {
        if ($vote == "ya") {
            $query = "UPDATE tb_resto SET upvotes = upvotes + 1, downvotes = downvotes - 1 WHERE id = $resto_id";
            $query1 = "UPDATE tb_review SET rekomendasi = 'Merekomendasikan' WHERE id = $review_id";
        } else if ($vote == "tidak") {
            $query = "UPDATE tb_resto SET downvotes = downvotes + 1, upvotes = upvotes - 1 WHERE id = $resto_id";
            $query1 = "UPDATE tb_review SET rekomendasi = 'Tidak Merekomendasikan' WHERE id = $review_id";
        }
    }
    $result = pg_query($koneksi, $query);
    $haha = pg_query($koneksi, $query1);
    return pg_affected_rows($result);
}

function addreviewVote($vote, $status, $resto_id, $uid)
{
    global $koneksi;
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = (string)(date("d/m/Y"));
    $jam = (string)(date('H:i'));
    if ($status == 0) {
        if ($vote == "ya") {
            $query = "UPDATE tb_resto SET upvotes = upvotes + 1 WHERE id = $resto_id";
            $query1 = "INSERT INTO tb_review (user_id, resto_id,rekomendasi, upvotes, downvotes, jam, tanggal) VALUES ($uid,$resto_id,'Merekomendasikan', 0, 0, '$jam', '$tanggal')";
        } else if ($vote == "tidak") {
            $query = "UPDATE tb_resto SET downvotes = downvotes + 1 WHERE id = $resto_id";
            $query1 = "INSERT INTO tb_review (user_id, resto_id,rekomendasi, upvotes, downvotes, jam, tanggal) VALUES ($uid,$resto_id,'Tidak Merekomendasikan', 0, 0, '$jam', '$tanggal')";
        }
    } else if ($status == 1) {
        if ($vote == "ya") {
            $query = "UPDATE tb_resto SET upvotes = upvotes + 1, downvotes = downvotes - 1 WHERE id = $resto_id";
            $query1 = "INSERT INTO tb_review (user_id, resto_id,rekomendasi, upvotes, downvotes, jam, tanggal) VALUES ($uid,$resto_id,'Merekomendasikan', 0, 0, '$jam', '$tanggal')";
        } else if ($vote == "tidak") {
            $query = "UPDATE tb_resto SET downvotes = downvotes + 1, upvotes = upvotes - 1 WHERE id = $resto_id";
            $query1 = "INSERT INTO tb_review (user_id, resto_id,rekomendasi, upvotes, downvotes, jam, tanggal) VALUES ($uid,$resto_id,'Tidak Merekomendasikan', 0, 0, '$jam', '$tanggal')";
        }
    }
    $result = pg_query($koneksi, $query);
    $haha = pg_query($koneksi, $query1);
    return pg_affected_rows($result);
}

function add($data)
{
    // Fetch data from inputs.
    global $koneksi;
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $no_telp = htmlspecialchars($data["no_telp"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $cover = 'bgimage.png';
    // Upload image.
    $gambar = upload('gambar');
    if (!$gambar) {
        return FALSE;
    }

    // Query insert data
    $query = "INSERT INTO tb_user(nama, email, no_telp, alamat, gambar ,cover)
                    VALUES
                ('$nama', '$email', '$no_telp', '$alamat','$gambar', '$cover')
                ";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}

function coverImage($inp)
{
    switch ($inp) {
        case 'Kuliner Indonesia':
            return 'indonesian.png';
            break;
        case 'Kuliner Jepang':
            return 'japanese.png';
        case 'Aneka Ayam':
            return 'chicken.png';
        case 'Cepat Saji':
            return 'fastfood.png';
        case 'Makanan Penutup':
            return 'sweets.png';
        case 'Aneka Mie dan Bakso':
            return 'noodles.png';
        case 'Aneka Minuman':
            return 'drinks.png';
        case 'Kuliner Korea':
            return 'korean.png';
    }
}

function upload($source)
{
    $name_file = $_FILES[$source]["name"];
    $size_file = $_FILES[$source]["size"];
    $error = $_FILES[$source]["error"];
    $tmpName = $_FILES[$source]["tmp_name"];

    // Tokenizing image name.
    $ekstensigambar = ['jpg', 'png', 'jpeg'];
    $extgambar = explode('.', $name_file);
    $extgambar = strtolower(end($extgambar));
    // Check if uploaded file is image
    if (!in_array($extgambar, $ekstensigambar)) {
        echo "<script>
                    alert('Yang diupload bukan gambar!');
                  </script>";
        return FALSE;
    }
    // check if File size is large or not.
    if ($size_file > 3000000) {
        echo "<script>
                    alert('Ukuran gambar terlalu besar!');
                  </script>";
        return FALSE;
    }
    // Generate new image name
    $namagambarBaru = uniqid();
    $namagambarBaru .= '.';
    $namagambarBaru .= $extgambar;
    if ($source == "gambar") {
        move_uploaded_file($tmpName, "../database/img/user/$namagambarBaru");
    } else if ($source == 'cover-image') {
        move_uploaded_file($tmpName, "../database/img/user/cover/$namagambarBaru");
    } else if ($source == "gambar-ulasan") {
        move_uploaded_file($tmpName, "../database/img/resto/ulasan/$namagambarBaru");
    } else if ($source == "fotomenu") {
        move_uploaded_file($tmpName, "../database/img/menu/$namagambarBaru");
    } else if ($source == 'fotoresto') {
        move_uploaded_file($tmpName, "../database/img/resto/$namagambarBaru");
    }
    return $namagambarBaru;
}

function delete($id)
{
    global $koneksi;
    $query = "DELETE FROM tb_user WHERE id = $id";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}
function updatePassword($data, $uid)
{
    global $koneksi;
    $id = $uid;
    $password = pg_escape_string($data["password"]);
    $passwordBaru = pg_escape_string($data["passwordBaru"]);
    $passwordConf = pg_escape_string($data["passwordConf"]);
    $result = pg_query($koneksi, "SELECT password from tb_user WHERE id = $id");
    // Check password
    $row = pg_fetch_assoc($result);
    // Add Superglobal variable
    if (password_verify($password, $row["password"])) {
        if ($passwordBaru == $passwordConf) {
            $password = password_hash($passwordBaru, PASSWORD_DEFAULT);
            $result = pg_query($koneksi, "UPDATE tb_user SET password = '$password' 
                WHERE id = $id");
            $_SESSION["password"] = $passwordBaru;
            return pg_affected_rows($result);
        } else {
            echo "
                    <script>
                        alert('Konfirmasi password salah!');
                    </script>
                    ";
            return -1;
        }
    } else {
        echo "
                <script>
                    alert('Current password salah!');
                </script>
                ";
        return -1;
    }
}


function updateUser($data, $uid)
{
    // Fetch data from user input.
    global $koneksi;
    $id = $uid;
    $nama = htmlspecialchars($data["nama"]);
    $no_telp = htmlspecialchars($data["no_telp"]);
    $email = htmlspecialchars($data["email"]);
    $deskripsi = htmlspecialchars($data["deskripsi_singkat"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $gambarLama = $data["gambarLama"];
    $coverLama = $data["coverLama"];

    // Check if user wants to change image or not.
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload('gambar');
    }
    // Check if user wants to change image or not.
    if ($_FILES['cover-image']['error'] === 4) {
        $cover = $coverLama;
    } else {
        $cover = upload('cover-image');
    }
    // Query insert data
    $query = "UPDATE tb_user SET 
                    nama = '$nama', 
                    email = '$email', 
                    no_telp = '$no_telp', 
                    deskripsi_singkat = '$deskripsi',
                    alamat = '$alamat', 
                    gambar = '$gambar',
                    cover = '$cover'
                  WHERE id = '$id'
                ";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}

function search($keyword)
{
    $query = "SELECT * FROM tb_resto 
                    WHERE 
                  UPPER(nama) LIKE UPPER('%$keyword%')
                  OR UPPER(deskripsi) LIKE UPPER('%$keyword%')
                  OR UPPER(kategori) LIKE UPPER('%$keyword%')
                  OR UPPER(web) LIKE UPPER('%$keyword%')
                ";
    return query($query);
}

function signup($data)
{
    global $koneksi;
    $nama = $data["nama"];
    $email = strtolower(stripslashes($data["email"]));
    $password = pg_escape_string($data["password"]);
    $password2 = pg_escape_string($data["password2"]);
    $gambar = "no-image.jpg";
    $cover = 'bgimage.png';

    // Check if email has been created or not.
    $result = pg_query($koneksi, "SELECT email from tb_user WHERE 
                           email = '$email'");
    if (pg_fetch_assoc($result)) {
        echo "<script>
                    alert('Email sudah terdaftar!');
              </script>";
        return false;
    }

    // Check password.
    if ($password !== $password2) {
        echo "<script>
                    alert('Konfirmasi password tidak sesuai!');
                  </script>";

        return false;
    }

    // encrypt a password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // Add new user in database
    $query = "INSERT INTO tb_user(nama, email, password, gambar, cover)
                    VALUES ('$nama', '$email', '$password', '$gambar', '$cover')
                ";
    $result = pg_query($koneksi, $query);
    return pg_affected_rows($result);
}
