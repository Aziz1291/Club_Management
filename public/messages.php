<?php 
include('header.php'); 
require_once('../classes/User.php');
require_once('../classes/Message.php');

$u = new User();
$m = new Message();
$users = $u->list_user();
$current_user_id = (int)($_SESSION['id'] ?? 0);
$messages = $m->getMessagesForUser($current_user_id);
$msgList = $messages ? $messages->fetchAll(PDO::FETCH_ASSOC) : [];
?>

<link rel="stylesheet" href="../assets/css/messages.css">

<section class="section">
    <div class="container-fluid">
        <div class="messages-page">
            <div class="messages-header-bar">
                <span class="kicker">Communications Desk</span>
                <h1 class="page-title">Direct Dispatches &amp; Messages</h1>
                <p class="page-subtitle">Communicate with club directors, coaches, and team athletes.</p>
            </div>

            <?php if (isset($_GET['sent'])): ?>
                <div class="alert-dispatch-sent" role="alert">
                    <i class="lni lni-checkmark-circle"></i>
                    <div>
                        <strong>Dispatch Transmitted!</strong>
                        <p class="mb-0 text-muted">Your message has been delivered to the recipient&rsquo;s inbox.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="messages-container">
                <!-- Compose Dispatch Panel -->
                <div class="send-message-section">
                    <h3 class="section-title">
                        <i class="lni lni-pencil-alt"></i> Compose Dispatch
                    </h3>
                    <?php form_error_box(); ?>
                    <form class="message-form" action="../actions/send_message.php" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="receiver_id">Select Recipient</label>
                            <select id="receiver_id" name="receiver_id" class="form-select" required>
                                <option value="">Choose an athlete or director...</option>
                                <?php foreach ($users as $user): ?>
                                    <?php if ($user[0] != $current_user_id): ?>
                                        <option value="<?= htmlspecialchars((string)$user[0]) ?>">
                                            <?= htmlspecialchars($user[1]) ?> (<?= ucfirst(htmlspecialchars($user[4])) ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message_content">Dispatch Content</label>
                            <textarea id="message_content" name="content" class="form-textarea" placeholder="Type your message or inquiry here..." maxlength="2000" required><?= htmlspecialchars(form_old('content')) ?></textarea>
                        </div>
                        <button type="submit" class="btn-send">
                            <i class="lni lni-telegram-original"></i> Send Dispatch
                        </button>
                    </form>
                </div>

                <!-- Messages Stream Panel -->
                <div class="messages-list-section">
                    <h3 class="section-title">
                        <i class="lni lni-inbox"></i> Your Dispatches Inbox (<?= count($msgList) ?>)
                    </h3>
                    <div class="messages-list">
                        <?php if (empty($msgList)): ?>
                            <div class="club-card text-center py-5">
                                <i class="lni lni-envelope" style="font-size: 2.2rem; color: var(--subtle);"></i>
                                <h4 class="mt-3">No Dispatches in Inbox</h4>
                                <p class="text-muted mb-0">Messages sent to you from members and administrators will appear here.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($msgList as $message): ?>
                                <?php 
                                $msgId = (int)$message['id'];
                                $sender = $u->getUser($message['sender_id']);
                                $senderName = htmlspecialchars($sender[1] ?? 'User');
                                $senderRole = htmlspecialchars($sender[4] ?? 'Member');
                                $status = htmlspecialchars($message['status'] ?? 'read');
                                $statusClass = $status === 'unread' ? 'unread' : '';
                                $avatar = get_avatar_url($sender[5] ?? '');
                                $timeLabel = !empty($message['created_at'])
                                    ? date('M j, Y', strtotime($message['created_at'])) . ' &bull; ' . date('H:i', strtotime($message['created_at']))
                                    : 'Recent';
                                $content = nl2br(htmlspecialchars($message['content'] ?? ''));
                                ?>
                                <div class="message-item <?= $statusClass ?>" id="msg-card-<?= $msgId ?>" data-status="<?= $status ?>">
                                    <div class="message-header">
                                        <div class="sender-info">
                                            <img src="<?= $avatar ?>" class="sender-avatar-img" alt="<?= $senderName ?>" onerror="this.src='../assets/images/profilee.jpg'">
                                            <div class="sender-details">
                                                <h4><?= $senderName ?></h4>
                                                <p><?= $senderRole ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if ($status === 'unread'): ?>
                                                <button type="button" class="btn-mark-read" onclick="markMessageAsRead(<?= $msgId ?>, this)" title="Mark as read">
                                                    <i class="lni lni-checkmark"></i> Mark Read
                                                </button>
                                            <?php endif; ?>
                                            <span class="message-status status-<?= $status ?>" id="status-tag-<?= $msgId ?>">
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="message-content"><?= $content ?></div>
                                    <div class="message-time">
                                        <i class="lni lni-timer"></i>
                                        <span><?= $timeLabel ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function markMessageAsRead(messageId, btnEl) {
    const formData = new FormData();
    formData.append('message_id', messageId);

    fetch('../actions/mark_message_read.php', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const card = document.getElementById('msg-card-' + messageId);
            const statusTag = document.getElementById('status-tag-' + messageId);
            if (card) {
                card.classList.remove('unread');
                card.setAttribute('data-status', 'read');
            }
            if (statusTag) {
                statusTag.classList.remove('status-unread');
                statusTag.classList.add('status-read');
                statusTag.textContent = 'Read';
            }
            if (btnEl) {
                btnEl.remove();
            }
        }
    })
    .catch(err => {
        console.error('Error marking message read:', err);
    });
}
</script>

<?php include('footer.php'); ?>
