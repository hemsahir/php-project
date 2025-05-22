<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

$lang = $_SESSION['lang'] ?? 'en';

$online_labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'heading' => 'Online Services',
        'video_gallery_title' => 'Video Gallery',
        'photo_gallery_title' => 'Photo Gallery',
        'read_more' => 'Read More',
        'view_all' => 'View All',
        'view_all_tenders' => 'View all Tenders',
        'tender_page_title' => 'Tenders',
        'press_release_page_title' => 'Press Releases',
        'whats_new_page_title' => "What's New",
        'web_link' => 'Web link',
        'jan_sunvai_title' => 'Public hearing',
        'e_news_letter_title' => 'E-news letter',
        'download_form_title' => 'Download form',
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
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'heading' => 'ऑनलाइन सेवाएं',
        'video_gallery_title' => 'वीडियो गैलरी',
        'photo_gallery_title' => 'फोटो गैलरी',
        'view_all' => 'सभी को देखें',
        'read_more' => 'अधिक पढ़ें',
        'view_all_tenders' => 'सभी निविदाएं देखें',
        'tender_page_title' => 'निविदाएँ',
        'press_release_page_title' => 'प्रेस प्रकाशनी',
        'whats_new_page_title' => 'क्या नया है',
        'web_link' => 'वेब लिंक',
        'jan_sunvai_title' => 'जन सुनवाई',
        'e_news_letter_title' => 'ई-न्यूज लेटर',
        'download_form_title' => 'डाउनलोड फार्म',
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

// Fetch What's New
$whatsNew = $conn->query("SELECT title, notice_date, file_path FROM whats_new ORDER BY notice_date DESC LIMIT 10");
// Fetch Press Release
$pressRelease = $conn->query("SELECT title, notice_date, file_path FROM press_releases ORDER BY notice_date DESC LIMIT 10");
// Fetch Tenders (Optional)
$tenders = $conn->query("SELECT title, notice_date, file_path FROM tenders ORDER BY notice_date DESC LIMIT 10");

// Get up to 3 homepage images, or fallback with total 3 images
$photos = [];
$res1 = $conn->query("SELECT * FROM photo_gallery WHERE is_homepage = 1 ORDER BY uploaded_at DESC LIMIT 3");
while ($row = $res1->fetch_assoc()) $photos[] = $row;

if (count($photos) < 3) {
  $needed = 3 - count($photos);
  $ids = array_column($photos, 'id');
  $idList = implode(',', $ids) ?: 0;
  $res2 = $conn->query("SELECT * FROM photo_gallery WHERE id NOT IN ($idList) ORDER BY uploaded_at DESC LIMIT $needed");
  while ($row = $res2->fetch_assoc()) $photos[] = $row;
}

// Get homepage video, or latest video
$video = $conn->query("SELECT * FROM video_gallery WHERE is_homepage = 1 ORDER BY uploaded_at DESC LIMIT 1")->fetch_assoc();
if (!$video) {
    $video = $conn->query("SELECT * FROM video_gallery ORDER BY uploaded_at DESC LIMIT 1")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $labels[$lang]['municipality'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/flexslider.css">
  <link rel="stylesheet" href="assets/css/body-section.css">
  <script src="assets/js/jquery.flexslider.js" defer></script>
  <script src="assets/js/body-section.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<section id="fontSize" class="wrapper body-wrapper" style="font-size: 100%;">
  <div class="bg-wrapper top-bg-wrapper gray-bg padding-top-bott">
    <div class="container common-container four_content body-container top-body-container padding-top-bott2">

      <div class="row gx-5 align-items-start">

        <!-- Left Column: Banner Content -->
        <div class="col-md-7">
          <div class="banner-content-wrapper">
            <h2><span>नगर पालिका परिषद, शिकारपुर, बुलन्दशहर</span></h2>
            <p class="banner-title-tag-line">नगर पालिका परिषद , शिकारपुर, बुलन्दशहर उत्तर प्रदेश सरकार की वेबसाइट में आपका स्वागत है।</p>
            <p class="banner-content" style="text-align: justify">
              ज़िला अमरोहा (पूर्ववर्ती ज्योतिबा फुलेनगर) दिनांक 15 अप्रैल 1997 को राज्य सरकार द्वारा स्थापित किया गया जिसका मुख्यालय अमरोहा नगर को बनाया गया नवनिर्मित जनपद में तीन तहसील शामिल की गयीं – अमरोहा, धनौरा, एवं हसनपुर। वर्तमान में नवीन तहसील नौगावां सादात को मिला कर 04 तहसील जनपद में शामिल हैं । ऐतिहासिक परिपेक्ष्य में जनपद का वर्तमान क्षेत्र बरेली जनपद में स्थित उत्तरी पांचाल देश, जिसकी राजधानी अहित छत्र थी, के राज्य में शामिल था। कहा जाता है कि मुग़ल शासक शाहजहाँ के शासन के समय में संभल के गवर्नर रुस्तम खां ने एक किले का निर्माण यहाँ कराया था तथा व्यापारियों तथा खेतिहरों को इसके आसपास बसाया था । 474 ई पूर्व अमरोहा क्षेत्र में वंशी साम्राज्य के  राजा अमरजोध का शासन था।
            </p>
            <p class="banner-content" style="text-align: justify">
              तारीखे-अमरोहा नामक ऐतिहासिक पुस्तक में यह उल्लखित है कि अमरोहा में 676 से 1148 ईस्वी तक राजपूत वंश का शासन था। बहराम शाह (1240-42) ने मलिक जलालुद्दीन को अमरोहा के हकीम के पद पर नियुक्त किया। प्राचीन समय में पांचाल प्रदेश के शासकों को, जिसका इस क्षेत्र पर प्रभाव था हस्तिनापुर के कुरु राजाओं द्वारा हटा दिया गया। कुषाण एवं नंद साम्राज्य के पतन के बाद इस क्षेत्र पर मौर्य वंश का भी शासन रहा तत्पश्चात समुद्रगुप्त का शासन स्थापित हुआ। लगभग दो शताब्दियों तक गुप्त वंश का शासन इस क्षेत्र पर रहा। गुप्त साम्राज्य के पतन के बाद कन्नौज के राजा मुखारी का नियंत्रण इस क्षेत्र पर हो गया इसके पश्चात् 606 से 647 ईस्वी तक यह कन्नौज नरेश हर्ष के शासन क्षेत्र में रहा। हर्ष की मृत्यु के पश्चात जनपद का उत्तरी क्षेत्र तोमर वंश के साम्राज्य क्षेत्र में रहा। पृथ्वी राज चौहान की शाहबुद्दीन गौरी के हाथों हार के पश्चात् मुस्लिम प्रभुत्व बढ़ना प्रारम्भ हुआ एवं अन्ततः राजपूत वंश के कठेरिया, बड़गूजर, गौड़, तोमर एवं अन्य क्षेत्रीय वंश सयुंक्त रूप से विदेशी मुस्लिम आक्रमणकारियों के ख़िलाफ़ खड़े हुए। 
            </p>
            <div class="view-footer">
              <a href="#" title="<?= $online_labels[$lang]['read_more'] ?>"><span><?= $online_labels[$lang]['read_more'] ?> &gt;</span></a>
            </div>
          </div>
        </div>

        <!-- Right Column: Ministers -->
        <div class="col-md-5">
          <div class="minister clearfix">
            <div class="minister-box row">
              <?php
              $ministers = [
                ["img" => "cmup.png", "name" => "माननीय श्री योगी आदित्यनाथ जी", "role" => "(मुख्यमंत्री)"],
                ["img" => "nagarvikash.jpg", "name" => "माननीय श्री ऐ. के. शर्मा", "role" => "(नगर विकास मंत्री)"],
                ["img" => "dm.jpeg", "name" => "श्रीमती श्रुति शर्मा, आईएएस", "role" => "(ज़िलाधिकारी)"],
                ["img" => "President.jpg", "name" => "श्रीमती राजबाला देवी", "role" => "(अध्यक्ष)"],
                // ["img" => "adhishashi.jpeg", "name" => "डॉ० बृजेश कुमार", "role" => "(अधिशासी अधिकारी)"],
              ];
                foreach ($ministers as $minister) {
                    echo '<div class="col-6 mb-3">
                        <div class="minister-sub text-center">
                          <div class="minister-image mb-2">
                            <img src="assets/uploads/minister/' . $minister['img'] . '" alt="' . $minister['name'] . '" title="' . $minister['role'] . '" class="img-fluid">
                          </div>
                          <div class="min-info">
                            <h4 class="mb-1" style="font-size: 15px;">' . $minister['name'] . '</h4>
                            <h5 style="font-size: 14px; color: #666;"><span>' . $minister['role'] . '</span></h5>
                          </div>
                        </div>
                      </div>';
                }
              ?>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- online seva section -->
   <section class="online-services-section wrapper">
    <div class="container common-container four_content banner-container body-container top-body-container"> 
        <section id="page-head" class="wrapper headings-wrapper text-center">
            <h2><?= $online_labels[$lang]['heading'] ?></h2>
            <hr>
        </section>
        <div class="banner-row">
            <div class="banner-box-middle" style="background: #a6690c;">
                <a href="#" target="_blank" title="<?= $online_labels[$lang]['services']['property_water']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['property_water']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['property_water']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle" style="background: #619303;">
                <a href="https://crsorgi.gov.in/web/index.php/auth/login" target="_blank"
                   title="<?= $online_labels[$lang]['services']['birth_death']['title'] ?>"
                   onclick="return confirm('<?= $online_labels[$lang]['services']['birth_death']['confirm'] ?>')">
                    <h2><?= $online_labels[$lang]['services']['birth_death']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['birth_death']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle" style="background: #910ebe;">
                <a href="#" target="_blank" title="<?= $online_labels[$lang]['services']['license']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['license']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['license']['icon'] ?> fa-4x"></i>
                </a>
            </div>
        </div>
        <div class="banner-row">
            <div class="banner-box-middle" style="background: #0026ff;">
                <a href="#" target="_blank" title="<?= $online_labels[$lang]['services']['advertisement']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['advertisement']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['advertisement']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle" style="background: #8b940d;">
                <a href="http://e-nagarsewaup.gov.in/ulbapps/OnlineUser/onlineMutationOption.action" target="_blank"
                   title="<?= $online_labels[$lang]['services']['mutation']['title'] ?>"
                   onclick="return confirm('<?= $online_labels[$lang]['services']['mutation']['confirm'] ?>')">
                    <h2><?= $online_labels[$lang]['services']['mutation']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['mutation']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle" style="background: #a6690c;">
                <a href="complaint.php" title="<?= $online_labels[$lang]['services']['complaint']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['complaint']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['complaint']['icon'] ?> fa-4x"></i>
                </a>
            </div>
        </div>
        <hr>
    </div>
</section>


<!-- Tender & What's New Section -->
    <div class="wrapper home-banner">
      <div class="container common-container four_content banner-container body-container top-body-container">
        <div class="left-block">
          <div class="left-col-2">
            <div class="page-tab clearfix">
              <div class="page-tab-res clearfix">
                <div id="parentHorizontalTab" style="display: block; width: 100%; margin: 0px;">
                  <ul class="resp-tabs-list hor_1">
                    <li class="resp-tab-item hor_1 resp-tab-active"><a href="#parentHorizontalTab1" id="tab-list-1"><?= $online_labels[$lang]['whats_new_page_title'] ?></a></li>
                    <li class="resp-tab-item hor_1"><a href="#parentHorizontalTab2"><?= $online_labels[$lang]['press_release_page_title'] ?></a></li>
                  </ul>
                  <div class="resp-tabs-container hor_1" style="border-color: rgb(76, 77, 82);">
                    <!-- What's New Tab -->
                    <div class="resp-tab-content hor_1 resp-tab-content-active" id="hor_1_tab_item-0">
                      <div class="content-wrapper">
                        <p class="text-slide pause" onclick="changeClass()"></p>
                        <div class="scroll-text">
                          <ul class="list">
                            <?php while ($row = $whatsNew->fetch_assoc()): ?>
                              <li>
                                <div class="list-content">
                                  <?php if (!empty($row['file_path']) && file_exists($row['file_path'])): ?>
                                    <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                                      <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                                    </a>
                                  <?php else: ?>
                                    <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                                  <?php endif; ?>
                                </div>
                              </li>
                            <?php endwhile; ?>
                          </ul>
                        </div>
                        <div class="view-footer-tender"><a href="whats_new_view_all.php" title="<?= $online_labels[$lang]['read_more'] ?>"><span><?= $online_labels[$lang]['read_more'] ?> &gt;</span></a></div>
                      </div>
                    </div>

                    <!-- Press Release Tab -->
                    <div class="resp-tab-content hor_1" id="hor_1_tab_item-1">
                      <div class="content-wrapper">
                        <p class="text-slide01 pause" onclick="changeClass01()"></p>
                        <div class="scroll-text01">
                          <ul class="list">
                            <?php while ($row = $pressRelease->fetch_assoc()): ?>
                              <li>
                                <div class="list-content">
                                  <?php if (!empty($row['file_path']) && file_exists($row['file_path'])): ?>
                                    <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                                      <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                                    </a>
                                  <?php else: ?>
                                    <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                                  <?php endif; ?>
                                </div>
                              </li>
                            <?php endwhile; ?>
                          </ul>
                        </div>
                        <div class="view-footer-tender"><a href="view_all_press.php" title="<?= $online_labels[$lang]['read_more'] ?>"><span><?= $online_labels[$lang]['read_more'] ?> &gt;</span></a></div>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
            </div>
          </div>

          <!-- Tenders Section -->
          <div class="left-col-2">
            <h2><?= $online_labels[$lang]['tender_page_title'] ?></h2>
            <p class="text-slide1 pause" onclick="changeClass1()"></p>
            <div class="scroll-text-1">
              <ul class="list">
                <?php while ($row = $tenders->fetch_assoc()): ?>
                  <li>
                    <div class="list-content">
                      <?php if (!empty($row['file_path']) && file_exists($row['file_path'])): ?>
                        <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                          <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                        </a>
                      <?php else: ?>
                        <?= htmlspecialchars($row['title']) ?> - <?= date("d/m/Y", strtotime($row['notice_date'])) ?>
                      <?php endif; ?>
                    </div>
                  </li>
                <?php endwhile; ?>
              </ul>
            </div>
            <div class="view-footer-tender"><a href="view_all_tenders.php" title="<?= $online_labels[$lang]['view_all_tenders'] ?>"><span><?= $online_labels[$lang]['view_all_tenders'] ?> &gt;</span></a></div>
          </div>
        </div>

        <!-- Right Side Links -->
          <div class="banner-right-wrapper">
              <div class="banner-box-wrapper">
                        <div class="banner-box banner-box-1">
                            <div class="banner-box-content">
                                <h2><?= $online_labels[$lang]['jan_sunvai_title'] ?></h2>
                                <a href="http://jansunwai.up.nic.in/" title="External link that opens in new tab" target="_blank" onclick="return confirm('<?= $online_labels[$lang]['services']['birth_death']['confirm'] ?>')">
                                    <p><?= $online_labels[$lang]['web_link'] ?></p>
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="banner-box banner-box-2">
                            <div class="banner-box-content">
                                <h2><?= $online_labels[$lang]['e_news_letter_title'] ?></h2>
                                <a href="#" title="External link that opens in new tab">
                                    <p><?= $online_labels[$lang]['web_link'] ?></p>
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="banner-box banner-box-3">
                            <div class="banner-box-content">
                                <h2><?= $online_labels[$lang]['download_form_title'] ?></h2>
                                <a href="#" title="External link that opens in new tab">
                                    <p><?= $online_labels[$lang]['web_link'] ?></p>
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>      
          </div>
      </div>
    </div>

<!-- Gallery and Video Section-->
<div class="wrapper home-btm-slider">
  <div class="container common-container four_content gallery-container">
    <div class="gallery-area clearfix">
      <div class="gallery-heading">
        <h3><?= $online_labels[$lang]['photo_gallery_title'] ?></h3>
        <a class="bttn-more bttn-view" href="photo_gallery_view.php" title="View all Photo Gallery"><span><?= $online_labels[$lang]['view_all'] ?></span></a>
      </div>
      <div class="gallery-holder">
        <div id="galleryCarousel" class="flexslider">
          <ul class="slides">
            <?php foreach ($photos as $i => $photo): ?>
              <li data-thumb="<?= $photo['image_path'] ?>" data-thumb-alt="Slide <?= $i+1 ?>">
                <img src="<?= $photo['image_path'] ?>" alt="gallery<?= $i+1 ?>" title="Slide <?= $i+1 ?>" draggable="false" style="width:100%; height:400px; object-fit:cover; object-position:center;">
              </li>
            <?php endforeach; ?>
          </ul>
          <ul class="flex-direction-nav">
            <li class="flex-nav-prev"><a class="flex-prev" href="#">Previous</a></li>
            <li class="flex-nav-next"><a class="flex-next" href="#">Next</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="gallery-right">
      <div class="video-heading">
        <h3><?= $online_labels[$lang]['video_gallery_title'] ?></h3>
        <a class="bttn-more bttn-view" href="video_gallery_view.php" title="View all Video Gallery"><span><?= $online_labels[$lang]['view_all'] ?></span></a>
      </div>
      <div class="video-wrapper">
        <?php if ($video): ?>
          <video poster="<?= $photos[0]['image_path'] ?? 'assets/uploads/carousel/placeholder.jpg' ?>" controls autoplay loop muted class="has-media-controls-hidden">
            <source src="<?= $video['video_path'] ?>" type="video/mp4">
            <span>Your browser does not support HTML5 video.</span>
          </video>
          <svg class="video-overlay-play-button" viewBox="0 0 200 200" alt="Play video">                         
            <circle cx="100" cy="100" r="90" fill="none" stroke-width="15" stroke="#fff"></circle>              
            <polygon points="70, 55 70, 145 145, 100" fill="#fff"></polygon>
          </svg> 
        <?php else: ?>
          <p>No video available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

</section>
</body>
</html>
