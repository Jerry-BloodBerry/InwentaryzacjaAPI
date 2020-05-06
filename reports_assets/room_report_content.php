<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../service/ReportAssetService.php';
include_once '../security/Security.php';
include_once '../security/BearerToken.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

if(!empty(BearerToken::getBearerToken())) {
    if(Security::authorizeUser(BearerToken::getBearerToken())) {
        ReportAssetService::getRoomsLastReportAssets($id);
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