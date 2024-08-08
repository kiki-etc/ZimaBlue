<?php
include_once '../env.php';

// Check if the request is a POST request and the upload was successful
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload']) && $_POST['upload'] == 'success') {
    // Define the Nylas API endpoint
    $nylasEndpoint = "https://api.us.nylas.com/v3/grants/6440e391-b493-448b-8cf3-6687ea4adb58/messages/send";
    $nylasApiKey = "nyk_v0_I0sADgPu4iqlEbIGy3WMrf942yAopNn19uHGu14qngNQLwIsLGUZJOmtiHtCGbKe"; // Replace with your actual Nylas API key

    // Set the recipient email and name
    $toEmail = "nyameye.akumia@ashesi.edu.gh";
    $toName = "Nyameye Akumia";

    // Get current date
    $currentDate = date('Y-m-d');

    // Prepare the data to be sent in the API request
    $postData = json_encode([
        "to" => [["email" => $toEmail, "name" => $toName]],
        "subject" => "New Case Submission",
        "body" => "A NEW CASE HAS BEEN SUBMITTED ON '$currentDate'"
    ]);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $nylasEndpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $nylasApiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo "Failed to send the message. Error: " . curl_error($ch);
    } else {
        // Decode the response to check if it was successful
        $responseDecoded = json_decode($response, true);
        if (isset($responseDecoded['id'])) {
            echo "<script>
                alert('Your message has been sent successfully');
                window.location.href='../view/user_dash.php';
            </script>";
        } else {
            echo "Failed to send the message. Response: " . $response;
        }
    }

    // Close the cURL session
    curl_close($ch);
} else {
    echo "File upload not successful or invalid request.";
}