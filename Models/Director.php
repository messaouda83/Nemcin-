<?php


class Director extends BDDConnect
{
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }

    public function getAllDirectors()
    {
        $sql = "SELECT DISTINCT id_artist, lastname_artist, firstname_artist, birth_date FROM artists a, movies f WHERE a.id_artist = f.director_id ORDER BY birth_date";
        $req = self::$_pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}