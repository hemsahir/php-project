<?php
// send_complaint_email.php (Updated)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

function send_complaint_email($name, $email, $phone, $subject, $message, $lang, $status = null, $status_update = false,$sendAdmin = true) {
    $admin_email = 'movieshemo@gmail.com';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'movieshemo@gmail.com';
        $mail->Password = 'hbqt whzm rijr crxu';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->isHTML(true);

        // Send email to admin
        if ($sendAdmin) {
            $mail->clearAddresses();
            $mail->setFrom('movieshemo@gmail.com', 'Nagarpalika Admin');
            $mail->addAddress($admin_email);
    
            if ($lang === 'hi') {
                $mail->Subject = '=?UTF-8?B?' . base64_encode('नई शिकायत प्राप्त हुई') . '?=';
                $mail->Body = "<h3>नई शिकायत प्राप्त हुई</h3>
                    <p><strong>नाम:</strong> $name</p>
                    <p><strong>ईमेल:</strong> $email</p>
                    <p><strong>फ़ोन:</strong> $phone</p>
                    <p><strong>विषय:</strong> $subject</p>
                    <p><strong>संदेश:</strong> $message</p>";
            } else {
                $mail->Subject = 'New Complaint Received';
                $mail->Body = "<h3>New Complaint Received</h3>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Subject:</strong> $subject</p>
                    <p><strong>Message:</strong> $message</p>";
            }
            $mail->send();
        }

        // Send separate email to user
        $mail->clearAddresses();
        $mail->addAddress($email);
        if ($status_update) {
            if ($lang === 'hi') {
                $mail->Subject = 'आपकी शिकायत की स्थिति अपडेट की गई है';
                $mail->Body = "<p>आपकी शिकायत की स्थिति अब '<strong>$status</strong>' है।</p>";
            } else {
                $mail->Subject = 'Your Complaint Status Updated';
                $mail->Body = "<p>Your complaint status has been updated to '<strong>$status</strong>'.</p>";
            }
        } else {
            if ($lang === 'hi') {
                $mail->Subject = '=?UTF-8?B?' . base64_encode('शिकायत सफलतापूर्वक भेजी गई') . '?=';
                $mail->Body = '<p>आपकी शिकायत सफलतापूर्वक भेजी गई है। हम शीघ्र ही आपसे संपर्क करेंगे।</p>';
            } else {
                $mail->Subject = 'Complaint Submitted Successfully';
                $mail->Body = '<p>Your complaint has been submitted successfully. We will get back to you soon.</p>';
            }
        }
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}
