<?php
// Database Constants
define('DB_SERVER', 'http://sql8.freesqldatabase.com/');
define('DB_USERNAME', 'sql8805800');
define('DB_PASSWORD', 'WpKfZ6vfYc'); // You need to add your actual password
define('DB_NAME', 'sql8805800');
define('DB_PORT', 3306);

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Application Constants
define('APP_NAME', 'TrainUp');
define('APP_VERSION', '1.0');
?>
