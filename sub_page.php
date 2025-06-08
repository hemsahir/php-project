<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

$pageData = null;

$online_labels = [
    'en' => [
        'services' => [
            'property_water' => ['title' => 'Property & Water Tax', 'icon' => 'fa-home'],
            'birth_death' => ['title' => 'Birth & Death Registration', 'confirm' => 'You are being transferred from the website of Nagar Panchayat, Uttar Pradesh and will now view content from an external website', 'icon' => 'fa-users'],
            'license' => ['title' => 'License', 'icon' => 'fa-credit-card'],
            'advertisement' => ['title' => 'Advertisement Tax', 'icon' => 'fa-newspaper-o'],
            'mutation' => ['title' => 'Mutation', 'confirm' => 'You are being transferred from the website of Nagar Panchayat, Uttar Pradesh and will now view content from an external website', 'icon' => 'fa-slideshare'],
            'complaint' => ['title' => 'Complaint', 'icon' => 'fa-pencil-square-o'],
        ]
    ],
    'hi' => [
        'services' => [
            'property_water' => ['title' => 'सम्पत्ति एवं जल कर', 'icon' => 'fa-home'],
            'birth_death' => ['title' => 'जन्म एवं मृत्यु पंजीकरण', 'confirm' => 'आपको उत्तर प्रदेश की नगर पंचायत की वेबसाइट से हस्तानांतरित किया जा रहा है और अब आप किसी बाहरी वेबसाइट का कंटेंट देखेंगे', 'icon' => 'fa-users'],
            'license' => ['title' => 'लाइसेन्स', 'icon' => 'fa-credit-card'],
            'advertisement' => ['title' => 'विज्ञापन कर', 'icon' => 'fa-newspaper-o'],
            'mutation' => ['title' => 'म्युटेशन', 'confirm' => 'आपको उत्तर प्रदेश की नगर पंचायत की वेबसाइट से हस्तानांतरित किया जा रहा है और अब आप किसी बाहरी वेबसाइट का कंटेंट देखेंगे', 'icon' => 'fa-slideshare'],
            'complaint' => ['title' => 'शिकायत', 'icon' => 'fa-pencil-square-o'],
        ]
    ]
];

if (isset($_GET['page_id']) && is_numeric($_GET['page_id'])) {
    $id = intval($_GET['page_id']);
    $stmt = $conn->prepare("SELECT * FROM sub_pages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pageData = $result->fetch_assoc();
    if ($pageData) {
        $title = strtolower(trim($pageData['title_en']));
        $title_hi = trim($pageData['title_hi']);

        // External link condition with JavaScript confirm
          if ($title == 'registration of births and deaths' || $title_hi == 'जन्म और मृत्यु का पंजीकरण') {
            $confirmMessage = $online_labels[$lang]['services']['birth_death']['confirm'];
            $targetUrl = 'https://crsorgi.gov.in/web/index.php/auth/login';

            echo "<script>
                if (confirm(" . json_encode($confirmMessage) . ")) {
                  window.open('$targetUrl', '_blank');
                }
                window.history.back();
            </script>";
            exit;
          }
          if ($title == 'mutations' || $title_hi == 'म्युटेशन्स') {
            $confirmMessage = $online_labels[$lang]['services']['mutation']['confirm'];
            $targetUrl = 'http://e-nagarsewaup.gov.in/ulbapps/OnlineUser/onlineMutationOption.action';

            echo "<script>
                if (confirm(" . json_encode($confirmMessage) . ")) {
                  window.open('$targetUrl', '_blank');
                }
                window.history.back();
            </script>";
            exit;
          }

        if ($title == 'photo gallery' || $title_hi == 'फोटो गैलरी') {
          header("Location: photo_gallery_view.php");
          exit;
        }
        if ($title == 'video gallery' || $title_hi == 'वीडियो गैलरी') {
          header("Location: video_gallery_view.php");
          exit;
        }
        if ($title == 'tender list' || $title_hi == 'निविदा सूची') {
          header("Location: view_all_tenders.php");
          exit;
        }
        if ($title == 'grievance redressal' || $title == 'employee grievance redressal' || $title_hi == 'कर्मचारी शिकायत निवारण' || $title_hi == 'शिकायत निवारण') {
          header("Location: complaint.php");
          exit;
        }
        if ($title == 'download form' || $title_hi == 'डाउनलोड फॉर्म') {
          header("Location: download_forms.php");
          exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title>
    <?php if ($pageData): ?>
    <?= $lang === 'hi'
    ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en'])
    : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?>
    <?php else: ?>
      <?= $lang === 'hi' ? 'त्रुटि' : 'Error' ?>
    <?php endif; ?>
  </title>
  <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<section id="subpage-font-size" class="wrapper body-wrapper " style="font-size: 100%;">
       <div class="bg-wrapper inner-wrapper">
            <div class="breadcam-bg breadcam">
                <div class="container common-container four_content text-center">
                    <ul class="breadcrumb">
                        <li><a href="index.php"><?= $lang === 'hi' ? 'मुखपृष्ठ' : 'Home' ?></a></li>
                        <?php
                            $mainTitleHi = '';
                            $mainTitleEn = '';
                            if ($pageData && isset($pageData['page_id'])) {
                                $stmt = $conn->prepare("SELECT title_en, title_hi FROM pages WHERE id = ?");
                                $stmt->bind_param("i", $pageData['page_id']);
                                $stmt->execute();
                                $mainPageResult = $stmt->get_result();
                                $mainPage = $mainPageResult->fetch_assoc();
                                $mainTitleEn = $mainPage['title_en'] ?? '';
                                $mainTitleHi = $mainPage['title_hi'] ?? '';
                            }
                        ?>
                        <?php if ($pageData): ?>
                            <li>
                              <a href="#">
                                  <?= $lang === 'hi' ? (!empty($mainTitleHi) ? $mainTitleHi : $mainTitleEn) : (!empty($mainTitleEn) ? $mainTitleEn : $mainTitleHi) ?>
                              </a>
                            </li>
                            <li>
                              <?= $lang === 'hi' ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en']) : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?>
                            </li>
                        <?php else: ?>
                            <li><?= $lang === 'hi' ? 'त्रुटि' : 'Error' ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <section id="list" class="wrapper list-wrapper">
            <div class="container common-container four_content">
            <div class="row">
              <!-- Main Content -->
              <div class="col-md-9 col-sm-12">
                <?php if ($pageData): ?>
                  <h2><?= $lang === 'hi' ? (!empty($pageData['title_hi']) ? $pageData['title_hi'] : $pageData['title_en']) : (!empty($pageData['title_en']) ? $pageData['title_en'] : $pageData['title_hi']) ?></h2>
                  <hr>
                  <div class="page-content mt-3">
                    <?= $lang === 'hi' ? (!empty($pageData['content_hi']) ? $pageData['content_hi'] : $pageData['content_en']) : (!empty($pageData['content_en']) ? $pageData['content_en'] : $pageData['content_hi']) ?>
                  </div>
                <?php else: ?>
                  <div class="alert alert-warning mt-4">
                    <?= $lang === 'hi' ? 'पृष्ठ नहीं मिला। कृपया बाद में पुनः प्रयास करें।' : 'Page not found. Please try again later.' ?>
                  </div>
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
                    <a href="http://localbodies.up.nic.in" target="_blank" class="btn btn-primary btn-block text-center external" rel="noopener" onclick="return confirm('<?= $online_labels[$lang]['services']['birth_death']['confirm'] ?>')">
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
