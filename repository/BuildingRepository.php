<?php
include_once '../interfaces/IRepository.php';
include_once '../object/Building.php';

class BuildingRepository implements IRepository
{
    //database connection and table name
    private $conn;
    private $table_name = "buildings";

    public function __construct($db)
    {
        $this->conn = $db;
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
        $query = "SELECT
                b.id, b.name
            FROM
                " . $this->table_name . " b
                ORDER BY b.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $building_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $building = new Building();
            $building->setId($row["id"]);
            $building->setName($row["name"]);
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
        $query = "INSERT
                INTO " . $this->table_name . "
                SET
                    name=:name";
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