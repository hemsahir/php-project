<!-- sidebar.php -->
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$active_tab = basename($_SERVER['PHP_SELF'], ".php");
$logo = 'assets/uploads/default_logo.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: #333;
            color: white;
            padding-top: 50px;
            padding-left: 10px;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover { background-color: #575757; }
        .sidebar a.active { background-color: #888; }
        .logo-img { width: 100px; height: auto; }
        .logout-btn {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logout-btn:hover { background-color: #c9302c; }
        .logout-btn i {
            margin-right: 10px;
        }
    </style>
</head>

<div class="sidebar">
    <img src="../<?php echo $logo; ?>" class="logo-img" alt="Logo">
    <a href="dashboard.php" class="<?php echo ($active_tab == 'dashboard') ? 'active' : ''; ?>">Dashboard</a>
    <a href="manage_slider.php" class="<?php echo ($active_tab == 'manage_slider') ? 'active' : ''; ?>">Manage Slider</a>
    <a href="manage_pages.php" class="<?php echo ($active_tab == 'manage_pages') ? 'active' : ''; ?>">Manage Pages</a>
    <a href="contact_us.php" class="<?php echo ($active_tab == 'contact_us') ? 'active' : ''; ?>">Contact Us</a>
    <a href="profile.php" class="<?php echo ($active_tab == 'profile') ? 'active' : ''; ?>">Profile</a>
    <a href="logout.php" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

</html>
