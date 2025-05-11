<?php
include 'config/db.php';
include 'includes/header.php';
$id = $_GET['id'] ?? 0;
$lang = $_SESSION['lang'];

$res = $conn->query("SELECT * FROM sub_pages WHERE id = $id");
if ($res->num_rows):
  $data = $res->fetch_assoc();
?>
<div class="container mt-4">
  <img src="assets/uploads/static_subpage.jpg" class="img-fluid mb-3" alt="Banner">
  <h3><?= $data["title_$lang"] ?></h3>
  <div><?= nl2br($data["content_$lang"]) ?></div>
</div>
<?php else: ?>
  <div class="container mt-4"><p>Page not found.</p></div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
