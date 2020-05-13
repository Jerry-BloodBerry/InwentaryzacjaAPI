<?php
include_once '../config/Database.php';
include_once '../repository/ReportAssetRepository.php';

/**
 * Klasa odpowiadajaca za obsluge rzeczy zwiazanych z raportami srodkow trwalych
 * 
 */
class ReportAssetService
{
    /**
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * (srodki trwale w pokoju na podstawie ostatniego raportu)
     * Jeżeli zawiera, to repozytorium zwraca funkcji obiekt (srodki trwale), a funkcja zwraca go jako json.
     * @param $room_id - (integer) id pokoju ktory jest sprawdzany
     */

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
    /**
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * (Sprawdza pozycje (srodki trwale) raportu na podstawie jego id)
     * Jeżeli zawiera, to repozytorium zwraca funkcji obiekt (srodki trwale z raportu), a funkcja zwraca go jako json
     * @param $report_id - (integer) id raportu
     */
    public static function getPositionsInReport($report_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rar = new ReportAssetRepository($db);

        $report_assets = $rar->getPositionsInReport($report_id);

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