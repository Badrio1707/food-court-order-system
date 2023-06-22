<?php
include_once ("../../functions/currency.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$FavProduct = array();
$cartCount = array();
$cart = array();
$userName = '';
$id_customer = '';
if (isset($_SESSION["adminloggedin"]) && $_SESSION["adminloggedin"] == true) {
    $userName = $_SESSION["names"]; 
    header("location: ../admin/index.php");
} else if (isset($_SESSION["customerloggedin"]) && $_SESSION["customerloggedin"] == true) {
    $userName = $_SESSION["names"]; 
    $id_customer=$_SESSION["id_customer"];
    include_once('../../controller/FrontController.php');
    $FavProduct = FrontController::displayFavProducts();
    $cartCount = FrontController::getCartCount($id_customer);
    $cart = FrontController::getCartByCustomer($id_customer);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== BOX ICONS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <!-- ===== CUSTOM CSS ===== -->
    <link rel="stylesheet" href="../../src/css/home.css">
    <link rel="stylesheet" href="../css/cart.css">

    <title>Makan yuk! | Beranda</title>
</head>
<body>
    <?php
    if (isset($_SESSION["customerloggedin"]) && $_SESSION["customerloggedin"] == true){
    ?>
    <!-- ===== HEADER ===== -->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="" class="nav__logo">Makan yuk!</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link active-link">
                            <i class='bx bx-home-alt nav__icon'></i>
                            <span class="nav__name">Beranda</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="view/user/shoplist.php" class="nav__link">
                            <i class='bx bx-bowl-hot nav__icon'></i>
                            <span class="nav__name">Kedai</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="view/user/order.php" class="nav__link">
                            <i class='bx bx-receipt nav__icon' ></i>
                            <span class="nav__name">Pesanan</span>
                        </a>
                    </li>

                    <li class="nav__item user-item">
                        <a href="" class="nav__link">
                            <i class='bx bx-user nav__icon' ></i>
                            <span class="nav__name">Pengguna</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                    <ul class="nav__btn">
                        <form action="" method="get">
                            <input type="text" name="search" placeholder="cari makanan">
                        </form>
                        <li class="cart-btn">
                            <a href="view/user/cart.php">
                                <i class='bx bx-cart'></i>
                                <span class="btn__text cart-count"><?php
                                if ($cartCount) {
                                    echo count($cartCount);
                                }else{
                                    echo "0";
                                }
                                    ?></span>
                            </a>
                        </li>
                        <li class="nav-btn">
                            <a href="#">
                                <span class="btn__text"><?php echo $userName?></span>
                            </a>
                            <ul>
                                <li><a href="view/user/userprofile.php">Profil</a></li>
                                <li>
                                    <form action="controller/FrontHandler.php">
                                        <input value="Logout" type="submit" name="logout">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </div>
        </nav>
    </header>

    <!-- ===== Daftar Keranjang -->
    <div class="cart-wrapper">
		<h1>Keranjangmu</h1>
		<div class="cart-project">
			<div class="cart-shop">
				<div class="cart-box">
					<div class="cart-content">
						<h3>Mie Yatmin - Om Dion</h3>
						<h4>Harga: Rp. 20.000</h4>
						<p class="cart-unit">Jumlah: <input type="number" value="1"></p>
						<p class="cart-btn-area"><i aria-hidden="true" class="fa fa-trash"></i> <span class="cart-btn2">Hapus</span></p>
					</div>
				</div>
				<div class="cart-box">
					<div class="cart-content">
						<h3>Nasi Goreng Sedap Mantap</h3>
						<h4>Harga: Rp. 15.000</h4>
						<p class="cart-unit">Jumlah: <input type="number" value="0"></p>
						<p class="cart-btn-area"><i aria-hidden="true" class="fa fa-trash"></i> <span class="cart-btn2">Hapus</span></p>
					</div>
				</div>
			</div>
			<div class="cart-right-bar">
				<p class="cart-unit">Nomor Meja: <input type="number" value="0"></p>
				<hr>
				<p><span>Total</span> <span>RP. 55.000</span></p>
				<hr>
				<p> Metode Pembayaran</p>
				<a href="#"><i class="fa fa-shopping-cart"></i>Online</a> 
				<br>
				<a href="paymentcod.html"><i class="fa fa-shopping-cart"></i>COD</a>
			</div>
		</div>
	</div>

        
    <?php 
    } else{
    
    ?>

    <header class="header" id="header">
            <nav class="nav container">
                <a href="" class="nav__logo">Makan yuk!</a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="" class="nav__link active-link">
                                <i class='bx bx-home-alt nav__icon'></i>
                                <span class="nav__name">Beranda</span>
                            </a>
                        </li>

                        <li class="nav__item user-item">
                            <a href="" class="nav__link">
                                <i class='bx bx-user nav__icon' ></i>
                                <span class="nav__name">Pengguna</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <ul class="nav__btn">
                        <li class="nav-btn">
                            <a href="#">
                                <i class='bx bx-user btn__icon'></i>
                                <span class="btn__text">Masuk</span>
                            </a>
                            <ul>
                                <li><a href="view/user/userlogin.php">Customer</a></li>
                                <li><a href="view/admin/adminlogin.php">Seller</a></li>
                            </ul>
                        </li>

                        <li class="nav-btn">
                            <a href="#">
                                <i class='bx bx-user-plus btn__icon' ></i>
                                <span class="btn__text">Daftar</span>
                            </a>
                            <ul>
                                <li><a href="view/user/usersignup.php">Customer</a></li>
                                <li><a href="view/admin/adminsignup.php">Seller</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <?php
        }
        ?>



    <!-- ===== CUSTOM JS ===== -->
    <script src="src/js/script.js"></script>

</body>
</html>

