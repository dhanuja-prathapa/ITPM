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

                //chart
                global $total, $i, $contents;

            }

            ?>
        </div>
    </main>
<?php include "footer.php"; ?>