<?php
include_once '../security/Security.php';
include_once '../interfaces/IService.php';

/**
 * Klasa odpowiadajaca za wszystkie zadania polegajace na dodaniu czegos do bazy danych, lub usunieciu
 */
class EditorService
{
    /**
     * Funkcja prosi repozytorium aby stworzylo/dodalo cos do bazy
     * @param $service - usluga zwiazana z tym czyms, okresla co chce dodac
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
     * Funkcja prosi repozytorium aby odpytalo baze, czy zawiera w sobie element o danym id.
     * Jeżeli zawiera, to repozytorium usuwa z bazy danych ten element.
     * @param $service - usluga zwiazana z tym czyms, okresla co chce usunac
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