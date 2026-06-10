<?php
require_once('../classes/Announcement.php');
$a= new Announcement();
$a->updateAnn($_POST['title'],$_POST['desc'],$_POST['idA'],$_POST['id']);
header("location:../public/announcements.php");
?>