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
                subscription_type ENUM('basic', 'pro', 'premium') DEFAULT 'basic',
                balance DECIMAL(10, 2) DEFAULT 0.00,
                two_fa_enabled BOOLEAN DEFAULT FALSE,
                profile_pic VARCHAR(255) DEFAULT NULL,
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
        'create_recharge_history_table' => "
        CREATE PROCEDURE create_recharge_history_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS recharge_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                amount DECIMAL(10, 2) NOT NULL, -- Amount in the user's currency
                coins INT NOT NULL, -- Coins received
                payment_method ENUM('momo', 'zalopay', 'code') NOT NULL, -- Payment method
                status ENUM('pending', 'completed', 'failed') DEFAULT 'pending', -- To track transaction state
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        END;
        ",
        'create_usage_history_table' => "
        CREATE PROCEDURE create_usage_history_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS usage_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                coins_used INT NOT NULL, -- Coins spent
                description TEXT NOT NULL, -- Description of the transaction
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        END;
        ",
        'insert_user' => "
        CREATE PROCEDURE insert_user(
            IN username VARCHAR(50),
            IN email VARCHAR(100),
            IN password VARCHAR(255),
            IN role ENUM('admin', 'member'),
            IN subscription ENUM('basic', 'pro', 'premium')
        )
        BEGIN
            INSERT INTO users (username, email, password, role, subscription_type)
            VALUES (username, email, password, role, subscription);
        END;
        "

        ,
        'create_support_table' => "
        CREATE PROCEDURE create_support_table()
        BEGIN
            CREATE TABLE IF NOT EXISTS support (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(200) NOT NULL,
                question TEXT NOT NULL,
                answer TEXT DEFAULT NULL,
                is_processed BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        END;"
    ];

    // Create all stored procedures
    foreach ($procedures as $name => $sql) {
        createStoredProcedure($mysqli, $name, $sql);
    }

    // Execute stored procedures to create tables
    $tablesToCreate = ['create_users_table', 'create_heroes_table', 'create_comments_table', 'create_news_table', 'create_pages_table', 'create_recharge_history_table', 'create_usage_history_table', 'create_support_table'];

    foreach ($tablesToCreate as $procedureName) {
        if ($mysqli->query("CALL $procedureName()") === TRUE) {
            echo "Table created successfully using `$procedureName`!<br>";
        } else {
            echo "Error executing `$procedureName`: " . $mysqli->error . "<br>";
        }
    }

    if ($mysqli->query("INSERT INTO `usage_history` (`id`, `user_id`, `date`, `coins_used`, `description`) VALUES ('1', '2', '02/11/2024', '10', 'Mua tướng Dragneel'), ('2', '2', '20/10/2024', '30', 'Nâng cấp tài khoản VIP'), ('3', '2', '15/10/2024', '5', 'Sử dụng dịch vụ hỗ trợ')") === TRUE) {
        echo "Insert into usage_history successfully!<br>";
    } else {
        echo "Error executing insert into usage_history: " . $mysqli->error . "<br>";
    }

    if ($mysqli->query("INSERT INTO `recharge_history` (`id`, `user_id`, `date`, `amount`, `coins`, `payment_method`, `status`) VALUES ('1', '2', current_timestamp(), '20000', '20', 'momo', 'completed'), ('2', '2', current_timestamp(), '50000', '50', 'zalopay', 'pending'), ('3', '2', current_timestamp(), '100000', '100', 'code', 'failed')") === TRUE) {
        echo "Insert into recharge_history successfully!<br>";
    } else {
        echo "Error executing insert into recharge_history: " . $mysqli->error . "<br>";
    }

    
    if ($mysqli->query("INSERT INTO `support` (`id`, `user_id`, `title`, `question`, `answer`, `is_processed`) VALUES ('1', '2', 'Hỗ trợ tài khoản', 'Tôi không thể đăng nhập vào tài khoản của mình. Xin hãy giúp đỡ!', NULL, '1'), ('2', '2', 'Hỗ trợ nạp tiền', 'Tôi đã nạp tiền nhưng không nhận được Coin. Xin hãy giúp đỡ!', NULL, '0'), ('3', '1', 'Hỗ trợ dịch vụ', 'Tôi muốn nâng cấp tài khoản VIP. Xin hãy giúp đỡ!', NULL, '1')") === TRUE) {
        echo "Insert into support successfully!<br>";
    } else {
        echo "Error executing insert into support: " . $mysqli->error . "<br>";
    }


    // Function to load users from CSV using stored procedure
// Function to load users from CSV using stored procedure
    function loadUsersFromCSV($mysqli, $csvFile) {
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Skip header
            fgetcsv($handle);

            // Iterate through CSV rows
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                [$username, $email, $password, $role, $subscription] = $data;

                // Kiểm tra trùng lặp username
                $checkStmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                $checkStmt->bind_param("s", $username);
                $checkStmt->execute();
                $count = 0;
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
                $checkStmt->close();

                if ($count > 0) {
                    echo "User `$username` already exists, skipping insertion.<br>";
                } else {
                    if ($stmt = $mysqli->prepare("CALL insert_user(?, ?, ?, ?, ?)")) {
                        $stmt->bind_param("sssss", $username, $email, $password, $role, $subscription);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        echo "Error executing `insert_user` for user `$username`: " . $mysqli->error . "<br>";
                    }
                }
            }

            fclose($handle);
            echo "CSV data loaded successfully!<br>";
        } else {
            echo "Error: Could not open file `$csvFile`.<br>";
        }
    }


    // // Load CSV data into users table
    // if (file_exists($csvFile)) {
    //     loadUsersFromCSV($mysqli, $csvFile);
    // } else {
    //     echo "CSV file not found at: $csvFile<br>";
    // }

    // Close connection
    $mysqli->close();

    $_SESSION['tables_created'] = true;

}
?>
