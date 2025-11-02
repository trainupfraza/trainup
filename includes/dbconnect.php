<?php
    class dbconnect{
        private $con;
        function __construct(){
            require_once dirname(__FILE__).'/constants.php';
            $this->con = $this->connect();
        }
        function connect(){
            include_once dirname(__FILE__).'/constants.php';
            $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if(mysqli_connect_errno()){
                echo "Failed to connect to MySQL: ".mysqli_connect_errno(); 
            }
            return $this->con;
        }
    }
?>