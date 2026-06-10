<?php
require_once('../classes/Message.php');
    $m = new Message();
    $message_id = $_POST['message_id'];
    $m->markAsRead($message_id)

?>