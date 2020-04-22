<?php


interface IRepository
{
    function find($id);
    function findAll();
    function deleteOne($id);
    function addNew($object);
}