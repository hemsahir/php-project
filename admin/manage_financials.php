<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$table = 'financial_documents';
$pageTitle = "Budget / Audit / Balance Sheet";

$categories = ['Budget', 'Audit Report', 'Balance Sheet'];

// Handle Add/Edit
if (isset($_POST['save'])) {
    $id = intval($_POST['id']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $file = $_FILES['file'];
    $filename = '';

    if ($file['name']) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        if (in_array($ext, $allowed) && $file['size'] <= 20 * 1024 * 1024) {
            $filename = time() . '_' . basename($file['name']);
            $target_dir = "../assets/uploads/";
            move_uploaded_file($file['tmp_name'], $target_dir . $filename);
        } else {
            $_SESSION['msgType'] = "error";
            $_SESSION['msg'] = "❌ Invalid file or size. Max 20MB. Allowed: JPG, PNG, PDF.";
            header("Location: manage_financials.php");
            exit;
        }
    }

    if ($filename) {
        $file_path = "assets/uploads/" . $filename;
    }

    if ($id > 0) {
        $update = "UPDATE $table SET category='$category', title='$title'";
        if ($filename) $update .= ", file_path='$file_path'";
        $update .= " WHERE id=$id";
        $conn->query($update);
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Entry updated.";
    } else {
        if ($filename) {
            $conn->query("INSERT INTO $table (category, title, file_path) VALUES ('$category', '$title', '$file_path')");
        } else {
            $conn->query("INSERT INTO $table (category, title) VALUES ('$category', '$title')");
        }
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Entry added.";
    }
    header("Location: manage_financials.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $result = $conn->query("SELECT file_path FROM $table WHERE id=$id");
    if ($result && $row = $result->fetch_assoc()) {
        $file_path = '../' . $row['file_path'];
        if (file_exists($file_path)) unlink($file_path);
    }
    $conn->query("DELETE FROM $table WHERE id=$id");
    $_SESSION['msgType'] = "success";
    $_SESSION['msg'] = "🗑️ Entry deleted.";
    header("Location: manage_financials.php");
    exit;
}

// Edit Mode
$editData = ['id' => 0, 'category' => '', 'title' => '', 'file_path' => ''];
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM $table WHERE id=$id");
    if ($res->num_rows > 0) {
        $editData = $res->fetch_assoc();
    }
}

// Filters
$filterCategory = isset($_GET['filter_category']) ? mysqli_real_escape_string($conn, $_GET['filter_category']) : '';
$filterDate = isset($_GET['filter_date']) ? mysqli_real_escape_string($conn, $_GET['filter_date']) : '';

// Build WHERE clause
$where = "WHERE 1";
if ($filterCategory != '') {
    $where .= " AND category = '$filterCategory'";
}
if ($filterDate != '') {
    $where .= " AND DATE(created_at) = '$filterDate'";
}
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div style="margin-left:260px; padding:20px;">
    <h4><?= $pageTitle ?></h4>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        
        <select name="category" class="form-select mb-2" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>" <?= ($editData['category'] == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="title" class="form-control mb-2" value="<?= htmlspecialchars($editData['title']) ?>" placeholder="Title" required>

        <input type="file" name="file" class="form-control mb-2" accept=".jpg,.jpeg,.png,.pdf">
        <small class="text-muted">Allowed formats: .jpg, .jpeg, .png, .pdf | Max size: 20MB</small><br>
        
        <?php if ($editData['file_path']): ?>
            <small>Current File: <a href="../<?= $editData['file_path'] ?>" target="_blank">View</a></small><br>
        <?php endif; ?>

        <button type="submit" name="save" class="btn btn-primary"><?= $editData['id'] ? 'Update' : 'Add' ?></button>
    </form>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="filter_category" class="form-select">
                <option value="">-- Filter by Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>" <?= ($filterCategory == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="filter_date" class="form-control" value="<?= $filterDate ?>">
        </div>
        <div class="col-6 col-md-auto">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-6 col-md-auto">
            <a href="manage_financials.php" class="btn btn-secondary w-100"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>

    <h5>All Documents</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>Category</th><th>Title</th><th>File</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT * FROM $table $where ORDER BY id DESC");
        while ($row = $res->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['category'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td>
                    <?php if ($row['file_path']): ?>
                        <a href="../<?= $row['file_path'] ?>" target="_blank">View</a>
                    <?php endif; ?>
                </td>
                <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this item?')" class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
<?php if (isset($_SESSION['msg'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['msgType'] ?>',
        title: '<?= ucfirst($_SESSION['msgType']) ?>',
        text: '<?= $_SESSION['msg'] ?>'
    });
    <?php unset($_SESSION['msg'], $_SESSION['msgType']); ?>
<?php endif; ?>
</script>

</body>
</html>
