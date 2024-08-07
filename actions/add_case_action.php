<?php
session_start();
include "../settings/connection.php";

if (isset($_POST['caseNumber']) && isset($_POST['title']) && isset($_POST['description'])) {

    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $caseNumber = validate($_POST['caseNumber']);
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);
    $createdBy = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Check if case number already exists
    $caseCheckQuery = "SELECT * FROM Cases WHERE CaseNumber = ?";
    $stmtCheck = $conn->prepare($caseCheckQuery);
    $stmtCheck->bind_param("s", $caseNumber);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        header("Location: ../admin/add_case.php?error=Case number already exists");
        exit();
    }

    // Insert the new case into the Cases table
    $insertQuery = "INSERT INTO Cases (CaseNumber, Title, Description, CreatedBy) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("sssi", $caseNumber, $title, $description, $createdBy);

    if ($stmtInsert->execute()) {
        // Log the activity
        $activityDescription = "Added an AJC case";
        $activityQuery = "INSERT INTO Activities (UserID, Description) VALUES (?, ?)";
        $stmtActivity = $conn->prepare($activityQuery);
        $stmtActivity->bind_param("is", $createdBy, $activityDescription);
        $stmtActivity->execute();

        header("Location: ../admin/cases.php?success=Case added successfully");
        exit();
    } else {
        header("Location: ../admin/add_case.php?error=Error adding case");
        exit();
    }
} else {
    header("Location: ../admin/add_case.php?error=All fields are required");
    exit();
}