<?php
session_start();
include('../config/db.php');

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
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="icon" type="image/png" href="../assets/uploads/default_logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f3f4f7, #e0f7fa);
      min-height: 100vh;
    }
    .main-content {
      margin-left: 260px;
      padding: 30px;
    }
    .dashboard-box {
      background: #ffffffdd;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }
    .dashboard-card {
      background: linear-gradient(135deg, #ffffff, #f0f9ff);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      text-align: center;
      transition: all 0.3s ease-in-out;
    }
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      background: linear-gradient(135deg, #e3f2fd, #fce4ec);
    }
    .dashboard-card h4 {
      font-size: 18px;
      color: #333;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="main-content">
  <div class="dashboard-box">
    <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
    <p class="text-muted">This is your admin dashboard. Use the options below to manage the website.</p>

    <div class="card-grid">
      <div class="dashboard-card">
        <h4>Manage Slider</h4>
        <p><a href="manage_slider.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Manage Pages</h4>
        <p><a href="manage_pages.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>What's New</h4>
        <p><a href="whats_new.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Press Release</h4>
        <p><a href="press_release.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Tenders</h4>
        <p><a href="tenders.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Financials</h4>
        <p><a href="manage_financials.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Download Forms</h4>
        <p><a href="download_forms.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Photo Gallery</h4>
        <p><a href="photo_gallery.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Video Gallery</h4>
        <p><a href="video_gallery.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
      <div class="dashboard-card">
        <h4>Complaint</h4>
        <p><a href="complaints.php" class="btn btn-outline-primary btn-sm">Open</a></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
