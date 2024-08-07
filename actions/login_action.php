<?php
session_start();
include "../settings/connection.php"; // Ensure this file exists and correctly sets up the $conn variable

if (isset($_POST['submit_button'])) {

    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $user_mail = validate($_POST['email']);
    $psswrd = validate($_POST['passwrd']);

    if (empty($user_mail)) {
        header("Location: ../login/login_view.php?error=Email is required");
        exit();
    } else if (empty($psswrd)) {
        header("Location: ../login/login_view.php?error=Password is required");
        exit();
    }

    $sql = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_mail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($psswrd, $row['PasswordHash'])) {
            $_SESSION['user_id'] = $row['UserID'];

            // Get the user's role
            $sqlRole = "SELECT RoleID FROM UserRoles WHERE UserID = ?";
            $stmtRole = $conn->prepare($sqlRole);
            $stmtRole->bind_param("i", $row['UserID']);
            $stmtRole->execute();
            $resultRole = $stmtRole->get_result();
            $roleRow = $resultRole->fetch_assoc();

            $_SESSION['user_role'] = $roleRow['RoleID'];

            // Get the role IDs for superadmin and admin
            $superadminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'superadmin'";
            $superadminRoleResult = $conn->query($superadminRoleQuery);
            $superadminRoleRow = $superadminRoleResult->fetch_assoc();
            $superadminRoleID = $superadminRoleRow['RoleID'];

            $adminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'admin'";
            $adminRoleResult = $conn->query($adminRoleQuery);
            $adminRoleRow = $adminRoleResult->fetch_assoc();
            $adminRoleID = $adminRoleRow['RoleID'];

            // Check if the user's role is either superadmin or admin
            if ($_SESSION['user_role'] == $superadminRoleID || $_SESSION['user_role'] == $adminRoleID) {
                header("Location: ../admin/admin_dash.php");
                exit();
            } else {
                header("Location: ../view/user_dash.php");
                exit();
            }
        } else {
            header("Location: ../login/login_view.php?error=Incorrect email or password.");
            exit();
        }
    } else {
        header("Location: ../login/login_view.php?error=Incorrect email or password.");
        exit();
    }
} else {
    header("Location: ../login/login_view.php");
    exit();
}
?>