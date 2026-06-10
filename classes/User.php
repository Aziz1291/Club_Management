<?php
class User{
    public $pdo;
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $profile_picture;
    function __construct(){
        require_once('../connexion.php');
        $cnx=new connexion();
        $this->pdo=$cnx->Cnx();
    }
    function nbUser(){
        $req="SELECT count(*) from users";
        $res=$this->pdo->query($req);
        return $res->fetchColumn();
    }
    function nbEvent(){
        $req="SELECT count(*) from events";
        $res=$this->pdo->query($req);
        return $res->fetchColumn();
    }
    function nbMsg($id){
        $req="SELECT count(*) from messages where status='unread' and receiver_id=$id";
        $res=$this->pdo->query($req);
        return $res->fetchColumn();
    }
    function nbReg($id){
        $req="SELECT count(*) from registrations where member_id=$id";
        $res=$this->pdo->query($req);
        return $res->fetchColumn();
    }
    function list_user(){
        $req="SELECT * from users order by role";
        $res=$this->pdo->query($req);
        return $res;
    }
    function login($username,$password,$role){
        $req=$this->pdo->prepare("SELECT * from users where username=? and password=? and role=?");
        $req->execute([$username,$password,$role]);
        $res=$req->fetch();
        if(!$res){
            if($role=='admin'){
                return 'wa';
            }
            else{
                return 'wm';
            }
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['id'] = $res[0];
        $_SESSION['username'] = $res[1];
        $_SESSION['role'] = $res[4];
        $_SESSION['profile_picture'] = $res[5];
        $_SESSION['email'] = $res[2];
        return "success";
    }
    
    function updateProfile($id,$n,$e,$p,$pp,$r){
    $req=$this->pdo->prepare("UPDATE users SET username=?, email=?, password=?, profile_picture=? , role=? WHERE id=?");
    $req->execute([$n,$e,$p,$pp,$r,$id]);
}
function getUser($id){
        $req=$this->pdo->prepare("SELECT * FROM users where id=?");
        $req->execute([$id]);
        $row=$req->fetch();
        return $row;
    }
    function addUser($n,$em,$pwd,$role){
        $req="INSERT into users (username,email,password,role) values(?,?,?,?)";
        $res=$this->pdo->prepare($req);
        $res->execute([$n,$em,$pwd,$role]);
    }

}