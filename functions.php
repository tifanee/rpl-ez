<?php
	// Set Parameters. Note : Adjust them first with your settings.
	$host = "localhost";
	$port = "5432";
	$dbname = "db_ezeats";
	$user = "postgres";
	$password = "database256";
	
	// Create connection.
	$dbconn = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
	
	// Turn on connection.
	$koneksi = pg_connect($dbconn);

    function query($query) {
        global $koneksi;
        $result = pg_query($koneksi, $query);
        $rows = [];
        while( $row = pg_fetch_assoc($result) ) {
            $rows[] = $row;
        }
        return $rows;
    }


    function add($data) {
        // Fetch data from inputs.
        global $koneksi;
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $no_telp = htmlspecialchars($data["no_telp"]);
        $alamat = htmlspecialchars($data["alamat"]);
        $tanggal_lahir = $data["tanggal_lahir"];
        // Upload image.
        $gambar = upload();
        if (!$gambar) {
            return FALSE;
        }

        // Query insert data
        $query = "INSERT INTO tb_user(nama, email, no_telp, alamat, tanggal_lahir,gambar)
                    VALUES
                ('$nama', '$email', '$no_telp', '$alamat', '$tanggal_lahir','$gambar')
                ";
        $result = pg_query($koneksi, $query);
        return pg_affected_rows($result);

    }

    function upload() {
        $name_file = $_FILES["gambar"]["name"];
        $size_file = $_FILES["gambar"]["size"];
        $error = $_FILES["gambar"]["error"];
        $tmpName = $_FILES["gambar"]["tmp_name"];

        // Check if image has been uploaded or not.
        if( $error === 4 ) {
            echo "<script>
                    alert('Pilih Gambar Terlebih Dahulu!');
                  </script>";
            return FALSE;
        }
        // Tokenizing image name.
        $ekstensigambar = ['jpg','png','jpeg'];
        $extgambar = explode('.', $name_file);
        $extgambar = strtolower(end($extgambar));
        // Check if uploaded file is image
        if( !in_array($extgambar, $ekstensigambar) ) {
            echo "<script>
                    alert('Yang diupload bukan gambar!');
                  </script>";
            return FALSE;
            
        }
        // check if File size is large or not.
        if ( $size_file > 5000000 ) {
            echo "<script>
                    alert('Ukuran gambar terlalu besar!');
                  </script>";
            return FALSE;           
        }
        // Generate new image name
        $namagambarBaru = uniqid();
        $namagambarBaru .= '.';
        $namagambarBaru .= $extgambar;

        $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
        move_uploaded_file($tmpName, $rootDir."/ezeats/images/$namagambarBaru");
        return $namagambarBaru;
    }

    function delete($id) {
        global $koneksi;
        $query = "DELETE FROM tb_user WHERE id = $id";
        $result = pg_query($koneksi, $query);
        return pg_affected_rows($result);
    }
    function updatePassword($data) {
        global $koneksi;
        $id = $data["id"];
        $password = pg_escape_string($data["password"]);
        $passwordBaru = pg_escape_string($data["passwordBaru"]);
        $passwordConf = pg_escape_string($data["passwordConf"]);
        $result = pg_query($koneksi, "SELECT password from tb_user WHERE id = $id");
        // Check password
        $row = pg_fetch_assoc($result);
        // Add Superglobal variable
        if (password_verify($password, $row["password"])) {
            if($passwordBaru == $passwordConf) {
                $password = password_hash($passwordBaru, PASSWORD_DEFAULT);
                $result = pg_query($koneksi, "UPDATE tb_user SET password = '$password' 
                WHERE id = $id");
                $_SESSION["password"] = $passwordBaru;
                return pg_affected_rows($result);
            }
            else {
                echo "
                    <script>
                        alert('Konfirmasi password salah!');
                    </script>
                    ";              
                return -1;
            }
        }
        else {
            echo "
                <script>
                    alert('Current password salah!');
                </script>
                ";              
            return -1;
        }
    }


    function updateUser($data) {
        // Fetch data from user input.
        global $koneksi;
        $id = $data["id"];
        $nama = htmlspecialchars($data["nama"]);
        $no_telp = htmlspecialchars($data["no_telp"]);
        $email = htmlspecialchars($data["email"]);
        $deskripsi = htmlspecialchars($data["deskripsi_singkat"]);
        $alamat = htmlspecialchars($data["alamat"]);
        $gambarLama = $data["gambarLama"];
        
        // Check if user wants to change image or not.
        if($_FILES['gambar']['error'] === 4) {
            $gambar = $gambarLama;
        } else {
            $gambar = upload();
        }
        // Query insert data
        $query = "UPDATE tb_user SET 
                    nama = '$nama', 
                    email = '$email', 
                    no_telp = '$no_telp', 
                    deskripsi_singkat = '$deskripsi',
                    alamat = '$alamat', 
                    gambar = '$gambar'
                  WHERE id = '$id'
                ";
        $result = pg_query($koneksi, $query);
        return pg_affected_rows($result);   
    }

    function search($keyword) {
        $query = "SELECT * FROM tb_user 
                    WHERE 
                  UPPER(nama) LIKE UPPER('%$keyword%')
                  OR UPPER(email) LIKE UPPER('%$keyword%')
                  OR UPPER(alamat) LIKE UPPER('%$keyword%')
                ";
        return query($query);
    }

    function signup($data) {
        global $koneksi;
        $nama = $data["nama"];
        $email = strtolower(stripslashes($data["email"]));
        $password = pg_escape_string($data["password"]);
        $password2 = pg_escape_string($data["password2"]);
        $gambar = "no-photo.jpg";
        // Check if inputs are empty string.
        if($nama == "" || $email == "" || $password == "") {
            echo "<script>
                    alert('Tidak ada data yang anda masukkan!');
                  </script>";
            return false;            
        }

        // Check if email has been created or not.
        $result = pg_query($koneksi, "SELECT email from tb_user WHERE 
                           email = '$email'");
        if(pg_fetch_assoc($result)) {
            echo "<script>
                    alert('Email sudah terdaftar!');
                  </script>";
            return false;
        }

        // Check password.
        if($password !== $password2) {
            echo "<script>
                    alert('Konfirmasi password tidak sesuai!');
                  </script>";

            return false;
        }

        // encrypt a password
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Add new user in database
        $query = "INSERT INTO tb_user(nama, email, password, gambar)
                    VALUES ('$nama', '$email', '$password', '$gambar')
                ";
        $result = pg_query($koneksi, $query);
        return pg_affected_rows($result);
        
    }

?>