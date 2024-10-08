<?php
session_start();
include "../settings/connection.php";

if (isset($_POST['title']) && isset($_POST['description'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $title = validate($_POST['title']);
    $description = validate($_POST['description']);
    $createdBy = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Insert the new case into the ComplaintsSuggestions table
    $insertQuery = "INSERT INTO ComplaintsSuggestions (Title, Description, UserID) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("ssi", $title, $description, $createdBy);

    if ($stmtInsert->execute()) {
        // Log the activity
        $activityDescription = "Added a Complaint/Suggestion";
        $activityQuery = "INSERT INTO Activities (UserID, Description) VALUES (?, ?)";
        $stmtActivity = $conn->prepare($activityQuery);
        $stmtActivity->bind_param("is", $createdBy, $activityDescription);
        $stmtActivity->execute();

        header("Location: ../view/user_dash.php?success=Complaint or Suggestion added successfully");
        exit();
    } else {
        header("Location: ../view/add_complaints_suggestions.php?error=Error adding complaint or suggestion");
        exit();
    }
} else {
    header("Location: ../view/add_complaints_suggestions.php?error=All fields are required");
    exit();
}