<?php
include_once '../service/ReportService.php';
include_once '../object/Report.php';
include_once '../object/ReportAsset.php';
include_once '../object/ReportHeader.php';
include_once '../object/Room.php';
require '../vendor/autoload.php';

use MongoDB\Driver\Command;
use Spipu\Html2Pdf\Html2Pdf;

$report = null;
function AddStyle() :void
{
    $style =
        "<style>
            table
            {
            border-collapse: collapse;
            }
            tr
            {
            }            
            td
            {
            border: solid 1px #000000;
            }
            #container
            {               
                display: inline-block;
            }
            .item
            {
                text-align: center;            
                margin-right: 10px;
                margin-left: 15px;
                font-size: 20px;    
                width: 90px; 
            }             
            .id
            {
                text-align: center;            
                margin-right: 10px;
                margin-left: 15px;
                font-size: 20px;    
                width: 45px; 
            }             
            .status
            {
                text-align: center;            
                margin-right: 10px;
                margin-left: 15px;
                font-size: 20px;    
                width: 450px; 
            }             
            .room
            {
                text-align: center;            
                margin-right: 10px;
                margin-left: 15px;
                font-size: 20px;    
                width: 65px; 
            }     
        </style>";
    echo $style;
}
function Title(string $name, int $nr, string $building, string $room, $date)
{
    echo "<h4 style='text-align: right'>".$date->format('d-m-Y')."</h4>";
    echo "<h1 style='text-align: center'> Raport nr ".$nr."</h1>";
    echo "<h2 style='text-align: center'> Budynek: ".$building."</h2>";
    echo "<h2 style='text-align: center'> Sala: ".$room."</h2>";
    echo "<BR><BR><BR>";
}
function Content(Report $report) :void
{
    echo "<div id='container'>";
    echo "<table>";
    ShowTableHeader();
    foreach ($report->getReportAssets() as $reportAsset)
    {
        ShowTableReportAssets($reportAsset, $report->getReportHeader()->getRoom());
    }
    echo "</table>";
    echo "</div>";

}
function ReturnCurrentHTML()
{
    return ob_get_clean();
}
function CheckIfReportExists(int $id) : bool
{
    $report = ReportService::getFullReportData($id);
    if ($report == null)
    {
        return false;
    }
    else
        return true;
}
function GetAssetLetter_Id(ReportAsset $asset) :string
{
    $ret = "";
    $ret .= $asset->getAsset()->getAssetType()->getLetter();
    $ret .= $asset->getAsset()->getId();
    return $ret;
}
function GetAssetName(ReportAsset $asset) :string
{
    return $asset->getAsset()->getAssetType()->getName();
}
function StatusOfItem(ReportAsset $asset, $aRoom) : int
{
    if ($asset->getPresent())
    {
        if($asset->getPreviousRoom() == null)
        {
            return -3;
        }
        else if($asset->getPreviousRoom() == $aRoom)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    else
    {
        if ($asset->getPreviousRoom() == $aRoom)
        {
            return -1;
        }
        else
        {
            return -2;
        }
    }

}
function InformationOfItemStatus(int $status) :string
{
    switch ($status)
    {
        case 0:
            return "-";
        case 1:
            return "Przeniesiono z innego miejsca";
        case -1:
            return "Przeniesiono do magazynu";
        case -2:
            return "Pojawił się podczas skanowania w innym pokoju";
        case -3:
            return "Nowy środek";
    }
}
function ShowStatusOfItem(ReportAsset $asset, Room $aRoom) :string
{
    return InformationOfItemStatus(StatusOfItem($asset, $aRoom));
}
function FromWhereMoved(int $status, $room) :string
{
    if($status == 1)
    {
        return $room->getName();
    }
    else
    {
        return '-';
    }
}
function GetBuildingName(Report $report) :string
{
    $room = $report->getReportHeader()->getRoom()->getId();
    $dataBase = new PDO("mysql:host=localhost.inwentaryzacja.com; dbname=inwentaryzacja_db", "root", "");
    $quarry = "Select buildings.name From buildings JOIN rooms ON rooms.building = buildings.id WHERE rooms.id=".$room;
    $line = $dataBase->query($quarry);
    foreach ($line as $value)
    {
        return $value[0];
    }
}
function ShowTableReportAssets(ReportAsset $reportAsset, Room $aRoom) :void
{
    echo "<tr>";
    echo "<td>";
    echo "<div class='item'>";
    echo GetAssetName($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='id'>";
    echo GetAssetLetter_Id($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='status'>";
    echo ShowStatusOfItem($reportAsset, $aRoom);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='room'>";
    echo FromWhereMoved(StatusOfItem($reportAsset, $aRoom), $reportAsset->getPreviousRoom());
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
function ShowTableHeader() :void
{
    echo "<tr>";
    echo "<td>";
    echo "<div class='item'>";
    echo "Przedmiot";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='id'>";
    echo "ID";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='status'>";
    echo "Status";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='room'>";
    echo "Miejsce";
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}

if (isset($_GET["id"]))
{
    $reportID = $_GET["id"];
    if (CheckIfReportExists($reportID))
    {
        $report = ReportService::getFullReportData($reportID);
    }
    else
    {
        echo "Id: ".$reportID." is invaild!!!";
        exit();
    }
}
else
{
    echo "No Id given!";
    exit();
}
AddStyle();
Title($report->getReportHeader()->getName(), $report->getReportHeader()->getId(),
    GetBuildingName($report),
    $report->getReportHeader()->getRoom()->getName(),
    $report->getReportHeader()->getCreateDate());
Content($report);

$html2pdf = new Html2Pdf("P","A4","pl","UTF-8");
$html2pdf->setDefaultFont("freesans");
$html2pdf->writeHTML(ReturnCurrentHTML());
$html2pdf->output();


