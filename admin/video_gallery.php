<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../config/db.php');
include('sidebar.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$uploadMsg = '';

// Upload video
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $count = count($_FILES['video']['name']);
    for ($i = 0; $i < $count; $i++) {
        $name = $_FILES['video']['name'][$i];
        $tmp = $_FILES['video']['tmp_name'][$i];
        $size = $_FILES['video']['size'][$i];

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if ($ext === 'mp4' && $size <= 10 * 1024 * 1024) {
            $newName = uniqid('vid_', true) . ".mp4";
            $target_dir = "../assets/uploads/gallery/videos/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($newName);
            move_uploaded_file($tmp, $target_file);
            $video_path = "assets/uploads/gallery/videos/" . $newName;
            $conn->query("INSERT INTO video_gallery (video_path, is_homepage, uploaded_at) VALUES ('$video_path', 0, NOW())");
        } else {
            $uploadMsg = 'Invalid file or size exceeded 10MB.';
        }
    }
    header("Location: video_gallery.php");
    exit();
}

// Toggle homepage video
if (isset($_GET['toggle_homepage']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT is_homepage FROM video_gallery WHERE id = $id");
    $row = $res->fetch_assoc();
    $current = $row['is_homepage'];

    if ($current == 0) {
        $homepageCount = $conn->query("SELECT COUNT(*) AS total FROM video_gallery WHERE is_homepage = 1")->fetch_assoc()['total'];
        if ($homepageCount >= 1) {
            echo "<script>if(confirm('Only 1 video allowed on homepage. Replace existing?')){window.location='video_gallery.php?force=1&id=$id';} else {window.location='video_gallery.php';}</script>";
            exit();
        }
    }

    $new = ($current == 1) ? 0 : 1;
    $conn->query("UPDATE video_gallery SET is_homepage = $new WHERE id = $id");
    header("Location: video_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Force homepage video
if (isset($_GET['force']) && isset($_GET['id'])) {
    $conn->query("UPDATE video_gallery SET is_homepage = 0 WHERE is_homepage = 1");
    $id = (int)$_GET['id'];
    $conn->query("UPDATE video_gallery SET is_homepage = 1 WHERE id = $id");
    header("Location: video_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Delete video
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $file = $conn->query("SELECT video_path FROM video_gallery WHERE id = $id")->fetch_assoc()['video_path'];
    if (file_exists("../" . $file)) unlink("../" . $file);
    $conn->query("DELETE FROM video_gallery WHERE id = $id");
    header("Location: video_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Pagination
$limit = 12;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total = $conn->query("SELECT COUNT(*) as total FROM video_gallery")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$data = $conn->query("SELECT * FROM video_gallery ORDER BY uploaded_at DESC LIMIT $limit OFFSET $offset");
?>

<div class="container mt-4" style="margin-left:260px">
    <h3 class="mb-4">Manage Video Gallery</h3>
    <div class="alert alert-info py-2 px-3 mb-3 small">
        <strong>Note:</strong> For homepage, select only <strong>1 video</strong>.
    </div>

    <?php if ($uploadMsg): ?>
        <div class="alert alert-danger"><?= $uploadMsg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="input-group">
            <input type="file" name="video[]" class="form-control" multiple required accept=".mp4">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        <div class="form-text">Only .mp4 files, Max 10MB per video</div>
    </form>

    <div class="row">
        <?php while($row = $data->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <video controls style="width: 100%; height: 200px; object-fit: cover;">
                        <source src="../<?= $row['video_path'] ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="card-body">
                        <a href="?toggle_homepage=1&id=<?= $row['id'] ?>&page=<?= $page ?>" class="btn btn-sm <?= $row['is_homepage'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                            <?= $row['is_homepage'] ? 'Shown on Homepage' : 'Show on Homepage' ?>
                        </a>
                        <a href="?delete=1&id=<?= $row['id'] ?>&page=<?= $page ?>" onclick="return confirm('Delete this video?')" class="btn btn-sm btn-danger float-end">Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
