<?php
include_once '../security/Security.php';
include_once '../interfaces/IService.php';
include_once '../security/BearerToken.php';

/**
 * Klasa odpowiadajaca za wszystkie zadania polegajace na dodaniu czegos do bazy danych, lub usunieciu
 */
class EditorService
{
    /**
     * Funkcja tworzaca (dodajaca) cos do bazy danych
     * @param $service - usluga zwiazana z tym czyms
     * @param $data - dane obiektu dodawanego do bazy danych
     */
    public static function Create(IService $service, $data)
    {
        if(!empty(BearerToken::getBearerToken())) {
            if(Security::authorizeUser(BearerToken::getBearerToken())) {
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
/**
 * Funkcja usuwajaca cos z bazy danych
 * @param $service - usluga zwiazana z tym czyms
 * @param $data - dane obiektu usuwanego z bazy danych
 */
    public static function Delete(IService $service, $data)
    {
        if(!empty(BearerToken::getBearerToken()) && !empty($data->id)) {
            if (Security::authorizeUser(BearerToken::getBearerToken())) {
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