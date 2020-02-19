<?php include "header.php"; ?>
<main>
<!-- Dhanuja Ranawake part -->
    <br><br>
    <div style="margin-left: 20%;margin-right:20%">
    <h5 style="text-align: center;"> Displaying the complexity of a program due to size</h5><br>
<?php
require 'codeSVM.php';
//Getting the code
$code = $_POST['code'];
//separating the lines
$codes = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $code);
$codes = explode("\n",$codes);

//define arrays
$cs = array_fill(1,sizeof($codes),0);
$nkw = array_fill(1,sizeof($codes),0);
$nid = array_fill(1,sizeof($codes),0);
$nop = array_fill(1,sizeof($codes),0);
$nnv = array_fill(1,sizeof($codes),0);
$nsl = array_fill(1,sizeof($codes),0);
//Analysis
sizeCal($codes);
calCs();
//Open the table and its first row
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo "<tr>";
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Nkw</th>";
echo "<th scope=\"col\">Nid</th>";
echo "<th scope=\"col\">Nop</th>";
echo "<th scope=\"col\">Nnv</th>";
echo "<th scope=\"col\">Nsl</th>";
echo "<th scope=\"col\">Cs</th>";
echo "</tr>";
echo "</thead>";

//Add empty <td>'s to even up the amount of cells in a row:
$lineno = 1;
foreach ($codes as $line){
    echo "<tr>";
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$nkw[$lineno]</td>";
    echo "<td>$nid[$lineno]</td>";
    echo "<td>$nop[$lineno]</td>";
    echo "<td>$nnv[$lineno]</td>";
    echo "<td>$nsl[$lineno]</td>";
    echo "<td>$cs[$lineno]</td>";
    echo "</tr>";
    $lineno++;
}

//Close the table row and the table
echo "</table>";?></div>
</main>