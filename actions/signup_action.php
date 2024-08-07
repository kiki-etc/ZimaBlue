<?php
session_start();
include "../settings/connection.php"; // Ensure this file exists and correctly sets up the $conn variable
include "../functions/functions.php"; // Include the functions for password hashing

if (isset($_POST['submit_button'])) {

    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['confirm_password']);
    $role_id = validate($_POST['role_id']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: ../login/signup_view.php?error=All fields are required");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: ../login/signup_view.php?error=Passwords do not match");
        exit();
    }

    // Check if the username or email already exists
    $sql = "SELECT * FROM Users WHERE Username = ? OR Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../login/signup_view.php?error=Username or email already taken");
        exit();
    }

    // Hash the password
    $hashedPassword = hashPassword($password);

    // Insert the new user into the Users table
    $sql = "INSERT INTO Users (Username, PasswordHash, Email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashedPassword, $email);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // Assign the selected role to the new user
        $sqlRole = "INSERT INTO UserRoles (UserID, RoleID) VALUES (?, ?)";
        $stmtRole = $conn->prepare($sqlRole);
        $stmtRole->bind_param("ii", $user_id, $role_id);

        if ($stmtRole->execute()) {
            header("Location: ../login/login_view.php?success=Account created successfully");
            exit();
        } else {
            header("Location: ../login/signup_view.php?error=Error assigning role");
            exit();
        }
    } else {
        header("Location: ../login/signup_view.php?error=Error creating account");
        exit();
    }
} else {
    header("Location: ../login/signup_view.php");
    exit();
}