<?php
include_once '../interfaces/IService.php';
include_once '../security/Security.php';

class RetrieverService
{
    public static function RetrieveObject(IService $service, $id)
    {
        if(Security::performAuthorization())
        {
            $service::findOneById($id);
        }
    }

    public static function RetrieveAllObjects(IService $service)
    {
        if(Security::performAuthorization())
        {
            $service::findAll();
        }
    }
}