<?php
include "../settings/connection.php"; // Ensure this file correctly sets up the $conn variable

header('Content-Type: application/json');

// Query to get the total number of cases
$totalCasesQuery = "SELECT COUNT(*) as TotalCases FROM Cases";
$totalCasesResult = $conn->query($totalCasesQuery);
$totalCases = $totalCasesResult->fetch_assoc()['TotalCases'];

// Query to get the number of resolved cases
$resolvedCasesQuery = "SELECT COUNT(*) as ResolvedCases FROM Cases WHERE Status = 'resolved'";
$resolvedCasesResult = $conn->query($resolvedCasesQuery);
$resolvedCases = $resolvedCasesResult->fetch_assoc()['ResolvedCases'];

// Query to get the number of pending cases
$pendingCasesQuery = "SELECT COUNT(*) as PendingCases FROM Cases WHERE Status = 'pending'";
$pendingCasesResult = $conn->query($pendingCasesQuery);
$pendingCases = $pendingCasesResult->fetch_assoc()['PendingCases'];

// Prepare the response
$response = array(
    'Total_Cases' => $totalCases,
    'Resolved_Cases' => $resolvedCases,
    'Pending_Cases' => $pendingCases
);

// Send the response as JSON
echo json_encode($response);

$conn->close();