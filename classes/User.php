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
        $req=$this->pdo->prepare("SELECT count(*) from messages where status='unread' and receiver_id=?");
        $req->execute([$id]);
        return $req->fetchColumn();
    }
    function nbReg($id){
        $req=$this->pdo->prepare("SELECT count(*) from registrations where member_id=?");
        $req->execute([$id]);
        return $req->fetchColumn();
    }
    function list_user(){
        $req="SELECT * from users order by role";
        $res=$this->pdo->query($req);
        return $res;
    }
    function login($username,$password,$role){
        // Step 1: check if username or email exists with that role
        $req=$this->pdo->prepare("SELECT * from users where (username=? or email=?) and role=?");
        $req->execute([$username, $username, $role]);
        $res=$req->fetch();
        if(!$res){
            // Username not found for this role
            return 'no_user';
        }
        // Step 2: check password (hashed; legacy plain-text rows are upgraded on first login)
        $stored = $res['password'];
        if (password_get_info($stored)['algo']) {
            $ok = password_verify($password, $stored);
        } else {
            $ok = hash_equals((string) $stored, (string) $password);
        }
        if (!$ok) {
            return 'wrong_password';
        }
        if (!password_get_info($stored)['algo'] || password_needs_rehash($stored, PASSWORD_DEFAULT)) {
            $up = $this->pdo->prepare("UPDATE users SET password=? WHERE id=?");
            $up->execute([password_hash($password, PASSWORD_DEFAULT), $res['id']]);
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['id'] = $res[0];
        $_SESSION['username'] = $res[1];
        $_SESSION['role'] = $res[4];
        $_SESSION['profile_picture'] = $res[5];
        $_SESSION['email'] = $res[2];
        return "success";
    }
    
    // An empty $p keeps the current password; otherwise it is stored hashed.
    function updateProfile($id,$n,$e,$p,$pp,$r){
    if ($p === '' || $p === null) {
        $req=$this->pdo->prepare("UPDATE users SET username=?, email=?, profile_picture=? , role=? WHERE id=?");
        $req->execute([$n,$e,$pp,$r,$id]);
    } else {
        $req=$this->pdo->prepare("UPDATE users SET username=?, email=?, password=?, profile_picture=? , role=? WHERE id=?");
        $req->execute([$n,$e,password_hash($p,PASSWORD_DEFAULT),$pp,$r,$id]);
    }
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
        $res->execute([$n,$em,password_hash($pwd,PASSWORD_DEFAULT),$role]);
    }
    // Which of the username or email already belongs to another account, if any.
    function takenBy($username, $email, $exceptId = 0){
        $req=$this->pdo->prepare("SELECT username, email FROM users WHERE (username=? OR email=?) AND id<>? LIMIT 1");
        $req->execute([$username, $email, (int)$exceptId]);
        $row=$req->fetch();
        if (!$row) return null;
        return strcasecmp($row['username'], $username) === 0 ? 'username' : 'email';
    }

}