<?php include "header.php"; ?>
    <main>
        <!-- Dhanuja Ranawake -->
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
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo 'File uploaded successfully';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';

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

                        for ($i =0; $i < $file_count; $i++){
                            global $i, $contents, $contentPath, $code, $file_count;

                            echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#Modal".$i."\"> " .$contents[$i]. "</button>"
                            ?>
                            <?php include "tablesPerFile.php"; ?>
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
                global $file_count,$contents,$total;
                $dataChart = null;
                for ($j = 0; $j < $file_count; $j++){
                    $myObj  = new \stdClass();
                    $myObj->name = $contents[$j];
                    $myObj->score = $total[$j];
                    $dataChart[$j] = $myObj;
                }

                $valueChart = json_encode($dataChart);
                global $valueChart;
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
                        backgroundColor: '#7B7979',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
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