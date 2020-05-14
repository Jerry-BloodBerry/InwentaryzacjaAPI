<?php
include_once '../service/ReportService.php';
include_once '../object/Report.php';
include_once '../object/ReportAsset.php';
include_once '../object/ReportHeader.php';
include_once '../object/Room.php';
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$reportID = $_GET["id"];
$report = null;

function Title(string $name, int $nr, string $room, $date)
{
    echo "<h4 style='text-align: right'>".$date->format('d-m-Y')."</h4>";
    echo "<h1 style='text-align: center'> Raport nr ".$nr."</h1>";
    echo "<h2 style='text-align: center'> Sala: ".$room."</h2>";
}
function ReturnCurrentHTML()
{
    return ob_get_clean();
}
function CheckIfReportExists(int $id) : bool
{
    $report = ReportService::getFullReportData(6);
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
        return $asset->getMovedFromRoom()->getName();
    }
    else
        return "-";
}
function ShowTableReportAssets(ReportAsset $reportAsset) :void
{
    echo "<tr>";
    echo "<td>";
    echo GetAssetName($reportAsset);
    echo "</td>";
    echo "<td>";
    echo GetAssetLetter_Id($reportAsset);
    echo "</td>";
    echo "<td>";
    echo IsMovedAsset($reportAsset);
    echo "</td>";
    echo "<td>";
    echo FromWhereMoved($reportAsset);
    echo "</td>";
    echo "</tr>";
}
function ShowTableHeader() :void
{
    echo "<tr>";
    echo "<td>";
    echo "Przedmiot";
    echo "</td>";
    echo "<td>";
    echo "ID";
    echo "</td>";
    echo "<td>";
    echo "Przeniesiony?";
    echo "</td>";
    echo "<td>";
    echo "Gdzie przeniesiony?";
    echo "</td>";
    echo "</tr>";
}
function Content(Report $report) :void
{
    echo "<table>";
    ShowTableHeader();
    foreach ($report->getReportAssets() as $reportAsset)
    {
        ShowTableReportAssets($reportAsset);
    }
    echo "</table>";
}
$report = ReportService::getFullReportData($reportID);
if (empty($repotID))
{
    if (CheckIfReportExists($reportID))
    {
        $report = ReportService::getFullReportData(6);
    }
    else
    {
        echo "Id: ".$reportID."is invaild!!!";
        exit();
    }
}
else
{
    echo "No Id given!";
    exit();
}

Title($report->getReportHeader()->getName(), $report->getReportHeader()->getId(),
    $report->getReportHeader()->getRoom()->getName(), $report->getReportHeader()->getCreateDate());
Content($report);

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML(ReturnCurrentHTML());
$html2pdf->output();



