<?php
    $host = "localhost";
    $dbname = "makan_yuk";
    $user = "root";
    $pass = "";

    $conn = mysqli_connect($host, $user, $pass, $dbname);

    $cart_id_product = mysqli_real_escape_string($conn, $_POST["id_product"]);
    $cart_id_customer = mysqli_real_escape_string($conn, $_POST["id_customer"]);
    $cart_id_seller = mysqli_real_escape_string($conn, $_POST["id_seller"]);
    $cart_id_resto = mysqli_real_escape_string($conn, $_POST["id_resto"]);
    $cart_product_quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);

mysqli_query($conn, "INSERT INTO cart (id_product, id_customer, id_seller, id_resto, quantity) VALUES ('" .$cart_id_product . "','" .$cart_id_customer . "','" .$cart_id_seller . "','" .$cart_id_resto . "','" .$cart_quantity . "')");