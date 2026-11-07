<?php
/**
 * auth.php — shared access-control and upload helpers.
 * Included by the pages in public/ and the scripts in actions/.
 */

require_once __DIR__ . '/error-page.php';

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

/** One token per session, sent with every form that changes data. */
function csrf_token()
{
    auth_start();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_valid()
{
    auth_start();
    return !empty($_SESSION['csrf'])
        && isset($_POST['csrf_token'])
        && hash_equals($_SESSION['csrf'], (string) $_POST['csrf_token']);
}

/** State-changing scripts accept POST only, and only from this site's own forms. */
function require_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed.');
    }
    if (!csrf_valid()) {
        http_response_code(403);
        exit('Your session expired. Go back, reload the page and try again.');
    }
}

/** Sends the user back to a form with a message and the values they typed. */
function form_fail($message, $back)
{
    auth_start();
    $_SESSION['form_error'] = $message;
    $_SESSION['form_old'] = $_POST;
    header('Location: ' . $back);
    exit;
}

/** Prints the message saved by form_fail(), once, and keeps the typed values for form_old(). */
function form_error_box()
{
    auth_start();
    $GLOBALS['form_old_values'] = $_SESSION['form_old'] ?? [];
    unset($_SESSION['form_old']);
    if (!empty($_SESSION['form_error'])) {
        echo '<div class="club-alert club-alert-danger" role="alert">' . htmlspecialchars($_SESSION['form_error']) . '</div>';
        unset($_SESSION['form_error']);
    }
}

/** A value the user typed before the form was rejected, or $default. */
function form_old($key, $default = '')
{
    $value = $GLOBALS['form_old_values'][$key] ?? $default;
    return is_string($value) ? $value : $default;
}

/** Trimmed text from the posted form, rejected when empty (if required) or longer than $max. */
function form_text($key, $label, $max, $back, $required = true)
{
    $value = trim((string) ($_POST[$key] ?? ''));
    if ($required && $value === '') {
        form_fail("$label is required.", $back);
    }
    if (mb_strlen($value) > $max) {
        form_fail("$label must be $max characters or fewer.", $back);
    }
    return $value;
}

/**
 * Checks the account fields shared by the profile, member-edit and add-member forms.
 * The password is optional when $passwordRequired is false (blank keeps the current one).
 * Returns [username, email, password].
 */
function form_account($back, $user, $exceptId = 0, $nameKey = 'name', $passwordKey = 'pwd', $passwordRequired = false)
{
    $name = form_text($nameKey, 'Username', 50, $back);
    if (mb_strlen($name) < 3) {
        form_fail('Username must be at least 3 characters long.', $back);
    }
    $email = form_text('email', 'Email', 100, $back);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        form_fail('Enter a valid email address.', $back);
    }
    $password = (string) ($_POST[$passwordKey] ?? '');
    if (($passwordRequired || $password !== '') && mb_strlen($password) < 6) {
        form_fail('Password must be at least 6 characters long.', $back);
    }
    $taken = $user->takenBy($name, $email, $exceptId);
    if ($taken) {
        form_fail("That $taken is already used by another account.", $back);
    }
    return [$name, $email, $password];
}

/** A posted date in YYYY-MM-DD form that is today or later. */
function form_future_date($key, $label, $back)
{
    $value = trim((string) ($_POST[$key] ?? ''));
    $date = DateTime::createFromFormat('Y-m-d', $value);
    if (!$date || $date->format('Y-m-d') !== $value) {
        form_fail("$label is not a valid date.", $back);
    }
    if ($value < date('Y-m-d')) {
        form_fail("$label cannot be in the past.", $back);
    }
    return $value;
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
