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

    /**
     * @param integer $id
     * @return Asset
     */
    function find($id)
    {
        $query = "SELECT 
                a.id, a.name, a.asset_type 
          FROM
            " . $this->table_name . " a
            LEFT JOIN 
                asset_types ast
                    ON a.asset_type = ast.id
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
        if(!$row) return null;

        $asset = new Asset();
        $asset->setAssetType($row["asset_type"]);
        $asset->setId($id);
        $asset->setName($row["name"]);

        return $asset;
    }

    /**
     * @return array
     */
    function findAll()
    {
        $query = "SELECT
                a.id, a.name, a.asset_type
            FROM
                " . $this->table_name . " a
                LEFT JOIN
                    asset_types ast
                        ON a.asset_type = ast.id
                ORDER BY a.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $asset_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $asset = new Asset();
            $asset->setId($row["id"]);
            $asset->setName($row["name"]);
            $asset->setAssetType($row["asset_type"]);
            $asset_array [] = $asset;
        }
        return array("count" => $stmt->rowCount(), "assets" => $asset_array);
    }

    /**
     * @param integer $id
     * @return bool
     */
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

        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    /**
     * @param Asset $asset
     * @return bool
     */
    function addNew($asset)
    {
        $query = "INSERT
                INTO " . $this->table_name . "
                SET
                    name=:name, asset_type=:type_id";
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $asset->setName(htmlspecialchars(strip_tags($asset->getName())));
        $asset->setAssetType(htmlspecialchars(strip_tags($asset->getAssetType())));

        //bind params
        $name = $asset->getName();
        $type = $asset->getAssetType();

        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":type_id",$type);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }
}