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
    <title>View AJC Cases</title>
    <link rel="stylesheet" href="../css/dash_style.css">
    <style>
        .case-list {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .case-item {
            padding: 10px;
            margin: 5px 0;
            border-bottom: 1px solid #ccc;
        }

        .case-item a {
            text-decoration: none;
            color: #A53838;
            font-weight: bold;
        }

        .case-item a:hover {
            color: #A01010;
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
            <a href="../admin/view_document_summaries.php"><i class="fa-solid fa-file-alt"></i>View Document Summaries</a>
            <a href="#" style="margin-top: 30px;">---------------------</a>
            <a href="../login/logout_view.php" style="margin-right: 100px;"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </div>
    <div class="content">

        <header class="header">
            <h1>View AJC Cases</h1>
        </header>

        <section class="case-list">
            <?php
            $caseQuery = "SELECT CaseID, CaseNumber, Title FROM Cases";
            $caseResult = $conn->query($caseQuery);

            if ($caseResult->num_rows > 0) {
                while ($case = $caseResult->fetch_assoc()) {
                    echo '<div class="case-item">';
                    echo '<a href="../functions/display_case_function.php?case_id=' . $case['CaseID'] . '">' . htmlspecialchars($case['CaseNumber']) . ': ' . htmlspecialchars($case['Title']) . '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No cases found.</p>';
            }
            ?>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
</body>

</html>
<?php } ?>