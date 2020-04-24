<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type application/json; charset=UTF-8");
include_once '../service/AssetService.php';
include_once '../service/RetrieverService.php';

RetrieverService::RetrieveAllObjects(new AssetService());