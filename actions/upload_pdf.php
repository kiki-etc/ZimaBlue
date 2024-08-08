<?php
session_start();
include "../settings/connection.php";

if (isset($_POST['submit'])) {
    $caseID = intval($_POST['caseID']);
    $uploadedBy = $_SESSION['user_id']; // Assuming the user ID is stored in the session

    // Check if a file is uploaded
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        // Check if the uploaded file is a PDF
        $fileType = mime_content_type($_FILES['pdf']['tmp_name']);
        if ($fileType == 'application/pdf') {
            // Define the target directory and file name
            $targetDir = "../uploads/";
            $fileName = basename($_FILES['pdf']['name']);
            $targetFilePath = $targetDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFilePath)) {
                // Insert the file information into the Documents table
                $insertQuery = "INSERT INTO Documents (CaseID, UploadedBy, DocumentName, DocumentPath) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("iiss", $caseID, $uploadedBy, $fileName, $targetFilePath);

                if ($stmt->execute()) {
                    echo "PDF uploaded successfully.";
                } else {
                    echo "Error inserting file information into database: " . $conn->error;
                }
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}
?>