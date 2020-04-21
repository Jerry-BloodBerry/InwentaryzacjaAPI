<?php


interface IRepository
{
    function find($id);
    function findOneBy($column_name);
    function findAll();
    function findAllLike();
}