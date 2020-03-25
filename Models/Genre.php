<?php

class Genre extends BDDConnect
{
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }

    public function getAllGenres()
    {
        $sql = 'SELECT * FROM movie_genres';
        $req = self::$_pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public static function convertGenreArrayForTwig($array)
    {
        $arrayEnd = [];

        for ($i = 0; $i < count($array); $i++) {
            $arrayEnd[$array[$i]['id_genre']] = $array[$i]['genre'];
        }

        return $arrayEnd;
    }
}
