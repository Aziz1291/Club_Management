<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Registration.php');

$eventId = (int) ($_POST['idEvent'] ?? 0);
$userId  = (int) ($_SESSION['id'] ?? 0);

$M = new Registration();
if ($eventId > 0 && $userId > 0) {
    $registered = $M->registerToEvent($userId, $eventId);
    if ($registered) {
        header("Location: ../public/events.php?registered=1&event_id=" . $eventId);
        exit;
    } else {
        header("Location: ../public/events.php?already_registered=1&event_id=" . $eventId);
        exit;
    }
}
header("Location: ../public/events.php");
exit;
?>
