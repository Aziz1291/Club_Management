<?php
require_once('../auth.php');
require_admin();
require_post();
form_collect();
include('../classes/User.php');
$role = in_array($_POST['role'] ?? '', ['admin', 'member'], true) ? $_POST['role'] : 'member';
$u = new User();
$back = '../public/addMember.php';
[$name, $email, $password] = form_account($back, $u, 0, 'username', 'password', true);
form_done($back);
$u->addUser($name, $email, $password, $role); // addUser hashes the password
flash_notice('Member added.');
header('location:../public/members.php');
?>
