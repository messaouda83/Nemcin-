<?php

class Movie extends BDDConnect {

    /**
     * Movie constructor.
     */
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }

    public static function convertMovieArrayForTwig($array)
    {
        $arrayEnd = [];

        for ($i = 0; $i < count($array); $i++) {
            $arrayEnd[$array[$i]['movie_id']] = [
                'title' => $array[$i]['title'],
                'releaseYear' => $array[$i]['release_year'],
                'poster' => $array[$i]['poster'],
                'synopsis' => $array[$i]['synopsis']
            ];
        }
        return $arrayEnd;
    }

    public function getAllMovies()
    {
        $sql = "SELECT * FROM movies";
        $req = self::$_pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}

