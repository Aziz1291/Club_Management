<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Event.php');
$e = new Event();
$e->delEvent((int) $_POST['ide']);
header("location:../public/manage_events.php");
?>
