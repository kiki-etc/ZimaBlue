<?php
include "../settings/core.php";
include "../settings/connection.php";

if (!isset($_GET['case_id'])) {
    echo "No case ID provided.";
    exit();
}

$caseID = intval($_GET['case_id']);

$caseQuery = "SELECT * FROM ComplaintsSuggestions WHERE ComplaintSuggestionID = ?";
$stmt = $conn->prepare($caseQuery);
$stmt->bind_param("i", $caseID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $case = $result->fetch_assoc();
} else {
    echo "Complain or Suggestion not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.userway.org/widget.js" data-account="yHxBfPK57z"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint or Suggestion Details</title>
    <link rel="stylesheet" href="../css/dash_style.css">
    <style>
        .case-details {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .case-details h2 {
            margin-top: 0;
        }

        .case-details p {
            margin: 10px 0;
        }

        .status-form {
            margin-top: 20px;
        }

        .status-form label {
            font-weight: bold;
        }

        .status-form select, .status-form button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .status-form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .status-form button:hover {
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
            <a href="../admin/admin_dash.php"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="../admin/cases.php"><i class="fa-solid fa-magnifying-glass"></i> View AJC Cases</a>
            <a href="../admin/complaints_suggestions.php"><i class="fa-solid fa-magnifying-glass"></i>View Complaints</a>
            <a href="../admin/add_case.php"><i class="fa-solid fa-align-justify"></i>Add New Case</a>
            <a href="#" style="margin-top: 30px;">---------------------</a>
            <a href="../view/user_profile.php"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="../login/logout_view.php" style="margin-right: 100px;"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </div>
    <div class="content">
        <header class="header">
            <h1>Complaint or SUggestion Details</h1>
        </header>

        <section class="case-details">
            <h2>Complaint or Suggestion Number: <?php echo htmlspecialchars($case['ComplaintSuggetsionID']); ?></h2>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($case['Title']); ?></p>
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br(htmlspecialchars_decode($case['Description'])); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($case['CreatedAt']); ?></p>

        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
</body>

</html>