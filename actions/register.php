<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Registration.php');
require_once('../classes/Event.php');

$eventId = (int) ($_POST['idEvent'] ?? 0);
$userId  = (int) ($_SESSION['id'] ?? 0);

// Admins manage events, they do not register for them.
if (($_SESSION['role'] ?? '') === 'admin') {
    flash_notice('Admins cannot register for events.', 'error');
    header('Location: ../public/events.php');
    exit;
}

// Past events are closed for registration.
$event = $eventId > 0 ? (new Event())->getEvent($eventId) : null;
if (!$event || substr((string) $event['date'], 0, 10) < date('Y-m-d')) {
    flash_notice('Registration is closed: this event has already taken place.', 'error');
    header('Location: ../public/events.php');
    exit;
}

$M = new Registration();
if ($eventId > 0 && $userId > 0) {
    $registered = $M->registerToEvent($userId, $eventId);
    if ($registered) {
        flash_code('registered');
        header("Location: ../public/events.php");
        exit;
    } else {
        flash_code('already_registered');
        header("Location: ../public/events.php");
        exit;
    }
}
header("Location: ../public/events.php");
exit;
?>
