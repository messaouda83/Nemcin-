<?php
class Admin extends BDDConnect
{
    
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }
   
    public function getHash($username)
    {
        $sql = "SELECT password FROM users where username =?";
        $req = self::$_pdo->prepare($sql);
        $req->execute([$username]);
        return $req->fetch();
    } 
} 