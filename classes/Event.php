<?php 
class Event{
    public $pdo;
    public $id;
    public $title;
    public $description;
    public $date;
    public $location;
    public $adminID;
    function __construct(){
        require_once('../connexion.php');
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }
    function listEvent(){
        $req=("SELECT * from events");
        $res=$this->pdo->query($req);
        return $res;
    }
    function delEvent($id){
        $req="DELETE from events where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$id]);
    }
    function addEvent($t,$de,$d,$l,$a){
        $req="INSERT INTO events(title,description,date,location,admin_Id) values(?,?,?,?,?)";
        $res=$this->pdo->prepare($req);
        $res->execute([$t,$de,$d,$l,$a]);
    }
    function getEvent($id){
        $req="SELECT * from events where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$id]);
        return $res->fetch();
    }
    function updateEvent($id,$t,$de,$d,$l,$a){
        $req="UPDATE events set title=? ,description=? ,date=? ,location=? ,admin_Id=? where id=?";
        $res=$this->pdo->prepare($req);
        $res->execute([$t,$de,$d,$l,$a,$id]);
    }
}