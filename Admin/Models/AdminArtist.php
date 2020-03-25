<?php


class AdminArtist extends Artist
{
    /**
     * Insert data into artist table
     * @param $lastname
     * @param $firstname
     * @param $birthDate
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure
     */
    public function insertArtist($lastname, $firstname, $birthDate)
    {
        $sql = "INSERT INTO artists (lastname_artist, firstname_artist, birth_date) VALUES (:lastname, :firstname, :birthDate)";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':lastname', $lastname);
        $req->bindParam(':firstname', $firstname);
        $req->bindParam(':birthDate', $birthDate);
        return $req->execute();
    }

    /**
     * Update artist data in artist table
     * @param $id_artist
     * @param $lastname
     * @param $firstname
     * @param $birthDate
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure
     */
    public function updateArtist($id_artist ,$lastname, $firstname, $birthDate)
    {
        $sql = "UPDATE artists SET lastname_artist=:lastname, firstname_artist=:firstname, birth_date=:birthDate WHERE id_artist= :id_artist";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id_artist', $id_artist);
        $req->bindParam(':lastname', $lastname);
        $req->bindParam(':firstname', $firstname);
        $req->bindParam(':birthDate', $birthDate);
        return $req->execute();

    }

    /**
     * Delete artist by ID
     * @param $id_artist
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure
     */
    public function deleteArtist($id_artist)
    {
        $sql = "DELETE FROM artists WHERE id_artist= :id ";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id_artist);
        return $req->execute();
    }

    /**
     * Get all data for one artist by ID
     * @param $id_artist
     * @return string|false Return <b>String</b> of the elements or <b>FALSE</b> on failure
     */
    public function getArtistById($id_artist)
    {
        $sql = "SELECT firstname_artist, lastname_artist, birth_date FROM artists WHERE id_artist = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id_artist);
        $req->execute();
        return $req->fetch();
    }

    public function artistExist($id_artist)
    {
        $sql = "SELECT true FROM artists WHERE id_artist = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id_artist);
        $req->execute();
        return (bool) $req->fetch();
    }

    public function getArtistId($name)
    {
        $sql =
            "SELECT id_artist " .
            "FROM artists " .
            "WHERE " .
            "CONCAT(lastname_artist, ' ', firstname_artist, ' - ', birth_date) " .
            "LIKE :name";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(":name", $name);
        $req->execute();
        return $req->fetch()['id_artist'];
    }

}