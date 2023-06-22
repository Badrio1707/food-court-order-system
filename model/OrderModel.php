<?php
include_once('Database.php');
class OrderModel extends DbConnection
{
    public $id;

    public $id_customer;

    public $id_admin;

    public $id_product;
    
    public $product_name;

    public $product_quantity;

    public $price;

    public $table_number = 0;
    
    public $payment_method;

    public $date;

    public function add()
    {
        $query = "INSERT into orders (id_customer, id_admin, id_product, product_name, product_quantity, price, table_number, payment_method, date) VALUES ('" . $this->id_customer . "','" . $this->id_admin . "','" . $this->id_product . "','" . $this->product_name ."','" . $this->product_quantity ."', '" . $this->price . "','" . $this->table_number . "','" . $this->payment_method . "','" . $this->date ."')";
        $result = $this->conn->query($query);
        return $result;
    }



     public function getOrdersByAdminId()
    {
        $query = "SELECT * FROM orders WHERE id_admin='$this->id_admin' ORDER BY id  ";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }

}

