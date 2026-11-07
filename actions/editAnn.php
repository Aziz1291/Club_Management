<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Announcement.php');
$id = (int) ($_POST['id'] ?? 0);
$back = '../public/editAnn.php?id=' . $id;
$title = form_text('title', 'Title', 150, $back);
$content = form_text('desc', 'Announcement text', 5000, $back);
$a = new Announcement();
$a->updateAnn($title, $content, $_SESSION['id'], $id);
flash_notice('Announcement updated.');
header("location:../public/announcements.php");
?>
