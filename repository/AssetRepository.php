<?php
include_once '../config/Database.php';
include_once '../object/Asset.php';
include_once '../object/Room.php';
include_once '../object/AssetType.php';
include_once '../object/Building.php';

class AssetRepository
{
    //database connection and table name
    /**
     * @var PDO
     */
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
        $query = "CALL getAssetInfo(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        return self::CreateAssetInfo($row);
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

        if($stmt->execute() && $stmt->rowCount()>0)
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
        $query = "CALL addNewAsset(:type_id)";
        $stmt = $this->conn->prepare($query);

        //bind params
        $type = htmlspecialchars(strip_tags($asset->getAssetType()->getId()));

        $stmt->bindParam(":type_id",$type);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    private static function CreateAssetInfo($row)
    {
        $asset = new Asset();
        $asset_type = new AssetType();
        $building = new Building();
        $room = new Room();


        $asset->setId($row['id']);

        $asset_type->setId($row['type']);
        $asset_type->setName($row['asset_type_name']);

        $room->setId($row['room_id']);
        $room->setName($row['room_name']);

        $building->setName($row['building_name']);

        $asset->setAssetType($asset_type);
        $asset->setRoom($room);
        $asset->setBuilding($building);

        return $asset;
    }
}