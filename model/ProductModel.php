<?php
include_once('Database.php');
class ProductModel extends DbConnection
{
    public $id;

    public $name;

    public $price;

    public $description;
    
    public $img;

    public $id_admin;

    public function add()
    {
        $query = "INSERT into product (name, price, description, img, id_admin) VALUES ('" . $this->name . "','" . $this->price . "','" . $this->description . "','" . $this->img ."','" . $this->id_admin ."')";
        $result = $this->conn->query($query);
        return $result;
    }

    public function getProducts()
    {
        $query = "SELECT * FROM `product`, `restaurant` WHERE restaurant.id_resto = product.id_resto ORDER BY product.total_order";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }

    public function getFavProducts()
    {
        $query = "SELECT * FROM `product`, `restaurant` WHERE restaurant.id_resto = product.id_resto ORDER BY product.total_order DESC LIMIT 8";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }
    
     public function getProductByAdminId()
    {
        $query = "SELECT * FROM product WHERE id_admin='$this->id_admin' ORDER BY id  ";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }
    public function delete() 
    {       
        $query = "DELETE FROM product WHERE id='$this->id'";
        $st = $this->conn->query($query);
        return $st;            
    }

}

