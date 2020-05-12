<?php
include_once '../object/Room.php';

class RoomRepository
{
    //database connection
    /**
     * @var PDO
     */
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param Room $room
     * @return bool
     */
    function addNew($room)
    {
        $query = "CALL addRoom(:name,:building)";
        $stmt = $this->conn->prepare($query);

        //bind param
        $name = $room->getName();
        $building = $room->getBuilding()->getId();

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