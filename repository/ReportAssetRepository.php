<?php
include_once '../object/ReportAsset.php';

class ReportAssetRepository
{
    //database connection and table name
    /**
     * @var PDO
     */
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAssetsInRoom($room_id)
    {
        $query = "CALL getAssetsInRoom(?)";
        $stmt = $this->conn->prepare($query);

        //sanitize
        $room_id = htmlspecialchars(strip_tags($room_id));

        $stmt->bindParam(1,$room_id);

        //execute query
        $stmt->execute();

        $room_assets = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $room_assets [] = self::createRoomAsset($row);
        }
        return $room_assets;
    }

    public function getAssetsInReport($report_id)
    {
        $query = "CALL getAssetsInReport(?)";

        $stmt = $this->conn->prepare($query);

        //sanitize
        $report_id = (int) htmlspecialchars(strip_tags($report_id));
        //bind param
        $stmt->bindParam(1,$report_id);
        //execute query
        $stmt->execute();

        $report_assets = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $report_assets [] = self::createReportAsset($row);
        }
        return array("report_assets" => $report_assets);
    }

    private static function createRoomAsset($row)
    {
        $room_asset = new ReportAsset();
        $room_asset->setId($row['id']);
        $room_asset->setType($row['type']);
        $room_asset->setAssetTypeName($row['asset_type_name']);
        $room_asset->setNewAsset($row['new_asset']);
        $room_asset->setMoved($row['moved']);
        $room_asset->setMovedFromId($row['moved_from_id']);
        $room_asset->setMovedFromName($row['moved_from_name']);

        return $room_asset;
    }

    private static function createReportAsset($row)
    {
        $report_asset = new ReportAsset();
        $report_asset->setId($row['asset_id']);
        $report_asset->setPreviousRoom($row['previous_room']);
        $report_asset->setPresent($row['present']);
        $report_asset->setType($row['asset_type']);
        $report_asset->setAssetTypeName($row['asset_type_name']);

        return $report_asset;
    }

}