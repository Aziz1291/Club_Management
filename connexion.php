<?php
class connexion
{
public function Cnx()
 {
 $dbc=new PDO('mysql:host=localhost;dbname=club_management','root','');
 return $dbc;
 }
}?>
