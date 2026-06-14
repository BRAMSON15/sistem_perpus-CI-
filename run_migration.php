<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'perpus';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS card_scans (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    scan_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('aktif') DEFAULT 'aktif',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if ($conn->query($sql) === TRUE) {
    echo "Table card_scans created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
