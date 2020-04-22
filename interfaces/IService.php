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
     * @param object $object
     * @return void
     */
    static function addNew($object);

    /**
     * @param integer $id
     * @return void
     */
    static function deleteOneById($id);
}