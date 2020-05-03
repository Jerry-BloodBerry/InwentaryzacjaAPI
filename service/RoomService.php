<?php
include_once '../interfaces/IService.php';
include_once '../repository/RoomRepository.php';
include_once '../config/Database.php';
include_once '../object/Room.php';
/**
 * Klasa posrednia pomiedzy otrzymaniem danych a wstawieniem ich do bazy danych
 * Obsluguje wszystko zwiazane z pokojami
 */
class RoomService implements IService
{

    /**
     * Funkcja znajdujaca pokoj w bazie danych, po jego id
     * @param $id - id szukanego pokoju
     */
    static function findOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new RoomRepository($db);

        $room = $rr->find($id);

        if($room!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($room);
        }
        else {
            http_response_code(404); // asset was not found
            echo json_encode(["message" => "Room does not exist"]);
        }
    }

    /**
     * Funkcja znajdujaca wszystkie pokoje w bazie danych
     */
    static function findAll()
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new RoomRepository($db);

        $rooms = $rr->findAll();

        if($rooms['count']>0)
        {
            http_response_code(200);
            echo json_encode($rooms["rooms"]);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No rooms were found"));
        }
    }

    /**
     * Funkcja dodajaca nowy pokoj do bazy danych
     * @param $data - dane dodawanego pokoju
     */
    static function addNew($data)
    {
        if(!empty($data->name) && !empty($data->building))
        {
            $room = new Room();
            $room->setName($data->name);
            $room->setBuilding($data->building);

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