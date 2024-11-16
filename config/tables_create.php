<?php

// Database connection settings
require_once 'database_connect.php';

// Path to the CSV file (relative path)
$csvFile = __DIR__ . '/data/users.csv';

// Create connection to MySQL server
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Stored procedure to create users table
function createUsersTable($mysqli) {
    $sql = "
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
    ";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "Users table creation procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for users table: " . $mysqli->error . "<br>";
    }
}

// Stored procedure to create heroes table
function createHeroesTable($mysqli) {
    $sql = "
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
    ";

    if ($mysqli->query($sql) === TRUE) {
        echo "Heroes table creation procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for heroes table: " . $mysqli->error . "<br>";
    }
}

// Stored procedure to create comments table
function createCommentsTable($mysqli) {
    $sql = "
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
    ";

    if ($mysqli->query($sql) === TRUE) {
        echo "Comments table creation procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for comments table: " . $mysqli->error . "<br>";
    }
}

// Stored procedure to create news table
function createNewsTable($mysqli) {
    $sql = "
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
    ";

    if ($mysqli->query($sql) === TRUE) {
        echo "News table creation procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for news table: " . $mysqli->error . "<br>";
    }
}

// Stored procedure to create pages table
function createPagesTable($mysqli) {
    $sql = "
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
    ";

    if ($mysqli->query($sql) === TRUE) {
        echo "Pages table creation procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for pages table: " . $mysqli->error . "<br>";
    }
}

// Stored procedure to insert data into users table
function createInsertUserProcedure($mysqli) {
    $sql = "
    CREATE PROCEDURE insert_user(IN username VARCHAR(50), IN email VARCHAR(100), IN password VARCHAR(255), IN role ENUM('admin', 'member'))
    BEGIN
        INSERT INTO users (username, email, password, role)
        VALUES (username, email, password, role);
    END;
    ";

    if ($mysqli->query($sql) === TRUE) {
        echo "Insert user procedure created successfully!<br>";
    } else {
        echo "Error creating procedure for inserting users: " . $mysqli->error . "<br>";
    }
}

// Function to load users from the CSV file into the database using the insert_user stored procedure
function loadUsersFromCSV($mysqli, $csvFile) {
    // Open the CSV file
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        // Skip the first row (header)
        fgetcsv($handle);

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Extract data from the CSV row
            $username = $data[0];
            $email = $data[1];
            $password = $data[2];
            $role = $data[3];

            // Call the insert_user stored procedure
            if ($stmt = $mysqli->prepare("CALL insert_user(?, ?, ?, ?)")) {
                $stmt->bind_param("ssss", $username, $email, $password, $role);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Error executing stored procedure: " . $mysqli->error . "<br>";
            }
        }

        // Close the CSV file
        fclose($handle);
        echo "Data successfully loaded from CSV!<br>";
    } else {
        echo "Error opening CSV file: $csvFile<br>";
    }
}


// Select the database to use
$mysqli->select_db($dbname);

// Create all tables using stored procedures
createUsersTable($mysqli);
createHeroesTable($mysqli);
createCommentsTable($mysqli);
createNewsTable($mysqli);
createPagesTable($mysqli);

// Create stored procedure for inserting users
createInsertUserProcedure($mysqli);

// Execute the stored procedures to create tables
$mysqli->query("CALL create_users_table()");
$mysqli->query("CALL create_heroes_table()");
$mysqli->query("CALL create_comments_table()");
$mysqli->query("CALL create_news_table()");
$mysqli->query("CALL create_pages_table()");

// Check if the CSV file exists and load the data
if (file_exists($csvFile)) {
    loadUsersFromCSV($mysqli, $csvFile); // Import data from CSV into users table
} else {
    echo realpath($csvFile);
    echo "Current directory: " . getcwd() . "<br>";

    echo "CSV file not found: $csvFile<br>";
}

// Close the MySQL connection
$mysqli->close();
?>
