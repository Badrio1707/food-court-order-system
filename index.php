<?php
include_once ("functions/currency.php");

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
    header("location: view/admin/admindashboard.php");
} else if (isset($_SESSION["customerloggedin"]) && $_SESSION["customerloggedin"] == true) {
    $userName = $_SESSION["names"]; 
    $id_customer=$_SESSION["id_customer"];
    include_once('controller/FrontController.php');
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
    <link rel="stylesheet" href="src/css/home.css">

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
                        <a href="view/user/foodlist.php" class="nav__link">
                            <i class='bx bx-bowl-hot nav__icon'></i>
                            <span class="nav__name">Menu</span>
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
                        <!-- <form action="" method="get">
                            <input type="text" name="search" placeholder="cari makanan">
                        </form> -->
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

    <!-- ===== HOME SECTIONS START ===== -->
    <section class="home" id="home">

        <div class="image" data-aos="fade-down">
            <img src="https://cdn.vox-cdn.com/thumbor/8hZcUxUOBb4GV1JiDsz1USpT29w=/385x352:1561x1061/1200x800/filters:focal(831x620:1137x926)/cdn.vox-cdn.com/uploads/chorus_image/image/70609268/Burger_King_Plant_based_Double_Cheeezeburger.0.jpg" alt="">
        </div>
    
        <div class="content" data-aos="fade-up">
            <h3>Kamu tau gak?</h3>
            <p>Banyak orang keliru dan mengira bahwa nama Hamburger berasal dari kata "Ham", tetapi sebenarnya namanya berasal dari kota Hamburg di Jerman, tempat makanan ini berasal. Dari kota kedua terbesar di Jerman ini banyak penduduknya yang beremigrasi ke Amerika dan menyebarkan pembuatan burger ke sana.</p>
            <a href="view/user/shoplist.php" class="btn">Cari Makanan</a>
        </div>
    
    </section>

    <!-- ===== MOST POPULAR FOODS ====== -->
    <section class="packages" id="packages">

        <h1 class="heading">Menu <span>Favorit</span> </h1>
    
        <?php
        if ($FavProduct) {
        ?>   
        <div class="box-container">
        
        <?php



            foreach ($FavProduct as $row):

        ?>
            
            <div id="food<?= $row['id_product']; ?>" class="box" data-aos="fade-up">
                <a href="#food<?= $row['id_product']; ?>">
                    <div class="image">
                        <img src="view/img/produk/<?php echo $row['product_img']; ?>" alt="">
                    </div>
                    <div class="content">
                        <div class="text">
                            <div class="name">
                                <h3> <i class="fas fa-utensils"></i> <p><?php echo $row['product_name']; ?></p> </h3>
                                <div class="price"> <?php echo format_rupiah($row['price']); ?></div>
                            </div>
                            <div class="info">
                                <p><?php echo $row['resto_name']; ?></p>
                            </div>
                        </div>
                        <div class="bttn">
                            <form action="" method="post">
                                <input type="hidden" name="id_product" value="<?php echo $row["id_product"]; ?>">
                                <input type="hidden" name="price" value="<?php echo $row["price"]; ?>">
                                <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
                                <input type="hidden" name="id_seller" value="<?php echo $row["id_seller"]; ?>">
                                <input type="hidden" name="id_resto" value="<?php echo $row["id_resto"]; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="add_cart" class="btn__order"><i class='bx bx-cart-add'></i></button>
                            </form>
                        </div>
                        
                    </div>
                </a>
            </div>
            <?php

            endforeach;

            if (isset($_POST['add_cart'])) {
                $cart_id_product = $_POST["id_product"];
                $cart_id_customer = $_POST["id_customer"];
                $cart_id_seller = $_POST["id_seller"];
                $cart_id_resto = $_POST["id_resto"];
                $cart_product_quantity = $_POST["quantity"];

                $cart = new CartModel();
                $cart->id_product = $cart_id_product;
                $cart->id_customer = $cart_id_customer;
                $cart->id_seller = $cart_id_seller;
                $cart->id_resto = $cart_id_resto;
                $cart->quantity = $cart_product_quantity;

                $cart->add();
            }
        }
        ?>

        
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


        <!-- ===== HOME SECTIONS START ===== -->

        <section class="home" id="home">

            <div class="image" data-aos="fade-down">
                <img src="https://cdn.vox-cdn.com/thumbor/8hZcUxUOBb4GV1JiDsz1USpT29w=/385x352:1561x1061/1200x800/filters:focal(831x620:1137x926)/cdn.vox-cdn.com/uploads/chorus_image/image/70609268/Burger_King_Plant_based_Double_Cheeezeburger.0.jpg" alt="">
            </div>
        
            <div class="content" data-aos="fade-up">
                <h3>Kamu tau gak?</h3>
                <p>Banyak orang keliru dan mengira bahwa nama Hamburger berasal dari kata "Ham", tetapi sebenarnya namanya berasal dari kota Hamburg di Jerman, tempat makanan ini berasal. Dari kota kedua terbesar di Jerman ini banyak penduduknya yang beremigrasi ke Amerika dan menyebarkan pembuatan burger ke sana.</p>
                <a href="view/user/shoplist.php" class="btn">Cari Makanan</a>
            </div>
    
        </section>
        <?php
        }
        ?>



    <!-- ===== CUSTOM JS ===== -->
    <script src="src/js/script.js"></script>

</body>
</html>

