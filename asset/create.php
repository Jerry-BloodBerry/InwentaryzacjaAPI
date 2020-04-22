<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../service/AssetService.php';
include_once '../security/Security.php';

//get posted data
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->token)) {
    if(Security::authorizeUser(htmlspecialchars(strip_tags($data->token)))) {
        AssetService::addNew($data);
    }
    else {
        http_response_code(503);
        echo json_encode(array("message" => "User authentication failed. Invalid or expired token", "auth" => false));
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Authentication failed. Auth token missing.", "auth" => false));
}