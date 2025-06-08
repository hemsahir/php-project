<?php
include('config/db.php');
include 'language_switch.php';

$labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'page' => 'Video Gallery',
        'no_data' => 'No data found.',
        'prev' => 'Previous',
        'next' => 'Next'
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'home' => 'मुखपृष्ठ',
        'page' => 'वीडियो गैलरी',
        'no_data' => 'कोई डेटा नहीं मिला।',
        'prev' => 'पिछला',
        'next' => 'अगला'
    ]
];

$limit = 12;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) AS total FROM video_gallery")->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

$videos = $conn->query("SELECT * FROM video_gallery ORDER BY uploaded_at DESC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <title><?= $labels[$lang]['page'] ?></title>
  <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .video-box video {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<section id="fontSize" class="wrapper body-wrapper" style="font-size: 100%;">
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

            <?php if ($videos->num_rows > 0): ?>
                <div class="row">
                    <?php while ($row = $videos->fetch_assoc()): ?>
                        <div class="col-md-4 col-sm-6 mb-4 video-box">
                            <video controls>
                                <source src="<?= $row['video_path'] ?>" type="video/mp4">
                                Your browser does not support HTML5 video.
                            </video>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p><?= $labels[$lang]['no_data'] ?></p>
            <?php endif; ?>

            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
