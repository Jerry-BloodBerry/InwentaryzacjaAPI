<?php
include_once '../config/Database.php';
include_once '../interfaces/IRepository.php';
include_once '../object/Asset.php';

class AssetRepository implements IRepository
{
    //database connection and table name
    private $conn;
    private $table_name = "assets";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function find($id)
    {
        $query = "SELECT 
                a.id, a.name, a.type_id 
          FROM
            " . $this->table_name . " a
            LEFT JOIN 
                asset_types ast
                    ON a.type_id = ast.id
            WHERE
                a.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);
        $asset = new Asset();
        $asset->setAssetType($row["type_id"]);
        $asset->setId($id);
        $asset->setName($row["name"]);

        return $asset;
    }

    function findOneBy($column_name)
    {
        // TODO: Implement findOneBy() method.
    }

    function findAll()
    {
        $query = "SELECT
                a.id, a.name, a.type_id
            FROM
                " . $this->table_name . " a
                LEFT JOIN
                    asset_types ast
                        ON a.type_id = ast.id
                ORDER BY a.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $asset_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $asset = new Asset();
            $asset->setId($row["id"]);
            $asset->setName($row["name"]);
            $asset->setAssetType($row["type_id"]);
            $asset_array [] = $asset;
        }
        return array("count" => $stmt->rowCount(), "assets" => $asset_array);
    }

    function findAllLike()
    {
        // TODO: Implement findAllLike() method.
    }
}