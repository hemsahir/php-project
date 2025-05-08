<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../config/db.php');
include('sidebar.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['admin'];

// Fetch admin data
$result = $conn->query("SELECT * FROM admin WHERE username='$username'");
$admin_data = $result->fetch_assoc();

// Handle password and profile updates
if (isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'] ? md5($_POST['password']) : $admin_data['password'];

    // Update admin profile
    $conn->query("UPDATE admin SET username='$new_username', email='$new_email', password='$new_password' WHERE username='$username'");
    $_SESSION['admin'] = $new_username;  // Update session
    header("Location: profile.php");  // Redirect to profile page after update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>


    <!-- Main Content -->
    <div class="main-content">
        <h1>Profile: <?php echo $username; ?></h1>
        
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <h3>Update Profile</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $admin_data['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $admin_data['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
            </div>
            <button name="update_profile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

</body>
</html>
