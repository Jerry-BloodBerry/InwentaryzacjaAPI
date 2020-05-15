<?php
include_once '../interfaces/IService.php';
include_once '../object/ReportHeader.php';
include_once '../config/Database.php';
include_once '../repository/ReportRepository.php';
include_once '../object/ReportAsset.php';
include_once '../repository/ReportAssetRepository.php';
include_once '../object/Report.php';

/**
 * Klasa posrednia pomiedzy otrzymaniem danych a wstawieniem ich do bazy danych
 */
class ReportService implements IService
{
    /**
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * Jeżeli zawiera, to repozytorium zwraca funkcji obiekt (raport), a funkcja zwraca go jako json
     * @param integer $id id szukanego raportu
     * @return mixed|void - zwraca raport jezeli jest w bazie
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
     * Funkcja prosi repozytorium aby odpytalo baze, o wszystkie elementy.
     * Repozytorium zwraca funkcji wszystkie obiekty (raporty), a funkcja zwraca je jako json
     * @return mixed|void - zwraca wszystkie raporty
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
     * Funkcja prosi repozytorium aby dodalo nowy raport na podstawie jego danych do bazy
     * @param array $data dane dodawanego raportu
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
            $resp = $rr->addNew($report_data);
            if($resp['id']!=null)
            {
                $id = (int)$resp['id'];
                http_response_code(201);
                echo json_encode(array("message" => "ReportHeader created successfully", "id" => $id));
            }
            else if($resp['message']!=null)
            {
                http_response_code(503);
                echo json_encode(array("message" => $resp['message'], "id"=> null));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create report. Service fatal error.", "id" => null));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create report. The data is incomplete."));
        }
    }

    /**
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * Jeżeli zawiera, to repozytorium usuwa z bazy danych ten element (raport).
     * @param integer $id id usuwanego raportu
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

    static function getFullReportData($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new ReportRepository($db);

        $report_header = $rr->find($id);
        if($report_header!=null)
        {
            $rar = new ReportAssetRepository($db);
            $positions = $rar->getPositionsInReport($id);
            return new Report($report_header,$positions);
        }
        else {
            return null;
        }
    }
}