<?php
// Include the functions file from the functions folder
include 'functions.php';

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Change this to your MySQL root password
$dbname = "JudicialManagementSystem";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Superadmin details
$superadminUsername = 'superadmin';
$superadminEmail = 'superadmin@ashesi.edu.gh';
$superadminPassword = 'Superadmin2024!';

// Hash the superadmin password
$hashedPassword = hashPassword($superadminPassword);

// Insert superadmin into the Users table
$sql = "INSERT INTO Users (Username, PasswordHash, Email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $superadminUsername, $hashedPassword, $superadminEmail);

if ($stmt->execute()) {
    echo "Superadmin inserted successfully.\n";

    // Get the inserted superadmin's UserID
    $superadminUserID = $stmt->insert_id;

    // Assign the superadmin role
    $sqlRole = "INSERT INTO UserRoles (UserID, RoleID) VALUES (?, (SELECT RoleID FROM Roles WHERE RoleName = 'superadmin'))";
    $stmtRole = $conn->prepare($sqlRole);
    $stmtRole->bind_param("i", $superadminUserID);

    if ($stmtRole->execute()) {
        echo "Superadmin role assigned successfully.\n";
    } else {
        echo "Error assigning superadmin role: " . $stmtRole->error . "\n";
    }

    $stmtRole->close();
} else {
    echo "Error inserting superadmin: " . $stmt->error . "\n";
}

$stmt->close();
$conn->close();