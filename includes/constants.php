<?php
// Database Constants - PostgreSQL Render
define('DB_HOST', 'dpg-d4968oc9c44c73bgq220-a.oregon-postgres.render.com');
define('DB_USER', 'train_up_user');
define('DB_PASSWORD', '6sebZERlRZWaxbVRTVWf67nnARKXtDVe');
define('DB_NAME', 'train_up_db_m8dc');
define('DB_PORT', 5432);

// Attempt to connect to PostgreSQL database
try {
    $pdo = new PDO("pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Application Constants
define('APP_NAME', 'TrainUp');
define('APP_VERSION', '1.0');
?>
