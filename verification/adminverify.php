<?php

if(isset($_POST['verify_email'])){

    $email = $_POST["email"];
    $verif_code = $_POST["vCode"];

    // Connect with database
    $conn = mysqli_connect("localhost", "root", "", 'onlineshop');

    // Mark email as verified
    $sql = "UPDATE admin SET verified = 1, v_code = '0' WHERE email = '" . $email . "' AND v_code = '" . $verif_code . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 0){
        die("Verification code failed");
    }

    echo "<p>you can login now</p>";
    exit();

}

?>

<form method="POST">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
    <input type="text" name="vCode" placeholder="Enter verification code" required>

    <input type="submit" name="verify_email" value="Verify Email">
</form>