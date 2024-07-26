<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constants if they are not already defined
if (!defined('ROOT__URL')) {
    define('ROOT__URL', 'http://localhost/Blogvista/');
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('DB_PORT')) {
    define('DB_PORT', 3307);
}

if (!defined('DB_USER')) {
    define('DB_USER', 'nidhi');
}

if (!defined('DB_PASS')) {
    define('DB_PASS', 'admin1234');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'blogvista');
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error); // Log error to file
        die("Connection failed: " . $conn->connect_error);
    }

} catch (mysqli_sql_exception $e) {
    error_log("Connection failed: " . $e->getMessage()); // Log error to file
    die("Connection failed: " . $e->getMessage());
}
?>
