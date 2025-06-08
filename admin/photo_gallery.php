<?php
// photo_gallery.php
session_start();
include('../config/db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$uploadMsg = '';
if (isset($_SESSION['uploadMsg'])) {
    $uploadMsg = $_SESSION['uploadMsg'];
    unset($_SESSION['uploadMsg']);
}

// Upload images
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $count = count($_FILES['photo']['name']);
    $hasError = false;
    for ($i = 0; $i < $count; $i++) {
        $name = $_FILES['photo']['name'][$i];
        $tmp = $_FILES['photo']['tmp_name'][$i];
        $size = $_FILES['photo']['size'][$i];

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png']) && $size <= 5 * 1024 * 1024) {
            $newName = uniqid('img_', true) . "." . $ext;
            $target_dir = "../assets/uploads/gallery/photos/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($newName);
            if (move_uploaded_file($tmp, $target_file)) {
                $image_path = "assets/uploads/gallery/photos/" . $newName;
                $conn->query("INSERT INTO photo_gallery (image_path, is_homepage, uploaded_at) VALUES ('$image_path', 0, NOW())");
            } else {
                $hasError = true;
            }
        } else {
            $hasError = true;
        }
    }
    if ($hasError) {
        $_SESSION['uploadMsg'] = 'Some files were invalid or exceeded 5MB.';
    }
    header("Location: photo_gallery.php");
    exit();
}

// Toggle homepage image
if (isset($_GET['toggle_homepage']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT is_homepage FROM photo_gallery WHERE id = $id");
    $row = $res->fetch_assoc();
    $current = $row['is_homepage'];

    if ($current == 0) {
        $homepageCount = $conn->query("SELECT COUNT(*) AS total FROM photo_gallery WHERE is_homepage = 1")->fetch_assoc()['total'];
        if ($homepageCount >= 3) {
            echo "<script>if(confirm('Only 3 images allowed on homepage. Replace existing?')){window.location='photo_gallery.php?force=1&id=$id';} else {window.location='photo_gallery.php';}</script>";
            exit();
        }
    }

    $new = ($current == 1) ? 0 : 1;
    $conn->query("UPDATE photo_gallery SET is_homepage = $new WHERE id = $id");
    header("Location: photo_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Force replace homepage images
if (isset($_GET['force']) && isset($_GET['id'])) {
    $conn->query("UPDATE photo_gallery SET is_homepage = 0 WHERE is_homepage = 1 LIMIT 3");
    $id = (int)$_GET['id'];
    $conn->query("UPDATE photo_gallery SET is_homepage = 1 WHERE id = $id");
    header("Location: photo_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Delete image
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $file = $conn->query("SELECT image_path FROM photo_gallery WHERE id = $id")->fetch_assoc()['image_path'];
    if (file_exists("../" . $file)) unlink("../" . $file);
    $conn->query("DELETE FROM photo_gallery WHERE id = $id");
    header("Location: photo_gallery.php?page=" . ($_GET['page'] ?? 1));
    exit();
}

// Pagination logic
$limit = 12;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total = $conn->query("SELECT COUNT(*) as total FROM photo_gallery")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$data = $conn->query("SELECT * FROM photo_gallery ORDER BY uploaded_at DESC LIMIT $limit OFFSET $offset");
include('sidebar.php');
?>

<div class="container mt-4" style="margin-left:260px">
    <h3 class="mb-4">Manage Photo Gallery</h3>
    <div class="alert alert-info py-2 px-3 mb-3 small">
        <strong>Note:</strong> For homepage, select only <strong>3 images</strong>.
    </div>

    <?php if ($uploadMsg): ?>
        <div class="alert alert-danger"><?= $uploadMsg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="input-group">
            <input type="file" name="photo[]" class="form-control" multiple required accept=".jpg,.jpeg,.png">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        <div class="form-text">Only .jpg/.jpeg/.png, Max 5MB per image</div>
    </form>

    <div class="row">
        <?php while($row = $data->fetch_assoc()): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="../<?= $row['image_path'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                    <div class="card-body text-center d-grid gap-2">
                        <a href="?toggle_homepage=1&id=<?= $row['id'] ?>&page=<?= $page ?>"
                        class="btn btn-sm <?= $row['is_homepage'] ? 'btn-success' : 'btn-outline-secondary' ?> w-100">
                            <?= $row['is_homepage'] ? 'Shown on Homepage' : 'Show on Homepage' ?>
                        </a>
                        <a href="?delete=1&id=<?= $row['id'] ?>&page=<?= $page ?>"
                        onclick="return confirm('Delete this image?')"
                        class="btn btn-sm btn-danger w-100">
                            Delete
                        </a>
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
