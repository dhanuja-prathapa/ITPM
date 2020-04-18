<?php include "header.php"; ?>
<main>
    <!-- Dhanuja Ranawake part -->
    <br><br>
    <div style="margin-left: 20%;margin-right:20%">
        <h5 style="text-align: center;"> Displaying the complexity of a program due to size</h5><br>
        <?php

        require 'codeSVM.php';
        require 'controlStructures.php';

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
            } else {
                echo '<div class="alert alert-danger" role="alert">';
                echo 'You should select a file to upload !!';
                echo '</div>';
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

        //define arrays
        $cs = array_fill(1, sizeof($codes), 0);
        $nkw = array_fill(1, sizeof($codes), 0);
        $nid = array_fill(1, sizeof($codes), 0);
        $nop = array_fill(1, sizeof($codes), 0);
        $nnv = array_fill(1, sizeof($codes), 0);
        $nsl = array_fill(1, sizeof($codes), 0);

        //define arrays for control structures
        $ccs = array_fill(1, sizeof($codes), 0);
        $wtcs = array_fill(1, sizeof($codes), 0);
        $nc = array_fill(1, sizeof($codes), 0);
        $ccspps = array_fill(1, sizeof($codes), 0);

        $TABLE_START = "<tr>";
        $TABLE_END = "</tr>";

        //Analysis
        sizeCal($codes);
        calCs();

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

        //heading for control structure table
        echo "<h5 style=\"text-align: center;\"> Displaying the complexity of a program due to control structures</h5><br>";

        findForLoops($codes);
        calCcs();

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
        ?>
    </div>
</main>
<?php include "footer.php"; ?>