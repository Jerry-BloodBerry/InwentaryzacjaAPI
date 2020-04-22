<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type application/json; charset=UTF-8");
include_once '../service/RoomService.php';

RoomService::findAll();