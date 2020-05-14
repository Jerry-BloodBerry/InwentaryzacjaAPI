<?php
include_once '../config/Database.php';
include_once '../object/User.php';

/** Klasa do obslugi tabeli uzytkownikow */
class UserRepository
{
    /** PDO wartosc polaczenia z baza */
    private $conn;

    /**
     * konstrukor
     * @param PDO $db polaczenie z baza
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Znajuje i zwraca uzytkownika o podanym id
     * @param integer $id id szukanego uzytkownika
     * @return User|null znaleziony uzytkownik
     */
    public function find($id)
    {
        $query = "CALL getUser(?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$id);

        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $user = new User();
        $user->setId($row['id']);
        $user->setLogin($row['login']);
        $user->setHash($row['hash']);

        return $user;
    }

    /**
     * Znajuje i zwraca uzytkownika o podanym loginie
     * @param $login login szukanego uzytkownika
     * @return User|null znaleziony uzytkownik
     */
    public function findOneByLogin($login)
    {
        $query = "CALL getUserByLogin(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$login);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $user = new User();
        $user->setId($row["id"]);
        $user->setLogin($row["login"]);
        $user->setHash($row["hash"]);

        return $user;
    }
}