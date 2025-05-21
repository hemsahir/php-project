<?php
header('Content-Type: application/json');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update sub-page
    if (isset($_POST['edit_sub_page_ajax'])) {
        $id = intval($_POST['sub_id']);
        $title_en = $conn->real_escape_string($_POST['sub_title_en']);
        $title_hi = $conn->real_escape_string($_POST['sub_title_hi']);
        $content_en = $conn->real_escape_string($_POST['sub_content_en']);
        $content_hi = $conn->real_escape_string($_POST['sub_content_hi']);

        $updated = $conn->query("UPDATE sub_pages SET title_en='$title_en', title_hi='$title_hi', content_en='$content_en', content_hi='$content_hi' WHERE id=$id");

        echo json_encode([
            'status' => $updated ? 'success' : 'error',
            'message' => $updated ? '✅ Sub-page updated successfully.' : '❌ Failed to update sub-page.'
        ]);
        exit;
    }

    // Delete sub-page
    if (isset($_POST['delete_sub_id'])) {
        $id = intval($_POST['delete_sub_id']);
        $deleted = $conn->query("DELETE FROM sub_pages WHERE id = $id");

        echo json_encode([
            'status' => $deleted ? 'success' : 'error',
            'message' => $deleted ? '🗑️ Sub-page deleted.' : '❌ Failed to delete sub-page.'
        ]);
        exit;
    }

    // Delete main page and its sub-pages
    if (isset($_POST['delete_main_id'])) {
        $id = intval($_POST['delete_main_id']);
        $subDeleted = $conn->query("DELETE FROM sub_pages WHERE page_id = $id");
        $mainDeleted = $conn->query("DELETE FROM pages WHERE id = $id");

        $success = $mainDeleted; // main deletion is primary
        echo json_encode([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? '🗑️ Main page and its sub-pages deleted.' : '❌ Failed to delete main page.'
        ]);
        exit;
    }

    // Fallback
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request type.'
    ]);
}
