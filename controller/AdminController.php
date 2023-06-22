<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once dirname(__FILE__) . '/../model/AdminModel.php';
include_once dirname(__FILE__) . '/../model/ResturantModel.php';
include_once dirname(__FILE__) . '/../model/ProductModel.php';
include_once dirname(__FILE__) . '/../model/OrderModel.php';
class AdminController
{
    public static function initProcess()
    {
        if (isset($_POST['adminsignup'])) {
            $_POST    = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $name     = trim($_POST['name']);
            $email    = trim($_POST['email']);
            $password = $_POST['password'];
            $contact  = trim($_POST['contact']);
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
            } elseif (empty($contact)) {
                $errorNbr = 5;
            }

            if (!$errorNbr) {
                $user          = new AdminModel();
                $user->name    = $name;
                $user->email   = $email;
                $user->contact = $contact;
                $user->vCode   = $vCode;
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user->setPassword($hashed_password);

                require '../PHPMailer/PHPMailer.php';
                require '../PHPMailer/SMTP.php';
                require '../PHPMailer/Exception.php';

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
                $mail->setFrom('badrio.yt.gaming@gmail.com');

                //Content                                
                $mail->isHTML(true);                                    //Set email format to HTML
                $mail->Body    = "Thanks for registration!<br>
                Here is your verify code<br>
                <h1>$vCode</h1>"
                ;
                $mail->addAddress($email);                              //Add a recipient
                $mail->send();

                $registerSucces = 'Something went wrong';
                if ($user->add()) {
                    $registerSucces = 'succefull';
                }
                header("Location: ../verification/adminverify.php?email=$email");
            } else {

                header("Location: ../view/admin/adminsignup.php?registerError=" . $errorNbr);
            }

        } elseif (isset($_POST['adminlogin'])) {
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);
            $errorNbr = 0;

            if (empty($email)) {
                $errorNbr = 1;
            } elseif (empty($password)) {
                $errorNbr = 2;
            }

            if (!$errorNbr) {
                $user        = new AdminModel();
                $user->email = $email;
                $user->setPassword($password);
                $data = $user->loginUser();

                if (empty($data)) {
                    $errorNbr = 3;
                    header("Location: ../view/admin/adminlogin.php?error=" . $errorNbr);
                } elseif($data['verified'] == 0){
                    $errorNbr = 4;
                    header("Location: http://localhost/onlineshop/verification/adminverify.php?email=$email");
                } else {
                    $_SESSION["adminloggedin"] = true;
                    $_SESSION["emails"]        = $data["admin_email"];
                    $_SESSION["names"]         = $data["admin_name"];
                    $_SESSION["id_admin"]      = $data["id_admin"];
                    header("Location: ../view/admin/admindashboard.php");
                }

            } else {
                header("Location: ../view/admin/admindashboard.phperror=" . $errorNbr);
            }

        } elseif (isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: http://localhost/onlineshop/index.php");
        } elseif (isset($_POST['add_restaurant'])) {
            $_POST    = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $name     = trim($_POST['name']);
            $email    = trim($_POST['email']);
            $contact  = trim($_POST['contact']);
            $img      = $_FILES["uploadfile"]["name"];
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder      = "../view/img/resto" . $img;
            $id_admin = (int) $_POST['id_admin'];
            $errorNbr = 0;

            if (empty($name)) {
                $errorNbr = 1;
            } elseif (empty($email)) {
                $errorNbr = 2;
            } elseif (empty($contact)) {
                $errorNbr = 3;
            } elseif (empty($address)) {
                $errorNbr = 4;
            } elseif (empty($id_admin)) {
                $errorNbr = 5;
            }

            if (!$errorNbr) {
                $restaurant           = new RestaurantModel();
                $restaurant->name     = $name;
                $restaurant->email    = $email;
                $restaurant->contact  = $contact;
                $restaurant->img      = $img;
                $restaurant->id_admin = $id_admin;
                $registerSucces      = 'Something went wrong';
                if ($restaurant->add()) {
                    $registerSucces = 'Shop added succefull';
                }
                header("Location: http://localhost/onlineshop/view/admin/myrestaurant.php?registerSucces=" . $registerSucces);
            } else {

                header("Location: http://localhost/onlineshop/view/admin/myrestaurant.php?registerError=" . $errorNbr);
            }

        } elseif (isset($_POST['add_product'])) {
            $name        = trim($_POST['name']);
            $price       = trim($_POST['price']);
            $description = trim($_POST['description']);
            $img         = $_FILES["uploadfile"]["name"];
            $tempname    = $_FILES["uploadfile"]["tmp_name"];
            $folder      = "../view/img/produk" . $img;
            $id_admin    = (int) $_POST['id_admin'];

            $errorNbr = 0;

            if (empty($name)) {
                $errorNbr = 1;
            } elseif (empty($price)) {
                $errorNbr = 2;
            } elseif (empty($description)) {
                $errorNbr = 3;
            } elseif (empty($img)) {
                $errorNbr = 4;
            } elseif (empty($id_admin)) {
                $errorNbr = 5;
            }

            if (!$errorNbr) {
                $product              = new ProductModel();
                $product->name        = $name;
                $product->price       = $price;
                $product->description = $description;
                $product->img         = $img;
                $product->id_admin    = $id_admin;

                $registerSucces = 'Something went wrong';
                if ($product->add()) {
                    if (move_uploaded_file($tempname, $folder)) {
                        $registerSucces = 'Product added succefull';
                    } else {
                        $registerSucces = 'Product added succefull. and image is not saved in folder';
                    }

                }
                header("Location: http://localhost/onlineshop/view/admin/add_food_items.php?registerSucces=" . $registerSucces);
            } else {

                header("Location: http://localhost/onlineshop/view/admin/add_food_items.php?registerError=" . $errorNbr);
            }
        } elseif (isset($_GET['id_del'])) {
            $id_del   = trim($_GET['id_del']);
            $errorNbr = 0;
            if (empty($id_del)) {
                $errorNbr = 4;
            }

            if (!$errorNbr) {
                $product        = new ProductModel();
                $product->id    = $id_del;
                $registerSucces = 'Something went wrongs';
                if ($product->delete()) {
                    $registerSucces = 'Deleted';
                }
                header("Location: http://localhost/onlineshop/view/admin/view_food_items.php?registerSucces=" . $registerSucces);
            } else {

                header("Location: http://localhost/onlineshop/view/admin/view_food_items.php?registerError=" . $errorNbr);
            }

        }
    }
    public static function getResturant($id_admin)
    {
        $resturant           = new RestaurantModel();
        $resturant->id_admin = $id_admin;
        return $resturant->getRestaurantByAdminId();
    }
    public static function getProducts($id_admin)
    {
        $product           = new ProductModel();
        $product->id_admin = $id_admin;
        return $product->getProductByAdminId();
    }

    public static function getOrders($id_admin)
    {
        $order           = new OrderModel();
        $order->id_admin = $id_admin;
        return $order->getOrdersByAdminId();
    }
}
