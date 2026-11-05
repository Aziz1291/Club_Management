<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Message.php');

$msgId = (int)($_POST['message_id'] ?? 0);
$userId = (int)($_SESSION['id'] ?? 0);

if ($msgId > 0 && $userId > 0) {
    $m = new Message();
    $m->markAsRead($msgId, $userId);
}

// Check if JSON requested
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message_id' => $msgId]);
    exit;
}

header('Location: ../public/messages.php');
exit;
?>
