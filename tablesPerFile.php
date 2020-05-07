<?php
global $i,$contents, $contentPath, $code;

echo "<div class=\"modal fade\" id=\"Modal" .$i."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalLabel".$i."\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"ModalLabel".$i."\">".$contents[$i]."</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">";

$code = file_get_contents($contentPath[$i]);
$codes = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $code);
$codes = explode("\n", $codes);

//define arrays for size
$cs = array_fill(1, sizeof($codes), 0);
$nkw = array_fill(1, sizeof($codes), 0);
$nid = array_fill(1, sizeof($codes), 0);
$nop = array_fill(1, sizeof($codes), 0);
$nnv = array_fill(1, sizeof($codes), 0);
$nsl = array_fill(1, sizeof($codes), 0);
$wkw = $_POST["Wkw"];
$wid = $_POST["Wid"];
$wop = $_POST["Wop"];
$wnv = $_POST["Wnv"];
$wsl = $_POST["Wsl"];
//configured weights for control structures
$wif = $_POST["Wif"];
$wfw = $_POST["Wfw"];
$wswt = $_POST["Wswt"];
$wcase = $_POST["Wcase"];

//define arrays for variables
$wvs = array_fill(1, sizeof($codes), 0);
$npdtv = array_fill(1, sizeof($codes), 0);
$npctv = array_fill(1, sizeof($codes), 0);
$cv = array_fill(1, sizeof($codes), 0);
$wpdtv = $_POST["Wpdtv"];
$wcdtv = $_POST["Wcdtv"];

//define arrays for methods
$wmrt = array_fill(1, sizeof($codes), 0);
$npdtp = array_fill(1, sizeof($codes), 0);
$ncdtp = array_fill(1, sizeof($codes), 0);
$cm = array_fill(1, sizeof($codes), 0);
$wpdtp = $_POST["Wpdtp"];
$wcdtp = $_POST["Wcdtp"];

//define arrays for control structures
$ccs = array_fill(1, sizeof($codes), 0);
$wtcs = array_fill(1, sizeof($codes), 0);
$nc = array_fill(1, sizeof($codes), 0);
$ccspps = array_fill(1, sizeof($codes), 0);

//define arrays for inheritance
$inhSize = substr_count($code, "class");
$classname = array_fill(1, $inhSize, 0);
$ndi = array_fill(1, $inhSize, 0);
$nidi = array_fill(1, $inhSize, 0);
$ti = array_fill(1, $inhSize, 0);
$ci = array_fill(1, $inhSize, 0);

$TABLE_START = "<tr>";
$TABLE_END = "</tr>";

//Analysis
sizeCal($codes);
calCs();
echo '<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Complexity of The Program Due To Size
                   </button>
                   </h2>
                </div>';
echo '<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">';
//Open the table and its first row
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo $TABLE_START;
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Nkw</th>";
echo "<th scope=\"col\">Nid</th>";
echo "<th scope=\"col\">Nop</th>";
echo "<th scope=\"col\">Nnv</th>";
echo "<th scope=\"col\">Nsl</th>";
echo "<th scope=\"col\">Cs</th>";
echo $TABLE_END;
echo "</thead>";

//Add empty <td>'s to even up the amount of cells in a row:
$lineno = 1;
foreach ($codes as $line) {
    echo $TABLE_START;
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$nkw[$lineno]</td>";
    echo "<td>$nid[$lineno]</td>";
    echo "<td>$nop[$lineno]</td>";
    echo "<td>$nnv[$lineno]</td>";
    echo "<td>$nsl[$lineno]</td>";
    echo "<td>$cs[$lineno]</td>";
    echo $TABLE_END;
    $lineno++;
}

//Close the table row and the table
echo "</table><br>";
echo ' </div>
              </div>
             </div>
            </div>';

//heading for variables
varCal($codes);
calCv();
echo '<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="heading3">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                          Complexity of The Program Due to Variables
                   </button>
                   </h2>
                </div>';
echo '<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
      <div class="card-body">';
//Open the table and its first row
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo $TABLE_START;
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Wvs</th>";
echo "<th scope=\"col\">Npdtv</th>";
echo "<th scope=\"col\">Npcdtv</th>";
echo "<th scope=\"col\">Cv</th>";
echo $TABLE_END;
echo "</thead>";

//Add empty <td>'s to even up the amount of cells in a row:
$lineno = 1;
foreach ($codes as $line) {
    echo $TABLE_START;
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$wvs[$lineno]</td>";
    echo "<td>$npdtv[$lineno]</td>";
    echo "<td>$npctv[$lineno]</td>";
    echo "<td>$cv[$lineno]</td>";
    echo $TABLE_END;
    $lineno++;
}

//Close the table row and the table
echo "</table><br>";
echo ' </div>
              </div>
             </div>
            </div>';

//heading for methods
methCal($codes);
calCm();
echo '<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="heading4">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                          Complexity of The Program Due to Methods
                   </button>
                   </h2>
                </div>';
echo '<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
      <div class="card-body">';
//Open the table and its first row
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo $TABLE_START;
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Wmrt</th>";
echo "<th scope=\"col\">Npdtp</th>";
echo "<th scope=\"col\">Ncdtp</th>";
echo "<th scope=\"col\">Cm</th>";
echo $TABLE_END;
echo "</thead>";

//Add empty <td>'s to even up the amount of cells in a row:
$lineno = 1;
foreach ($codes as $line) {
    echo $TABLE_START;
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$wmrt[$lineno]</td>";
    echo "<td>$npdtp[$lineno]</td>";
    echo "<td>$ncdtp[$lineno]</td>";
    echo "<td>$cm[$lineno]</td>";
    echo $TABLE_END;
    $lineno++;
}

//Close the table row and the table
echo "</table><br>";
echo ' </div>
              </div>
             </div>
            </div>';


//Control structures function calls
findControlStructure($codes);
calCcs();
//Control structure section table creation start
echo '<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                           Complexity of The Program Due To Control Structures
                   </button>
                   </h2>
                </div>';
echo '<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">';

//Defining columns for the control structure table
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo $TABLE_START;
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Wtcs</th>";
echo "<th scope=\"col\">NC</th>";
echo "<th scope=\"col\">Ccspps</th>";
echo "<th scope=\"col\">Ccs</th>";
echo $TABLE_END;
echo "</thead>";

//Table data inserting loop
$lineno = 1;
foreach ($codes as $line) {
    echo $TABLE_START;
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$wtcs[$lineno]</td>";
    echo "<td>$nc[$lineno]</td>";
    echo "<td>$ccspps[$lineno]</td>";
    echo "<td>$ccs[$lineno]</td>";
    echo $TABLE_END;
    $lineno++;
}
echo "</table><br>";
echo ' </div>
               </div>
               </div>
               </div>';

//Complexity due to all factors table
echo ' <div class="accordion" id="accordionExample">
                <div class="card">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                           Complexity of The Program Due To All Factors
                   </button>
                   </h2>
                </div>
          ';
echo '<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">';

//Defining columns for the all factor table
echo "<table class=\"table table-bordered table-striped \">";
echo "<thead class=\"thead-dark\">";
echo $TABLE_START;
echo "<th style='width: 7%' scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Cs</th>";
echo "<th scope=\"col\">Cv</th>";
echo "<th scope=\"col\">Cm</th>";
echo "<th scope=\"col\">Ccs</th>";
echo "<th scope=\"col\">TCps</th>";
echo $TABLE_END;
echo "</thead>";

//Inserting values to all factor table
$lineno = 1;
$tcps = array_fill(1,sizeof($codes),0);
global $tcps;
foreach ($codes as $line) {
    $tcps[$lineno] = $cs[$lineno] + $cv[$lineno] + $cm[$lineno] + $ccs[$lineno];
    echo $TABLE_START;
    echo "<th scope= \"row\">$lineno</th>";
    echo "<td>$line</td>";
    echo "<td>$cs[$lineno]</td>";
    echo "<td>$cv[$lineno]</td>";
    echo "<td>$cm[$lineno]</td>";
    echo "<td>$ccs[$lineno]</td>";
    echo "<td>$tcps[$lineno]</td>";
    echo $TABLE_END;
    $lineno++;
}


//calculating the total value
global $file_count;
$total = array_fill(0,$file_count,0);
$lineno=1;
foreach ($codes as $line){
    global $total;
    $total[$i] += $tcps[$lineno];
    $lineno++;
}

echo "</table><br>";
echo ' </div>
              </div>
             </div>
            </div>';




echo "</div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
      </div>
    </div>
  </div>
</div>";
?>