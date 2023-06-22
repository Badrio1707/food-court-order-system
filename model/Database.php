<?php

class DbConnection 
{
    private $host = "localhost";
    private $dbname = "makan_yuk";
    private $user = "root";
    private $pass = "";

    protected $conn;

    /**
     * Database Connection
     */
     public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
    }
}

