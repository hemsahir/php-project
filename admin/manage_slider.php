<?php
session_start();
include('../config/db.php');
include('sidebar.php');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle image upload for the slider
if (isset($_POST['upload_slider'])) {
    // Validate image file type and size
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $max_size = 5 * 1024 * 1024; // 5MB

    $image = $_FILES['slider_image']['name'];
    $image_tmp = $_FILES['slider_image']['tmp_name'];
    $image_size = $_FILES['slider_image']['size'];
    $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    if (!in_array($image_extension, $allowed_extensions)) {
        echo "❌ Invalid file type. Only JPG, JPEG, PNG files are allowed.";
    } elseif ($image_size > $max_size) {
        echo "❌ File size exceeds 5MB limit.";
    } else {
        // Check how many images already exist in the slider
        $result = $conn->query("SELECT COUNT(*) as image_count FROM sliders");
        $row = $result->fetch_assoc();
        if ($row['image_count'] < 5) {
            $target_dir = "../assets/uploads/";
            $target_file = $target_dir . basename($image);
            if (move_uploaded_file($image_tmp, $target_file)) {
                $slider_path = "assets/uploads/" . basename($_FILES["slider_image"]["name"]);
                $conn->query("INSERT INTO sliders (image) VALUES ('$slider_path')");
                echo "✅ Slider image uploaded successfully!";
            } else {
                echo "❌ Error uploading the slider image.";
            }
        } else {
            echo "❌ You can only upload a maximum of 5 slider images.";
        }
    }
}

// Delete slider image
if (isset($_GET['delete_slider'])) {
    $image_id = $_GET['delete_slider'];
    $result = $conn->query("SELECT * FROM sliders WHERE id=$image_id");
    $slider = $result->fetch_assoc();
    if (isset($slider['image'])) {
        unlink("../" . $slider['image']); // Delete the image file
        $conn->query("DELETE FROM sliders WHERE id=$image_id");
        echo "✅ Slider image deleted successfully!";
    }
}

// Fetch existing sliders
$sliders_result = $conn->query("SELECT * FROM sliders");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Slider</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Slider</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Upload Slider Image</label>
                <input type="file" name="slider_image" class="form-control" required>
            </div>
            <button type="submit" name="upload_slider" class="btn btn-primary">Upload Slider</button>
        </form>

        <h3 class="mt-4">Existing Sliders</h3>
        <div class="row">
            <?php while ($slider = $sliders_result->fetch_assoc()) { ?>
                <div class="col-md-3 mb-4">
                    <img src="../<?php echo $slider['image']; ?>" class="img-fluid" alt="Slider Image">
                    <a href="?delete_slider=<?php echo $slider['id']; ?>" class="btn btn-danger btn-sm mt-2">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
