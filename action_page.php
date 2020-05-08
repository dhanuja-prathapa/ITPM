<?php include "header.php"; ?>
    <main>
        <br><br>
        <div class="container">
            <?php

            require 'codeSVM.php';
            require 'controlStructures.php';
            require 'codeVariable.php';
            require 'codeMethods.php';

            //file upload
            // Check if image file is a actual image or fake image
            if (isset($_POST['submit'])) {
                $name = $_FILES['file']['name'];
                $temp_name = $_FILES['file']['tmp_name'];
                if (isset($name) and !empty($name)) {
                    $location = 'uploads/';
                    if (move_uploaded_file($temp_name, $location . $name)) {
                        echo '<div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">';
                        echo 'File uploaded successfully';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div><script>
                                    window.setTimeout(function () { 
                                        $("#success-alert").alert(\'close\'); 
                                    }, 2000);
                               </script>';

                    }
                    /** @var TYPE_NAME $filepath */
                    $extension = pathinfo($name,PATHINFO_EXTENSION);
                    $zipname = pathinfo($name,PATHINFO_FILENAME)."/";

                    $filepath = 'uploads/' . $name;
                    if ($extension == 'zip') {
                        $zip = new ZipArchive();
                        $zip->open($filepath,ZipArchive::CREATE);
                        $file_count = $zip->count();

                        $contents = array_fill(0,$file_count,0);
                        $contentPath = array_fill(0,$file_count,0);

                        $extractPath = "uploads/" . $zipname;
                        $zip->extractTo($extractPath);

                        for ($i = 0; $i < $file_count; $i++){

                            $contents[$i] = $zip->getNameIndex($i);
                            $contentPath[$i] = $extractPath.$contents[$i];
                        }
                        $zip->close();

                        $total = array_fill(0,$file_count,0);

                        for ($i =0; $i < $file_count; $i++){
                            global $i, $contents, $contentPath, $code, $file_count;

                            echo "<button type=\"button\" class=\"btn btn-secondary\" style='margin-right:2px; margin-bottom:2px;' data-toggle=\"modal\" data-target=\"#Modal".$i."\"> " .$contents[$i]. "</button>"
                            ?>
                            <?php include "tablesPerFile.php"; ?>
                            <?php include "pdf/tablesToPDF.php"; ?>
                           <?php

                        }

                    }else{
                        /* Normal File */
                        global $code;
                        $code= file_get_contents($filepath);
                        ?>
                        <?php include "onefileTable.php"; ?>
                        <?php
                    }
                }
                echo "<a class='btn badge-info' style=\"float:right\" href=\"pdf/report.php\">Report</a>";
                global $file_count,$contents,$total;
                $totalPC = 0;

                for($r = 0; $r < sizeof($total); $r++){
                    $totalPC += $total[$r];
                }
                echo "<br><br><h6 class='mx-auto p-3' style='font-size: x-large;text-align: center; background-color: #961c1c;color: white;'>Total Program Complexity = <span class=\"badge badge-light\">" .$totalPC. " </span></h6>" ;
                $dataChart = null;
                for ($j = 0; $j < $file_count; $j++){
                    $myObj  = new \stdClass();
                    $myObj->name = $contents[$j];
                    $myObj->score = $total[$j];
                    $dataChart[$j] = $myObj;
                }
                $valueChart = json_encode($dataChart);
                global $valueChart;
                echo "<h6 class='mx-auto p-3 text-uppercase' style='max-width:400px; font-weight: bold'>Complexities of The Uploaded Files</h6>";
               echo "<div class=\"chart-container\">
  <canvas id=\"bar-chartcanvas\"></canvas>
</div>

<!-- javascript to run ChartJS with SQL data (JS to generate chart must come AFTER canvas HTML) -->
<script>
$(document).ready(function () {
    showTotalGraph();
});

function showTotalGraph(){{
    // This is the database.php file we created earlier, its JSON output will be processed in this function
    
          var dataString =  '$valueChart';       
            var data = JSON.parse(dataString);
            console.log(data);
            // Declare the variables for your graph (for X and Y Axis)
            var nameVar = []; // X Axis Label
            var total = []; // Value and Y Axis basis

            for (var i in data) {
                // formStatus is taken from JSON output (see above)
                nameVar.push(data[i].name);
                total.push(data[i].score);
            }
            console.log(nameVar);
            var options = {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: true
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            var chartdata = {
                labels: nameVar,
                datasets: [
                    {
                        label: 'Total',
                        backgroundColor: 'rgba(0,0,255,0.3)',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: 'rgba(0,0,255,0.5)',
                        hoverBorderColor: '#666666',
                        data: total
                    }
                ]
            };

            //This is the div ID (within the HTML content) where you want to display the chart
            var graphTarget = $(\"#bar-chartcanvas\");
            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                options: options
            });
        
}}
</script>


";
            }

            ?>
        </div>
    </main>
<?php include "footer.php"; ?>