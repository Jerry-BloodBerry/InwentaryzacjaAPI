<?php
include_once '../service/ReportService.php';
include_once '../object/Report.php';
include_once '../object/ReportAsset.php';
include_once '../object/ReportHeader.php';
include_once '../object/Room.php';
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$report = null;
function AddStyle() :void
{
    $style =
        "<style>
            #container
            {
                text-align: center;
                display: inline-block;
            }
            .position
            {
                text-align: left;            
                margin-right: 10px;
                margin-left: 15px;
                font-size: 20px;             
            }     
        </style>";
    echo $style;
}
function Title(string $name, int $nr, string $room, $date)
{
    echo "<h4 style='text-align: right'>".$date->format('d-m-Y')."</h4>";
    echo "<h1 style='text-align: center'> Raport nr ".$nr."</h1>";
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
        ShowTableReportAssets($reportAsset);
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
    $ret = "id: ";
    $ret .= $asset->getAsset()->getAssetType()->getLetter();
    $ret .= $asset->getAsset()->getId();
    return $ret;
}
function GetAssetName(ReportAsset $asset) :string
{
    return $asset->getAsset()->getAssetType()->getName();
}
function IsMovedAsset(ReportAsset $asset) : string
{
    if ($asset->getMoved())
    {
        return "Tak";
    }
    else
        return "Nie";
}
function FromWhereMoved(ReportAsset $asset) :string
{
    if ($asset->getMoved())
    {
        return $asset->getPreviousRoom()->getName();
    }
    else
        return "-";
}
function ShowTableReportAssets(ReportAsset $reportAsset) :void
{
    echo "<tr>";
    echo "<td>";
    echo "<div class='position'>";
    echo GetAssetName($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo GetAssetLetter_Id($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo IsMovedAsset($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo FromWhereMoved($reportAsset);
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
function ShowTableHeader() :void
{
    echo "<tr>";
    echo "<td>";
    echo "<div class='position'>";
    echo "Przedmiot";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo "ID";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo "Przeniesiony?";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='position'>";
    echo "Gdzie przeniesiony?";
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
    $report->getReportHeader()->getRoom()->getName(), $report->getReportHeader()->getCreateDate());
Content($report);

$html2pdf = new Html2Pdf("P","A4","pl","UTF-8");
$html2pdf->setDefaultFont("freesans");
$html2pdf->writeHTML(ReturnCurrentHTML());
$html2pdf->output();



