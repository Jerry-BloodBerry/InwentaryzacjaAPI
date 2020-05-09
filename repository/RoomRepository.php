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

    function findAll()
    {
        $query = "CALL getRooms()";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        $rooms_array = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $building = new Building();
            $building->setId($row['building_id']);
            $building->setName($row['building_name']);

            $room = new Room();
            $room->setId($row['id']);
            $room->setName($row['name']);
            $room->setBuilding($building);

            $rooms_array [] = $room;
        }
        return array("count" => $stmt->rowCount(), "rooms" => $rooms_array);
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