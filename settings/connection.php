<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change this to your MySQL root password
$dbname = "database";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "";