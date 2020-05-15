<?php


interface IService
{
    /**
     * Funkcja wyszukuje pojedynczy element w bazie i go zwraca
     * @param $id - integer - id szukanego elementu
     * @return mixed - zwraca element z bazy o podanym id
     */
    static function findOneById($id);

    /**
     * Funkcja wyszukuje wszystkie elementy w bazie i je zwraca
     * @return mixed - zwraca wszystkie elementy z bazy
     */
    static function findAll();

    /**
     * Funkcja dodaje pojedynczy element do bazy
     * @param $data - typ zaleznie od tego co implementuje interfejs, zwykle array - dane elementu dodawanego
     */
    static function addNew($data);

    /**
     * Funkcja usuwa pojedynczy element z bazy
     *  @param $id - integer - id usuwanego elementu
     */
    static function deleteOneById($id);
}