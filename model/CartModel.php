<?php

use LDAP\Result;

include_once('Database.php');
class CartModel extends DbConnection
{
    public $id;
    public $id_product;
    public $id_customer;
    public $id_seller;
    public $id_resto;
    public $quantity;


    public function add()
    {

        $query  = "INSERT INTO cart (id_product, id_customer, id_seller, id_resto, quantity) VALUES ('" . $this->id_product . "','" . $this->id_customer . "','" . $this->id_seller . "','" . $this->id_resto . "','" . $this->quantity . "')";
        $result = $this->conn->query($query);

        return $result;
    }

    public function delete() 
    {       
        $query = "DELETE FROM cart WHERE id='$this->id'";
        $stmt = $this->conn->query($query);
        return $stmt;            
    }

    public function displayCartCount()
    {
        $query = "SELECT * FROM cart WHERE id_customer='$this->id_customer'";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
            
        }
        return $result;
    }

    public function displayCartByCustomer($id_customer)
    {
        $query = "SELECT *,sum(price) as total, sum(quantity) as tot_quantity FROM cart, product, customer, seller, restaurant WHERE product.id_product = cart.id_product AND customer.id_customer = 1 AND seller.id_seller = cart.id_seller AND restaurant.id_resto = cart.id_resto GROUP BY cart.id_product";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
            
        }
        return $result;
    }

    public function displayCartResto($id_customer){
        $query = "SELECT * FROM cart, restaurant WHERE restaurant.id_resto = cart.id_resto AND cart.id_customer = $id_customer GROUP BY cart.id_resto";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
            
        }
        return $result;
    }



}