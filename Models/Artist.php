<?php

/**
 * Class Artist
 */
class Artist extends BDDConnect
{
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }

    /**
     * Get all artists id and data
     * @return array
     */
    public function getAllArtists()
    {
        $sql = "SELECT * FROM artists";
        $req = self::$_pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getArtisteData($artistID)
    {
        $sql = "SELECT * FROM artists WHERE id_artist = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $artistID);
        $req->execute();
        return $req->fetch();
    }

    public static function convertArtistArrayForTwig($array)
    {
        $arrayEnd = [];
        for ($i = 0; $i < count($array); $i++) {
            $arrayEnd[$array[$i]['id_artist']] = [
                'firstname' => $array[$i]['firstname_artist'],
                'lastname' => $array[$i]['lastname_artist'],
                'birthdate' => $array[$i]['birth_date']
            ];
        }
        return $arrayEnd;
    }

}
