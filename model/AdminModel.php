<?php

include_once 'Database.php';
class AdminModel extends DbConnection
{

    public $id;
    public $name;
    public $email;
    private $password;
    public $contact;
    public $vCode;

    public function add()
    {

        $query  = "INSERT INTO seller (seller_name, seller_email, seller_password, v_code) VALUES ('" . $this->name . "','" . $this->email . "','" . $this->password . "','" . $this->vCode . "')";
        $result = $this->conn->query($query);

        return $result;
    }

    /**
     * user logged in
     * @return array
     */

    public function loginUser()
    {
        $query  = "SELECT * FROM seller WHERE seller_email='$this->email' LIMIT 1";
        $stmt   = $this->conn->query($query);
        $result = $stmt->fetch_assoc();
        if ($result) {
            if (password_verify($this->password, $result['password'])) {
                $result = $result;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    public function setPassword($pass)
    {

        $this->password = $pass;

    }

    /**
     * Returns password
     */

    public function getPassword()
    {

        return $this->password;
    }
}
