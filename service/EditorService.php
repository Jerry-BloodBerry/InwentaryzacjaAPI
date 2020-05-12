<?php
include_once '../security/Security.php';
include_once '../interfaces/IService.php';

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
        if(Security::performAuthorization())
        {
            $service::addNew($data);
        }
    }
/**
 * Funkcja usuwajaca cos z bazy danych
 * @param $service - usluga zwiazana z tym czyms
 * @param $data - dane obiektu usuwanego z bazy danych
 */
    public static function Delete(IService $service, $data)
    {
        if(Security::performAuthorization())
        {
            $service::deleteOneById($data->id);
        }
    }
}