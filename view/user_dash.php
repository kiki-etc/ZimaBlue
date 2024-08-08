<?php
session_start();
include "../settings/core.php";
include "../settings/connection.php";

// Display success and error messages
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/dash_style.css">
</head>

<body>
    <?php if (isset($message)): ?>
        <p style='color: green;'><?php echo $message; ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p style='color: red;'><?php echo $error; ?></p>
    <?php endif; ?>
    
    <div class="sidebar">
        <div class="sidebar_logo">
            <a href="../view/user_dash.php">
                <img id="logo" src="../images/logo.png"> 
            </a>
        </div>
        <div class="menu_top">
            <a href="../view/user_dash.php"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="../view/cases.php"><i class="fa-solid fa-magnifying-glass"></i>View AJC Cases</a>
            <a href="../view/add_case.php"><i class="fa-solid fa-align-justify"></i>Submit Proposal</a>
            <a href="#" style="margin-top: 30px;">
                ---------------------
            </a>
            <a href="../login/logout_view.php" style="margin-right: 100px;"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </div>
    <div class="content">

        <header class="header">
            <h1>Dashboard</h1>
        </header>

        <section class="stats">
            <div class="box">
                <i class="fa-solid fa-folder"></i>
                <h3 id="total-cases-count"></h3>
                <p>Total Cases</p>
            </div>
            <div class="box">
                <i class="fa-solid fa-check-circle"></i>
                <h3 id="resolved-cases-count"></h3>
                <p>Resolved Cases</p>
            </div>
            <div class="box">
                <i class="fa-solid fa-hourglass-half"></i>
                <h3 id="pending-cases-count"></h3>
                <p>Pending Cases</p>
            </div>
        </section>
        <section class="recent-activities">
            <h2>Recent Activities</h2>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody id="activity-table-body">
                    <?php include "../actions/admin_dash_activities.php"; ?>
                </tbody>
            </table>
            <div class="pagination">
                <button id="prev-btn" onclick="loadPreviousPage()">Previous</button>
                <button id="next-btn" onclick="loadNextPage()">Next</button>
            </div>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
    <script src="../js/admin_dash_script.js"></script>
    <script>
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../actions/admin_dash_stats.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var statistics = JSON.parse(xhr.responseText);

                document.getElementById("total-cases-count").textContent = statistics.Total_Cases;
                document.getElementById("resolved-cases-count").textContent = statistics.Resolved_Cases;
                document.getElementById("pending-cases-count").textContent = statistics.Pending_Cases;
            }
        };
        xhr.send();

        var currentPage = 1;

        function loadNextPage() {
            currentPage++;
            loadData(currentPage);
        }

        function loadPreviousPage() {
            if (currentPage > 1) {
                currentPage--;
                loadData(currentPage);
            }
        }

        function loadData(page) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../actions/admin_dash_activities.php?page=" + page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var tableBody = document.getElementById("activity-table-body");
                    tableBody.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>
<?php } ?>