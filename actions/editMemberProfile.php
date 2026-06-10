<?php
session_start();
require_once('../classes/User.php');

$id   = $_POST['id'];
$name = trim($_POST['name']);
$email= trim($_POST['email']);
$pwd  = trim($_POST['pwd']);
$role = $_POST['role'];

// ── Handle profile picture upload ─────────────────────────────────────────
$imgPath = $_POST['old_img']; // keep existing by default

if (!empty($_FILES['profile_image']['name'])) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $ftype   = mime_content_type($_FILES['profile_image']['tmp_name']);

    if (in_array($ftype, $allowed) && $_FILES['profile_image']['size'] <= 5 * 1024 * 1024) {
        $ext      = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $id . '_' . time() . '.' . strtolower($ext);
        $dest     = '../uploads/' . $filename;

        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0755, true);
        }

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $dest)) {
            if (!empty($_POST['old_img']) && strpos($_POST['old_img'], '../uploads/') === 0) {
                if (file_exists($_POST['old_img'])) unlink($_POST['old_img']);
            }
            $imgPath = $dest;
        }
    }
}

// ── Update database ───────────────────────────────────────────────────────
$us = new User();
$us->updateProfile($id, $name, $email, $pwd, $imgPath, $role);

header('Location: ../public/members.php?success=1');
exit;
?>
