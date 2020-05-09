<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../service/AssetService.php';
include_once '../security/Security.php';

// get passed json data
$data = json_decode(file_get_contents("php://input"));

if(empty($data->id))
{
    http_response_code(404);
    echo json_encode(array("message" => "Unable to delete asset. Id was not provided"));
    exit();
}

if(Security::performAuthorization())
{
    AssetService::deleteOneById($data->id);
}