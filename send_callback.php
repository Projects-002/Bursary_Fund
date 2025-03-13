<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME'); // SMTP username
        $mail->Password = getenv('SMTP_PASSWORD'); // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('alexkipchirchir927@gmail.com');

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Name: $name\nEmail: $email\nMobile: $mobile\nSubject: $subject\n\nMessage:\n$message";

        $mail->send();
        echo "Email successfully sent to alexkipchirchir927@gmail.com...";
    } catch (Exception $e) {
        echo "Email sending failed. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>