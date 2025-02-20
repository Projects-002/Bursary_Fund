<?php
$host = "localhost";  // Change if using a remote database
$username = "root";   // Your MySQL username
$password = "alex";       // Your MySQL password
$database = "sholarease"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
