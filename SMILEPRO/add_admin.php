<?php
$servername = "localhost";
$username = "root"; // change this to your database username
$password = "root"; // change this to your database password
$dbname = "smilepro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password before storing it in the database
$admin_username = 'admin';
$admin_password = password_hash('samara_123', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES ('$admin_username', '$admin_password')";

if ($conn->query($sql) === TRUE) {
    echo "New admin user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();