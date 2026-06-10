<?php
require_once('../classes/Event.php');
$id=$_POST['ide'];
$e=new Event();
$e->delEvent($id);
header("location:../public/manage_events.php")
?>