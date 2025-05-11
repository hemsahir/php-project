<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
// include 'language_switch.php';

// Fetch slider images
$sliderQuery = $conn->query("SELECT * FROM sliders ORDER BY id ASC");
?>
<?php include 'includes/header.php'; ?>

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
<?php include 'includes/main-body.php'; ?>
<?php include 'includes/footer.php'; ?>
