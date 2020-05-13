<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

//Strona

function Title(string $name, int $nr, string $sala, string $data)
{
    echo "<h4 style='text-align: right'>".$data."</h4>";
    echo "<h1 style='text-align: center'> Raport nr ".$nr."</h1>";
    echo "<h2 style='text-align: center'> Sala: ".$sala."</h2>";
}

function Content($tab)
{
    echo "<table>";
    echo "<tr>";
    echo  "<td>1</td>";
    echo  "<td>2</td>";
    echo  "<td>3</td>";
    echo  "<td>4</td>";
    echo "</tr>";

    echo "<tr>";
    echo  "<td>1</td>";
    echo  "<td>2</td>";
    echo  "<td>3</td>";
    echo  "<td>4</td>";
    echo "</tr>";

    foreach ($tab as $item)
    {
        
    }
    
    echo "</table>";
}
$tablica = array(1,2,3,4,5,6,7,8,9,10);
Title("test", 14, "3/35", "28.10.2019");
Content($tablica);
function ReturnCurrentHTML()
{
    return ob_get_clean();
}


$html2pdf = new Html2Pdf();
$html2pdf->writeHTML(ReturnCurrentHTML());
$html2pdf->output();



