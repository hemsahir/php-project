<?php
require_once('db.php');

// Admin Table
$conn->query("CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(255),
  email VARCHAR(100) DEFAULT 'admin@email.com'
)");

// Insert default admin if not exists
$conn->query("INSERT INTO admin (username, password, email) 
  SELECT * FROM (SELECT 'admin', MD5('admin123'), 'admin@email.com') AS tmp 
  WHERE NOT EXISTS (SELECT * FROM admin WHERE username='admin')");

// Pages Table: Main pages (only titles, no content)
$conn->query("CREATE TABLE IF NOT EXISTS pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100) UNIQUE,
  sort_order INT UNIQUE,
  title_en VARCHAR(255),
  title_hi VARCHAR(255)
)");

// Sub-pages Table: Sub pages under each main page (with full content)
$conn->query("CREATE TABLE IF NOT EXISTS sub_pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_id INT,
  title_en VARCHAR(255),
  title_hi VARCHAR(255),
  content_en TEXT,
  content_hi TEXT,
  FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
)");

// Header Section (Sliders)
$conn->query("CREATE TABLE IF NOT EXISTS sliders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL
)");

$conn->query("CREATE TABLE IF NOT EXISTS whats_new (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    notice_date DATE,
    description TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS press_releases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    notice_date DATE,
    description TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS tenders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    notice_date DATE,
    description TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT,
    status ENUM('Pending', 'In Progress', 'Complete') DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS photo_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255),
    is_homepage BOOLEAN DEFAULT FALSE,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS video_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_path VARCHAR(255),
    is_homepage BOOLEAN DEFAULT FALSE,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

echo "✅ Installation complete. Tables created.<br>";
echo "<a href='../admin/login.php'>Go to Admin Panel</a>";
?>
