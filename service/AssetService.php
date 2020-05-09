<?php
include_once '../repository/AssetRepository.php';
include_once '../config/Database.php';

class AssetService
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
     * @inheritDoc
     */
    static function addNew($data)
    {
        if(
            !empty($data->type)
        )
        {
            $asset = new Asset();
            $asset_type = new AssetType();
            $asset_type->setId($data->type);
            $asset->setAssetType($asset_type);

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
     * @inheritDoc
     */
    public static function deleteOneById($id)
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