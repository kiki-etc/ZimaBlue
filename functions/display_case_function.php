<?php
include "../settings/core.php";
include "../settings/connection.php";

if (!isset($_GET['case_id'])) {
    echo "No case ID provided.";
    exit();
}

$caseID = intval($_GET['case_id']);

$caseQuery = "SELECT * FROM Cases WHERE CaseID = ?";
$stmt = $conn->prepare($caseQuery);
$stmt->bind_param("i", $caseID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $case = $result->fetch_assoc();
} else {
    echo "Case not found.";
    exit();
}

// Fetch defendants
$defendantsQuery = "SELECT Users.Email FROM Users JOIN CaseDefendants ON Users.UserID = CaseDefendants.UserID WHERE CaseDefendants.CaseID = ?";
$stmtDefendants = $conn->prepare($defendantsQuery);
$stmtDefendants->bind_param("i", $caseID);
$stmtDefendants->execute();
$defendantsResult = $stmtDefendants->get_result();

// Fetch prosecutors
$prosecutorsQuery = "SELECT Users.Email FROM Users JOIN CaseProsecutors ON Users.UserID = CaseProsecutors.UserID WHERE CaseProsecutors.CaseID = ?";
$stmtProsecutors = $conn->prepare($prosecutorsQuery);
$stmtProsecutors->bind_param("i", $caseID);
$stmtProsecutors->execute();
$prosecutorsResult = $stmtProsecutors->get_result();

// Handle form submission for updating status
if (isset($_POST['update_status'])) {
    $newStatus = htmlspecialchars($_POST['status']);

    $updateQuery = "UPDATE Cases SET Status = ? WHERE CaseID = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("si", $newStatus, $caseID);

    if ($stmtUpdate->execute()) {
        echo "Status updated successfully.";
        // Refresh case data
        $stmt->execute();
        $case = $stmt->get_result()->fetch_assoc();
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Details</title>
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
            <h1>Case Details</h1>
        </header>

        <section class="case-details">
            <h2>Case Number: <?php echo htmlspecialchars($case['CaseNumber']); ?></h2>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($case['Title']); ?></p>
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br(htmlspecialchars_decode($case['Description'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($case['Status'] ?? 'Pending'); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($case['CreatedAt']); ?></p>

            <h3>Defendants</h3>
            <ul>
                <?php while ($defendant = $defendantsResult->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($defendant['Email']); ?></li>
                <?php endwhile; ?>
            </ul>

            <h3>Prosecutors</h3>
            <ul>
                <?php while ($prosecutor = $prosecutorsResult->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($prosecutor['Email']); ?></li>
                <?php endwhile; ?>
            </ul>

            <form class="status-form" action="" method="post">
                <label for="status">Update Status:</label>
                <select id="status" name="status" required>
                    <option value="pending" <?php if ($case['Status'] == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="resolved" <?php if ($case['Status'] == 'resolved') echo 'selected'; ?>>Resolved</option>
                </select>
                <button type="submit" name="update_status">Update Status</button>
            </form>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/88061bebc5.js" crossorigin="anonymous"></script>
</body>

</html>