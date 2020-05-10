<?php
include_once '../config/Database.php';
include_once '../repository/ReportAssetRepository.php';

class ReportAssetService
{
    public static function getAssetsInRoom($room_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rar = new ReportAssetRepository($db);

        $room_assets = $rar->getAssetsInRoom($room_id);

        if(count($room_assets)>0)
        {
            //everything went OK, assets were found
            http_response_code(200);
            echo json_encode($room_assets);
        }
        else {
            http_response_code(404); // last report for room was not found
            echo json_encode(["message" => "Room with the given id does not exist in the database."]);
        }
    }

    public static function getAssetsInReport($report_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rar = new ReportAssetRepository($db);

        $report_assets = $rar->getAssetsInReport($report_id);
        $report_assets = $report_assets['report_assets'];

        if(count($report_assets)>0)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($report_assets);
        }
        else {
            http_response_code(404); // last report for room was not found
            echo json_encode(["message" => "Report with the given id does not exist in the database."]);
        }

    }
}