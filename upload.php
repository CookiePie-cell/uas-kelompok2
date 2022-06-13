<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

    require 'functions.php';

    if(isset($_POST["upload"])) {
        if(upload($_POST) > 0) {
            echo "
                <script> 
                    alert('Gambar berhasil diupload');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script> 
                    alert('Gambar gagal diupload');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Upload</title>
</head>
<body>
    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <header class=main-header>
        <h1>KELOMPOK 2</h1>
        <nav class=main-nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a href="upload.php" class="nav-link">UPLOAD</a>
                </li>
                <li class="nav-item">
                    <a href="my_gambar.php" class="nav-link">GALLERY SAYA</a>
                </li>
                <li class="nav-item">
                    <a href="kelompok.php" class="nav-link">KELOMPOK</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">LOG OUT</a>
                </li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <script type="text/javascript" src="script2.js"></script>
    <div class="wrapper" id="wrapper-upload">
        <div class="form-container">
            <header> 
                <h1>UPLOAD</h1>
            </header>
            <form action="" method="POST" onsubmit="return validasi_form()" enctype="multipart/form-data">
                <label for="judul-gambar">Judul</label>
                <input type="text" class="input-form" id="judul-gambar" name="judul_gambar" maxlength="50" placeholder="Judul">
                
                <label for="country">Negara</label>
                <select id="country" name="country">
                    <option value="indonesia">Indonesia</option>
                    <option value="usa">USA</option>
                    <option value="china">China</option>
                </select>
               
                <label for="deskripsi-gambar">Deskripsi</label>
                <textarea id="deskripsi-gambar" name="deskripsi_gambar" maxlength="255" placeholder="Deskripsi gambar..." style="height:200px"></textarea>
            
                <label for="file_gambar">Gambar</label><span>(Max: 2MB)</span>
                <input class="input-form" type="file" name="file_gambar" id="file-gambar">
                
                <input type="submit" name="upload" value="Submit">

            </form>
            <script type="text/javascript" src="script.js"></script>
        </div>
    </div>
</body>
</html>