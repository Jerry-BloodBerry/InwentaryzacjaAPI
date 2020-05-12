<?php
include_once '../repository/RoomRepository.php';
include_once '../config/Database.php';
include_once '../object/Room.php';
include_once '../object/Building.php';

/**
 * Klasa posrednia pomiedzy otrzymaniem danych a wstawieniem ich do bazy danych
 * Obsluguje wszystko zwiazane z pokojami
 */

class RoomService
{

    /**
     * Funkcja dodajaca nowy pokoj do bazy danych
     * @param $data - dane dodawanego pokoju
     */
    public static function addNew($data)
    {
        if(!empty($data->name) && !empty($data->building))
        {
            $room = new Room();
            $room->setName($data->name);

            $building = new Building();
            $building->setId($data->building);

            $room->setBuilding($building);

            //init database
            $database = new Database();
            $db = $database->getConnection();

            $rr = new RoomRepository($db);

            if($rr->addNew($room))
            {
                http_response_code(201);
                echo json_encode(array("message" => "Room created successfully"));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create room. Service temporarily unavailable."));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create room. The data is incomplete."));
        }
    }


    /**
     * Funkcja usuwajaca pokoj z bazy danych na podstawie jego id
     * @param $id - id usuwanego pokoju
     */
    static function deleteOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new RoomRepository($db);

        if($rr->deleteOne($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Room was deleted"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete room. Service temporarily unavailable."));
        }
    }

}