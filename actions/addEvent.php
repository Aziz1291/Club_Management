<?php
require_once('../auth.php');
require_admin();
require_post();
form_collect();
require_once('../classes/Event.php');
$back = '../public/addEvent.php';
$title = form_text('title', 'Title', 150, $back);
$description = form_text('description', 'Description', 2000, $back);
$date = form_future_date('date', 'Event date', $back);
$location = form_text('location', 'Location', 150, $back);
$adminId = (int) ($_POST['admin_id'] ?? 0);
if ($adminId <= 0) {
    form_fail('Choose who runs the event.', $back);
}
form_done($back);
$ev = new Event();
$ev->addEvent($title, $description, $date, $location, $adminId);
flash_notice('Event created.');
header("location:../public/manage_events.php");
?>
