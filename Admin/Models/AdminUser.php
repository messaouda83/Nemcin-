<?php


class AdminUser extends BDDConnect
{
    public function __construct()
    {
        self::$_pdo = parent::getPdo();
    }

    /**
     * @return array
     */
    public function getAllUser()
    {
        $sql = "SELECT * FROM user";
        $req = self::$_pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * @param $userMail
     * @return bool <b>TRUE</b> on sucess, <b>FALSE</b> on failure.
     */
    public function emailExist($userMail) {
        $sql = "SELECT true FROM user WHERE email = :mail";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':mail', $userMail);

        $req->execute();

        return (bool) $req->fetch();
    }

    public function getUserID($email)
    {
        $sql = "SELECT user_id FROM user WHERE email = :mail";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':mail', $email);
        $req->execute();
        return $req->fetch()['user_id'];
    }


    /**
     * @param $userID
     * @return string|false
     */
    public function getUserEmail($userID)
    {
        $sql = "SELECT email FROM user WHERE user_id = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $userID);
        $req->execute();
        return $req->fetch();
    }

    /**
     * @param $userID
     * @return string|false
     */
    public function getUserName($userID)
    {
        $sql = "SELECT name FROM user WHERE user_id = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $userID);
        $req->execute();
        return $req->fetch();
    }

    /**
     * @param $userID
     * @return string|false
     * @deprecated unsafe
     */
    public function getUserPlainPasssord($userID)
    {
        $sql = "SELECT password FROM user WHERE user_id = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $userID);
        $req->execute();
        return $req->fetch()['password'];
    }

    /**
     * @param $userID
     * @return string|false
     */
    public function getUserSaltedPasssord($userID)
    {
        $sql = "SELECT salted_password FROM user WHERE user_id = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(':id', $userID);
        $req->execute();
        return $req->fetch()['salted_password'];
    }

    public function addUser($email, $name, $password, $saltedPassword)
    {
        $sql = "INSERT INTO user(email, name, password, salted_password) VALUES (:mail, :name, :plainPassword, :saltedPassword)";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(":mail", $email);
        $req->bindParam(":name", $name);
        $req->bindParam(":plainPassword", $password);
        $req->bindParam(":saltedPassword", $saltedPassword);
        return $req->execute();
    }

    public function updateUSer($userID, $email, $name, $password, $saltedPassword)
    {
        $sql = "UPDATE user SET email = :mail, name = :name, password = :plainPassword, salted_password = :saltedPassword WHERE user_id = :id";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(":id", $userID);
        $req->bindParam(":mail", $email);
        $req->bindParam(":name", $name);
        $req->bindParam(":plainPassword", $password);
        $req->bindParam(":saltedPassword", $saltedPassword);
        return $req->execute();
    }

    public function deleteUser($userID)
    {
        $sql = "DELETE FROM user WHERE user_id= ':id' ";
        $req = self::$_pdo->prepare($sql);
        $req->bindParam(":id", $userID);
        return $req->execute();
    }
}