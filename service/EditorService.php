<?php
include_once '../security/Security.php';
include_once '../interfaces/IService.php';

class EditorService
{
    public static function Create(IService $service, $data)
    {
        if(Security::performAuthorization())
        {
            $service::addNew($data);
        }
    }

    public static function Delete(IService $service, $data)
    {
        if(Security::performAuthorization())
        {
            $service::deleteOneById($data->id);
        }
    }
}