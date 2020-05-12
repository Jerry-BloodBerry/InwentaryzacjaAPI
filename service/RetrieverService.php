<?php
include_once '../interfaces/IService.php';
include_once '../security/Security.php';

/**
 * Klasa obslugujaca zadania GET
 */
class RetrieverService
{
    /**
     * Funkcja zwracajaca dany obiekt
     * @param $service - usluga do obiektu, okresla co chce zwrocic
     * @param $id - id zwracanego obiektu
     */
    public static function RetrieveObject(IService $service, $id)
    {
        if(Security::performAuthorization())
        {
            $service::findOneById($id);
        }
    }
    /**
     * Funkcja zwracajaca wszystkie obiekty
     * @param $service - usluga do obiektu, okresla co chce zwrocic
     */
    public static function RetrieveAllObjects(IService $service)
    {
        if(Security::performAuthorization())
        {
            $service::findAll();
        }
    }
}