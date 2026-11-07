<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Message.php');

// Members can delete messages they sent; the message disappears for the recipient too.
$deleted = (new Message())->deleteSent((int) ($_POST['id'] ?? 0), (int) $_SESSION['id']);
flash_notice($deleted ? 'Message deleted.' : 'Message not found.', $deleted ? 'success' : 'error');
header('Location: ../public/messages.php?box=sent');
exit;
