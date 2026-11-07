<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Announcement.php');
$a = new Announcement();
$a->delAnn((int) $_POST['id']);
flash_notice('Announcement deleted.');
header("location:../public/announcements.php");
?>
