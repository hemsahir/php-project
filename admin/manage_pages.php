<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle Add or Edit Main Page
if (isset($_POST['save_main_page'])) {
    $title_en = $conn->real_escape_string($_POST['title_en']);
    $title_hi = $conn->real_escape_string($_POST['title_hi']);
    $sort_order = intval($_POST['sort_order']);
    $id = isset($_POST['main_id']) ? intval($_POST['main_id']) : 0;

    if ($id > 0) {
        $conn->query("UPDATE pages SET title_en='$title_en', title_hi='$title_hi', sort_order=$sort_order WHERE id=$id");
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Main page updated.";
        header("Location: manage_pages.php");
        exit;
    } else {
        $check = $conn->query("SELECT * FROM pages WHERE sort_order = $sort_order");
        if ($check->num_rows > 0) {
            $_SESSION['msgType'] = "error";
            $_SESSION['msg'] = "❌ Sort order already in use.";
            header("Location: manage_pages.php");
            exit;
        } else {
            $conn->query("INSERT INTO pages (title_en, title_hi, sort_order) VALUES ('$title_en', '$title_hi', $sort_order)");
            $_SESSION['msgType'] = "success";
            $_SESSION['msg'] = "✅ Main page added.";
            header("Location: manage_pages.php");
            exit;
        }
    }
}

// Add Sub Pages
if (isset($_POST['add_sub_page']) && isset($_POST['sub_title_en']) && is_array($_POST['sub_title_en'])) {
    $parent_id = intval($_POST['parent_page_id']);
    $valid = false;
    foreach ($_POST['sub_title_en'] as $i => $title_en) {
        $title_en = mysqli_real_escape_string($conn, $title_en);
        $title_hi = mysqli_real_escape_string($conn, $_POST['sub_title_hi'][$i]);
        $content_en = mysqli_real_escape_string($conn, $_POST['sub_content_en'][$i]);
        $content_hi = mysqli_real_escape_string($conn, $_POST['sub_content_hi'][$i]);

        if ((!$title_en && !$title_hi) || (!$content_en && !$content_hi)) {
            continue; // Skip invalid entries
        }
        $valid = true;
        $conn->query("INSERT INTO sub_pages (page_id, title_en, title_hi, content_en, content_hi)
                    VALUES ('$parent_id', '$title_en', '$title_hi', '$content_en', '$content_hi')");
    }
    if ($valid) {
        $_SESSION['msgType'] = "success";
        $_SESSION['msg'] = "✅ Sub-pages added.";
    } else {
        $_SESSION['msgType'] = "error";
        $_SESSION['msg'] = "❌ No valid sub-pages to add.";
    }
    header("Location: manage_pages.php");
    exit;
}

$pages_result = $conn->query("SELECT * FROM pages ORDER BY sort_order ASC");
include('sidebar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pages</title>
     <link rel="icon" type="image/png" href="../assets/uploads/default_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .accordion-button {
            background-color: #f8f9fa;
        }

        .accordion-header .btn {
            z-index: 2;
        }
        @media (max-width: 991px) {
            body {
               padding-left: 260px; /* Sidebar width */
           }
           .accordion {
               padding: 30px;
           }
           .border.p-3.mb-3.bg-light.rounded {
            box-sizing: border-box;
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
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
                            <button onclick="deleteMainPage(<?= $page['id'] ?>,event)" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                        <button class="accordion-button collapsed flex-grow-1 ms-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse<?= $page['id'] ?>"
                            aria-expanded="false" aria-controls="collapse<?= $page['id'] ?>">
                            <?= $page['title_en'] ?> / <?= $page['title_hi'] ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $page['id'] ?>" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <input type="hidden" name="parent_page_id" value="<?= $page['id'] ?>">
                            <div class="sub-page-wrapper mb-3" data-parent="<?= $page['id'] ?>"></div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-3 add-sub-page"
                                    data-id="<?= $page['id'] ?>">+ Add Sub-page</button>
                            <div class="border-top pt-3">
                                <h5>Existing Sub-pages</h5>
                                <?php while ($sub = $sub_pages->fetch_assoc()) { ?>
                                    <!-- Each Sub-Page Display -->
                                    <div class="border p-3 mb-3 bg-light rounded">
                                        <strong><?= $sub['title_en'] ?> / <?= $sub['title_hi'] ?></strong>
                                        <p><b>EN:</b> <?= $sub['content_en'] ?></p>
                                        <p><b>HI:</b> <?= $sub['content_hi'] ?></p>

                                        <div class="action-icons">
                                            <!-- Show edit form button -->
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleSubPageEdit(<?= $sub['id'] ?>)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button onclick="deleteSubPage(<?= $sub['id'] ?>,event)" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                        <!-- Edit form (no <form> tag) -->
                                        <div class="sub_page_edit_form mt-3" id="edit_form_<?= $sub['id'] ?>" style="display: none;">
                                            <input type="hidden" name="sub_id" value="<?= $sub['id'] ?>">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Title (EN)</label>
                                                    <input type="text" name="edit_sub_title_en" class="form-control" placeholder="Title (EN)" value="<?= htmlspecialchars($sub['title_en']) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Title (HI)</label>
                                                    <input type="text" name="edit_sub_title_hi" class="form-control" placeholder="Title (HI)" value="<?= htmlspecialchars($sub['title_hi']) ?>">
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Content (EN)</label>
                                                <textarea name="edit_sub_content_en_<?= $sub['id'] ?>" class="form-control mb-2 editor" placeholder="Content (EN)"><?= $sub['content_en'] ?></textarea>
                                            </div>
                                            <div class="mb-2">
                                                 <label class="form-label">Content (HI)</label>
                                                <textarea name="edit_sub_content_hi_<?= $sub['id'] ?>" class="form-control mb-2 editor" placeholder="Content (HI)"><?= $sub['content_hi'] ?></textarea>
                                            </div>
                                            <button type="button" onclick="saveSubPage(<?= $sub['id'] ?>)" class="btn btn-sm btn-success">Save</button>
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
        <textarea name="sub_content_en[]" class="form-control mb-2 editor" placeholder="Content (EN)" rows="2"></textarea>
        <textarea name="sub_content_hi[]" class="form-control mb-2d mb-2 editor" placeholder="Content (HI)" rows="2"></textarea>
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

    function toggleSubPageEdit(id) {
        const form = document.getElementById('edit_form_' + id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

    function saveSubPage(id) {
        const form = document.getElementById('edit_form_' + id);
        const enName = 'edit_sub_content_en_' + id;
        const hiName = 'edit_sub_content_hi_' + id;
        if (editorInstances[enName]) {
            form.querySelector(`[name="${enName}"]`).value = editorInstances[enName].getData();
        }
        if (editorInstances[hiName]) {
            form.querySelector(`[name="${hiName}"]`).value = editorInstances[hiName].getData();
        }

        const data = new FormData();

        data.append('edit_sub_page_ajax', true);
        data.append('sub_id', id);
        data.append('sub_title_en', form.querySelector(`[name="edit_sub_title_en"]`).value);
        data.append('sub_title_hi', form.querySelector(`[name="edit_sub_title_hi"]`).value);
        data.append('sub_content_en', form.querySelector(`[name="${enName}"]`).value);
        data.append('sub_content_hi', form.querySelector(`[name="${hiName}"]`).value);

        fetch('update_sub_page.php', {
            method: 'POST',
            body: data
        }).then(res => res.json()).then(response => {
            Swal.fire({
                icon: response.status === 'success' ? 'success' : 'error',
                title: response.status === 'success' ? 'Success' : 'Error',
                text: response.message,
                confirmButtonColor: '#3085d6'
            }).then(() => {
                if (response.status === 'success') {
                    location.reload(); // reload only on success
                }
            });
        }).catch(err => {
            Swal.fire('Error', 'Something went wrong.', 'error');
            console.error(err);
        });
    }

    function deleteSubPage(id,event) {
        if (event) event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete this sub-page!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = new FormData();
                data.append('delete_sub_id', id);
                fetch('update_sub_page.php', {
                    method: 'POST',
                    body: data
                }).then(res => res.json()).then(response => {
                    Swal.fire({
                        icon: response.status === 'success' ? 'success' : 'error',
                        title: response.status === 'success' ? 'Deleted' : 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    });
                });
            }
        });
    }
    
    function deleteMainPage(id,event) {
        if (event) event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the main page and all its sub-pages!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete all!'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = new FormData();
                data.append('delete_main_id', id);
                fetch('update_sub_page.php', {
                    method: 'POST',
                    body: data
                }).then(res => res.json()).then(response => {
                    Swal.fire({
                        icon: response.status === 'success' ? 'success' : 'error',
                        title: response.status === 'success' ? 'Deleted' : 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    });
                });
            }
        });
    }

    document.querySelectorAll('.add-sub-page').forEach(button => {
        button.addEventListener('click', function () {
            const parentId = this.dataset.id;
            const wrapper = document.querySelector(`.sub-page-wrapper[data-parent="${parentId}"]`);
            const template = document.getElementById('subPageTemplate').content.cloneNode(true);
            wrapper.appendChild(template);
            initAllCKEditors();
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-sub-page')) {
            e.target.closest('.border').remove();
        }
    });

    const editorInstances = {};
    function initCKEditorFor(el) {
        ClassicEditor
            .create(el, {
                toolbar: [
                    'heading', '|',
                    'link','bold', 'italic','bulletedList', 'numberedList', '|',
                    'insertTable', 'blockQuote','|',
                    'undo', 'redo'
                ],
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(editor => {
                editorInstances[el.name] = editor;
            }).catch(error => {
                console.error(error);
            });
    }
    function initAllCKEditors() {
        document.querySelectorAll('textarea.editor:not([data-ckeditor-initialized])').forEach(el => {
            el.setAttribute('data-ckeditor-initialized', 'true');
            initCKEditorFor(el);
        });
    }


    document.addEventListener('DOMContentLoaded',initAllCKEditors);
    document.addEventListener('DOMContentLoaded', function () {
        const accordion = document.getElementById('pageAccordion');
        accordion.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function (e) {
                const targetSelector = this.getAttribute('data-bs-target');
                if (!targetSelector) return;
                const target = document.querySelector(targetSelector);
                if (!target) return;
                const isOpen = target.classList.contains('show');
                // Hide all other open sections
                accordion.querySelectorAll('.accordion-collapse.show').forEach(el => {
                    if (el !== target) {
                        const instance = bootstrap.Collapse.getOrCreateInstance(el);
                        instance.hide();
                    }
                });
                // Toggle the clicked section
                const instance = bootstrap.Collapse.getOrCreateInstance(target);
                if (isOpen) {
                    instance.hide();  // close if already open
                } else {
                    instance.show();  // open if closed
                }

                // Prevent default Bootstrap toggle
                e.preventDefault();
            });
        });
    });

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
