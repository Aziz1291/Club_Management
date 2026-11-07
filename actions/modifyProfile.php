<?php
require_once('../auth.php');
require_login();
require_post();
form_collect();
require_once('../classes/User.php');

// A user can only edit their own profile and cannot change their own role
$id  = (int) $_SESSION['id'];
$us  = new User();
$cur = $us->getUser($id);

$back = '../public/profile.php';
[$name, $email, $pwd] = form_account($back, $us, $id);
form_done($back);

$imgPath = save_profile_image($_FILES['profile_image'] ?? [], $id, $cur['profile_picture'], $imgError);
if ($imgError) {
    flash_code('img_' . $imgError);
    header('Location: ../public/profile.php');
    exit;
}
$imgPath = $imgPath ?? $cur['profile_picture'];

$us->updateProfile($id, $name, $email, $pwd, $imgPath, $cur['role']); // blank password keeps the current one

$_SESSION['username']        = $name;
$_SESSION['email']           = $email;
$_SESSION['profile_picture'] = $imgPath;

flash_code('profile_saved');
header('Location: ../public/profile.php');
exit;
?>
