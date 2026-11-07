<?php
class Registration{
    public $id;
    public $member_id;
    public $event_id;
    public $pdo;
    function __construct(){
        require_once('../connexion.php');
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }
    function isRegistered($member_id, $event_id) {
        $req = $this->pdo->prepare("SELECT COUNT(*) FROM registrations WHERE member_id = ? AND event_id = ?");
        $req->execute([(int)$member_id, (int)$event_id]);
        return ((int)$req->fetchColumn()) > 0;
    }
    function getRegisteredEventIds($member_id) {
        $req = $this->pdo->prepare("SELECT event_id FROM registrations WHERE member_id = ?");
        $req->execute([(int)$member_id]);
        return $req->fetchAll(PDO::FETCH_COLUMN, 0) ?: [];
    }
    function registerToEvent($idM,$event_id){
        if ($this->isRegistered($idM, $event_id)) {
            return false;
        }
        $req=$this->pdo->prepare("INSERT into registrations(member_id,event_id) values(?,?)");
        return $req->execute([(int)$idM, (int)$event_id]);
    }
    function cancelRegistration($id,$member_id){
        $req=$this->pdo->prepare("DELETE from registrations where id=? and member_id=?");
        return $req->execute([(int)$id, (int)$member_id]);
    }
    function getRegistrations($id){
        $req=$this->pdo->prepare("SELECT 
            e.id AS event_id,
            e.title,
            e.description,
            e.date,
            e.location,
            e.admin_Id,
            r.id AS registration_id
            FROM registrations r 
            JOIN events e ON r.event_id = e.id 
            WHERE r.member_id = ?
            ORDER BY e.date ASC");
        $req->execute([(int)$id]);
        return $req;
    }
}
?>
