<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
include 'language_switch.php';

$lang = $_SESSION['lang'] ?? 'en';

$online_labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'welcome_msg' => 'Welcome to the official website of Municipal Council, Shikarpur, Bulandshahr, Uttar Pradesh.',
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
        'welcome_msg' => 'नगर पालिका परिषद , शिकारपुर, बुलन्दशहर उत्तर प्रदेश सरकार की वेबसाइट में आपका स्वागत है।',
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

$language_labels = [
  'en' => [
    'about_details_1' => 'Shikarpur town, located in Bulandshahr district of Uttar Pradesh, holds a very important place from historical, religious and cultural point of view. This town is not only known for its religious places, old forts and social structures, but its history is also thousands of years old, which makes it one of the oldest towns of western Uttar Pradesh.The area of ​​Shikarpur was under the influence of Kuru and Panchal Mahajanapadas in ancient times. It is believed that this area was part of Panchal Desh extending from Hastinapur to Mathura, Meerut, and Bulandshahr. During the Mahabharata period, Hastinapur and its surrounding areas had special religious and political importance, and Shikarpur is also considered to be a part of that geography. This region is mentioned by various names in Buddhist literature and Puranas. The Nanda dynasty, Maurya dynasty, Shunga dynasty, Kushan dynasty, and Gupta Empire ruled here respectively. During the Gupta period, this area was prosperous and was known as the center of learning, culture and religion.',

    'about_details_2' => 'After the fall of the Gupta Empire, this region came under the control of the kings of Kannauj, especially during the rule of Harshavardhan. After the death of Harsha, this region came under the control of the Tomar, Pratihara and Chauhan kings. The administrative importance of this region remained even during the reign of Prithviraj Chauhan. When Muslim rule began in India after the defeat of Prithviraj Chauhan in the Second Battle of Tarain in 1192 AD, the Delhi Sultanate took control of this region. Khilji, Tughlaq, Lodi and finally the Mughal rulers established administrative posts and military bases here. The fort, Jama Masjid and other buildings of that time in Shikarpur are witnesses of this era. This city was especially famous as a hunting ground. It is said that the royal family of Delhi used to come here to hunt in the forest areas, and that is why this place was named "Shikarpur".'
  ],
  'hi' => [
    'about_details_1' => 'उत्तर प्रदेश के बुलंदशहर जिले में स्थित शिकारपुर नगर ऐतिहासिक, धार्मिक एवं सांस्कृतिक दृष्टि से अत्यंत महत्वपूर्ण स्थान रखता है। यह नगर न केवल अपने धार्मिक स्थलों, पुराने किलों और सामाजिक संरचनाओं के लिए जाना जाता है, बल्कि इसका इतिहास भी हज़ारों वर्षों पुराना है, जो इसे पश्चिमी उत्तर प्रदेश के प्राचीनतम नगरों में से एक बनाता है।
    शिकारपुर का क्षेत्र प्राचीन काल में कुरु और पांचाल महाजनपदों के प्रभाव में था। माना जाता है कि यह क्षेत्र हस्तिनापुर से लेकर मथुरा, मेरठ, और बुलंदशहर तक फैले पांचाल देश का हिस्सा था। महाभारत काल में हस्तिनापुर और उसके आस-पास के क्षेत्र विशेष धार्मिक और राजनीतिक महत्व रखते थे, और शिकारपुर भी उस भूगोल का हिस्सा माना जाता है। बौद्ध साहित्य और पुराणों में इस क्षेत्र का उल्लेख विभिन्न नामों से मिलता है। यहाँ नंद वंश, मौर्य वंश, शुंग वंश, कुषाण वंश, और गुप्त साम्राज्य का शासन क्रमशः रहा। गुप्त काल में यह क्षेत्र समृद्ध था और विद्या, संस्कृति तथा धर्म के केंद्र के रूप में जाना जाता था।',

    'about_details_2' => 'गुप्त साम्राज्य के पतन के बाद यह क्षेत्र कन्नौज के राजाओं के नियंत्रण में आया, विशेषकर हर्षवर्धन के शासन में। हर्ष की मृत्यु के पश्चात यह क्षेत्र तोमर, प्रतिहार एवं चौहान राजाओं के अधीन हो गया। पृथ्वीराज चौहान के शासनकाल में भी इस क्षेत्र का प्रशासनिक महत्व बना रहा। 1192 ई. में तराइन के द्वितीय युद्ध में पृथ्वीराज चौहान की हार के बाद जब भारत में मुस्लिम शासन की शुरुआत हुई, तो दिल्ली सल्तनत ने इस क्षेत्र को अपने अधीन किया। खिलजी, तुगलक, लोदी और अंततः मुग़ल शासकों ने यहाँ प्रशासनिक चौकियाँ और सैनिक ठिकाने स्थापित किए। शिकारपुर में उस समय के किला, जामा मस्जिद, तथा अन्य इमारतें इस युग की गवाह हैं। यह नगर शिकारगाह के रूप में विशेष रूप से प्रसिद्ध था। कहा जाता है कि दिल्ली के शाही परिवार यहाँ के वन क्षेत्रों में शिकार खेलने आते थे, और इसीलिए इस स्थान का नाम "शिकारपुर" पड़ा।'
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

$aboutTitle = ($lang == 'hi') ? 'नगर पालिका परिषद के बारे में' : 'About Nagar Palika Parishad';
$stmt = $conn->prepare("SELECT * FROM sub_pages WHERE title_$lang = ? LIMIT 1");
$stmt->bind_param("s", $aboutTitle);
$stmt->execute();
$result = $stmt->get_result();
$aboutPage = $result->fetch_assoc();
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
  <link href="https://fonts.googleapis.com/css2?family=Hind&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/flexslider.css">
  <link rel="stylesheet" href="assets/css/body-section.css">
  <script src="assets/js/jquery.flexslider.js" defer></script>
  <script src="assets/js/body-section.js" defer></script>
  <script src="assets/js/font-zoom.js" defer></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<section id="fontSize" class="wrapper body-wrapper" style="font-size: 100%;">
  <div class="bg-wrapper top-bg-wrapper gray-bg padding-top-bott">
    <div class="container common-container four_content body-container top-body-container padding-top-bott2">

      <div class="row gx-5 align-items-start">

        <!-- Left Column: Banner Content -->
        <div class="col-md-7">
          <div class="banner-content-wrapper">
            <h2><span><?= $online_labels[$lang]['municipality'] ?></span></h2>
            <p class="banner-title-tag-line"><?= $online_labels[$lang]['welcome_msg'] ?></p>
            <p class="banner-content" style="text-align: justify">
              <?= $language_labels[$lang]['about_details_1'] ?>
            </p>
            <p class="banner-content" style="text-align: justify">
             <?= $language_labels[$lang]['about_details_2'] ?>
            </p>
            <div class="view-footer">
              <a href="sub_page.php?page_id=<?= $aboutPage['id'] ?>" title="<?= $online_labels[$lang]['read_more'] ?>"><span><?= $online_labels[$lang]['read_more'] ?> &gt;</span></a>
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
                ["img" => "adhishashi.jpeg", "name" => "नीतू देवी", "role" => "(अधिशासी अधिकारी)"],
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
            <div class="banner-box-middle">
                <a href="#" title="<?= $online_labels[$lang]['services']['property_water']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['property_water']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['property_water']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle">
                <a href="https://crsorgi.gov.in/web/index.php/auth/login" target="_blank"
                   title="<?= $online_labels[$lang]['services']['birth_death']['title'] ?>"
                   onclick="return confirm('<?= $online_labels[$lang]['services']['birth_death']['confirm'] ?>')">
                    <h2><?= $online_labels[$lang]['services']['birth_death']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['birth_death']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle">
                <a href="#" title="<?= $online_labels[$lang]['services']['license']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['license']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['license']['icon'] ?> fa-4x"></i>
                </a>
            </div>
        </div>
        <div class="banner-row">
            <div class="banner-box-middle">
                <a href="#" title="<?= $online_labels[$lang]['services']['advertisement']['title'] ?>">
                    <h2><?= $online_labels[$lang]['services']['advertisement']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['advertisement']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle">
                <a href="http://e-nagarsewaup.gov.in/ulbapps/OnlineUser/onlineMutationOption.action" target="_blank"
                   title="<?= $online_labels[$lang]['services']['mutation']['title'] ?>"
                   onclick="return confirm('<?= $online_labels[$lang]['services']['mutation']['confirm'] ?>')">
                    <h2><?= $online_labels[$lang]['services']['mutation']['title'] ?></h2>
                    <i class="fa <?= $online_labels[$lang]['services']['mutation']['icon'] ?> fa-4x"></i>
                </a>
            </div>
            <div class="banner-box-middle">
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
                                <a href="download_forms.php" title="External link that opens in new tab">
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
