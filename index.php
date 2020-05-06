<?php include "header.php"; ?>

<body>
<main style="margin-left: 20%;margin-right: 20%;"><br><br>
  <form action="action_page.php" id="form1" method="post" enctype="multipart/form-data" class="rounded border bg-light" style="padding: 4%">
      <br>
      <img src="images/upload-icon.png" class="rounded mx-auto d-block uploadicon" alt="...">
    <br>
      <br><div class="d-block" style="padding-left: 20%; padding-right: 20%; padding-bottom: 10%;">
          <p>
              <a class="btn btn-outline-primary" data-toggle="collapse" href="#collapseSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                  Advanced Settings
              </a>
          </p>
          <div class="collapse" id="collapseSettings">
              <div class="card card-body">
                  <div class="row">
                  <!--Size-->
                  <div class="col-4 bg-light border">
                      <div class="justify-content-md-center">
                          <h6 style="text-align: center; padding-top: 4px;">Size</h6>
                      </div>
                  <div class="row">
                     <div class="form-group col-6">
                         <label class="btn btn-secondary" for="Wkw" data-toggle="tooltip" data-placement="left" title="Weight due to keywords">Wkw</label>
                         <input type="number" class="form-control" id="Wkw" value="1">
                      </div>
                      <div class="form-group col-6">
                          <label class="btn btn-secondary" for="Wid" data-toggle="tooltip" data-placement="left" title="Weight due to identifiers">Wid</label>
                          <input type="number" class="form-control" id="Wid" value="1">
                      </div>
                      <div class="form-group col-6">
                          <label class="btn btn-secondary" for="Wop" data-toggle="tooltip" data-placement="left" title="Weight due to operators">Wop</label>
                          <input type="number" class="form-control" id="Wop" value="1">
                      </div>
                      <div class="form-group col-6">
                          <label class="btn btn-secondary" for="Wnv" data-toggle="tooltip" data-placement="left" title="Weight due to numerical values or numbers">Wnv</label>
                          <input type="number" class="form-control" id="Wnv" value="1">
                      </div>
                      <div class="form-group col-12">
                          <label class="btn btn-secondary" for="Wsl" data-toggle="tooltip" data-placement="left" title="Weight due to string literals">Wsl</label>
                          <input type="number" class="form-control" id="Wsl" value="1">
                      </div>
                  </div>
                  </div>
                  <!-- Variable-->
                  <div class="col-4 bg-light border">
                      <div class="justify-content-md-center">
                          <h6 style="text-align: center; padding-top: 4px;">Variable</h6>
                      </div>
                      <div class="row">
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wvs" data-toggle="tooltip" data-placement="left" title="Weight due to variable scope">Wvs</label>
                              <input type="number" class="form-control" id="Wvs" value="1">
                          </div>
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wpdtv" data-toggle="tooltip" data-placement="left" title="Weight of primitive data type variables">Wpdtv</label>
                              <input type="number" class="form-control" id="Wpdtv" value="1">
                          </div>
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wcdtv" data-toggle="tooltip" data-placement="left" title="Weight of composite data type variables">Wcdtv</label>
                              <input type="number" class="form-control" id="Wcdtv" value="1">
                          </div>
                      </div>
                  </div>
                  <!--method-->
                  <div class="col-4 bg-light border">
                      <div class="justify-content-md-center">
                          <h6 style="text-align: center; padding-top: 4px;">Methods</h6>
                      </div>
                      <div class="row">
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wmrt" data-toggle="tooltip" data-placement="left" title="Weight due to method return type">Wmrt</label>
                              <input type="number" class="form-control" id="Wmrt" value="1">
                          </div>
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wpdtp" data-toggle="tooltip" data-placement="left" title="Weight of primitive data type parameters">Wpdtp</label>
                              <input type="number" class="form-control" id="Wpdtp" value="1">
                          </div>
                          <div class="form-group col-12">
                              <label class="btn btn-secondary" for="Wcdtp" data-toggle="tooltip" data-placement="left" title="Weight of composite data type parameters">Wcdtp</label>
                              <input type="number" class="form-control" id="Wcdtp" value="1">
                          </div>
                      </div>
                  </div>
                  <!--inheritance-->
                      <div class="col-6 bg-light border">
                          <div class="justify-content-md-center">
                              <h6 style="text-align: center; padding-top: 4px;">Inheritance</h6>
                          </div>
                          <div class="row">
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wmrt" data-toggle="tooltip" data-placement="left" title="Weight due to method return type">Wmrt</label>
                                  <input type="number" class="form-control" id="Wmrt" value="1">
                              </div>
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wpdtp" data-toggle="tooltip" data-placement="left" title="Weight of primitive data type parameters">Wpdtp</label>
                                  <input type="number" class="form-control" id="Wpdtp" value="1">
                              </div>
                              <div class="form-group col-12">
                                  <label class="btn btn-secondary" for="Wcdtp" data-toggle="tooltip" data-placement="left" title="Weight of composite data type parameters">Wcdtp</label>
                                  <input type="number" class="form-control" id="Wcdtp" value="1">
                              </div>
                          </div>
                      </div>
                      <!--conrtol-->
                      <div class="col-6 bg-light border">
                          <div class="justify-content-md-center">
                              <h6 style="text-align: center; padding-top: 4px;">Control Structures</h6>
                          </div>
                          <div class="row">
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wmrt" data-toggle="tooltip" data-placement="left" title="Weight due to method return type">Wmrt</label>
                                  <input type="number" class="form-control" id="Wmrt" value="1">
                              </div>
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wpdtp" data-toggle="tooltip" data-placement="left" title="Weight of primitive data type parameters">Wpdtp</label>
                                  <input type="number" class="form-control" id="Wpdtp" value="1">
                              </div>
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wcdtp" data-toggle="tooltip" data-placement="left" title="Weight of composite data type parameters">Wcdtp</label>
                                  <input type="number" class="form-control" id="Wcdtp" value="1">
                              </div>
                              <div class="form-group col-6">
                                  <label class="btn btn-secondary" for="Wcdtp" data-toggle="tooltip" data-placement="left" title="Weight of composite data type parameters">Wcdtp</label>
                                  <input type="number" class="form-control" id="Wcdtp" value="1">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div><br>
      <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Upload</span>
      </div>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="file" id="file" required>
        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
      </div>
    </div>
    <script>
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>
    <input type="submit" name="submit" class="btn btn-primary " style="margin:0 auto; width: 100%;" value="Analyse">
      </div>
  </form>
</main><br><br>

</body>

<?php include "footer.php"; ?>
