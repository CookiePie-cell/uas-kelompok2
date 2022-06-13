<?php
    session_start();

    if(isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }

    require 'functions.php';

    if(isset($_POST["register"])) {
        if(registrasi($_POST) > 0) {
            echo "<script> 
                    alert('Berhasil mendaftar'); 
                    document.location.href = 'login.php';
                </script>";
        } else {
            echo "<script> alert('asd'); </script>";
            echo mysqli_error($conn);
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
    <title>Registrasi</title>
</head>
<body>
    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <header class=main-header id="register-header">
        <h1>KELOMPOK 2</h1>
        <nav class=main-nav>
            <ul>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">KEMBALI</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="wrapper" id="register-wrapper">
        <div class="form-container" id="register-container">
            <header> 
                <h1>REGISTER</h1>
            </header>
            <form action="" method="POST" onsubmit="return validasi_form()">
                <label for="nama_lengkap">Nama lengkap</label>
                <input type="text" class="input-form" id="nama_lengkap" name="nama_lengkap" placeholder="Nama">

                <label for="username">Username</label>
                <input type="text" class="input-form" id="username" name="username" placeholder="Username">

                <label for="password">Password</label>
                <input type="password" class="input-form" id="password" name="password" placeholder="Password">

                <label for="negara">Negara</label>
                <select id="negara" name="negara">
                    <option value="indonesia">Indonesia</option>
                    <option value="usa">USA</option>
                    <option value="china">China</option>
                </select>
                
                <input type="submit" name="register" value="Daftar">
            </form>
            <script type="text/javascript" src="script.js"></script>
        </div>
    </div>
</body>
</html>