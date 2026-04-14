<?php
// nezaštićena konfiguracija
define('DB_HOST', getenv('DB_HOST') ?: '172.20.0.20');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'bankapp');

function db() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>