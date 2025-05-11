<?php
session_start();
include('../config/db.php');
require_once('send_mail.php');

$step = isset($_SESSION['reset_email']) && isset($_SESSION['reset_otp']) ? 2 : 1;
$message = '';

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    $check = $conn->query("SELECT * FROM admin WHERE email='$email'");
    if ($check->num_rows == 1) {
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp'] = $otp;

        // Send OTP
        $subject = "Nagarpalika Admin Password Reset OTP";
        $body = "Your OTP to reset password is: $otp";
        $headers = "From: no-reply@nagarpalika.test.in";

        $result = send_otp_email($email, $otp);
        $message = $result === true ? "✅ OTP sent to your email." : $result;
        // if (mail($email, $subject, $body, $headers)) {
        //     $message = $result === true ? "✅ OTP sent to your email." : $result;
        // } else {
        //     $message = "❌ Failed to send OTP. Please check mail setup.";
        // }
    } else {
        $message = "❌ Email not found in admin account.";
    }
}

if (isset($_POST['reset_password'])) {
    $otp = $_POST['otp'];
    $newpass = md5($_POST['new_password']);

    if ($_SESSION['reset_otp'] == $otp) {
        $email = $_SESSION['reset_email'];
        $conn->query("UPDATE admin SET password='$newpass' WHERE email='$email'");
        $message = "✅ Password reset successfully. You can login now.";
        session_destroy(); // Clear session
    } else {
        $message = "❌ Invalid OTP.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .reset-box {
            margin-top: 80px;
            max-width: 450px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="reset-box">
        <h4 class="text-center mb-4">🔐 Forgot Password</h4>
        <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>

        <?php if ($step === 1): ?>
        <form method="post">
            <div class="mb-3">
                <label>Registered Email</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <button name="send_otp" class="btn btn-primary w-100">Send OTP</button>
        </form>
        <?php else: ?>
        <form method="post">
            <div class="mb-3">
                <label>Enter OTP</label>
                <input type="text" name="otp" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required />
            </div>
            <button name="reset_password" class="btn btn-success w-100">Reset Password</button>
        </form>
        <?php endif; ?>

        <div class="mt-3 text-center">
            <a href="login.php">← Back to Login</a>
        </div>
    </div>
</div>
</body>
</html>
