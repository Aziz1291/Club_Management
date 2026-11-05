<?php
require_once('../auth.php');
require_admin();
require_post();
include('../classes/User.php');
$role = in_array($_POST['role'], ['admin', 'member'], true) ? $_POST['role'] : 'member';
$u = new User();
$u->addUser($_POST['username'], $_POST['email'], $_POST['password'], $role); // addUser hashes the password
header('location:../public/members.php');
?>
