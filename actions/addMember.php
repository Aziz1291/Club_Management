<?php
include('../classes/User.php');
$u=new User();
$u->addUser($_POST['username'],$_POST['email'],$_POST['password'],$_POST['role']);
header('location:../public/members.php');?>