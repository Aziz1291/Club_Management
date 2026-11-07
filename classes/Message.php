<?php 
require_once('../connexion.php');
class Message{
    public $pdo;
    function __construct(){
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }
    function getMessagesForUser($id){
        $req="SELECT * from messages where receiver_id = ? ORDER BY created_at DESC";
        $res = $this->pdo->prepare($req);
        $res->execute([$id]);
        return $res;
    }
    /** Latest unread messages for the header dropdown, with the sender's name. */
    function getUnreadPreview($id, $limit = 3){
        $res = $this->pdo->prepare("SELECT m.id, m.content, m.created_at, u.username AS sender FROM messages m LEFT JOIN users u ON u.id = m.sender_id WHERE m.receiver_id = ? AND m.status = 'unread' ORDER BY m.created_at DESC LIMIT " . (int) $limit);
        $res->execute([$id]);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    function countUnread($id){
        $res = $this->pdo->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND status = 'unread'");
        $res->execute([$id]);
        return (int) $res->fetchColumn();
    }
    function getSentByUser($id){
        $res = $this->pdo->prepare("SELECT * from messages where sender_id = ? ORDER BY created_at DESC");
        $res->execute([$id]);
        return $res;
    }
    /** Deletes a message only when this user sent it. Returns whether one was deleted. */
    function deleteSent($message_id, $sender_id) {
        $res = $this->pdo->prepare("DELETE FROM messages WHERE id = ? AND sender_id = ?");
        $res->execute([$message_id, $sender_id]);
        return $res->rowCount() > 0;
    }
    function sendMessage($sender_id, $receiver_id, $content) {
    $req = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
    $res = $this->pdo->prepare($req);
    $res->execute([$sender_id, $receiver_id, $content]);
    }
    function markAsRead($message_id, $receiver_id) {
    $req = "UPDATE messages SET status = 'read' WHERE id = ? AND receiver_id = ?";
    $res = $this->pdo->prepare($req);
    $res->execute([$message_id, $receiver_id]);
    } 
}