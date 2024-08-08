<?php
include_once '../env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload']) && $_POST['upload'] == 'success') {
    // Retrieve form data
    $defendant_emails = $_POST['defendant_emails'];
    $prosecutor_emails = $_POST['prosecutor_emails'];
    $case_title = $_POST['case_title'];
    $description = $_POST['description'];

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

        // Get current date
        $current_date = date('Y-m-d');

        // Email content
        $email_body = "You have a pending AJC case titled '$case_title'.\n\nDescription:\n$description\n\nDate: $current_date";

        // Set up email details
        $mail->setFrom('marthagyeman14@gmail.com', 'Automated Notification');
        $mail->isHTML(false);
        $mail->Subject = "New Case - '$case_title'";
        $mail->Body = $email_body;

        // Add all defendant emails
        foreach ($defendant_emails as $email) {
            $mail->addAddress($email);
        }

        // Add all prosecutor emails
        foreach ($prosecutor_emails as $email) {
            $mail->addAddress($email);
        }

        // Send email
        $mail->send();

        echo "<script>
            alert('Your message has been sent successfully');
            window.location.href='../view/admin_dash.php';
        </script>";
    
    } catch (Exception $e) {
        echo "Failed to send the message. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "File upload not successful or invalid request.";
}
