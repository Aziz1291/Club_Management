<?php
require_once('../auth.php');
require_admin();
require_post();
require_once('../classes/Event.php');
$id = (int) ($_POST['ide'] ?? 0);
$back = '../public/editEvent.php?ide=' . $id;
$title = form_text('title', 'Title', 150, $back);
$description = form_text('description', 'Description', 2000, $back);
$date = form_future_date('date', 'Event date', $back);
$location = form_text('location', 'Venue', 150, $back);
$adminId = (int) ($_POST['admin_id'] ?? 0);
if ($adminId <= 0) {
    form_fail('Choose who runs the event.', $back);
}
$ev = new Event();
$ev->updateEvent($id, $title, $description, $date, $location, $adminId);
flash_notice('Event updated.');
header("location:../public/manage_events.php");
?>
