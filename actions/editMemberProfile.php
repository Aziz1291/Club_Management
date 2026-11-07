<?php
require_once('../auth.php');
require_admin();
require_post();
form_collect();
require_once('../classes/User.php');

$id   = (int) ($_POST['id'] ?? 0);
$role = in_array($_POST['role'] ?? '', ['admin', 'member'], true) ? $_POST['role'] : 'member';

$us  = new User();
$cur = $us->getUser($id);
if (!$cur) {
    header('Location: ../public/members.php');
    exit;
}

$back = '../public/editMemberProfile.php?id=' . $id;
[$name, $email, $pwd] = form_account($back, $us, $id);
form_done($back);

// Profile picture: validated by MIME type; the old file comes from the database, not the form
$imgPath = save_profile_image($_FILES['profile_image'] ?? [], $id, $cur['profile_picture'], $imgError) ?? $cur['profile_picture'];

$us->updateProfile($id, $name, $email, $pwd, $imgPath, $role); // blank password keeps the current one

flash_notice('Member profile updated.');
header('Location: ../public/members.php');
exit;
?>
