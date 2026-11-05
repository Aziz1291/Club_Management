<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/User.php');
$role = in_array($_POST['role'], ['admin', 'member'], true) ? $_POST['role'] : 'member';
$us = new User();
$us->updateProfile((int) $_POST['id'], $_POST['name'], $_POST['email'], $_POST['pwd'], $_POST['img'], $role);
header('Location:../public/members.php');
?>
