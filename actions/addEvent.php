<?php
require_once('../classes/Event.php');
$ev=new Event();
$ev->addEvent($_POST['title'],$_POST['description'],$_POST['date'],$_POST['location'],$_POST['admin_id']);
header("location:../public/manage_events.php");
?>