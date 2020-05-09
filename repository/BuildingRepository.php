<?php
include_once '../interfaces/IRepository.php';
include_once '../object/Building.php';
include_once '../object/Room.php';

class BuildingRepository implements IRepository
{
    //database connection and table name
    /**
     * @var PDO
     */
    private $conn;
    private $table_name = "buildings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function findAllRooms($building_id)
    {
        $query = "CALL getRooms(?)";
        $stmt = $this->conn->prepare($query);

        //sanitize
        $building_id = htmlspecialchars(strip_tags($building_id));

        $stmt->bindParam(1,$building_id);

        //execute query
        $stmt->execute();
        $room_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $room = new Room();
            $room->setId($row["id"]);
            $room->setName($row["name"]);

            $building = new Building();
            $building->setId($row["building_id"]);
            $building->setName($row['building_name']);

            $room->setBuilding($building);
            $room_array [] = $room;
        }
        return array("count" => $stmt->rowCount(), "rooms" => $room_array);
    }

    function find($id)
    {
        $query = "SELECT 
                b.id, b.name 
          FROM
            " . $this->table_name . " b
            WHERE
                b.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $building = new Building();
        $building->setId($id);
        $building->setName($row["name"]);

        return $building;
    }

    function findAll()
    {
        $query = "CALL getBuildings()";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        $building_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $building = new Building();
            $building->setId($row['id']);
            $building->setName($row['name']);
            $building_array [] = $building;
        }
        return array("count" => $stmt->rowCount(), "buildings" => $building_array);
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
     * @param Building $building
     * @return bool
     */
    function addNew($building)
    {
        $query = "CALL addBuilding(:name)";
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $building->setName(htmlspecialchars(strip_tags($building->getName())));

        //bind param
        $name = $building->getName();

        $stmt->bindParam(":name",$name);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }
}