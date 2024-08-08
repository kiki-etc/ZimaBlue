<?php  
include "../settings/core.php";
include "../settings/connection.php";

// Get the role IDs for superadmin and admin
$superadminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'superadmin'";
$superadminRoleResult = $conn->query($superadminRoleQuery);
$superadminRoleRow = $superadminRoleResult->fetch_assoc();
$superadminRoleID = $superadminRoleRow['RoleID'];

$adminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'admin'";
$adminRoleResult = $conn->query($adminRoleQuery);
$adminRoleRow = $adminRoleResult->fetch_assoc();
$adminRoleID = $adminRoleRow['RoleID'];

if ($_SESSION['user_role'] != $superadminRoleID && $_SESSION['user_role'] != $adminRoleID) {
    header("Location: ../view/user_dash.php");
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Proposal</title>
    <link rel="stylesheet" href="../css/dash_style.css">
    <style>
        .upload-form {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .upload-form h2 {
            margin-top: 0;
        }

        .upload-form label {
            font-weight: bold;
        }

        .upload-form input[type="file"],
        .upload-form button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .upload-form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .upload-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar_logo">
            <a href="../view/user_dash.php">
                <img id="logo" src="../images/logo.png"> 
            </a>
        </div>
        <div class="menu_top">
            <a href="../view/admin_dash.php"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="../view/cases.php"><i class="fa-solid fa-magnifying-glass"></i> View AJC Cases</a>
            <a href="../view/add_case.php"><i class="fa-solid fa-align-justify"></i>Submit Proposal</a>
            <a href="../view/add_complaints_suggestions.php"><i class="fa-solid fa-align-justify"></i>Submit Complaint/Suggestion</a>
            <a href="#" style="margin-top: 30px;">
                ---------------------
            </a>
            <a href="../login/logout_view.php" style="margin-right: 100px;"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </div>
    <div class="content">

        <header class="header">
            <h1>Upload PDF</h1>
        </header>

        <section class="upload-form">
            <form id="uploadForm" action="../actions/upload_pdf.php" method="post" enctype="multipart/form-data">
                <h2>Upload PDF</h2>
                <label for="caseID">Case ID:</label>
                <input type="text" id="caseID" name="caseID" required>
                
                <label for="pdf">Select PDF:</label>
                <input type="file" id="pdf" name="pdf" accept="application/pdf" required>
                
                <button type="button" onclick="handleUpload()">Upload</button>
            </form>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
    <script>
        function handleUpload() {
            // Perform AJAX request to call upload_notification.php
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../functions/upload_notification.php", true);
            xhr.send();

            // Submit the form
            document.getElementById('uploadForm').submit();
        }
    </script>
</body>

</html>
<?php } ?>