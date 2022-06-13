<?php
    $conn = mysqli_connect("localhost", "admin", "admin", "kelompok2_db");

    function query($query) {
        global $conn;

        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }


    // Mengambil data untuk halaman my_gambar.php
    function get_gambar_saya($data) {
        global $conn;

        $stmt = $conn -> prepare("SELECT * FROM gambar WHERE fk_user_id = ?");
        $stmt -> bind_param("i", $data);
        $stmt -> execute();
        $result = $stmt -> get_result();
        return $result -> fetch_all(MYSQLI_ASSOC);
    }

    // Menyimpan data gambar dan thumbnail (jika ada) ke database
    function upload($data) {
        global $conn;

        // detail input
        $user_id = $_SESSION["user_id"];
        $judul_gambar = $data["judul_gambar"];
        $deskripsi_gambar = $data["deskripsi_gambar"];
        $tanggal_upload = date('Y-m-d h:i:s');
        $asal_gambar = $data["country"];

        if($judul_gambar == "") {
            echo "<script> alert('Masukkan nama gambar'); </script>";
            return false;
        }

        $gambar = upload_gambar();
        if(!$gambar) {
            
            return false;
        }

        $query = $conn -> prepare("INSERT INTO gambar(fk_user_id, judul_gambar, deskripsi_gambar, tanggal_upload, asal_gambar, nama_file)
                                    VALUES(?, ?, ?, ?, ?, ?)");
        $query -> bind_param("isssss", $user_id, $judul_gambar, $deskripsi_gambar, $tanggal_upload, $asal_gambar, $gambar);
        
        $query -> execute();
        // mysqli_query($conn, $query)
        
        return mysqli_affected_rows($conn);
                  
    }


    // Mengambil data gambar dari file pc
    function upload_gambar() {
        $namaFile = $_FILES['file_gambar']['name'];
        $ukuranFile = $_FILES['file_gambar']['size'];
        $error = $_FILES['file_gambar']['error'];
        $tmpName = $_FILES['file_gambar']['tmp_name'];

        if($error === 1){
            echo "<script> alert('Ukuran gambar yang dimasukkan terlalu besar!'); </script>" ;
            return false;
        }

        if($error === 4) {
            return false;
        }

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script> Format file yang dimasukkan salah! </script>" ;
            return false;
        }


        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
        return $namaFileBaru;
    }

    // Fungsi untuk login untuk halaman login.php
    function login($username, $password) {
        global $conn;

        $stmt = $conn -> prepare("SELECT * FROM user_tb WHERE username = ?");
        $stmt -> bind_param("s", $username);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["user_password"])) {
                // Membuat session login
                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $row['user_id'];
                $_SESSION["username"] = $row['username'];
                
                // Set cookie 
                if(isset($_POST["remember"])) {
                    // cookie atur selama 30 hari
                    setcookie('my_id', $row['user_id'], time() + (86400 * 30));
                    setCookie('key', hash('sha256', $row['username']), time() + (86400 * 30));
                }
                
                return true;
            } 
        }
        return false;

    }


    // Fungsi registrasi untuk halaman register.php
    function registrasi($data) {
        global $conn;

        $nama_lengkap = strtolower(stripcslashes($data["nama_lengkap"]));
        $username = strtolower(stripcslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $negara = $data["negara"];
  
        if(!validasi_data($nama_lengkap, $username, $password, $negara)) {
            return false;
        }

        // cek username
        $stmt = $conn -> prepare("SELECT username FROM user_tb WHERE username = ?");
        $stmt -> bind_param("s", $username);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if( mysqli_fetch_assoc($result)) {
            echo "<script>
                    alert('Username telah digunakan');
                  </script> 
                ";
            return false;
        }

        // enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        // tambah data ke database
        $stmt2 = $conn -> prepare("INSERT INTO user_tb(nama_lengkap, username, user_password, asal_negara) 
                        VALUES (?, ?, ?, ?)");
        $stmt2 -> bind_param("ssss", $nama_lengkap, $username, $password, $negara);
        $stmt2 -> execute();
        return mysqli_affected_rows($conn);
    }

    function validasi_data() {
        $arg_list = func_get_args();
        for($i = 0; $i < func_num_args(); $i++) {
            if($arg_list[$i] == "") {
                return false;
            }
        }
        return true;
    }

    // mengecek jika cookie sudah pernah dibuat
    function cek_cookie() {
        global $conn;

        if(isset($_COOKIE['my_id']) && isset($_COOKIE['key'])) {
            $id = $_COOKIE['my_id'];
            $key = $_COOKIE['key'];

            $stmt = $conn -> prepare("SELECT username FROM user_tb WHERE user_id = ?");
            $stmt -> bind_param("i", $id);
            $stmt -> execute();

            $result = $stmt -> get_result();
            $row = mysqli_fetch_assoc($result);

            if($key === hash('sha256', $row['username'])) {
                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $row['username'];
            }
        }
    } 

    // Mengambil data gambar yang sesuai dengan query pencarian
    function get_search_query($query) {
        global $conn;
        
        $param = "%{$query}%";
        $stmt = $conn -> prepare("SELECT * FROM gambar WHERE judul_gambar LIKE ?");
        $stmt -> bind_param("s", $param);
        $stmt -> execute();
        $result = $stmt -> get_result();
        return $result -> fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil data vigambardeo sesuai dengan query pencarian untuk gambar yang diupload pemilik akun 
    function get_gambarSaya_query($id, $query) {
        global $conn;

        $param = "%{$query}%";
        $stmt = $conn -> prepare("SELECT * FROM gambar WHERE fk_user_id = ? AND judul_gambar LIKE ?");
        $stmt -> bind_param("is", $id, $param);
        $stmt -> execute();
        $result = $stmt -> get_result();
        return $result -> fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil data untuk halaman detail_gambar.php
    function detail_gambar($id) {
        global $conn;
        // var_dump($id);
        $stmt = $conn -> prepare("SELECT username, fk_user_id, judul_gambar, deskripsi_gambar, tanggal_upload, asal_gambar, nama_file FROM user_tb
                                 INNER JOIN gambar ON gambar.fk_user_id = user_tb.user_id WHERE gambar.gambar_id = ?" );
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        return mysqli_fetch_assoc($result);
    }
    

    // Menghapus gambar dari database
    function hapus_gambar($id, $namaGambar) {
        global $conn;
        
        $stmt = $conn -> prepare("DELETE FROM gambar WHERE gambar_id = ?");
        $stmt -> bind_param("i", $id);
        $stmt -> execute();
        $result = $stmt -> get_result();
        hapus_file($namaGambar);
        return 1;
    }

    // Menghapus file gambar (jika ada)
    function hapus_file($gambar) {
        $path1 = "img/" . $gambar;

        if(file_exists($path1)) {
            unlink($path1);
        }
    }

?>