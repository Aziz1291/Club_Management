<?php
require_once('../classes/Admin.php');
$op=new Admin();
$id=$_POST['curid'];
$op->deleteMembre($id);
header('Location:../public/members.php');
?>