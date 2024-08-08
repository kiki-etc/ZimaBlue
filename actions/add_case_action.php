<?php
session_start();
include "../settings/connection.php";

if (isset($_POST['caseNumber']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['defendant_emails']) && isset($_POST['prosecutor_emails'])) {
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
        $caseID = $stmtInsert->insert_id;

        // Insert defendants
        $defendant_emails = $_POST['defendant_emails'];
        $defendantInsertQuery = "INSERT INTO CaseDefendants (CaseID, UserID) VALUES (?, ?)";
        $stmtDefendantInsert = $conn->prepare($defendantInsertQuery);

        foreach ($defendant_emails as $email) {
            $userQuery = "SELECT UserID FROM Users WHERE Email = ?";
            $stmtUser = $conn->prepare($userQuery);
            $stmtUser->bind_param("s", $email);
            $stmtUser->execute();
            $resultUser = $stmtUser->get_result();
            if ($resultUser->num_rows > 0) {
                $user = $resultUser->fetch_assoc();
                $stmtDefendantInsert->bind_param("ii", $caseID, $user['UserID']);
                $stmtDefendantInsert->execute();
            }
        }

        // Insert prosecutors
        $prosecutor_emails = $_POST['prosecutor_emails'];
        $prosecutorInsertQuery = "INSERT INTO CaseProsecutors (CaseID, UserID) VALUES (?, ?)";
        $stmtProsecutorInsert = $conn->prepare($prosecutorInsertQuery);

        foreach ($prosecutor_emails as $email) {
            $userQuery = "SELECT UserID FROM Users WHERE Email = ?";
            $stmtUser = $conn->prepare($userQuery);
            $stmtUser->bind_param("s", $email);
            $stmtUser->execute();
            $resultUser = $stmtUser->get_result();
            if ($resultUser->num_rows > 0) {
                $user = $resultUser->fetch_assoc();
                $stmtProsecutorInsert->bind_param("ii", $caseID, $user['UserID']);
                $stmtProsecutorInsert->execute();
            }
        }

        // Log the activity
        $activityDescription = "Added an AJC case";
        $activityQuery = "INSERT INTO Activities (UserID, Description) VALUES (?, ?)";
        $stmtActivity = $conn->prepare($activityQuery);
        $stmtActivity->bind_param("is", $createdBy, $activityDescription);
        $stmtActivity->execute();

        // Send notifications
        $_POST['upload'] = 'success';
        include "../functions/case_notification.php";

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