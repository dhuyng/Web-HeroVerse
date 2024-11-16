<?php
// database.php
require_once 'env.php';

// Get database credentials from environment variables
$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// Create a connection to MySQL server (without specifying a database initially)
$conn = mysqli_connect($host, $username, $password);

// Check if the connection is successful
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if the database exists
$db_check = mysqli_select_db($conn, $dbname);

if (!$db_check) {
    // If database does not exist, create it
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
} else {
    echo "Database '$dbname' already exists and is selected.<br>";
}

// Now you are connected to the selected database and can proceed with other operations.

// Close the connection (optional, typically you’ll do this at the end of the script)
mysqli_close($conn);
?>
