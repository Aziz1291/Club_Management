<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Event.php');
$ev = new Event();
$ev->addEvent($_POST['title'], $_POST['description'], $_POST['date'], $_POST['location'], (int) $_POST['admin_id']);
header("location:../public/manage_events.php");
?>
