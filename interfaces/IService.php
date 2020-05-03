<?php


interface IService
{
    /**
     * Funkcja wyszukuje element w bazie Repozytorium i go zwraca
     * @param $id - id szukanego elementu
     */
    static function findOneById($id);

    /**
     * Funkcja wyszukuje wszystkie elementy w bazie Repozytorium i je zwraca
     *
     */
    static function findAll();

    /**
     * Funkcja dodaje element do bazy repozytorium
     * @param $data - dane elementu dodawanego
     */
    static function addNew($data);

    /**
     * Funkcja usuwa element z bazy repozytorium
     *  @param $id - id usuwanego elementu
     */
    static function deleteOneById($id);
}