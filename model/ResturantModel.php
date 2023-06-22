<?php
include_once('Database.php');
class RestaurantModel extends DbConnection
{
    public $id;

    public $name;

    public $email;

    public $contact;
    
    public $img;

    public $id_admin;


    /**
     * add new user
     */

    public function add()
    {
        $query = "INSERT into restaurant (resto_name, resto_email, resto_contact, resto_img,id_admin) VALUES ('" . $this->name . "','" . $this->email . "','" . $this->contact . "','" . $this->img ."','" . $this->id_admin ."')";
        $result = $this->conn->query($query);
        return $result;
    }
    public function getRestaurant()
    {
        $query = "SELECT * FROM restaurant ORDER BY id_resto";
        $st = $this->conn->query($query);
        $result =array();
        if($st){
            $result = $st->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }

    public function getRestaurantByAdminId()
    {
        $query = "SELECT * FROM restaurant WHERE id_admin='$this->id_admin' LIMIT 1";
        $st = $this->conn->query($query);
        $result ='';
        if($st){
            $result = $st->fetch_assoc();
        }
        return $result;
    }

}

