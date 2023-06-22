<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart = array();
$userName = '';
$id_customer = '';
if (isset($_SESSION["customerloggedin"]) && $_SESSION["customerloggedin"] == true) {
    $userName=$_SESSION["names"];
    $id_customer=$_SESSION["id_customer"];
    include_once('../../controller/FrontController.php');
    $cart = FrontController::getCartByCustomer($id_customer);
} else{
   header("Location: http://localhost/onlineshop/view/customer/customerlogin.php");

}

?>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
	<link rel="stylesheet" href="">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<link href="../css/cart.css" rel="stylesheet">
</head>
<body>

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
</body>
</html>