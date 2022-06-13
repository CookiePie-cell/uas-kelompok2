<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

    require 'functions.php';

    $detail = detail_gambar($_GET["id"]);
    if(isset($_POST["hapus_gambar"])) {
        if(hapus_gambar($_GET["id"], $detail["nama_file"] > 0)) {
            echo "
                <script> 
                    alert('Gambar berhasil dihapus') 
                    document.location.href = 'index.php'
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
    <title>Detail gambar</title>
</head>
<body>
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
    <div class="detail-gambar-container">
        <div class=big-gambar-container>
        <img id="gambar-besar" src="img/<?= $detail['nama_file'] ?>" alt="gambar orang" style="width:820px;height:520px;">
        </div>
        <div class="sidenav">
            <div class="sidenav-content">
                <div class="judul-container">
                    <h2><?= $detail["judul_gambar"] ?></h2>
                </div>
                <h5> Pengupload </h5>
                <p><?= $detail["username"] ?></p>
                <h5>Tanggal upload</h5>
                <p><?= $detail["tanggal_upload"] ?></p>
                <h5>Asal</h5>
                <p><?= $detail["asal_gambar"] ?></p>
                <h5>Deskripsi</h5>
                <p><?= $detail["deskripsi_gambar"] ?></p>
                <?php if($detail["fk_user_id"] == $_SESSION["user_id"]) : ?>
                    <form action="" id="delete-form" method="POST">
                        <input type="submit" id="btn-hapus" name="hapus_gambar" value="Hapus">
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="script2.js"></script>
    <!-- <div class="detail-video-container">
        <div class=big-video-container>
            <video width="720" height="480" controls>
                <source src="videos/Joseph Julio Nicholas.mp4" type="video/mp4">
            </video>
            <div class=thumbnail-desc>
                <p>Julio Nicholas</p>
                <p>120k</p>
            </div>
            <h2>hello</h2>
        </div>
    </div> -->
</body>
</html>