<?php
include_once '../security/Security.php';
include_once '../interfaces/IService.php';

class EditorService
{
    public static function Create(IService $service, $data)
    {
        if(!empty($data->token)) {
            if(Security::authorizeUser(htmlspecialchars(strip_tags($data->token)))) {
                $service::addNew($data);
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

    public static function Delete(IService $service, $data)
    {
        if(!empty($data->token) && !empty($data->id)) {
            if (Security::authorizeUser(htmlspecialchars(strip_tags($data->token)))) {
                $service::deleteOneById($data->id);
            }
            else {
                http_response_code(503);
                echo json_encode(array("message" => "User authentication failed. Invalid or expired token", "auth" => false));
            }
        }
        else {
            http_response_code(400);
            echo json_encode(array("message" => "Authentication failed. Auth token and/or id missing.", "auth" => false));
        }
    }
}