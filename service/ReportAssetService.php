<?php
include_once '../config/Database.php';
include_once '../repository/ReportAssetRepository.php';

class ReportAssetService
{
    public static function getRoomsLastReportAssets($room_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rar = new ReportAssetRepository($db);

        $report_assets = $rar->getRoomsLastReportAssets($room_id);

        if($report_assets!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($report_assets);
        }
        else {
            http_response_code(404); // last report for room was not found
            echo json_encode(["message" => "Report for this room does not exist in the database."]);
        }
    }

    public static function getLastRoomForAsset($asset_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rar = new ReportAssetRepository($db);

        $previous_room = $rar->getLastRoomForAsset($asset_id);

        if($previous_room!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($previous_room);
        }
        else {
            http_response_code(404); // last report for room was not found
            echo json_encode(["message" => "Previous room for this asset does not exist or is null"]);
        }
    }
}