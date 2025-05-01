<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// MySQL database configuration for XAMPP
$db_host = 'localhost';
$db_name = 'learnflare';
$db_user = 'root';      // Default XAMPP MySQL username
$db_pass = '';          // Default XAMPP MySQL password is empty

// Create connection using PDO with MySQL driver
try {
    // MySQL connection string
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Test the connection
    $test_query = $pdo->query("SELECT 1");
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>