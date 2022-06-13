<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

    require 'functions.php';

    $gambar = get_gambar_saya($_SESSION["user_id"]);

    if(isset($_GET["search_query"])) {
        $gambar = get_gambarSaya_query($_SESSION["user_id"], $_GET["search_query"]);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gallery</title>
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
    <div class=main-content>
        <div class="search-box">
            <form action="" name="search-form">
                <input id="search-textbox" type="text" name="search_query" placeholder="Temukan gambar">
                <input id="btn-search" type="submit" value="Cari">
            </form>
        </div>
        <h1>GALLERY SAYA</h1>
        <?php if(count($gambar) === 0) : ?>
            <?php if(isset($_GET["search_query"])) : ?>
                <p>Gambar tidak ditemukan</p>
            <?php else :?>
                <p>Anda belum mengupload gambar</p>
            <?php endif ?>
        <?php endif; ?>
        <?php foreach($gambar as $g) : ?>
        <div class=container-gambar>
            <img src="img/<?= $g['nama_file'] ?>" alt="gambar orang" style="width:360px;height:240px;">
            <div class=thumbnail-desc>
                <h5><?= strlen($g["judul_gambar"]) > 25 ? substr($g["judul_gambar"], 0, 25) . "..." : $g["judul_gambar"]?></h5>
                <span><?= substr($g["tanggal_upload"], 0, 11); ?></span>
            </div>
            <div class="btn-lihat">
                <a href="detail_gambar.php?id=<?= $g["gambar_id"] ?>">Lihat</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <script type="text/javascript" src="script2.js"></script>
</body>
</html>