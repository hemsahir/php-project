<?php
session_start();
include('../config/db.php');

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
        $_SESSION['msgType'] = "error";
        $_SESSION['msg'] = "❌ Invalid file type. Only JPG, JPEG, PNG files are allowed.";
        header("Location: manage_slider.php");
        exit;
    } elseif ($image_size > $max_size) {
        $_SESSION['msgType'] = "error";
        $_SESSION['msg'] = "❌ File size exceeds 5MB limit.";
        header("Location: manage_slider.php");
        exit;
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
                $_SESSION['msgType'] = "success";
                $_SESSION['msg'] = "✅ Slider image uploaded successfully!";
                header("Location: manage_slider.php");
                exit;
            } else {
                $_SESSION['msgType'] = "error";
                $_SESSION['msg'] = "❌ Error uploading the slider image.";
                header("Location: manage_slider.php");
                exit;
            }
        } else {
            $_SESSION['msgType'] = "error";
            $_SESSION['msg'] = "❌ You can only upload a maximum of 5 slider images.";
            header("Location: manage_slider.php");
            exit;
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
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Slider image deleted successfully!";
        header("Location: manage_slider.php");
        exit;
    }
}

// Fetch existing sliders
$sliders_result = $conn->query("SELECT * FROM sliders");
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Slider</title>
    <link rel="icon" type="image/png" href="../assets/uploads/default_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        background: #f8f9fa;
    }
    h2, h3 {
        text-align: center;
        margin-bottom: 20px;
    }
    form {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        max-width: 500px;
        margin: auto;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }
    .col-md-3 {
        flex: 0 0 auto;
        width: 23%;
        text-align: center;
    }
    .img-fluid {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.1);
    }
    .btn-danger.btn-sm {
        width: 100%;
        font-size: 14px;
        padding: 6px 12px;
    }
    /* Responsive fixes */
    @media (max-width: 991px) {
        .col-md-3 {
            width: 32%;
        }
    }
    @media (max-width: 767px) {
        .col-md-3 {
            width: 48%;
        }
        .img-fluid {
            width: 100%;
        }
        form {
            width: 100%;
            margin-top: 20px;
        }
        .btn-danger.btn-sm {
            margin-top: 10px;
        }
    }
    @media (max-width: 480px) {
        .col-md-3 {
            width: 100%;
        }
        .img-fluid {
            width: 90%;
            margin: auto;
        }
        .btn-danger.btn-sm {
            width: 90%;
            margin: 10px auto 0;
            display: block;
        }
    }
</style>
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
                    <a href="?delete_slider=<?php echo $slider['id']; ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Delete this image?')">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
<script>
    <?php if (isset($_SESSION['msg'])): ?>
        Swal.fire({
            icon: '<?= $_SESSION['msgType'] ?>',
            title: '<?= ucfirst($_SESSION['msgType']) ?>',
            text: '<?= $_SESSION['msg'] ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php
    // clear message after showing
        unset($_SESSION['msg']);
        unset($_SESSION['msgType']);
        endif;
    ?>
</script>
</body>
</html>
