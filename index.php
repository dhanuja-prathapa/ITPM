<?php include "header.php"; ?>
<style>
    ::-webkit-file-upload-button {
        cursor: pointer;
    }

    input[type=file] {
        cursor: pointer;
    }
</style>

<body>
<main style="margin-left: 20%;margin-right: 20%;"><br><br>
    <!-- form initialization -->
    <form action="action_page.php" id="form1" method="post" enctype="multipart/form-data"
          class="rounded border bg-light" style="padding: 4%">
        <h5 class="mx-auto d-block uploadicon" style="text-align: center; font-weight: bold"> TIEVS HOME PAGE </h5>
        <br>
        <img src="images/upload-icon.png" class="rounded mx-auto d-block uploadicon" alt="...">
        <br>
        <br>
        <!-- Manual weight configuration collapse section -->
        <div class="d-block" style="padding-left: 20%; padding-right: 20%; padding-bottom: 10%;">
            <p>
                <a class="btn btn-outline-primary" data-toggle="collapse" href="#collapseSettings" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Configure Component Weights
                </a>
            </p>
            <div class="collapse" id="collapseSettings">
                <div class="card card-body">
                    <div class="row">

                        <!-- Manual declaration of weight for size-->
                        <div class="col-4 bg-light border">
                            <div class="justify-content-md-center">
                                <h6 style="text-align: center; padding-top: 4px;">Size</h6>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wkw" data-toggle="tooltip"
                                           data-placement="left" title="Weight due to keywords">Wkw</label>
                                    <input type="number" class="form-control" name="Wkw" id="Wkw" value="1">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wid" data-toggle="tooltip"
                                           data-placement="left" title="Weight due to identifiers">Wid</label>
                                    <input type="number" class="form-control" name="Wid" id="Wid" value="1">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wop" data-toggle="tooltip"
                                           data-placement="left" title="Weight due to operators">Wop</label>
                                    <input type="number" class="form-control" name="Wop" id="Wop" value="1">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wnv" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight due to numerical values or numbers">Wnv</label>
                                    <input type="number" class="form-control" name="Wnv" id="Wnv" value="1">
                                </div>
                                <div class="form-group col-12">
                                    <label class="btn btn-secondary" for="Wsl" data-toggle="tooltip"
                                           data-placement="left" title="Weight due to string literals">Wsl</label>
                                    <input type="number" class="form-control" name="Wsl" id="Wsl" value="1">
                                </div>
                            </div>
                        </div>

                        <!-- Manual declaration of weight for variables-->
                        <div class="col-4 bg-light border">
                            <div class="justify-content-md-center">
                                <h6 style="text-align: center; padding-top: 4px;">Variable</h6>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="btn btn-secondary" for="Wpdtv" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight of primitive data type variables">Wpdtv</label>
                                    <input type="number" class="form-control" name="Wpdtv" id="Wpdtv" value="1">
                                </div>
                                <div class="form-group col-12">
                                    <label class="btn btn-secondary" for="Wcdtv" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight of composite data type variables">Wcdtv</label>
                                    <input type="number" class="form-control" name="Wcdtv" id="Wcdtv" value="2">
                                </div>
                            </div>
                        </div>

                        <!-- Manual declaration of weights for methods-->
                        <div class="col-4 bg-light border">
                            <div class="justify-content-md-center">
                                <h6 style="text-align: center; padding-top: 4px;">Methods</h6>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="btn btn-secondary" for="Wpdtp" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight of primitive data type parameters">Wpdtp</label>
                                    <input type="number" class="form-control" name="Wpdtp" id="Wpdtp" value="1">
                                </div>
                                <div class="form-group col-12">
                                    <label class="btn btn-secondary" for="Wcdtp" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight of composite data type parameters">Wcdtp</label>
                                    <input type="number" class="form-control" name="Wcdtp" id="Wcdtp" value="2">
                                </div>
                            </div>
                        </div>

                        <!-- Manual declaration of weight for control structures-->
                        <div class="col-12 bg-light border">
                            <div class="justify-content-md-center">
                                <h6 style="text-align: center; padding-top: 4px;">Control Structures</h6>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wif" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight related to if or else if">Wif</label>
                                    <input type="number" class="form-control" name="Wif" id="Wif" value="2">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wfw" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight related to for, while or do while loops">Wfw</label>
                                    <input type="number" class="form-control" name="Wfw" id="Wfw" value="3">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wswt" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight related to 'switch' in switch statement">Wswt</label>
                                    <input type="number" class="form-control" name="Wswt" id="Wswt" value="2">
                                </div>
                                <div class="form-group col-6">
                                    <label class="btn btn-secondary" for="Wcase" data-toggle="tooltip"
                                           data-placement="left"
                                           title="Weight related to 'case' in switch statement">Wcase</label>
                                    <input type="number" class="form-control" name="Wcase" id="Wcase" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Upload section of Folder or File by choosing from local PC-->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">File/Folder</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input " name="file" id="file" required>
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <!-- Javascript code for selecting file from pc -->
            <script>
                $(".custom-file-input").on("change", function () {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            </script>
            <!--Analyse button -->
            <input type="submit" name="submit" class="btn btn-primary " style="margin:0 auto; width: 100%;"
                   value="Analyse">
        </div>
    </form>
</main>
<br><br>

</body>

<?php include "footer.php"; ?>
