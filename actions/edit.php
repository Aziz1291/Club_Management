<?php
require_once('../classes/User.php');
$us=new User();
$us->updateProfile($_POST['id'],$_POST['name'],$_POST['email'],$_POST['pwd'],$_POST['img'],$_POST['role']);

header('Location:../public/members.php');?>