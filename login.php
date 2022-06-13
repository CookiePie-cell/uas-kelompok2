<?php
    session_start();

    require 'functions.php';

    cek_cookie();

    if(isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }

    
    if(isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if(login($username, $password)) {
            header("Location: index.php");
            exit;
        }
        
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<body>
    <script>
        if(window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <div class="wrapper">
        <div class="form-container" id="login-form">
            <div class="content-wrapper">
                <div class="login-content">
                    <h2>LOGIN</h2><br>
                    <?php if(isset($error)) { ?>
                        <p class="error">username / password salah</p>
                    <?php } ?>
                    <form action="" method="POST">
                        <div class="login-input-wrapper">
                            <input class="input-action" type="text" name="username" placeholder="Username">
                        </div>
                        <div class="login-input-wrapper">
                            <input class="input-action" type="password" name="password" placeholder="Password">
                        </div>
                        <div id="cekbox-remember">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <input class="input-action" id="btn-login" type="submit" name="login" value="Login">
                    </form>
                    <a href="register.php">Buat akun</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>