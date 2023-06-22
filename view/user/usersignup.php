<?php
$errors = '';
$registerSucces = '';
$regErors = '';

if (isset( $_GET['registerSucces'])) {
    $registerSucces = $_GET['registerSucces'];
}
if (isset ( $_GET['registerError'])) {
  $errorNo=$_GET['registerError'];
  switch($errorNo) {
    case 1:
    $regErors = 'Please enter name ';
    break;
    case 2:
    $regErors = 'Please enter email';
    break;
    case 3:
    $regErors = 'Please enter password';
    break;
    case 4:
    $regErors = 'Password should be at least 8 characters';
    break;
    case 5:
    $regErors = 'Please enter username';
    break;
    case 6:
    $regErors = 'Email already exist';
    break;
    default:
    $regErors = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="../../src/css/login.css">
         
    <!--<title>Login & Registration Form</title>-->
</head>
<body>
    
    <div class="container active">
        <div class="forms">

            <!-- Registration Form -->
            <div class="form signup">
                
                <span class="title">Sign Up</span>

                <form action="../../controller/FrontHandler.php" method="post">
                    <div class="input-field">
                        <input type="text" name="name" placeholder="Masukan nama anda">
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="uid" placeholder="Masukkan username (untuk login)">
                        <i class="uil uil-user icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="email" placeholder="Masukan email anda">
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    
                    <div class="input-field">
                        <input type="password" name="password" class="password" placeholder="Masukan password">
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="termCon">
                            <label for="termCon" class="text">Saya menerima semua syarat dan ketentuan.</label>
                        </div>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="customersignup" value="Daftar">
                    </div>
                </form>
                <?php
                if(!empty($regErors)): ?>

                <div class="alert">
                    <div class="alert-danger"><?php echo $regErors ?></div>
                </div>
                <?php endif; ?>
                <div class="login-signup">
                    <span class="text">Sudah mendaftar?
                        <a href="userlogin.php" class="text login-link">Masuk disini</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="src/js/login.js"></script>
</body>
</html>