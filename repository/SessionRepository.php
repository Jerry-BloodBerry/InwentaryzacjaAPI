<?php
include_once '../config/Database.php';
include_once '../interfaces/IRepository.php';
include_once '../object/Session.php';

class SessionRepository implements IRepository
{
    private $conn;
    private $table_name = 'login_sessions';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param $id
     * @return Session|null
     */
    public function find($id)
    {
        $query = "SELECT 
                s.id, s.user_id, s.token, s.expiration_date, s.create_date 
          FROM
            " . $this->table_name . " s
            LEFT JOIN 
                users u
                    ON s.user_id = u.id
            WHERE
                s.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $session = new Session();
        $session->setId($row["id"]);
        $session->setCreateDate($row["create_date"]);
        $session->setToken($row["token"]);
        $session->setExpirationDate($row["expiration_date"]);
        $session->setUserId($row["user_id"]);

        return $session;
    }

    public function findAll()
    {
        $query = "SELECT 
                s.id, s.user_id, s.token, s.expiration_date, s.create_date 
          FROM
            " . $this->table_name . " s
            LEFT JOIN 
                users u
                    ON s.user_id = u.id
            ORDER BY s.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        $session_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $session = new Session();
            $session->setId($row["id"]);
            $session->setToken($row["token"]);
            $session->setUserId($row["user_id"]);
            $session->setCreateDate($row["create_date"]);
            $session->setExpirationDate($row["expiration_date"]);
            $session_array [] = $session;
        }
        return array("count" => $stmt->rowCount(), "assets" => $session_array);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteOne($id)
    {
        $query = "DELETE
                FROM " . $this->table_name . "
                WHERE id = ?";
        //prepare_query
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $id = htmlspecialchars(strip_tags($id));

        //bind parameter
        $stmt->bindParam(1,$id);

        if($stmt->execute() && $stmt->rowCount()>0)
        {
            return true;
        }
        return false;
    }

    /**
     * @param Session $session
     * @return bool
     * @throws Exception
     */
    public function addNew($session)
    {
        $query = "INSERT
                INTO " . $this->table_name . "
                SET
                    user_id=:u_id, token=:token, expiration_date=:exp_date, create_date=:crt_date";
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $session->setUserId(htmlspecialchars(strip_tags($session->getUserId())));
        $session->setToken(htmlspecialchars(strip_tags($session->getToken())));
        $session->setCreateDate(new DateTime('now'));
        try{
            $session->setExpirationDate(new DateTime(htmlspecialchars(strip_tags($session->getExpirationDate()))));
        }
        catch (Exception $e) {
            echo 'An exception occurred while setting date fields: ' . $e->getMessage();
        }

        //bind params
        $user_id = $session->getUserId();
        $token = $session->getToken();
        $exp_date = $session->getExpirationDate();
        $crt_date = $session->getCreateDate();

        //bind params
        $stmt->bindParam(":u_id",$user_id);
        $stmt->bindParam(":token",$token);
        $stmt->bindParam(":exp_date",$exp_date);
        $stmt->bindParam(":crt_date",$crt_date);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    public function findOneByToken($token)
    {
        $query = "SELECT 
                s.id, s.user_id, s.token, s.expiration_date, s.create_date 
          FROM
            " . $this->table_name . " s
            LEFT JOIN 
                users u
                    ON s.user_id = u.id
            WHERE
                s.token = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$token);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $session = new Session();
        $session->setId($row["id"]);
        $session->setCreateDate($row["create_date"]);
        $session->setToken($row["token"]);
        $session->setExpirationDate($row["expiration_date"]);
        $session->setUserId($row["user_id"]);

        return $session;
    }
}