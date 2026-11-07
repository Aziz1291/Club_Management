<?php
require_once('../auth.php');
require_admin();
require_post();
include('../classes/User.php');
$role = in_array($_POST['role'] ?? '', ['admin', 'member'], true) ? $_POST['role'] : 'member';
$u = new User();
[$name, $email, $password] = form_account('../public/addMember.php', $u, 0, 'username', 'password', true);
$u->addUser($name, $email, $password, $role); // addUser hashes the password
flash_notice('Member added.');
header('location:../public/members.php');
?>
