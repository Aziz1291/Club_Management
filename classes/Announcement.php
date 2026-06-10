<?php
require_once('../connexion.php');
class Announcement {

    public function __construct() {
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }

    function displayAnn(){
        $req="SELECT * from announcements";
        $res=$this->pdo->prepare($req);
        $res->execute();
        return $res;
    }
    function delAnn($id){
        $req="DELETE from announcements where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$id]);
    }
    function addAnn($title,$desc,$a){
        $req="INSERT into announcements(title,content,admin_id) values(?,?,?)";
        $res=$this->pdo->prepare($req);
        $res->execute([$title,$desc,$a]);
    }
    function updateAnn($title,$desc,$a,$id){
        $req="UPDATE announcements set title=?,content=?,admin_id=? where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$title,$desc,$a,$id]);
    }
    function getAnn($id){
        $req="SELECT * from announcements where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$id]);
        return $res->fetch();
    }
}
?>