<?php
include_once '../interfaces/IService.php';
include_once '../object/AssetType.php';
include_once '../config/Database.php';
include_once '../repository/AssetTypeRepository.php';

/**
 * Klasa zarzadzajaca srodkami trwalymi
 * 
 */
class AssetTypeService implements IService
{

    /**
     * Funkcja znajduje element (srodek trwaly) w bazie po jego id
     * @param $id - id szukanego elementu w bazie
     */
    static function findOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $atr = new AssetTypeRepository($db);

        $room = $atr->find($id);

        if($room!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($room);
        }
        else {
            http_response_code(404); // asset was not found
            echo json_encode(["message" => "Asset type does not exist"]);
        }
    }

    /**
    * Funkcja wyszukujaca wszystkie elementy (srodki trwale) w bazie
    */
    static function findAll()
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $astr = new AssetTypeRepository($db);

        $asset_types = $astr->findAll();

        if($asset_types['count']>0)
        {
            http_response_code(200);
            echo json_encode($asset_types["asset_types"]);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No asset types were found"));
        }
    }

    /**
     * Funkcja dodajaca nowy srodek trwaly do bazy
     * @param $data - dane nowego elementu
     */
    static function addNew($data)
    {
        if(!empty($data->letter) && !empty($data->name))
        {
            $asset_type = new AssetType();
            $asset_type->setName($data->name);
            $asset_type->setLetter($data->letter);

            //init database
            $database = new Database();
            $db = $database->getConnection();

            $astr = new AssetTypeRepository($db);

            if($astr->addNew($asset_type))
            {
                http_response_code(201);
                echo json_encode(array("message" => "Asset type created successfully"));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create asset type. Service temporarily unavailable."));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create asset type. The data is incomplete."));
        }
    }

    /**
     * Funkcja usuwajaca srodek trwaly po jego id
     * @param $id - id srodka trwalego
     */
    static function deleteOneById($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance
        $astr = new AssetTypeRepository($db);

        if($astr->deleteOne($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Asset type was deleted"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete asset type. Service temporarily unavailable."));
        }
    }
}