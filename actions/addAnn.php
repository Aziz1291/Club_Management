<?php
require_once('../classes/Announcement.php');
$a= new Announcement();
$a->addAnn($_POST['title'],$_POST['desc'],$_POST['idA']);
header("location:../public/announcements.php");
?>