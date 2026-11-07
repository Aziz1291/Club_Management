<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Announcement.php');
$back = '../public/addAnn.php';
$title = form_text('title', 'Title', 150, $back);
$content = form_text('desc', 'Announcement text', 5000, $back);
$a = new Announcement();
$a->addAnn($title, $content, $_SESSION['id']);
header("location:../public/announcements.php");
?>
