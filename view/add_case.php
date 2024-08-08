<?php  
include "../settings/core.php";
include "../settings/connection.php";

// Get the role IDs for superadmin and admin
$superadminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'superadmin'";
$superadminRoleResult = $conn->query($superadminRoleQuery);
$superadminRoleRow = $superadminRoleResult->fetch_assoc();
$superadminRoleID = $superadminRoleRow['RoleID'];

$adminRoleQuery = "SELECT RoleID FROM Roles WHERE RoleName = 'admin'";
$adminRoleResult = $conn->query($adminRoleRoleQuery);
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
    <title>Add AJC Case</title>
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
            <a href="../admin/admin_dash.php"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="../admin/cases.php"><i class="fa-solid fa-magnifying-glass"></i>View AJC Cases</a>
            <a href="../admin/complaints_suggestions.php"><i class="fa-solid fa-magnifying-glass"></i>View Complaints</a>
            <a href="../admin/add_case.php"><i class="fa-solid fa-align-justify"></i>Add New Case</a>
            <a href="#" style="margin-top: 30px;">
                ---------------------
            </a>
            <a href="../view/user_profile.php"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="../login/logout_view.php" style="margin-right: 100px;"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </div>
    <div class="content">

        <header class="header">
            <h1>Add New AJC Case</h1>
        </header>

        <section class="form-section">
            <form action="../actions/add_case_action.php" method="post">
                <label for="caseNumber">Case Number:</label>
                <input type="text" id="caseNumber" name="caseNumber" required>
                
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <div id="defendants">
                    <label for="defendant_email">Defendant Email:</label>
                    <input type="email" id="defendant_email" name="defendant_emails[]" required>
                </div>
                <button type="button" onclick="addDefendant()">Add Another Defendant</button>

                <div id="prosecutors">
                    <label for="prosecutor_email">Prosecutor Email:</label>
                    <input type="email" id="prosecutor_email" name="prosecutor_emails[]" required>
                </div>
                <button type="button" onclick="addProsecutor()">Add Another Prosecutor</button>
                
                <input type="hidden" name="upload" value="success">
                <button type="submit">Submit</button>
            </form>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
    <script>
        function addDefendant() {
            var div = document.createElement('div');
            div.innerHTML = '<label for="defendant_email">Defendant Email:</label><input type="email" id="defendant_email" name="defendant_emails[]" required>';
            document.getElementById('defendants').appendChild(div);
        }

        function addProsecutor() {
            var div = document.createElement('div');
            div.innerHTML = '<label for="prosecutor_email">Prosecutor Email:</label><input type="email" id="prosecutor_email" name="prosecutor_emails[]" required>';
            document.getElementById('prosecutors').appendChild(div);
        }
    </script>
</body>

</html>
<?php } ?>