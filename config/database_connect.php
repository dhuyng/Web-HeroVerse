<?php
// database_connect.php
require_once 'env.php';

// Get database credentials from environment variables
$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$conn = mysqli_connect($host, $username, $password);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if the database exists
$db_check = mysqli_select_db($conn, $dbname);

if (!$db_check) {
    $create_db_query = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    
    if (mysqli_query($conn, $create_db_query)) {
        echo "Database '$dbname' created successfully (or already exists).<br>";
    } else {
        die('Error creating database: ' . mysqli_error($conn));
    }

    // After creating the database, select it for use
    if (!mysqli_select_db($conn, $dbname)) {
        die('Error selecting database: ' . mysqli_error($conn));
    }
}
