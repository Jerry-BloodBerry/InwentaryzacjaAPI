<?php
include_once '../interfaces/IService.php';
include_once '../object/ReportHeader.php';
include_once '../config/Database.php';
include_once '../repository/ReportRepository.php';
include_once '../object/ReportAsset.php';

class ReportService implements IService
{
    /**
     * @inheritDoc
     */
    static function findOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new ReportRepository($db);

        $report = $rr->find($id);

        if($report!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($report);
        }
        else {
            http_response_code(404); // asset was not found
            echo json_encode(["message" => "ReportHeader does not exist"]);
        }
    }

    /**
     * @inheritDoc
     */
    static function findAll()
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new ReportRepository($db);

        $reports = $rr->findAll();

        if(count($reports)>0)
        {
            http_response_code(200);
            echo json_encode($reports);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No reports were found"));
        }
    }

    /**
     * @inheritDoc
     */
    static function addNew($data)
    {
        if(
            !empty($data->name)&&
            !empty($data->room)&&
            !empty($data->assets))
        {
            $assets = $data->assets;
            foreach ($data->assets as $asset)
            {
                if(empty($asset->id) || empty($asset->present)) {
                    http_response_code(400);
                    echo json_encode(array("message" => "Unable to create report. The data is incomplete."));
                    exit();
                }
            }
            $report = new ReportHeader();
            $room = new Room();
            $room->setId($data->room);

            $report->setName($data->name);
            $report->setRoom($room);
            $report->setCreateDate(new DateTime('now'));

            //init database
            $database = new Database();
            $db = $database->getConnection();

            $rr = new ReportRepository($db);
            $report_data = [
                'report' => $report,
                'assets' => $assets
            ];
            if($rr->addNew($report_data))
            {
                http_response_code(201);
                echo json_encode(array("message" => "ReportHeader created successfully"));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create report. Service temporarily unavailable."));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create report. The data is incomplete."));
        }
    }

    /**
     * @inheritDoc
     */
    static function deleteOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new ReportRepository($db);

        if($rr->deleteOne($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "ReportHeader was deleted"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete report. Service temporarily unavailable."));
        }
    }
}