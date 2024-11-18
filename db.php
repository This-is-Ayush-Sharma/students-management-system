<?php
$servername = "localhost:3306";
$username = "root";  // Adjust if your database has a different username
$password = "ayush1299";      // Adjust if your database has a password
$dbname = "school_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
