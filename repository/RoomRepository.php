<?php
include_once '../interfaces/IRepository.php';
include_once '../object/Room.php';

class RoomRepository implements IRepository
{
    //database connection and table name
    private $conn;
    private $table_name = "rooms";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function find($id)
    {
        $query = "SELECT 
                r.id, r.name, r.building 
          FROM
            " . $this->table_name . " r
            LEFT JOIN 
                buildings b
                    ON r.building = b.id
            WHERE
                r.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $room = new Room();
        $room->setId($id);
        $room->setName($row["name"]);
        $room->setBuilding($row["building"]);
        return $room;
    }

    function findAll()
    {
        $query = "SELECT
                r.id, r.name, r.building
            FROM
                " . $this->table_name . " r
            LEFT JOIN 
                buildings b
                    ON r.building = b.id
                ORDER BY r.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $room_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $room = new Room();
            $room->setId($row["id"]);
            $room->setName($row["name"]);
            $room->setBuilding($row["building"]);
            $room_array [] = $room;
        }
        return array("count" => $stmt->rowCount(), "rooms" => $room_array);
    }

    function deleteOne($id)
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
     * @param Room $room
     * @return bool
     */
    function addNew($room)
    {
        $query = "INSERT
                INTO " . $this->table_name . "
                SET
                    name=:name, building=:building";
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $room->setName(htmlspecialchars(strip_tags($room->getName())));
        $room->setBuilding(htmlspecialchars(strip_tags($room->getBuilding())));

        //bind param
        $name = $room->getName();
        $building = $room->getBuilding();

        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":building",$building);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }
}