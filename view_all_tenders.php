<?php
include 'config/db.php';
include 'language_switch.php';

$lang = $_SESSION['lang'] ?? 'en';

$labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'page' => 'Tenders',
        'sr' => 'Sr. No.',
        'date' => 'Date',
        'title' => 'Title',
        'desc' => 'Description',
        'file' => 'View File',
        'no_data' => 'No data found.',
        'prev' => 'Previous',
        'next' => 'Next',
        'search' => 'Search'
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'home' => 'मुखपृष्ठ',
        'page' => 'निविदाएँ',
        'sr' => 'क्रम सं.',
        'date' => 'तारीख',
        'title' => 'शीर्षक',
        'desc' => 'विवरण',
        'file' => 'फ़ाइल देखें',
        'no_data' => 'कोई डेटा नहीं मिला।',
        'prev' => 'पिछला',
        'next' => 'अगला',
        'search' => 'खोजें'
    ]
];

$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$date = mysqli_real_escape_string($conn, $_GET['date'] ?? '');
$where = "WHERE 1";
if ($search) $where .= " AND title LIKE '%$search%'";
if ($date) $where .= " AND notice_date = '$date'";

$totalRes = $conn->query("SELECT COUNT(*) as total FROM tenders $where");
$totalRows = $totalRes->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
$data = $conn->query("SELECT * FROM tenders $where ORDER BY notice_date DESC LIMIT $offset, $limit");
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $labels[$lang]['page'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* same styling as what's new */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        thead {
            background-color: #004080;
            color: #fff;
        }
        tbody tr:hover {
            background-color: rgb(246, 164, 146);
            transition: background-color 0.3s ease;
        }
        th:nth-child(1), td:nth-child(1) { width: 60px; }
        th:nth-child(2), td:nth-child(2) { width: 120px; }
        th:nth-child(3), td:nth-child(3) { width: 200px; }
        th:nth-child(5), td:nth-child(5) { width: 100px; text-align: center; }
        th:nth-child(4), td:nth-child(4) { width: auto; }
        .breadcrumb { margin-top: 10px; font-size: 15px; }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a, .pagination span {
            margin: 0 3px;
            padding: 6px 12px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
        }
        .pagination a.disabled { background-color: #ccc; pointer-events: none; }
        .pagination span.current { background-color: #333; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<section id="fontSize" class="wrapper body-wrapper " style="font-size: 100%;">
    <div class="bg-wrapper inner-wrapper">
        <div class="breadcam-bg breadcam">
            <div class="container common-container four_content text-center">
                <ul class="breadcrumb">
                    <li><a href="index.php"><?= $labels[$lang]['home'] ?></a></li>
                    <li><a href="#"><?= $labels[$lang]['page'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section id="list" class="wrapper list-wrapper">
        <div class="container common-container four_content">
            <h2><?= $labels[$lang]['municipality'] ?></h2>
            <hr>
            <h3><?= $labels[$lang]['page'] ?></h3>

            <form method="GET" class="mb-3" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="<?= $labels[$lang]['title'] ?>" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="form-control" style="max-width: 200px;">
                <input type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>" class="form-control" style="max-width: 200px;">
                <button type="submit" class="btn btn-primary"><?= $labels[$lang]['search'] ?></button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th><?= $labels[$lang]['sr'] ?></th>
                        <th><?= $labels[$lang]['date'] ?></th>
                        <th><?= $labels[$lang]['title'] ?></th>
                        <th><?= $labels[$lang]['desc'] ?></th>
                        <th><?= $labels[$lang]['file'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data->num_rows > 0): $i = $offset + 1; ?>
                        <?php while ($row = $data->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row['notice_date'])) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td>
                                    <?php if (!empty($row['file_path']) && file_exists($row['file_path'])): ?>
                                        <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">📄</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5"><?= $labels[$lang]['no_data'] ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&date=<?= urlencode($date) ?>"><?= $labels[$lang]['prev'] ?></a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="current"><?= $i ?></span>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&date=<?= urlencode($date) ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&date=<?= urlencode($date) ?>"><?= $labels[$lang]['next'] ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
