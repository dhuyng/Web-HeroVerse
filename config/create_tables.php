<?php

// create_tables.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['tables_created']) || !$_SESSION['tables_created']) {

    // Database connection settings
    require_once 'database_connect.php';

    // Path to the CSV file (relative path)
    $csvFile = __DIR__ . '/data/users.csv';

    // Ensure $mysqli is globally accessible
    $mysqli = $conn; 

    // Function to create stored procedures
    function createStoredProcedure($mysqli, $procedureName, $procedureSQL) {
        // Drop the procedure if it exists to ensure reusability
        $mysqli->query("DROP PROCEDURE IF EXISTS $procedureName");

        // Create the procedure
        if ($mysqli->query($procedureSQL) === TRUE) {
            echo "Procedure `$procedureName` created successfully!<br>";
        } else {
            echo "Error creating procedure `$procedureName`: " . $mysqli->error . "<br>";
        }
    }

    // Stored procedures definitions
    $procedures = [
        'create_users_table' => "
        CREATE PROCEDURE create_users_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'member') DEFAULT 'member',
                avatar VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        END;
        ",
        'create_heroes_table' => "
        CREATE PROCEDURE create_heroes_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS heroes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT NOT NULL,
                image VARCHAR(255) DEFAULT NULL,
                type VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        END;
        ",
        'create_comments_table' => "
        CREATE PROCEDURE create_comments_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS comments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                content TEXT NOT NULL,
                type ENUM('hero', 'news') NOT NULL,
                type_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        END;
        ",
        'create_news_table' => "
        CREATE PROCEDURE create_news_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS news (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(200) NOT NULL,
                content TEXT NOT NULL,
                image VARCHAR(255) DEFAULT NULL,
                keywords VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        END;
        ",
        'create_pages_table' => "
        CREATE PROCEDURE create_pages_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS pages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        END;
        ",
        'insert_user' => "
        CREATE PROCEDURE insert_user(IN username VARCHAR(50), IN email VARCHAR(100), IN password VARCHAR(255), IN role ENUM('admin', 'member'))
        BEGIN
            INSERT INTO users (username, email, password, role)
            VALUES (username, email, password, role);
        END;
        "
    ];

    // Create all stored procedures
    foreach ($procedures as $name => $sql) {
        createStoredProcedure($mysqli, $name, $sql);
    }

    // Execute stored procedures to create tables
    $tablesToCreate = ['create_users_table', 'create_heroes_table', 'create_comments_table', 'create_news_table', 'create_pages_table'];

    foreach ($tablesToCreate as $procedureName) {
        if ($mysqli->query("CALL $procedureName()") === TRUE) {
            echo "Table created successfully using `$procedureName`!<br>";
        } else {
            echo "Error executing `$procedureName`: " . $mysqli->error . "<br>";
        }
    }

    // Function to load users from CSV using stored procedure
    function loadUsersFromCSV($mysqli, $csvFile) {
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Skip header
            fgetcsv($handle);

            // Iterate through CSV rows
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                [$username, $email, $password, $role] = $data;

                if ($stmt = $mysqli->prepare("CALL insert_user(?, ?, ?, ?)")) {
                    $stmt->bind_param("ssss", $username, $email, $password, $role);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "Error executing `insert_user` for user `$username`: " . $mysqli->error . "<br>";
                }
            }

            fclose($handle);
            echo "CSV data loaded successfully!<br>";
        } else {
            echo "Error: Could not open file `$csvFile`.<br>";
        }
    }

    // Load CSV data into users table
    if (file_exists($csvFile)) {
        loadUsersFromCSV($mysqli, $csvFile);
    } else {
        echo "CSV file not found at: $csvFile<br>";
    }

    // Close connection
    $mysqli->close();

    $_SESSION['tables_created'] = true;

}
?>
