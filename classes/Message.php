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
    function sendMessage($sender_id, $receiver_id, $content) {
    $req = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
    $res = $this->pdo->prepare($req);
    $res->execute([$sender_id, $receiver_id, $content]);
    }
    function markAsRead($message_id) {
    $req = "UPDATE messages SET status = 'read' WHERE id = ?";
    $res = $this->pdo->prepare($req);
    $res->execute([$message_id]);
    } 
}