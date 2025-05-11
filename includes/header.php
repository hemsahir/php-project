<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

$pageData = null;
if (isset($_GET['page_slug'])) {
  $slug = $_GET['page_slug'];
  $stmt = $conn->prepare("SELECT * FROM sub_pages WHERE LOWER(REPLACE(title_en, ' ', '-')) = ?");
  $stmt->bind_param("s", $slug);
  $stmt->execute();
  $result = $stmt->get_result();
  $pageData = $result->fetch_assoc();
}
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

?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title>नगर पालिका परिषद शिकारपुर</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/script.js" defer></script>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="container d-flex justify-content-between align-items-center">
    <ul class="d-flex align-items-center mb-0">
      <li><a href="https://up.gov.in/" target="_blank">उत्तर प्रदेश सरकार |</a></li>
      <li><a href="https://up.gov.in/" target="_blank">Government of Uttar Pradesh</a></li>
    </ul>
    <ul class="d-flex align-items-center mb-0">
      <li><a href="#"><i class="fas fa-universal-access"></i></a></li>
      <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
      <li><a href="#"><i class="fab fa-twitter"></i></a></li>
      <li><a href="#"><i class="fab fa-youtube"></i></a></li>
      <li class="language-switch">
        <form method="get">
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
      <a href="/" class="header__logo d-flex align-items-center">
        <img src="assets/uploads/default_logo.png" alt="नगर पालिका परिषद">
        <em>
          <span style="font-size: 35px;">नगर पालिका परिषद, शिकारपुर </span><br>
          <span style="margin-top: 10px;">जनपद - बुलन्दशहर</span>
        </em>
      </a>
    </div>
    <a href="https://swachhbharat.mygov.in/" target="_blank">
      <img src="assets/uploads/swach-bharat.png" alt="Swachh Bharat" height="100%">
    </a>
  </div>
</header>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg main-menu sticky-top">
  <div class="container">
    <a class="navbar-brand <?= !isset($_GET['page_slug']) ? 'active' : '' ?>" href="/"><i class="fa fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <?php
        $currentSlug = $_GET['page_slug'] ?? '';
      ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php foreach ($mainPages as $main): 
            $isActive = false;
              foreach ($main['subpages'] as $sub) {
                $slug = strtolower(str_replace(' ', '-', $sub['title_en']));
                if ($slug === $currentSlug) {
                  $isActive = true;
                  break;
                }
              }
            $activeClass = $isActive ? 'active' : '';
          ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= $activeClass ?>" href="#" role="button" data-bs-toggle="dropdown">
            <?= $lang === 'hi' ? $main['title_hi'] : $main['title_en'] ?>
          </a>
            <?php if (count($main['subpages']) > 0): ?>
              <ul class="dropdown-menu show-on-hover">
                <?php foreach ($main['subpages'] as $sub): ?>
                  <li>
                    <a class="dropdown-item" href="/page/<?= urlencode(strtolower(str_replace(' ', '-', $sub['title_en']))) ?>">
                      <?= $lang === 'hi' ? $sub['title_hi'] : $sub['title_en'] ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>
