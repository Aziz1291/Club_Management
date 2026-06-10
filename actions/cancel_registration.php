<?php
$id=$_POST['registration_id'];
require_once('../classes/Registration.php');
$r=new Registration();
$r->cancelRegistration($id);
header("location:../public/my_registrations.php");
?>
