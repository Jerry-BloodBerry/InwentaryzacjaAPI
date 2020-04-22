<?php


interface IService
{
    /**
     * @param $id
     * @return void
     */
    static function findOneById($id);

    /**
     * @return void
     */
    static function findAll();

    /**
     * @param array $data
     * @return void
     */
    static function addNew($data);

    /**
     * @param integer $id
     * @return void
     */
    static function deleteOneById($id);
}