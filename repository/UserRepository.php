<?php
include_once '../config/Database.php';
include_once '../object/User.php';

class UserRepository
{
    //database connection and table name
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findOneByLogin($login)
    {
        $query = "SELECT 
                u.id, u.login, u.hash 
          FROM
            " . $this->table_name . " u
            WHERE
                u.login = ?
            LIMIT
                0,1";
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