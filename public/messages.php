<?php include('header.php'); ?>
<?php
require_once('../classes/User.php');
require_once('../classes/Message.php');
$u = new User();
$m = new Message();
$users = $u->list_user();
$current_user_id = $_SESSION['id'];
$messages = $m->getMessagesForUser($current_user_id);
?>
<style>
<?php include('../assets/css/messages.css') ;?>
</style>

<div class='messages-page'>
    <div class='page-header'>
        <h1 class='page-title'>Messages</h1>
        <p class='page-subtitle'>Communicate with other users and manage your conversations</p>
    </div>

    <div class='messages-container'>
        <div class='send-message-section'>
            <h3 class='section-title'>
                <i class='fas fa-paper-plane'></i>
                Send New Message
            </h3>
            <form class='message-form' action='../actions/send_message.php' method='POST'>
                <div class='form-group'>
                    <label class='form-label'>Select Recipient</label>
                    <select name='receiver_id' class='form-select' required>
                        <option value=''>Choose a user...</option>
                        <?php foreach($users as $user){if($user[0] != $current_user_id){
                            echo"<option value='$user[0]'>$user[1] ($user[4])</option>";
                        }}?>
                    </select>
                </div>
                <div class='form-group'>
                    <label class='form-label'>Message Content</label>
                    <textarea name='content' class='form-textarea' placeholder='Type your message here...' required></textarea>
                </div>
                <button type='submit' class='btn-send'>
                    <i class='fas fa-paper-plane'>Send Message</i>
                    
                </button>
            </form>
        </div>
        <div class='messages-list-section'>
            <h3 class='section-title'>
                <i class='lni lni-inbox'></i>
                Your Messages
            </h3>
            <div class='messages-list'>
                    <?php foreach($messages as $message): ?>
                        <?php 
                        $sender      = $u->getUser($message[1]);
                        $status_class= $message['status'];
                        $avatar      = !empty($sender[5]) ? htmlspecialchars($sender[5]) : '../assets/images/profilee.jpg';
                        $timeLabel   = !empty($message['created_at'])
                                        ? date('d M Y, H:i', strtotime($message['created_at']))
                                        : 'Unknown time';
                        ?>
                        <div class='message-item <?php echo $status_class; ?>' 
                             data-status='<?php echo $message['status']; ?>'>
                            <div class='message-header'>
                                <div class='sender-info'>
                                    <div class='sender-avatar'>
                                        <img src='<?= $avatar ?>' class='sender-avatar-img' alt='Sender Avatar'>
                                    </div>
                                    <div class='sender-details'>
                                        <h4><?php echo htmlspecialchars($sender[1]); ?></h4>
                                        <p><?php echo htmlspecialchars($sender[4]); ?></p>
                                    </div>
                                </div>
                                <div class='message-status status-<?php echo $message['status']; ?>'>
                                    <?php echo ucfirst($message['status']); ?>
                                </div>
                            </div>
                            <p class='message-content'><?php echo htmlspecialchars($message['content']); ?></p>
                            <div class='message-time'>
                                <i class='lni lni-timer'></i>
                                <?= $timeLabel ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>