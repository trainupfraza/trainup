<?php
class dbconnect{
    private $con;
    function __construct(){
        require_once dirname(__FILE__).'/constants.php';
        $this->con = $this->connect();
    }
    function connect(){
        include_once dirname(__FILE__).'/constants.php';
        
        $connection_string = "host=" . DB_HOST . " port=" . DB_PORT . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASSWORD;
        $this->con = pg_connect($connection_string);
        
        if(!$this->con){
            echo "Failed to connect to PostgreSQL";
            return null;
        }
        return $this->con;
    }
    
    // Helper method to get the connection
    function getConnection() {
        return $this->con;
    }
}
?>
