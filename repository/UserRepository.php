<?php
include_once '../config/Database.php';
include_once '../object/User.php';

class UserRepository
{
    //database connection and table name
    /**
     * @var PDO
     */
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

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