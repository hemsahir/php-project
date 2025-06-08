<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$tableName = 'tenders';
$pageTitle = "Tenders";


// ADD or EDIT
if (isset($_POST['save'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = mysqli_real_escape_string($conn, $_POST['notice_date']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $file = $_FILES['file'];
    $filename = '';

    if ($file['name']) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
            $filename = time() . '_' . basename($file['name']);
            $target_dir = "../assets/uploads/";
            move_uploaded_file($file['tmp_name'], $target_dir . $filename);
        } else {
            $_SESSION['msgType'] = "error";
            $_SESSION['msg'] = "❌ Invalid file type. Only JPG, PNG, and PDF are allowed.";
            header("Location: tenders.php");
            exit;
        }
    }
    if ($filename) {
        $file_path = "assets/uploads/" . $filename;
    }

    if ($id > 0) {
        // Edit
        $update = "UPDATE $tableName SET title='$title', notice_date='$date', description='$desc'";
        if ($filename) $update .= ", file_path='$file_path'";
        $update .= " WHERE id=$id";
        $conn->query($update);
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Data updated.";
        header("Location: tenders.php");
        exit;
    } else {
       // Add
        if ($filename) {
            $conn->query("INSERT INTO $tableName (title, notice_date, description, file_path)
                        VALUES ('$title', '$date', '$desc', '$file_path')");
        } else {
            $conn->query("INSERT INTO $tableName (title, notice_date, description)
                        VALUES ('$title', '$date', '$desc')");
        }
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Data added.";
        header("Location: tenders.php");
        exit;
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $result = $conn->query("SELECT file_path FROM $tableName WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $file_path = '../' . $row['file_path'];
        if (file_exists($file_path) && is_file($file_path)) {
            unlink($file_path);
        }
    }
    $conn->query("DELETE FROM $tableName WHERE id=$id");
    $_SESSION['msgType'] = "success";
    $_SESSION['msg'] = "🗑️ Data deleted.";
    header("Location: tenders.php");
    exit;
}
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    td .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }
    td {
        vertical-align: middle;
    }
</style>
</head>
<body>

<div style="margin-left:260px; padding:20px;">
    <h4><?= $pageTitle ?></h4>

    <?php
    // If editing
    $editData = ['id' => 0, 'title' => '', 'notice_date' => '', 'description' => '', 'file_path' => ''];
    if (isset($_GET['edit'])) {
        $id = intval($_GET['edit']);
        $res = $conn->query("SELECT * FROM $tableName WHERE id=$id");
        if ($res->num_rows > 0) {
            $editData = $res->fetch_assoc();
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <input type="text" name="title" value="<?= htmlspecialchars($editData['title']) ?>" placeholder="Title" class="form-control mb-2" required>
        <input type="date" name="notice_date" value="<?= $editData['notice_date'] ?>" class="form-control mb-2" required>
        <textarea name="description" class="form-control mb-2" placeholder="Description" required><?= htmlspecialchars($editData['description']) ?></textarea>
        <div class="mb-3">
            <input type="file" name="file" id="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-muted">Allowed formats: .jpg, .jpeg, .png, .pdf</small>
        </div>
        <?php if ($editData['file_path']): ?>
            <small>Current File: <a href="../<?= $editData['file_path'] ?>" target="_blank">View</a></small><br>
        <?php endif; ?>
        <button type="submit" name="save" class="btn btn-primary"><?= $editData['id'] ? 'Update' : 'Add' ?></button>
    </form>

    <h5>All Entries</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>Title</th><th>Date</th><th>Description</th><th>File</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM $tableName ORDER BY id DESC");
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= $row['notice_date'] ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                    <?php if ($row['file_path']): ?>
                        <a href="../<?= $row['file_path'] ?>" target="_blank">View</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this item?')" class="btn btn-sm btn-danger">Delete</a>
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
            text: '<?= $_SESSION['msg'] ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php
    // clear message after showing
        unset($_SESSION['msg']);
        unset($_SESSION['msgType']);
        endif;
    ?>
</script>
</body>
</html>
