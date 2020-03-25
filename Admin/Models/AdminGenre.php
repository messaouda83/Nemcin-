<?php


class AdminGenre extends Genre
{
    public function insertGenre(string $genre)
    {
        $sql = "INSERT INTO movie_genres (genre) values (:genre)";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':genre', $genre);
        return $req->execute();
    }

    public function updateGenre(int $id_genre, string $genre)
    {
        $sql = "UPDATE movie_genres SET genre = :genre WHERE id_genre = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':id', $id_genre);
        return $req->execute();
    }

    public function deleteGenre(int $id_genre)
    {
        $sql = "DELETE FROM movie_genres WHERE id_genre = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id_genre);
        return $req->execute();
    }

    public function getGenreId(string $genre)
    {
        $sql = "SELECT id_genre FROM movie_genres WHERE genre = :genre";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':genre', $genre);
        $req->execute();
        return $req->fetch()['id_genre'];
    }

    public function getGenreById(int $id_genre)
    {
        $sql = "SELECT genre FROM movie_genres WHERE id_genre = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id_genre);
        $req->execute();
        return $req->fetch();
    }

    public function genreExist($id)
    {
        $sql = "SELECT true FROM movie_genres WHERE id_genre = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        return (bool) $req->fetch();
    }
}