<?php
session_start();
include('../config/db.php');

$logo = '../assets/uploads/default_logo.png';

// Handle login
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $q = $conn->query("SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if ($q->num_rows == 1) {
        $_SESSION['admin'] = $user;
        header("Location: dashboard.php");
    } else {
        $error = "❌ Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars($logo); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/uploads/login_bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(6px);
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }
       .login-box {
            position: relative;
            z-index: 1;
            margin-top: 60px;
            max-width: 420px;
            width: 90%;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            text-align: center;
    }
        .logo-img {
            max-height: 80px;
            margin-bottom: 20px;
        }
        .form-label {
            float: left;
        }
        @media (max-width: 576px) {
            .login-box {
                padding: 20px;
            }
            .logo-img {
                max-height: 60px;
            }
            h4 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-box">
        <img src="<?= htmlspecialchars($logo); ?>" class="logo-img" alt="Website Logo">
        <h4 class="mb-3">🛡️ Admin Login</h4>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required />
            </div>
            <button name="login" class="btn btn-primary w-100">Login</button>
            <div class="mt-3">
                <a href="forgot_password.php" class="text-decoration-none">🔑 Forgot Password?</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
