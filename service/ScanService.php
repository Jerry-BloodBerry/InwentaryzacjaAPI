<?php
include_once '../repository/ScanRepository.php';
include_once '../repository/UserRepository.php';

class ScanService
{
    public static function getScans()
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // create a repository instance

        $ur = new UserRepository($db);
        $user = $ur->findCurrentUser();

        $sr = new ScanRepository($db);
        $response = $sr->getScans($user->getId());

        if(!is_string($response))
        {
            http_response_code(200);
            echo json_encode($response);
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("message" => $response));
        }
    }

    static function addNew($data)
    {
        if(!empty($data->room))
        {
            //init database
            $database = new Database();
            $db = $database->getConnection();

            $sr = new ScanRepository($db);

            $ur = new UserRepository($db);
            $user = $ur->findCurrentUser();

            $resp = $sr->addScan($data->room, $user->getId());

            if($resp['id']!=null)
            {
                $id = (int)$resp['id'];
                http_response_code(201);
                echo json_encode(array("message" => "Zapis został utworzony.", "id" => $id));
            }
            else if($resp['message']!=null)
            {
                http_response_code(409);
                echo json_encode(array("message" => $resp['message'], "id"=> null));
            }
            else
            {
                http_response_code(503);
                echo json_encode(array("message" => "Niepowodzenie. Usługa chwilowo niedostępna.", "id" => null));
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(array("message" => "Niepowodzenie. Przekazano niekompletne dane."));
        }
    }

    public static function deleteOne($id)
    {
        //init database
        $database = new Database();
        $db = $database->getConnection();

        $sr = new ScanRepository($db);
        if($sr->deleteScan($id))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Skan został usunięty."));
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Niepowodzenie. Usługa chwilowo niedostępna."));
        }
    }

    public static function updateScan($data)
    {
        if(!empty($data->id) && !empty($data->positions)) {
            $positions = $data->positions;
            foreach ($positions as $position) {
                if (empty($position->asset) || empty($position->state)) {
                    http_response_code(400);
                    echo json_encode(array("message" => "Niepowodzenie. Przekazano niekompletne dane."));
                    exit();
                }
            }
        }

        //init database
        $database = new Database();
        $db = $database->getConnection();

        $sr = new ScanRepository($db);
        if($sr->updateScan($data->id, $data->positions))
        {
            http_response_code(200);
            echo json_encode(array("message" => "Skan został zaktualizowany."));
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Niepowodzenie. Usługa chwilowo niedostępna."));
        }
    }
}