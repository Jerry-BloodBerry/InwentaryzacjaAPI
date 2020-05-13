<?php
include_once '../interfaces/IService.php';
include_once '../security/Security.php';

/**
 * Klasa obslugujaca zadania GET
 */
class RetrieverService
{
    /**
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * Jeżeli zawiera, to repozytorium zwraca z bazy danych ten element (typ w zaleznosci od uslugi),
     * funkcja zwraca go jako json.
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
     * Funkcja prosi repozytorium aby odpytalo baze, o wszystkie elementy.
     * Repozytorium zwraca funkcji wszystkie obiekty (typ na podstawie uslugi), a funkcja zwraca je jako json.
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