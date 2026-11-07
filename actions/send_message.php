<?php
require_once('../auth.php');
require_login();
require_post();
form_collect();
require_once('../classes/Message.php');
require_once('../classes/User.php');

$back = '../public/messages.php';
$content = form_text('content', 'Message', 2000, $back);
$receiverId = (int)($_POST['receiver_id'] ?? 0);
if ($receiverId <= 0 || !(new User())->getUser($receiverId)) {
    form_fail('Choose who should receive the message.', $back);
}
form_done($back);

$m = new Message();
$m->sendMessage((int) $_SESSION['id'], $receiverId, $content);
flash_code('sent');
header('Location: ../public/messages.php?box=sent');
exit;
?>
