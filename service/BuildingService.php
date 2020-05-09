<?php
include_once '../interfaces/IService.php';
include_once '../object/Building.php';
include_once '../repository/BuildingRepository.php';
include_once '../config/Database.php';

class BuildingService implements IService
{
    /**
     * @inheritDoc
     */
    public static function findAllRooms($building_id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $rr = new BuildingRepository($db);

        $rooms = $rr->findAllRooms($building_id);

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
     * @inheritDoc
     */
    static function findOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $br = new BuildingRepository($db);

        $building = $br->find($id);

        if($building!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($building);
        }
        else {
            http_response_code(404); // asset was not found
            echo json_encode(["message" => "Building does not exist"]);
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
        $br = new BuildingRepository($db);

        $buildings = $br->findAll();

        if($buildings['count']>0)
        {
            http_response_code(200);
            echo json_encode($buildings["buildings"]);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No buildings were found"));
        }
    }

    /**
     * @inheritDoc
     */
    static function addNew($data)
    {
        if(!empty($data->name))
        {
            $building = new Building();
            $building->setName($data->name);

            //init database
            $database = new Database();
            $db = $database->getConnection();

            $br = new BuildingRepository($db);

            if($br->addNew($building))
            {
                http_response_code(201);
                echo json_encode(array("message" => "Building created successfully"));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create building. Service temporarily unavailable."));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create building. The data is incomplete."));
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
        $br = new BuildingRepository($db);

        if($br->deleteOne($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Building was deleted"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete building. Service temporarily unavailable."));
        }
    }
}