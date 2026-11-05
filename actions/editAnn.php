<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Announcement.php');
$a = new Announcement();
$a->updateAnn($_POST['title'], $_POST['desc'], $_SESSION['id'], (int) $_POST['id']);
header("location:../public/announcements.php");
?>
