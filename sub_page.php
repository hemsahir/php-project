<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

$pageData = null;

if (isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
    $id = intval($_GET['page_id']);
    $stmt = $conn->prepare("SELECT * FROM sub_pages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pageData = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $lang === 'hi'
    ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en'])
    : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- <div class="container py-4">
  <?php if ($pageData): ?>
    <h2>
      <?= $lang === 'hi'
        ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en'])
        : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?>
    </h2>
    <div class="page-content mt-3">
      <?= $lang === 'hi'
        ? (!empty($pageData['content_hi']) ? $pageData['content_hi'] : $pageData['content_en'])
        : (!empty($pageData['content_en']) ? $pageData['content_en'] : $pageData['content_hi']) ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning"><?= $lang === 'hi' ? 'पृष्ठ नहीं मिला' : 'Page not found' ?></div>
  <?php endif; ?>
</div> -->

<section id="fontSize" class="wrapper body-wrapper " style="font-size: 100%;">
       <div class="bg-wrapper inner-wrapper">
            <div class="breadcam-bg breadcam">
                <div class="container common-container four_content text-center">
                    <ul class="breadcrumb">
                        <li><a href="index.php"><?= $lang === 'hi' ? 'मुखपृष्ठ' : 'Home' ?></a></li>
                        <?php
                            $mainTitleHi = '';
                            $mainTitleEn = '';
                            if (isset($pageData['page_id'])) {
                                $stmt = $conn->prepare("SELECT title_en, title_hi FROM pages WHERE id = ?");
                                $stmt->bind_param("i", $pageData['page_id']);
                                $stmt->execute();
                                $mainPageResult = $stmt->get_result();
                                $mainPage = $mainPageResult->fetch_assoc();
                                $mainTitleEn = $mainPage['title_en'] ?? '';
                                $mainTitleHi = $mainPage['title_hi'] ?? '';
                            }
                        ?>
                        <li>
                            <a href="#">
                                <?= $lang === 'hi' ? (!empty($mainTitleHi) ? $mainTitleHi : $mainTitleEn) : (!empty($mainTitleEn) ? $mainTitleEn : $mainTitleHi) ?>
                            </a>
                        </li>
                        <li>
                            <?= $lang === 'hi' ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en']) : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <section id="list" class="wrapper list-wrapper">
            <div class="container common-container four_content">
                <h2><?= $lang === 'hi' ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en']) : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?></h2>
                <hr>
                <div class="page-content mt-3">
                    <?= $lang === 'hi' ? (!empty($pageData['content_hi']) ? $pageData['content_hi'] : $pageData['content_en']) : (!empty($pageData['content_en']) ? $pageData['content_en'] : $pageData['content_hi']) ?>
                </div>
            </div>
        </section>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
