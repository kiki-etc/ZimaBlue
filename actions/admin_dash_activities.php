<?php
include "../db/connection.php"; // Ensure this file correctly sets up the $conn variable

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of activities per page
$offset = ($page - 1) * $limit;

header('Content-Type: text/html');

// Query to get recent activities with pagination
$activitiesQuery = "
    SELECT Users.Username, Activities.ActivityDate, Activities.Description 
    FROM Activities 
    JOIN Users ON Activities.UserID = Users.UserID 
    ORDER BY Activities.ActivityDate DESC 
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($activitiesQuery);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Generate the HTML for the activities table rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
    echo "<td>" . htmlspecialchars($row['ActivityDate']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
    echo "</tr>";
}

$stmt->close();
$conn->close();