<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Message.php');

$content = trim($_POST['content'] ?? '');
$receiverId = (int)($_POST['receiver_id'] ?? 0);

if ($content !== '' && $receiverId > 0) {
    $m = new Message();
    $m->sendMessage((int) $_SESSION['id'], $receiverId, $content);
    header('Location: ../public/messages.php?sent=1');
    exit;
}
header('Location: ../public/messages.php');
exit;
?>
