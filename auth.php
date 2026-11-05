<?php
/**
 * auth.php — shared access-control and upload helpers.
 * Included by the pages in public/ and the scripts in actions/.
 */

function auth_start()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function auth_login_url()
{
    $dir = basename(dirname($_SERVER['SCRIPT_NAME']));
    return $dir === 'actions' ? '../public/login.php' : 'login.php';
}

/** Redirect to the login page unless a user is signed in. */
function require_login()
{
    auth_start();
    if (empty($_SESSION['id'])) {
        header('Location: ' . auth_login_url());
        exit;
    }
}

/** Only admins may continue; everyone else gets 403 (or the login page if signed out). */
function require_admin()
{
    require_login();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Forbidden: administrators only.');
    }
}

/** State-changing scripts accept POST only. */
function require_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed.');
    }
}

/**
 * Safely resolves avatar URLs, ensuring fallback to default asset avatar
 * if missing or legacy 'default.png'.
 */
function get_avatar_url($pic)
{
    if (empty($pic) || $pic === 'default.png' || $pic === 'default.jpg') {
        return '../assets/images/profilee.jpg';
    }
    if (strpos($pic, 'http://') === 0 || strpos($pic, 'https://') === 0) {
        return $pic;
    }
    if (strpos($pic, '../') === 0) {
        return $pic;
    }
    if (strpos($pic, 'uploads/') === 0) {
        return '../' . $pic;
    }
    return '../assets/images/profilee.jpg';
}

/**
 * Validate and store an uploaded profile picture.
 * The extension comes from the detected MIME type, never from the client file name.
 * Returns the stored path (e.g. ../uploads/profile_3_1700000000.png) or null.
 * $error is set to 'too_large' or 'invalid_type' when the file is rejected.
 */
function save_profile_image(array $file, $userId, $oldPath = null, &$error = null)
{
    $error = null;
    if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        $error = 'too_large';
        return null;
    }
    $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $mime = mime_content_type($file['tmp_name']);
    if (!isset($types[$mime])) {
        $error = 'invalid_type';
        return null;
    }
    $dir = __DIR__ . '/uploads';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $name = 'profile_' . (int) $userId . '_' . time() . '.' . $types[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        return null;
    }
    if ($oldPath && strpos($oldPath, '../uploads/') === 0) {
        $old = $dir . '/' . basename($oldPath);
        if (is_file($old)) {
            unlink($old);
        }
    }
    return '../uploads/' . $name;
}
