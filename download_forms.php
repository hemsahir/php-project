<?php
include('config/db.php');
include 'language_switch.php';

$labels_language = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'page' => "Download Form",
        'no_data' => 'No record found.',
        'prev' => 'Previous',
        'next' => 'Next',
        'search' => 'Search',
        'confirm' => 'You are being transferred from the website of Nagar Panchayat, Uttar Pradesh and will now view content from an external website'
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'home' => 'मुखपृष्ठ',
        'page' => 'डाउनलोड फार्म',
        'sr' => 'क्रम सं.',
        'title' => 'शीर्षक',
        'no_data' => 'कोई डेटा नहीं मिला।',
        'prev' => 'पिछला',
        'next' => 'अगला',
        'search' => 'खोजें',
        'confirm' => 'आपको उत्तर प्रदेश की नगर पंचायत की वेबसाइट से हस्तानांतरित किया जा रहा है और अब आप किसी बाहरी वेबसाइट का कंटेंट देखेंगे'
    ]
];

$lang = $_SESSION['lang'] ?? 'hi';
$filterCategory = $_GET['category'] ?? '';
$searchTitle = $_GET['title'] ?? '';
$documents = [];
// Build WHERE clause if filters applied
$where = "WHERE 1";
if (!empty($searchTitle)) {
    $safeTitle = mysqli_real_escape_string($conn, $searchTitle);
    $where .= " AND title LIKE '%$safeTitle%'";
}
// Fetch from DB
$query = "SELECT * FROM download_forms $where ORDER BY id DESC";
$res = $conn->query($query);
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $documents[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $labels_language[$lang]['page'] ?></title>
  <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .section-header {
      background-color: #e0f0fb;
      font-weight: bold;
      font-size: 1.2rem;
      padding: 10px 15px;
      border-top: 2px solid #007BFF;
      border-bottom: 2px solid #007BFF;
      margin-bottom: 10px;
    }
    .doc-item {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
    }
    .doc-title {
      font-weight: 500;
    }
    .file-meta {
      font-size: 0.9rem;
      color: #666;
    }
    .download-btn {
      /* float: right; */
      white-space: nowrap;
    }
    @media (max-width: 768px) {
      .download-btn {
        float: none;
        display: inline-block;
        margin-top: 10px;
      }
    td.text-end {
        text-align: center !important;
    }
    }
  </style>
</head>

<body>
<?php include 'includes/header.php'; ?>
<section id="whats-new-fontSize" class="wrapper body-wrapper " style="font-size: 100%;">
        <div class="bg-wrapper inner-wrapper">
            <div class="breadcam-bg breadcam">
                <div class="container common-container four_content text-center">
                    <ul class="breadcrumb">
                        <li><a href="index.php"><?= $labels_language[$lang]['home'] ?></a></li>
                        <li><a href="#"><?= $labels_language[$lang]['page'] ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    <section id="list" class="wrapper list-wrapper">
        <div class="container common-container four_content">
            <h2><?= $labels_language[$lang]['municipality'] ?></h2>
            <hr>
            <h4 class="mb-4 text-primary">
                <?= $labels_language[$lang]['page'] ?>
            </h4>
            <div class="row">
            <div class="col-md-9 col-sm-12">
                <form method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-md-5">
                        <input type="text" name="title" value="<?= htmlspecialchars($searchTitle) ?>" class="form-control"
                            placeholder="<?= $lang === 'hi' ? 'शीर्षक खोजें' : 'Search Title' ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> <?= $labels_language[$lang]['search'] ?>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="download_forms.php" class="btn btn-secondary w-100">
                        <i class="fas fa-sync me-1"></i> <?= $lang === 'hi' ? 'रीसेट करें' : 'Reset' ?>
                        </a>
                    </div>
                </form>
                <?php if (count($documents) > 0): ?>
                <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"><?= $lang === 'hi' ? 'क्रम सं.' : 'Sr. No.' ?></th>
                        <th><?= $lang === 'hi' ? 'शीर्षक' : 'Title' ?></th>
                        <th style="width: 120px;"><?= $lang === 'hi' ? 'डाउनलोड फ़ाइल' : 'Download file' ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($documents as $i => $doc): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="doc-title"><?= htmlspecialchars($doc['title']) ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-dark download-btn" href="<?= $doc['file_path'] ?>" target="_blank" download>
                                <i class="bi bi-download me-1"></i> <?= $lang === 'hi' ? 'डाउनलोड' : 'Download' ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <?php else: ?>
                    <div class="alert alert-info"><?= $labels_language[$lang]['no_data'] ?></div>
                <?php endif; ?>
            </div>
             <!-- Right Sidebar -->
            <div class="col-md-3 col-sm-12 inner-right">
              <div class="panel panel-warning">
                <div class="panel-heading text-center">
                  <i class="fa fa-th-list"></i>&nbsp;&nbsp;
                  <?= $lang === 'hi' ? 'महत्वपूर्ण लिंक' : 'Important Links' ?>
                </div>
                <div class="panel-body">
                  <div class="button-group shadow leaders d-flex flex-column align-items-center">
                    <a href="#" class="btn btn-primary btn-block text-center external">
                      <i class="fa-solid fa-newspaper me-2"></i>
                      <?= $lang === 'hi' ? 'न्यूज़लेटर' : 'Newsletter' ?>
                    </a>
                    <a href="http://localbodies.up.nic.in" target="_blank" class="btn btn-primary btn-block text-center external" rel="noopener" onclick="return confirm('<?= $labels_language[$lang]['confirm'] ?>')">
                      <i class="fa-solid fa-building me-2"></i>
                      <?= $lang === 'hi' ? 'स्थानीय निकाय निदेशालय' : 'Local Bodies Directorate' ?>
                    </a>
                    <a href="#" class="btn btn-primary btn-block text-center external">
                      <i class="fa-solid fa-note-sticky me-2"></i>
                      <?= $lang === 'hi' ? 'शासनादेश' : 'Government Orders' ?>
                    </a>
                    <a href="#" class="btn btn-primary btn-block text-center external">
                      <i class="fa-solid fa-book me-2"></i>
                      <?= $lang === 'hi' ? 'अधिनियम और नियमावली' : 'Acts & Manuals' ?>
                    </a>
                    <a href="#" class="btn btn-primary btn-block text-center external">
                      <i class="fa-solid fa-envelope me-2"></i>
                      <?= $lang === 'hi' ? 'सिटीजन चार्टर' : 'Citizen Charter' ?>
                    </a>
                    <a href="#" class="btn btn-warning btn-block text-center external">
                      <i class="fa-solid fa-comment-dots me-2"></i>
                      <?= $lang === 'hi' ? 'फीडबैक' : 'Feedback' ?>
                    </a>
                    <a href="#" class="btn btn-warning btn-block text-center external">
                      <i class="fa-solid fa-chart-line me-2"></i>
                      <?= $lang === 'hi' ? 'रिपोर्ट' : 'Reports' ?>
                    </a>
                    <a href="#" class="btn btn-warning btn-block text-center external">
                      <i class="fa-solid fa-circle-info me-2"></i>
                      <?= $lang === 'hi' ? 'इनफार्मेशन डेस्क' : 'Information Desk' ?>
                    </a>
                    <a href="#" class="btn btn-warning btn-block text-center external">
                      <i class="fa-solid fa-map-location-dot me-2"></i>
                      <?= $lang === 'hi' ? 'मानचित्र' : 'Map' ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            </div>
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
