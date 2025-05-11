<?php
session_start();
include('../config/db.php');
include('sidebar.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$msg = ''; $msgType = 'success';
// Handle Add or Edit Main Page
if (isset($_POST['save_main_page'])) {
    $title_en = $_POST['title_en'];
    $title_hi = $_POST['title_hi'];
    $sort_order = intval($_POST['sort_order']);
    $id = isset($_POST['main_id']) ? intval($_POST['main_id']) : 0;

    if ($id > 0) {
        $conn->query("UPDATE pages SET title_en='$title_en', title_hi='$title_hi', sort_order=$sort_order WHERE id=$id");
        $msg = "✅ Main page updated.";
    } else {
        $check = $conn->query("SELECT * FROM pages WHERE sort_order = $sort_order");
        if ($check->num_rows > 0) {
            $msg = "❌ Sort order already in use.";
            $msgType = 'error';
        } else {
            $conn->query("INSERT INTO pages (title_en, title_hi, sort_order) VALUES ('$title_en', '$title_hi', $sort_order)");
            $msg = "✅ Main page added.";
        }
    }
}

// Handle Edit Sub-page
if (isset($_POST['save_sub_page'])) {
    $id = intval($_POST['sub_id']);
    $title_en = $_POST['sub_title_en'];
    $title_hi = $_POST['sub_title_hi'];
    $content_en = $_POST['sub_content_en'];
    $content_hi = $_POST['sub_content_hi'];
    $conn->query("UPDATE sub_pages SET title_en='$title_en', title_hi='$title_hi', content_en='$content_en', content_hi='$content_hi' WHERE id=$id");
    $msg = "✅ Sub-page updated.";
}

// Add Sub Pages
if (isset($_POST['add_sub_page']) && isset($_POST['sub_title_en']) && is_array($_POST['sub_title_en'])) {
    $parent_id = intval($_POST['parent_page_id']);
    foreach ($_POST['sub_title_en'] as $i => $title_en) {
        $title_en = mysqli_real_escape_string($conn, $title_en);
        $title_hi = mysqli_real_escape_string($conn, $_POST['sub_title_hi'][$i]);
        $content_en = mysqli_real_escape_string($conn, $_POST['sub_content_en'][$i]);
        $content_hi = mysqli_real_escape_string($conn, $_POST['sub_content_hi'][$i]);
        $conn->query("INSERT INTO sub_pages (page_id, title_en, title_hi, content_en, content_hi)
                    VALUES ('$parent_id', '$title_en', '$title_hi', '$content_en', '$content_hi')");
    }
    $msg = "✅ Sub-pages added.";
}

// Delete Sub Page
if (isset($_GET['delete_sub'])) {
    $id = intval($_GET['delete_sub']);
    $conn->query("DELETE FROM sub_pages WHERE id = $id");
    $msg = "🗑️ Sub-page deleted.";
}

// Delete Main Page
if (isset($_GET['delete_main'])) {
    $id = intval($_GET['delete_main']);
    $conn->query("DELETE FROM sub_pages WHERE page_id = $id");
    $conn->query("DELETE FROM pages WHERE id = $id");
    $msg = "🗑️ Main page and sub-pages deleted.";
}

$pages_result = $conn->query("SELECT * FROM pages ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/tinymce/tinymce.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        tinymce.init({
            selector: 'textarea.wysiwyg',
            menubar: false
        });
    });
</script>



    <style>
        .accordion-button {
            background-color: #f8f9fa;
        }

        .accordion-header .btn {
            z-index: 2;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Manage Pages</h2>

    <!-- Add/Edit Main Page -->
    <form method="POST" class="mb-5">
        <h4>Add / Edit Main Page</h4>
        <input type="hidden" name="main_id" id="main_id">
        <div class="mb-3">
            <label>Main Page Title (English)</label>
            <input type="text" name="title_en" id="title_en" class="form-control">
        </div>
        <div class="mb-3">
            <label>Main Page Title (Hindi)</label>
            <input type="text" name="title_hi" id="title_hi" class="form-control">
        </div>
        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" required>
        </div>
        <button type="submit" name="save_main_page" class="btn btn-primary">Save Main Page</button>
    </form>

    <!-- Accordion Display -->
        <div class="accordion" id="pageAccordion">
            <?php while ($page = $pages_result->fetch_assoc()) {
                $sub_pages = $conn->query("SELECT * FROM sub_pages WHERE page_id = " . $page['id']);
                ?>
                <form method="POST">
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header d-flex align-items-center justify-content-between" id="heading<?= $page['id'] ?>">
                        <div class="action-icons d-flex gap-2 ps-2">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="editMainPage(<?= $page['id'] ?>, '<?= $page['title_en'] ?>', '<?= $page['title_hi'] ?>', <?= $page['sort_order'] ?>)">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="?delete_main=<?= $page['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete this main page and its sub-pages?')">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                        <button class="accordion-button collapsed flex-grow-1 ms-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse<?= $page['id'] ?>"
                            aria-expanded="false" aria-controls="collapse<?= $page['id'] ?>">
                            <?= $page['title_en'] ?> / <?= $page['title_hi'] ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $page['id'] ?>" class="accordion-collapse collapse"
                         data-bs-parent="#pageAccordion">
                        <div class="accordion-body">
                            <input type="hidden" name="parent_page_id" value="<?= $page['id'] ?>">
                            <div class="sub-page-wrapper mb-3" data-parent="<?= $page['id'] ?>"></div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-3 add-sub-page"
                                    data-id="<?= $page['id'] ?>">+ Add Sub-page</button>
                            <div class="border-top pt-3">
                                <h5>Existing Sub-pages</h5>
                                <?php while ($sub = $sub_pages->fetch_assoc()) { ?>
                                    <div class="border p-2 mb-2 position-relative">
                                        <strong><?= $sub['title_en'] ?> / <?= $sub['title_hi'] ?></strong>
                                        <p><b>EN:</b> <?= $sub['content_en'] ?></p>
                                        <p><b>HI:</b> <?= $sub['content_hi'] ?></p>
                                        <div class="action-icons">
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="sub_id" value="<?= $sub['id'] ?>">
                                                <input type="hidden" name="sub_title_en" value="<?= htmlspecialchars($sub['title_en']) ?>">
                                                <input type="hidden" name="sub_title_hi" value="<?= htmlspecialchars($sub['title_hi']) ?>">
                                                <input type="hidden" name="sub_content_en" value="<?= htmlspecialchars($sub['content_en']) ?>">
                                                <input type="hidden" name="sub_content_hi" value="<?= htmlspecialchars($sub['content_hi']) ?>">
                                                <button type="submit" name="save_sub_page" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></button>
                                            </form>
                                            <a href="?delete_sub=<?= $sub['id'] ?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Delete this sub-page?')">
                                               <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if ($pages_result->num_rows > 0) { ?>
                                <button type="submit" name="add_sub_page" class="btn btn-success mt-4">Save All Sub-pages</button>
                            <?php }?>
                        </div>
                    </div>
                </div>
                </form>
            <?php } ?>
        </div>
</div>

<!-- Template for sub-page entry -->
<template id="subPageTemplate">
    <div class="border p-3 mb-3 bg-light rounded">
        <div class="row">
            <div class="col-md-6 mb-2">
                <input type="text" name="sub_title_en[]" class="form-control" placeholder="Sub-page Title (EN)">
            </div>
            <div class="col-md-6 mb-2">
                <input type="text" name="sub_title_hi[]" class="form-control" placeholder="Sub-page Title (HI)">
            </div>
        </div>
        <textarea name="sub_content_en[]" class="form-control mb-2 wysiwyg mb-2" placeholder="Content (EN)" rows="2"></textarea>
        <textarea name="sub_content_hi[]" class="form-control mb-2 wysiwyg mb-2" placeholder="Content (HI)" rows="2"></textarea>
        <button type="button" class="btn btn-sm btn-danger remove-sub-page">Remove</button>
    </div>
</template>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        let valid = true;

        // Validate Main Page Fields (only if saving main page)
        const mainTitleEn = document.getElementById('title_en')?.value.trim();
        const mainTitleHi = document.getElementById('title_hi')?.value.trim();
        if (document.querySelector('[name="save_main_page"]') && !mainTitleEn && !mainTitleHi) {
            alert('Fill at least one of Main Page Title (EN or HI)');
            valid = false;
        }

        // Validate each Sub-page block
        document.querySelectorAll('.sub-page-wrapper').forEach(wrapper => {
            wrapper.querySelectorAll('.border').forEach(subBlock => {
                const enTitle = subBlock.querySelector('[name="sub_title_en[]"]')?.value.trim();
                const hiTitle = subBlock.querySelector('[name="sub_title_hi[]"]')?.value.trim();
                const enContent = subBlock.querySelector('[name="sub_content_en[]"]')?.value.trim();
                const hiContent = subBlock.querySelector('[name="sub_content_hi[]"]')?.value.trim();

                if (!enTitle && !hiTitle) {
                    alert('Each Sub-page must have at least Title EN or HI');
                    valid = false;
                }
                if (!enContent && !hiContent) {
                    alert('Each Sub-page must have at least Content EN or HI');
                    valid = false;
                }
            });
        });

        if (!valid) {
            e.preventDefault(); // Stop form submit
        }
    });

    function editMainPage(id, en, hi, sort) {
        document.getElementById('main_id').value = id;
        document.getElementById('title_en').value = en;
        document.getElementById('title_hi').value = hi;
        document.getElementById('sort_order').value = sort;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.querySelectorAll('.add-sub-page').forEach(button => {
        button.addEventListener('click', function () {
            const parentId = this.dataset.id;
            const wrapper = document.querySelector(`.sub-page-wrapper[data-parent="${parentId}"]`);
            const template = document.getElementById('subPageTemplate').content.cloneNode(true);
            wrapper.appendChild(template);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-sub-page')) {
            e.target.closest('.border').remove();
        }
    });

    <?php if ($msg): ?>
        Swal.fire({
            icon: '<?= $msgType ?>',
            title: '<?= $msgType ?>',
            text: '<?= $msg ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php endif; ?>
</script>
</body>
</html>
