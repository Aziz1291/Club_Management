<?php
$idE=$_POST['idEvent'];
$idM=$_POST['idUser'];
require_once('../classes/Registration.php');
$M=new Registration();
$M->registerToEvent($idM,$idE);
header("location:../public/events.php");
?>