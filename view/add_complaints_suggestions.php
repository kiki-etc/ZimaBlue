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
    <script src="https://cdn.userway.org/widget.js" data-account="yHxBfPK57z"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Complaint or Suggestion</title>
    <link rel="stylesheet" href="../css/dash_style.css">
    <style>
        .form-section {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-section form {
            display: flex;
            flex-direction: column;
        }

        .form-section label {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section textarea {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-section textarea {
            resize: vertical;
            height: 100px;
        }

        .form-section button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #A53838;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-section button:hover {
            background-color: #A52929;
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
            <h1>Submit Complaint or Suggestion</h1>
        </header>

        <section class="form-section">
            <form action="../actions/add_complaints_suggestions_action.php" method="post">
                             
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <input type="hidden" name="upload" value="success">
                <button type="submit">Submit</button>
            </form>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
</body>

</html>
<?php } ?>