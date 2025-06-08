<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../config/db.php');

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
    <title>Admin Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: #2c3e50;
            color: white;
            padding-top: 20px;
            overflow-y: auto;
        }
        .sidebar .logo-img {
            width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 20px auto;
        }
        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: background-color 0.2s, padding-left 0.2s;
        }
        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 25px;
        }
        .sidebar a.active {
            background-color: #1abc9c;
            font-weight: bold;
        }
        .dropdown a.dropdown-toggle::after {
            float: right;
            margin-top: 6px;
        }
        .dropdown .collapse a {
            padding-left: 40px;
            font-size: 0.95rem;
        }
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            margin: 20px;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background-color: #c0392b;
            text-decoration: none;
        }
        .logout-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="../<?php echo $logo; ?>" class="logo-img" alt="Logo">

        <a href="dashboard.php" class="<?php echo ($active_tab == 'dashboard') ? 'active' : ''; ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="manage_slider.php" class="<?php echo ($active_tab == 'manage_slider') ? 'active' : ''; ?>"><i class="bi bi-images me-2"></i>Manage Slider</a>
        <a href="manage_pages.php" class="<?php echo ($active_tab == 'manage_pages') ? 'active' : ''; ?>"><i class="bi bi-file-earmark-text me-2"></i>Manage Pages</a>

        <!-- Updates & Notices Menu -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle d-block text-white py-2 px-3" data-bs-toggle="collapse" data-bs-target="#updatesMenu" aria-expanded="false">
                <i class="bi bi-bell me-2"></i>Updates & Notices
            </a>
            <div id="updatesMenu" class="collapse ps-2">
                <a href="whats_new.php" class="<?php echo ($active_tab == 'whats_new') ? 'active' : ''; ?>">What's New</a>
                <a href="press_release.php" class="<?php echo ($active_tab == 'press_release') ? 'active' : ''; ?>">Press Release</a>
                <a href="tenders.php" class="<?php echo ($active_tab == 'tenders') ? 'active' : ''; ?>">Tenders</a>
            </div>
        </div>

        <a href="manage_financials.php" class="<?= ($active_tab == 'manage_financials') ? 'active' : ''; ?>"><i class="bi bi-file-earmark-bar-graph me-2"></i>Financial Reports</a>

        <a href="download_forms.php" class="<?php echo ($active_tab == 'download_forms') ? 'active' : ''; ?>">
            <i class="bi bi-download me-2"></i>Download Forms
        </a>

        <!-- Manage Gallery Menu -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle d-block text-white py-2 px-3" data-bs-toggle="collapse" data-bs-target="#galleryMenu" aria-expanded="false">
                <i class="bi bi-camera me-2"></i>Manage Gallery
            </a>
            <div id="galleryMenu" class="collapse ps-2">
                <a href="photo_gallery.php" class="<?php echo ($active_tab == 'photo_gallery') ? 'active' : ''; ?>">Photo Gallery</a>
                <a href="video_gallery.php" class="<?php echo ($active_tab == 'video_gallery') ? 'active' : ''; ?>">Video Gallery</a>
            </div>
        </div>

        <a href="complaints.php" class="<?php echo ($active_tab == 'complaints') ? 'active' : ''; ?>"><i class="bi bi-chat-dots me-2"></i>Complaint Management</a>
        <a href="profile.php" class="<?php echo ($active_tab == 'profile') ? 'active' : ''; ?>"><i class="bi bi-person-circle me-2"></i>Profile</a>

        <a href="logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</body>
</html>
