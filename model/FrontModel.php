<?php

use LDAP\Result;

include_once('Database.php');
class FrontModel extends DbConnection
{
    public $id;

    private $name;

    private $uid;

    private $email;
    
    private $password;

    private $vCode;

    /**
     * add new user
     */

    public function setSignup($name, $uid, $email, $vCode, $pass)
    {
        $this->name = $name;
        $this->uid = $uid;
        $this->email = $email;
        $this->vCode = $vCode;
        $this->password = $pass;
    }

    public function setLogin($uid, $pass)
    {
        $this->uid = $uid;
        $this->password = $pass;
    }

    public function add()
    {
        $query = "INSERT into customer (customer_name, customer_uid, customer_email, customer_password, v_code) VALUES ('" . $this->name . "','" . $this->uid . "','" . $this->email . "','" . $this->password ."','" . $this->vCode ."')";
        $result = $this->conn->query($query);

        return $result;
    }

    public function checkUser(){
        $query = "SELECT customer_email FROM customer WHERE customer_email = '$this->email'";
        $stmt = $this->conn->query($query);
        $result = $stmt->fetch_assoc();

        return (is_array($result) && count($result) > 0);
    }

    /**
     * user logged in
     * @return array
     */
    
    public function loginUser()
    {
        $query  = "SELECT * FROM customer WHERE customer_uid ='$this->uid'";
        $stmt   = $this->conn->query($query);
        $result = $stmt->fetch_assoc();
        if ($result) {
            if (password_verify($this->password , $result['customer_password'])) {
                $result = $result;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Set password
     * @param Assign value to password
     */

    /**
     * Returns password
     */
    
    public function getPassword()
    {
        return $this->password;
    }
    

    public function displayCustomers()
    {
        $query = "SELECT * FROM customer ORDER BY id  ";
        $stmt = $this->conn->query($query);
        $result =array();
        if($stmt){
            $result = $stmt->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }
}

