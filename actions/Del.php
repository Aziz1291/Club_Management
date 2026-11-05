<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Admin.php');
$id = (int) $_POST['curid'];
if ($id !== (int) $_SESSION['id']) { // an admin cannot delete their own account
    $op = new Admin();
    $op->deleteMembre($id);
}
header('Location: ../public/members.php');
?>
