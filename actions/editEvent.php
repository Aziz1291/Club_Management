<?php
require_once('../classes/Event.php');
$ev=new Event();
$id= (int) $_POST['ide'];
$ev->updateEvent($id,$_POST['title'],$_POST['description'],$_POST['date'],$_POST['location'],$_POST['admin_id']);
header("location:../public/manage_events.php");
?>