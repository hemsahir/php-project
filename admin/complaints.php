<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Filters
$filter = [
    'name' => $_GET['name'] ?? '',
    'email' => $_GET['email'] ?? '',
    'phone' => $_GET['phone'] ?? '',
    'subject' => $_GET['subject'] ?? '',
    'date' => $_GET['date'] ?? '',
    'status' => $_GET['status'] ?? ''
];
$where = "WHERE 1";
foreach ($filter as $key => $value) {
    if ($value) {
        $escaped = $conn->real_escape_string($value);
        if ($key === 'date') {
            $where .= " AND DATE(created_at) = '$escaped'";
        } else {
            $where .= " AND $key LIKE '%$escaped%'";
        }
    }
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM complaints $where");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

$data = $conn->query("SELECT * FROM complaints $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset");

// Email on status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['complaint_id'])) {
    $id = (int)$_POST['complaint_id'];
    $newStatus = $conn->real_escape_string($_POST['update_status']);
    $conn->query("UPDATE complaints SET status = '$newStatus' WHERE id = $id");

    $res = $conn->query("SELECT * FROM complaints WHERE id = $id");
    if ($res->num_rows > 0) {
        $complaint = $res->fetch_assoc();
        $lang = 'en';
        $to = $complaint['email'];
        $subject = $lang === 'hi' ? '=?UTF-8?B?' . base64_encode('शिकायत की स्थिति अपडेट की गई है') . '?=' : 'Complaint Status Updated';
        $message = $lang === 'hi'
            ? "आपकी शिकायत की स्थिति अब '$newStatus' है।"
            : "Your complaint status is now '$newStatus'.";

        include_once('../send_complaint.php');
        $sendMail = send_complaint_email('', $to, '', $subject, $message, $lang, $newStatus, true,false);
        if ($sendMail) {
            $_SESSION['msgType'] = "success";
            $_SESSION['msg'] = "✅ Status updated.";
        } else {
            $_SESSION['msgType'] = "error";
            $_SESSION['msg'] = "❌ Some error while updating status.";
        }
    }
    header("Location: complaints.php");
    exit();
}
include('sidebar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Complaint Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            padding-left: 260px; /* Sidebar width */
        }
        .main-container {
            padding: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
            font-size: 14px;
        }
        .form-select-sm {
            min-width: 120px;
        }
    </style>
</head>
<body>
<div class="main-container">
    <h2 class="mb-4">Complaint Management</h2>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-2"><input type="text" name="name" value="<?= htmlspecialchars($filter['name']) ?>" class="form-control" placeholder="Name"></div>
        <div class="col-md-2"><input type="email" name="email" value="<?= htmlspecialchars($filter['email']) ?>" class="form-control" placeholder="Email"></div>
        <div class="col-md-2"><input type="text" name="phone" value="<?= htmlspecialchars($filter['phone']) ?>" class="form-control" placeholder="Phone"></div>
        <div class="col-md-2"><input type="text" name="subject" value="<?= htmlspecialchars($filter['subject']) ?>" class="form-control" placeholder="Subject"></div>
        <div class="col-md-2"><input type="date" name="date" value="<?= htmlspecialchars($filter['date']) ?>" class="form-control"></div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="Pending" <?= $filter['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $filter['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Complete" <?= $filter['status'] === 'Complete' ? 'selected' : '' ?>>Complete</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th style="width: 100px;">Date</th>
                <th style="width: 100px;">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th style="min-width: 150px;">Subject</th>
                <th style="min-width: 200px;">Message</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($data->num_rows > 0): $i = $offset + 1; ?>
                <?php while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <form method="POST" class="d-flex gap-2">
                                <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                               <select name="update_status" class="form-select form-select-sm">
                                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="In Progress" <?= $row['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="Complete" <?= $row['status'] === 'Complete' ? 'selected' : '' ?>>Complete</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No complaints found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
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
