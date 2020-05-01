<?php
include_once '../interfaces/IRepository.php';
include_once '../object/Report.php';
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
        $query = "SELECT 
                r.id, r.name, r.room, r.create_date, r.owner 
          FROM
            " . $this->table_name . " r
            WHERE
                r.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);

        //execute query
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) return null;

        $report = new Report();
        $report->setId($id);
        $report->setName($row["name"]);
        $report->setRoom($row["room"]);
        $report->setCreateDate($row["create_date"]);
        $report->setOwner($row["owner"]);
        return $report;
    }

    function findAll()
    {
        $query = "SELECT
                r.id, r.name, r.room, r.create_date, r.owner
            FROM
                " . $this->table_name . " r
                ORDER BY r.id";
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        $report_array = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $report = new Report();
            $report->setId($row["id"]);
            $report->setName($row["name"]);
            $report->setRoom($row["room"]);
            $report->setCreateDate($row["create_date"]);
            $report->setOwner($row["owner"]);
            $report_array [] = $report;
        }
        return array("count" => $stmt->rowCount(), "reports" => $report_array);
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
        /** @var Report $report */
        $report = $report_data['report'];
        $assets = $report_data['assets'];
        //sanitize data
        $report->setName(htmlspecialchars(strip_tags($report->getName())));
        $report->setRoom(htmlspecialchars(strip_tags($report->getRoom())));
        $this->setOwnerForReport($report);

        try {
            $date = $report->getCreateDate()->format('Y-m-d H:i:s');
            $this->conn->beginTransaction();
            $this->insertReport($report,$date);

            $last_report_id = $this->getLastReportId();
            $this->insertReportsAssets($assets,$report,$last_report_id);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->conn->rollBack();
            return false;
        }
    }

    private function setOwnerForReport($report)
    {
        $token = BearerToken::getBearerToken();
        $stmt = $this->conn->query("
        SELECT `user_id` FROM login_sessions
        WHERE `token` = '{$token}'
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $owner = $row['user_id'];
        $report->setOwner($owner);
    }

    private function getLastReportId()
    {
        $stmt = $this->conn->query("
            SELECT `id` FROM `{$this->table_name}` ORDER BY `id` DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    /**
     * @param array $assets
     * @param Report $report
     * @param integer $last_report_id
     */
    private function insertReportsAssets($assets, $report, $last_report_id)
    {
        foreach ($assets as $asset)
        {
            $asset->setPreviousRoom($report->getRoom());
            $asset->setReportId($last_report_id);
            $this->conn->exec("
                INSERT INTO `reports_assets`
                SET
                `report_id` = {$asset->getReportId()},
                `asset_id` = {$asset->getAssetId()},
                `previous_room` = {$asset->getPreviousRoom()} 
                ");
        }
    }
    private function insertReport($report, $date)
    {
        $this->conn->exec("
            INSERT INTO `{$this->table_name}` 
            SET 
            `name` = '{$report->getName()}', 
            `room` = {$report->getRoom()},
            `create_date` = '{$date}',
            `owner` = {$report->getOwner()}
            ");
    }
}