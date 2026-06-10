<?php
class Registration{
    public $id;
    public $member_id;
    public $event_id;
    function __construct(){
        require_once('../connexion.php');
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }
    function registerToEvent($idM,$event_id){
        $req=$this->pdo->prepare("INSERT into registrations(member_id,event_id) values(?,?)");
        $req->execute([$idM,$event_id]);
    }
    function cancelRegistration($id){
        $req=$this->pdo->prepare("DELETE from registrations where id=?");
        $req->execute([$id]);
    }
    function getRegistrations($id){
        $req=$this->pdo->prepare("SELECT e.*,r.id from registrations r join events e on  r.event_id=e.id where r.member_id=?");
        $req->execute([$id]);
        return $req;
    }
}
?>