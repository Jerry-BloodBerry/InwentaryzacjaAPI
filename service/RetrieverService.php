<?php
include_once '../security/BearerToken.php';
include_once '../interfaces/IService.php';
include_once '../security/Security.php';

class RetrieverService
{
    public static function RetrieveObject(IService $service, $id)
    {
        if(!empty(BearerToken::getBearerToken())) {
            if(Security::authorizeUser(BearerToken::getBearerToken())) {
                $service::findOneById($id);
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

    }

    public static function RetrieveAllObjects(IService $service)
    {
        if(!empty(BearerToken::getBearerToken())) {
            if(Security::authorizeUser(BearerToken::getBearerToken())) {
                $service::findAll();
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

    }
}