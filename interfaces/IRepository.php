<?php


interface IRepository
{
    /**
     * Funkcja wyszukuje element w bazie Repozytorium i go zwraca
     * @param $id - id szukanego elementu
     */
    function find($id);
    /**
     * Funkcja wyszukuje wszystkie elementy w bazie Repozytorium i je zwraca
     *
     */
    function findAll();
    /**
     * Funkcja usuwa element z bazy repozytorium
     *  @param $id - id usuwanego elementu
     */
    function deleteOne($id);
    /**
     * Funkcja dodaje element do bazy repozytorium
     * @param $object - element dodawany
     */
    function addNew($object);
}