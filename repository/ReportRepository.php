<?php
include_once '../interfaces/IRepository.php';
include_once '../object/ReportHeader.php';
include_once '../config/Database.php';
include_once '../security/BearerToken.php';

class ReportRepository implements IRepository
{
    //database connection and table name
    /**
     * @var PDO
     */
    private $conn;
    private $table_name = "reports";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function find($id)
    {
        $query = "CALL getReportHeader(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        return self::prepareReport($row);
    }

    function findAll()
    {
        $query = "CALL getLoginSession(?)";
        $stmt = $this->conn->prepare($query);

        $token = BearerToken::getBearerToken();
        $stmt->bindParam(1,$token);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user_id = $row['user_id'];

        $query = "CALL getReportsHeaders(?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$user_id);

        //execute query
        $stmt->execute();
        $report_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $report_array [] = self::prepareReport($row);
        }
        return $report_array;
    }

    function deleteOne($id)
    {
        $query = "DELETE
                FROM " . $this->table_name . "
                WHERE id = ?";
        //prepare_query
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $id = htmlspecialchars(strip_tags($id));

        //bind parameter
        $stmt->bindParam(1,$id);

        if($stmt->execute() && $stmt->rowCount()>0)
        {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $report_data
     * @return bool
     */
    function addNew($report_data)
    {
        /** @var ReportHeader $report */
        $report = $report_data['report'];
        $assets = $report_data['assets'];
        //sanitize data
        $report->setName(htmlspecialchars(strip_tags($report->getName())));
        $report->setRoomId(htmlspecialchars(strip_tags($report->getRoomId())));
        $this->setOwnerForReport($report);

        $query = "CALL addNewReport(:name,:room,:owner,:positions)";
        $stmt = $this->conn->prepare($query);

        $name = $report->getName();
        $room = $report->getRoomId();
        $owner = $report->getOwnerId();
        $assets = json_encode($assets);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':room', $room);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':positions', $assets);

        $stmt->execute();
        return true;
    }

    private function setOwnerForReport(ReportHeader $report)
    {
        $token = BearerToken::getBearerToken();
        $stmt = $this->conn->query("
        SELECT `user_id` FROM login_sessions
        WHERE `token` = '{$token}'
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $owner = $row['user_id'];
        $report->setOwnerId($owner);
    }

    private static function prepareReport($row)
    {
        $report = new ReportHeader();
        $report->setId($row["id"]);
        $report->setName($row["name"]);
        try {
            $report->setCreateDate(new DateTime($row["create_date"]));
        } catch (Exception $e) {
            echo 'Exception thrown while setting CreateDate in ReportRepository on line 134: ' . $e->getMessage();
        }
        $report->setOwnerId($row["owner_id"]);
        $report->setOwnerName($row['owner_name']);
        $report->setRoomName($row['room_name']);
        $report->setBuildingName($row['building_name']);

        return $report;
    }
}