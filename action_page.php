<?php include "header.php"; ?>
<main>
    <!-- Dhanuja Ranawake part -->
    <br><br>
    <div style="margin-left: 20%;margin-right:20%">
        <!--<h5 style="text-align: center;"> Displaying the complexity of a program due to size</h5>--><br>
        <?php

        require 'codeSVM.php';
        require 'controlStructures.php';
        require 'codeVariable.php';
        require 'codeMethods.php';
        require 'inheritance.php';
        //file upload

        // Check if image file is a actual image or fake image
        if(isset($_POST['submit'])){
            $name       = $_FILES['file']['name'];
            $temp_name  = $_FILES['file']['tmp_name'];
            if(isset($name) and !empty($name)){
                $location = 'uploads/';
                if(move_uploaded_file($temp_name, $location.$name)){
                   echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                   echo 'File uploaded successfully';
                   echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                   echo '<span aria-hidden="true">&times;</span>';
                   echo '</button>';
                   echo '</div>';

                }
                /** @var TYPE_NAME $filepath */
                $filepath = 'uploads/' . $name;
                $code = file_get_contents($filepath);
            }
            /** @var TYPE_NAME $filepath */
            $filepath = 'uploads/'.$name;
            $code = file_get_contents($filepath);
        }


        //Getting the code
        //$code = $_POST['code'];

        //separating the lines
        $codes = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $code);
        $codes = explode("\n", $codes);

        //define arrays for size
        $cs = array_fill(1, sizeof($codes), 0);
        $nkw = array_fill(1, sizeof($codes), 0);
        $nid = array_fill(1, sizeof($codes), 0);
        $nop = array_fill(1, sizeof($codes), 0);
        $nnv = array_fill(1, sizeof($codes), 0);
        $nsl = array_fill(1, sizeof($codes), 0);

        //define arrays for variables
        $wvs = array_fill(1,sizeof($codes), 0);
        $npdtv = array_fill(1,sizeof($codes), 0);
        $npctv = array_fill(1,sizeof($codes), 0);
        $cv = array_fill(1,sizeof($codes), 0);
        $wpdtv = 1;
        $wpctv = 2;

        //define arrays for methods
        $wmrt = array_fill(1,sizeof($codes), 0);
        $npdtp = array_fill(1,sizeof($codes), 0);
        $ncdtp = array_fill(1,sizeof($codes), 0);
        $cm = array_fill(1,sizeof($codes), 0);
        $wpdtp = 1;
        $wcdtp = 2;

        //define arrays for control structures
        $ccs = array_fill(1, sizeof($codes), 0);
        $wtcs = array_fill(1, sizeof($codes), 0);
        $nc = array_fill(1, sizeof($codes), 0);
        $ccspps = array_fill(1, sizeof($codes), 0);

        //define arrays for inheritance
        $inhSize = substr_count($code,"class");
        $classname = array_fill(1,$inhSize,0);
        $ndi =  array_fill(1,$inhSize,0);
        $nidi =  array_fill(1,$inhSize,0);
        $ti =  array_fill(1,$inhSize,0);
        $ci =  array_fill(1,$inhSize,0);

        $TABLE_START = "<tr>";
        $TABLE_END = "</tr>";

        //Analysis
        sizeCal($codes);
        calCs();
        echo'<div class="accordion" id="accordionExample">
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
        echo'<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="heading3">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                          Complexity of a program due to Variables
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
        echo'<div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="heading4">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                          Complexity of a program due to Methods
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



        //heading for control structure table
  // echo "<h5 style=\"text-align: center;\"> Displaying the complexity of a program due to control structures</h5><br>";

            findControlStructure($codes);
            calCcs();
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
            //defining columns for the control structure table
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

            //inheritance begins
                inhcal($codes,$inhSize);
                calinh();
            echo ' <div class="accordion" id="accordionExample">
                <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                   <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                           Complexity of The Program Due Inheritance
                   </button>
                   </h2>
                </div>
          ';
            echo '<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">';
            //defining columns for the inheritance table
            echo "<table class=\"table table-bordered table-striped \">";
            echo "<thead class=\"thead-dark\">";
            echo $TABLE_START;
            echo "<th style='width: 7%' scope=\"col\">Count</th>";
            echo "<th scope=\"col\">Class Name</th>";
            echo "<th scope=\"col\">No of direct inheritances</th>";
            echo "<th scope=\"col\">No of indirect inheritances</th>";
            echo "<th scope=\"col\">Total inheritances</th>";
            echo "<th scope=\"col\">Ci</th>";
            echo $TABLE_END;
            echo "</thead>";


            for ($i = 1; $i <= $inhSize; $i++) {
                echo $TABLE_START;
                echo "<th scope= \"row\">$i</th>";
                echo "<td>$classname[$i]</td>";
                echo "<td>$ndi[$i]</td>";
                echo "<td>$nidi[$i]</td>";
                echo "<td>$ti[$i]</td>";
                echo "<td>$ci[$i]</td>";
                echo $TABLE_END;

            }
            echo "</table><br>";
            echo ' </div>
              </div>
             </div>
            </div>';

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
            //defining columns for the all factor table
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

            $lineno = 1;
            foreach ($codes as $line) {
                $tcps = $cs[$lineno] + $cv[$lineno] + $cm[$lineno] + $ccs[$lineno];
                echo $TABLE_START;
                echo "<th scope= \"row\">$lineno</th>";
                echo "<td>$line</td>";
                echo "<td>$cs[$lineno]</td>";
                echo "<td>$cv[$lineno]</td>";
                echo "<td>$cm[$lineno]</td>";
                echo "<td>$ccs[$lineno]</td>";
                echo "<td>$tcps</td>";
                echo $TABLE_END;
                $lineno++;
            }
            echo "</table><br>";
            echo ' </div>
              </div>
             </div>
            </div>';
            ?>
        </div>
    </main>
<?php include "footer.php"; ?>