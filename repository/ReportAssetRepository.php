<?php
include_once '../object/ReportAsset.php';

class ReportAssetRepository
{
    //database connection and table name
    private $conn;
    private $table_name = "reports_assets";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getRoomsLastReportAssets($room_id)
    {
        $query = "SELECT id
                FROM reports 
                WHERE room = ?
                ORDER BY id DESC
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$room_id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $report_id = $row['id'];

        $query = "SELECT asset_id, previous_room
                FROM " . $this->table_name . "
                WHERE report_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$report_id);

        //execute query
        $stmt->execute();
        $report_assets = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $report_asset = new ReportAsset();
            $report_asset->setReportId($report_id);
            $report_asset->setAssetId($row["asset_id"]);
            $report_asset->setPreviousRoom($row["previous_room"]);
            $report_assets [] = $report_asset;
        }
        return array("count" => $stmt->rowCount(), "report_assets" => $report_assets);
    }

    public function getLastRoomForAsset($asset_id)
    {
        $query = "SELECT previous_room
                FROM " . $this->table_name . "
                WHERE asset_id = ?
                ORDER BY report_id DESC
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$asset_id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        return $row['previous_room'];
    }

}