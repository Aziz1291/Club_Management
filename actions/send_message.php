<?php
require_once('../classes/Message.php');
session_start();
    $m = new Message();
    $sender_id = $_SESSION['id'];
    $receiver_id = $_POST['receiver_id'];
    $content = $_POST['content'];
    $m->sendMessage($sender_id, $receiver_id, $content);
    header('Location: ../public/messages.php');
?>