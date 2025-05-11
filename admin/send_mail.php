<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

function send_otp_email($to_email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'movieshemo@gmail.com';
        $mail->Password = 'hbqt whzm rijr crxu';   // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email details
        $mail->setFrom('movieshemo@gmail.com', 'Nagarpalika Admin');
        $mail->addAddress($to_email);
        $mail->isHTML(true);
        $mail->Subject = 'Nagarpalika Admin Password Reset OTP';
        $mail->Body    = "<p>Your OTP to reset password is: <strong>$otp</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}
