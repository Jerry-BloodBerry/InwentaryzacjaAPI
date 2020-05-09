<?php
include_once '../repository/RoomRepository.php';
include_once '../config/Database.php';
include_once '../object/Room.php';

class RoomService
{
    /**
     * @inheritDoc
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

    public static function findAll()
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
}