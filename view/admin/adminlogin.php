<?php
session_start();
$errors = '';
if (isset($_SESSION["adminloggedin"]) && $_SESSION["adminloggedin"] == true) {
  header("location: admindashboard.php"); //Redirecting to admin dashboard Page
}
if (isset( $_GET['error'])) {
    $errorNo = $_GET['error'];
    switch( $errorNo) {
      case 1:
      $errors = 'Please Enter Email ';
      break;
      case 2:
      $errors = 'Please Enter  password';
      break;
      case 3:
      $errors = 'Invalid email or password';
      break;
      case 4:
      $errors = 'Account not Verified';
      break;
      default:
      $errors = '';
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
    
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>

                <form action="../../controller/AdminHandler.php" method="post"> 
                    <div class="input-field">
                        <input type="text" name="email" placeholder="Masukkan email anda">
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" class="password" placeholder="Masukkan password">
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <a href="#" class="text">Lupa password?</a>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="adminlogin" value="Masuk">
                    </div>
                </form>
                <?php
                if(!empty($errors)): ?>
                <div class="alert">
                    <div class="alert-danger"><?php echo $errors ?></div>
                </div>
                <?php endif; ?>

                <div class="login-signup">
                    <span class="text">Belum daftar?
                        <a href="adminsignup.php" class="text signup-link">Daftar sekarang!</a>
                    </span>
                </div>
            </div>

    <script src="../../src/js/login.js"></script>
</body>
</html>

