<?php
require_once('User.php');
class Member extends User{
    
    function send_message($admin_id,$cont){
        $req=$this->pdo->prepare("INSERT into messages(sender_id,receiver_id,content) values(?,?,?)");
        $req->execute([$this->id,$admin_id,$cont]);
    }
    function viewAnnouncement(){
        $req="SELECT * from announcements ";
        return $this->pdo->query($req);
    }
}