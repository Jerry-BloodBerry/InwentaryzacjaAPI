<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../service/BuildingService.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

BuildingService::findOneById($id);