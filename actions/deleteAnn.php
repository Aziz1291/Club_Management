<?php
require_once('../classes/Announcement.php');
$a=new Announcement();
$a->delAnn($_POST['id']);
header("location:../public/announcements.php");?>