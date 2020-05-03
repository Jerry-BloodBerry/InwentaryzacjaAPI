<?php
include_once '../repository/AssetRepository.php';
include_once '../interfaces/IService.php';
include_once '../config/Database.php';

/**
 * Klasa zarzadzajaca srodkami trwalymi
 * 
 */
class AssetService implements IService
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
        $ar = new AssetRepository($db);

        $asset = $ar->find($id);

        if($asset!=null)
        {
            //everything went OK, asset was found
            http_response_code(200);
            echo json_encode($asset);
        }
        else {
            http_response_code(404); // asset was not found
            echo json_encode(["message" => "Asset does not exist"]);
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
        $ar = new AssetRepository($db);

        $assets = $ar->findAll();

        if($assets['count']>0)
        {
            http_response_code(200);
            echo json_encode($assets["assets"]);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No assets were found"));
        }
    }

    /**
     * Funkcja dodajaca nowy srodek trwaly do bazy
     * @param $data - dane nowego elementu
     */
    static function addNew($data)
    {
        if(
            !empty($data->name) &&
            !empty($data->asset_type)
        )
        {
            $asset = new Asset();
            $asset->setName($data->name);
            $asset->setAssetType($data->asset_type);

            //init database
            $database = new Database();
            $db = $database->getConnection();

            $ar = new AssetRepository($db);

            if($ar->addNew($asset))
            {
                http_response_code(201);
                echo json_encode(array("message" => "Asset created successfully"));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create asset. Service temporarily unavailable."));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create asset. The data is incomplete."));
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
        $ar = new AssetRepository($db);

        if($ar->deleteOne($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Asset was deleted"));
        }
        else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete asset. Service temporarily unavailable."));
        }
    }
}