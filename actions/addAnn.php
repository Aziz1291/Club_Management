<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Announcement.php');
$a = new Announcement();
$a->addAnn($_POST['title'], $_POST['desc'], $_SESSION['id']);
header("location:../public/announcements.php");
?>
