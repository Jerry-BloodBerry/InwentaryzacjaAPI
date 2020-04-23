<?php
include_once '../interfaces/IRepository.php';
include_once '../object/Report.php';
include_once '../config/Database.php';

class ReportRepository implements IRepository
{
    //database connection and table name
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
     * @param Report $report
     * @return bool
     */
    function addNew($report)
    {
        $query = "INSERT
                INTO " . $this->table_name . "
                SET
                    name=:name, room=:room, create_date=:create_date, owner=:owner";
        $stmt = $this->conn->prepare($query);

        //sanitize data
        $report->setName(htmlspecialchars(strip_tags($report->getName())));
        $report->setRoom(htmlspecialchars(strip_tags($report->getRoom())));
        $report->setCreateDate(htmlspecialchars(strip_tags($report->getCreateDate())));
        $report->setOwner(htmlspecialchars(strip_tags($report->getOwner())));

        //bind param
        $name = $report->getName();
        $room = $report->getRoom();
        $create_date = $report->getCreateDate();
        $owner = $report->getOwner();

        $stmt->bindParam(":name",$name);
        $stmt->bindParam(":room",$room);
        $stmt->bindParam(":create_date",$create_date);
        $stmt->bindParam(":owner",$owner);

        //execute query
        if($stmt->execute())
        {
            return true;
        }
        return false;
    }
}