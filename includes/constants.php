<?php
// For Render deployment - connect to InfinityFree MySQL
// Use environment variables with InfinityFree as fallback
$db_host = getenv('DB_HOST') ?: 'sql212.infinityfree.com';
$db_user = getenv('DB_USER') ?: 'if0_40180454';
$db_pass = getenv('DB_PASSWORD') ?: 'DFFVnI7Dza5MA';
$db_name = getenv('DB_NAME') ?: 'if0_40180454_train_up';

define('DB_HOST', $db_host);
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_pass);
define('DB_NAME', $db_name);

// Debug connection info
error_log("Connecting to database - Host: " . DB_HOST . ", DB: " . DB_NAME);
?>
