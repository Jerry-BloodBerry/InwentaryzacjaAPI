<?php
include_once '../service/AssetService.php';

$id = isset($_GET['id']) ? $_GET['id'] : die();

AssetService::findOneById($id);