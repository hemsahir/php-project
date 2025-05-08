<?php
session_start();
include('../config/db.php');
include('sidebar.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['logout'])) {
    // Destroy session to log out
    session_unset();   // Remove all session variables
    session_destroy(); // Destroy session

    // Redirect to login page
    header("Location: login.php");
    exit();
}
// Fetch the admin username
$username = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content { margin-left: 260px; padding: 20px; }
    </style>
</head>
<body>



    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>This is your admin dashboard. Use the sidebar to navigate through the admin panel.</p>
    </div>

</body>
</html>
