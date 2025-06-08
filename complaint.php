<?php
include 'config/db.php';
include 'language_switch.php';
require 'send_complaint.php';

$lang = $_SESSION['lang'] ?? 'en';

$labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'title' => 'Complaint Form',
        'name' => 'Your Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'subject' => 'Subject',
        'message' => 'Complaint Message',
        'submit' => 'Submit',
        'success' => 'Your complaint has been submitted successfully!',
        'error' => 'Something went wrong. Please try again.',
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'title' => 'शिकायत फ़ॉर्म',
        'name' => 'आपका नाम',
        'home' => 'मुखपृष्ठ',
        'email' => 'ईमेल',
        'phone' => 'फोन',
        'subject' => 'विषय',
        'message' => 'शिकायत विवरण',
        'submit' => 'जमा करें',
        'success' => 'आपकी शिकायत सफलतापूर्वक जमा हो गई है!',
        'error' => 'कुछ गलत हुआ। कृपया पुनः प्रयास करें।',
    ]
];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $msg = $_POST['message'] ?? '';

    $stmt = $conn->prepare("INSERT INTO complaints (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $msg);
    if ($stmt->execute()) {
        send_complaint_email($name, $email, $phone, $subject, $msg, $lang); // email function
        $message = '<div class="alert alert-success">' . $labels[$lang]['success'] . '</div>';
    } else {
        $message = '<div class="alert alert-danger">' . $labels[$lang]['error'] . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $labels[$lang]['title'] ?></title>
    <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<section id="complaint-fontSize" class="wrapper body-wrapper " style="font-size: 100%;">
    <div class="bg-wrapper inner-wrapper">
        <div class="breadcam-bg breadcam">
            <div class="container common-container four_content text-center">
                <ul class="breadcrumb">
                    <li><a href="index.php"><?= $labels[$lang]['home'] ?></a></li>
                    <li><a href="#"><?= $labels[$lang]['title'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section id="list" class="wrapper list-wrapper">
        <div class="container common-container four_content">
        <!-- <div class="container mt-5"> -->
            <h2><?= $labels[$lang]['municipality'] ?></h2>
            <hr>
            <h3><?= $labels[$lang]['title'] ?></h3>
            <?= $message ?>
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><?= $labels[$lang]['name'] ?></label>
                    <input type="text" name="name" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?= $labels[$lang]['email'] ?></label>
                    <input type="email" name="email" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?= $labels[$lang]['phone'] ?></label>
                    <input type="text" name="phone" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?= $labels[$lang]['subject'] ?></label>
                    <input type="text" name="subject" required class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label"><?= $labels[$lang]['message'] ?></label>
                    <textarea name="message" rows="4" required class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><?= $labels[$lang]['submit'] ?></button>
                </div>
            </form>
        <!-- </div> -->
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
