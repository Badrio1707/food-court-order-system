<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once dirname(__FILE__) . '/../model/FrontModel.php';
include_once dirname(__FILE__) . '/../model/ResturantModel.php';
include_once dirname(__FILE__) . '/../model/ProductModel.php';
include_once dirname(__FILE__) . '/../model/OrderModel.php';
include_once dirname(__FILE__) . '/../model/AdminModel.php';
include_once dirname(__FILE__) . '/../model/CartModel.php';
class FrontController extends FrontModel
{

    public static function initProcess()
    {
        if (isset($_POST['customersignup'])) {
            $_POST    = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $name     = trim($_POST['name']);
            $uid  = trim($_POST['uid']);
            $email    = trim($_POST['email']);
            $password = $_POST['password'];
            $vCode  = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $errorNbr = 0;


            if (empty($name)) {
                $errorNbr = 1;
            } elseif (empty($email)) {
                $errorNbr = 2;
            } elseif (empty($password)) {
                $errorNbr = 3;
            } elseif (strlen($password) < 8) {
                $errorNbr = 4;
            } elseif (empty($uid)) {
                $errorNbr = 5;
            }

            if (!$errorNbr) {
                $user            = new FrontModel();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user->setSignup($name, $uid, $email, $vCode, $hashed_password);

                require '../PHPMailer/PHPMailer.php';
                require '../PHPMailer/SMTP.php';
                require '../PHPMailer/Exception.php';

                if($user->checkUser()){
                    $errorNbr = 6;
                    header("Location: ../view/user/usersignup.php?registerError=" . $errorNbr);
                }else{
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer();

                    //Server settings                                       //Enable verbose debug output
                    $mail->isSMTP();                                        //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                   //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
                    $mail->SMTPSecure = 'tls';                              //Enable implicit TLS encryption
                    $mail->Port       = 587;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    $mail->Username   = 'badrio.yt.gaming@gmail.com';       //SMTP username
                    $mail->Password   = 'yymfahayzgjuauvt';                 //SMTP password

                    $mail->Subject = 'Verification Code';

                    //Recipients
                    $mail->setFrom('badrio.yt.gaming@gmail.com', 'Makan yuk!');

                    //Content                                
                    $mail->isHTML(true);                                    //Set email format to HTML
                    $mail->Body    = "Thanks for registration!<br>
                    Here is your verify code<br>
                    <h1>$vCode</h1>";
                    $mail->addAddress($email);
                                               //Add a recipient

                    $registerSucces = 'Something went wrong';
                    if ($user->add()) {
                        $mail->send();
                        $registerSucces = 'Registration succefull';
                        header("Location: ../verification/userverify.php?email=$email");
                    } else {
                        header("Location: ../view/user/usersignup.php?registerError=" . $errorNbr);
                    }
                }
            
            }     

        } elseif (isset($_POST['customerlogin'])) {
            $uid    = trim($_POST['uid']);
            $password = trim($_POST['password']);
            $errorNbr = 0;

            if (empty($uid)) {
                $errorNbr = 1;
            } elseif (empty($password)) {
                $errorNbr = 2;
            }

            if (!$errorNbr) {
                $user        = new FrontModel();
                $user->setLogin($uid, $password);
                $data = $user->loginUser();

                if (empty($data)) {
                    $errorNbr = 3;
                    header("Location: ../view/user/userlogin.php?error=" . $errorNbr);
                } elseif($data['verified'] == 0){
                    $errorNbr = 4;
                    header("Location: ../verification/userverify.php?email=$uid");
                }
                 else {
                    $_SESSION["customerloggedin"] = true;
                    $_SESSION["emails"]           = $data["customer_email"];
                    $_SESSION["names"]            = $data["customer_name"];
                    $_SESSION["id_customer"]      = $data["id_customer"];
                    header("Location: ../");
                }

            } else {
                header("Location: ../view/user/userlogin.php?error=" . $errorNbr);
            }

        } elseif (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: ../index.php");
            
        // } elseif (isset($_POST['add_cart'])) {
        //     $cart_id_product       = $_POST["id_product"];
        //     $cart_id_customer      = $_POST["id_customer"];
        //     $cart_id_seller        = $_POST["id_seller"];
        //     $cart_id_resto         = $_POST["id_resto"];
        //     $cart_product_quantity = $_POST["quantity"];

        //     $cart = new CartModel();
        //     $cart->id_product  = $cart_id_product;
        //     $cart->id_customer = $cart_id_customer;
        //     $cart->id_seller   = $cart_id_seller;
        //     $cart->id_resto    = $cart_id_resto;
        //     $cart->quantity    = $cart_product_quantity;

        //     $cart->add();
        //     header("Location: ../index.php");


        } elseif (isset($_GET['delete_cart'])) {
            $id = $_GET['delete_cart'];

            $cart     = new CartModel();
            $cart->id = $id;
            

        } elseif (isset($_GET['empty'])) {
            foreach ($_SESSION["cart"] as $keys => $values) {
                unset($_SESSION["cart"]);
            }
            header("Location: ../view/user/cart.php");
        } elseif (isset($_POST['submit_order'])) {
            $errorNbr      = 0;
            $cart_products = array();
            $table_number = trim($_POST['table_number']);
            $payment_method = trim($_POST['payment_method']);
            if ($payment_method == 'online') {
                $pin_one   = trim($_POST['pin_one']);
                $pin_two   = trim($_POST['pin_two']);
                $pin_three = trim($_POST['pin_three']);
                $pin_four  = trim($_POST['pin_four']);
                $month   = trim($_POST['month']);
                $year   = trim($_POST['year']);
                $ccv   = trim($_POST['ccv']);
                if (empty($pin_one) || empty($pin_two) || empty($pin_three) || empty($pin_four) || empty($month) || empty($year) || empty($ccv) || empty($table_number)) {
                    $errorNbr = 1;
                }
            }

            if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                $cart_products = $_SESSION["cart"];
            } else {
                $errorNbr = 2;
            }

            if (!$errorNbr) {
                $order_saved  = 0;
                $order        = new OrderModel();
                foreach ($cart_products as $product) {
                    $order->id_customer      = $product['cart_id_customer'];
                    $order->id_admin         = $product['cart_id_admin'];
                    $order->id_product       = $product['cart_id_product'];
                    $order->product_name     = $product['cart_product_name'];
                    $order->price            = $product['cart_product_price'];
                    $order->product_quantity = $product['cart_product_quantity'];
                    $order->payment_method   = $payment_method;
                    $order->table_number     = $table_number;
                    $order->date             = date("Y-m-d");
                    $order_saved             = $order->add();
                }
                if (empty($order_saved)) {
                    $errorNbr = 3;
                    header("Location: ../view/user/order.php?error=" . $errorNbr);
                } else {
                    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $keys => $values) {
                            unset($_SESSION["cart"]);
                        }
                    }
                    $orderSuccess = 'order placed succefull';
                    header("Location: ../view/user/order.php?orderSuccess=" . $orderSuccess);
                }

            } else {
                header("Location: ../view/user/order.php?error=" . $errorNbr);
            }
        }
    }

    public static function displayProducts()
    {
        $product = new ProductModel();
        return $product->getProducts();
    }

    public static function displayFavProducts()
    {
        $product = new ProductModel();
        return $product->getFavProducts();
    }

    public static function displayRestaurant()
    {
        $restaurant = new RestaurantModel();
        return $restaurant->getRestaurant();
    }

    public static function getCustomers()
    {
        $customers           = new FrontModel();
        return $customers->displayCustomers();
    }
    public static function getCartCount($id_customer)
    {
        $cart = new CartModel();
        $cart->id_customer = $id_customer;
        return $cart->displayCartCount();
    }
    public static function getCartByCustomer($id_customer)
    {
        $cart = new CartModel();
        $cart->id_customer = $id_customer;
        return $cart->displayCartByCustomer($id_customer);
    }

    public static function getCartResto($id_customer)
    {
        $cart = new CartModel();
        $cart->id_customer = $id_customer;
        return $cart->displayCartResto($id_customer);
    }
}
