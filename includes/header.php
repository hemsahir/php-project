<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

// Fetch main pages and their subpages
$mainPagesQuery = $conn->query("SELECT * FROM pages ORDER BY sort_order ASC");
$mainPages = [];
while ($mainPage = $mainPagesQuery->fetch_assoc()) {
    $mainPage['subpages'] = [];
    $subPageQuery = $conn->query("SELECT * FROM sub_pages WHERE page_id = {$mainPage['id']} ORDER BY id ASC");
    while ($subPage = $subPageQuery->fetch_assoc()) {
        $mainPage['subpages'][] = $subPage;
    }
    $mainPages[] = $mainPage;
}
// Fetch slider images
$sliderQuery = $conn->query("SELECT * FROM sliders ORDER BY id ASC");
$totalPages_header = count($mainPages);
$middleIndex = ceil($totalPages_header / 2);
$i = 0;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title>नगर पालिका परिषद शिकारपुर</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Hind&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/script.js" defer></script>
  <script src="assets/js/font-zoom.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <ul class="d-flex align-items-center mb-0 flex-wrap">
      <li><a href="https://up.gov.in/" target="_blank">उत्तर प्रदेश सरकार</a></li>
      <span class="separator">|</span>
      <li><a href="https://up.gov.in/" target="_blank">Government of Uttar Pradesh</a></li>
       <span class="separator">|</span>
      <li><a href="screen-reader.php"><?= ($lang === 'hi') ? 'स्क्रीन रीडर का उपयोग' : 'Screen Reader Access' ?></a></li>
      <span class="separator">|</span>
      <li><a href="https://nppshikarpur.com/admin/login.php" target="_blank"><i class="fa fa-user-lock me-1"></i><?= ($lang === 'hi') ? 'प्रशासन लॉगिन' : 'Admin Login' ?></a></li>
    </ul>
    </ul>
    <ul class="d-flex align-items-center mb-0 flex-wrap">
      <div class="datetime-info text-end me-3">
        <i class="fa fa-clock-o"></i>
        <span id="currentDay"></span>,
        <span id="currentDate"></span>
        <span id="currentTime"></span>
      </div>

      <div class="font-resize-controls me-3">
        <button id="decreaseFont" title="छोटा करें">A-</button>
        <button id="resetFont" title="मूल आकार">A</button>
        <button id="increaseFont" title="बड़ा करें">A+</button>
      </div>
      <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
      <li><a href="#"><i class="fab fa-twitter"></i></a></li>
      <li><a href="#"><i class="fab fa-youtube"></i></a></li>
      <li class="language-switch ms-2">
        <form method="get">
          <input type="hidden" name="page_id" value="<?= $_GET['page_id'] ?? '' ?>">
          <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="hi" <?= $lang === 'hi' ? 'selected' : '' ?>>हिन्दी</option>
            <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
          </select>
        </form>
      </li>
    </ul>
  </div>
</div>

<!-- Logo Header -->
<header class="py-3 border-bottom">
  <div class="container d-flex justify-content-between align-items-center">
    <div class="logo d-flex align-items-center">
      <a href="index.php" class="header__logo d-flex align-items-center">
        <img src="assets/uploads/default_logo.png" alt="नगर पालिका परिषद" style="max-height: 100px; width: auto;">
        <em class="logo-text">
          <span style="font-size: 35px;" class="main-title">नगर पालिका परिषद, शिकारपुर </span><br>
          <span style="margin-top: 10px;" class="sub-title">जनपद - बुलन्दशहर</span>
        </em>
      </a>
    </div>
    <a href="https://swachhbharat.mygov.in/" target="_blank" class="swachh-logo">
      <img src="assets/uploads/swach-bharat.png" alt="Swachh Bharat" height="100%">
    </a>
  </div>
</header>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg main-menu sticky-top" id="fontSize">
  <div class="container">
    <a class="navbar-brand active" href="index.php"><i class="fas fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <?php
        $currentPageId = $_GET['page_id'] ?? null;
      ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php foreach ($mainPages as $main): 
            $isActive = false;
              foreach ($main['subpages'] as $sub) {
                if ($sub['id'] == $currentPageId) {
                  $isActive = true;
                  break;
                }
              }
            $activeClass = $isActive ? 'active' : '';
          ?>
        <li class="nav-item dropdown">
            <?php if (count($main['subpages']) > 0): ?>
              <a class="nav-link dropdown-toggle <?= $activeClass ?>" href="#" role="button" data-bs-toggle="dropdown">
            <?php else: ?>
              <a class="nav-link <?= $activeClass ?>" href="#">
            <?php endif; ?>
            <?= $lang === 'hi' ? (!empty($main['title_hi']) ? $main['title_hi'] : $main['title_en']) : (!empty($main['title_en']) ? $main['title_en'] : $main['title_hi']) ?>
          </a>
            <?php if (count($main['subpages']) > 0): ?>
              <ul class="dropdown-menu show-on-hover">
                <?php foreach ($main['subpages'] as $sub): ?>
                  <li>
                    <a class="dropdown-item" href="sub_page.php?page_id=<?= $sub['id'] ?>">
                      <?= $lang === 'hi' ? (!empty($sub['title_hi']) ? $sub['title_hi'] : $sub['title_en']) : (!empty($sub['title_en']) ? $sub['title_en'] : $sub['title_hi']) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
          <?php
            if (++$i == $middleIndex):
          ?>
            <li class="nav-item">
              <a class="nav-link nowrap-text <?= basename($_SERVER['PHP_SELF']) == 'financial_reports.php' ? 'active' : '' ?>" href="financial_reports.php">
                <?= $lang === 'hi' ? 'बजट एवं ऑडिट रिपोर्ट' : 'Budget & Audit Report' ?>
              </a>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Slider Section -->
<section class="wrapper banner-wrapper">
  <div class="slider-container position-relative">
    <?php
    $sliderImages = [];
    while ($row = $sliderQuery->fetch_assoc()) {
      $sliderImages[] = $row['image'];
    }
    foreach ($sliderImages as $index => $imgPath): ?>
      <img src="<?= $imgPath ?>" class="<?= $index === 0 ? 'active' : '' ?>" alt="Slider <?= $index+1 ?>">
    <?php endforeach; ?>
    
    <div class="slider-btn prev" onclick="prevSlide()"><i class="fas fa-chevron-left"></i></div>
    <div class="slider-btn next" onclick="nextSlide()"><i class="fas fa-chevron-right"></i></div>

    <div class="slider-controls">
      <?php foreach ($sliderImages as $index => $_): ?>
        <a href="#" class="indicator <?= $index === 0 ? 'active-indicator' : '' ?>" onclick="goToSlide(<?= $index ?>)"></a>
      <?php endforeach; ?>
      <i class="fas fa-pause" id="pausePlayBtn" onclick="toggleSlider()"></i>
    </div>
  </div>
</section>

<script>
  const lang = '<?= $lang ?>'; // From PHP

  function updateDateTime() {
    const now = new Date();

    // Day names
    const daysEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const daysHi = ['रविवार', 'सोमवार', 'मंगलवार', 'बुधवार', 'गुरुवार', 'शुक्रवार', 'शनिवार'];

    // Format date
    const dayName = lang === 'hi' ? daysHi[now.getDay()] : daysEn[now.getDay()];
    const dateStr = now.toLocaleDateString(lang === 'hi' ? 'hi-IN' : 'en-IN', {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    });

    // Format time with AM/PM
    const timeStr = now.toLocaleTimeString(lang === 'hi' ? 'hi-IN' : 'en-IN', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: true
    });

    // Set values
    document.getElementById('currentDay').textContent = dayName;
    document.getElementById('currentDate').textContent = dateStr;
    document.getElementById('currentTime').textContent = timeStr;
  }

  // Update every second
  setInterval(updateDateTime, 1000);
  updateDateTime(); // Initial call
</script>

</body>
</html>
