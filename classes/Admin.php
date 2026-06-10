<?php
require_once('User.php');
class Admin extends User{
    function __construct() {
        
        parent::__construct(); 
    }
    function deleteMembre($id){
        $req=$this->pdo->prepare("DELETE from users where id=?");
        $req->execute([$id]);
    }
    
    function listAdmin(){
        $req=$this->pdo->prepare("SELECT * from users where role=?");
        $req->execute(['admin']);
        return $req;
    }}