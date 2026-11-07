<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/User.php');

// A user can only edit their own profile and cannot change their own role
$id  = (int) $_SESSION['id'];
$us  = new User();
$cur = $us->getUser($id);

[$name, $email, $pwd] = form_account('../public/profile.php', $us, $id);

$imgPath = save_profile_image($_FILES['profile_image'] ?? [], $id, $cur['profile_picture'], $imgError);
if ($imgError) {
    header('Location: ../public/profile.php?error=' . $imgError);
    exit;
}
$imgPath = $imgPath ?? $cur['profile_picture'];

$us->updateProfile($id, $name, $email, $pwd, $imgPath, $cur['role']); // blank password keeps the current one

$_SESSION['username']        = $name;
$_SESSION['email']           = $email;
$_SESSION['profile_picture'] = $imgPath;

header('Location: ../public/profile.php?success=1');
exit;
?>
