<?php
include_once '../env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload']) && $_POST['upload'] == 'success') {
    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = USERNAME; // Your Gmail email address
        $mail->Password = PASSWD; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom(NOTIFICATION_EMAIL, 'Automated Notification');
        $mail->addAddress(NOTIFICATION_EMAIL);

        // Get current date
        $current_date = date('Y-m-d');

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Case Submission';
        $mail->Body = "A NEW CASE HAS BEEN SUBMITTED ON '$current_date'";

        // Send email
        $mail->send();

        echo "Notification sent successfully.";
    } catch (Exception $e) {
        echo "Failed to send the message. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "File upload not successful or invalid request.";
}