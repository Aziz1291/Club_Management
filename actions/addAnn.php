<?php
require_once('../auth.php');
require_admin();
require_post();
form_collect();
require_once('../classes/Announcement.php');
$back = '../public/addAnn.php';
$title = form_text('title', 'Title', 150, $back);
$content = form_text('desc', 'Announcement text', 5000, $back);
form_done($back);
$a = new Announcement();
$a->addAnn($title, $content, $_SESSION['id']);
flash_notice('Announcement published.');
header("location:../public/announcements.php");
?>
