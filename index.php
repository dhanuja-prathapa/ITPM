<?php include "header.php"; ?>

<body>
<main style="margin-left: 20%;margin-right: 20%;"><br><br>
  <form action="action_page.php" id="form1" method="post" enctype="multipart/form-data" class="rounded" style="padding: 4%;background-color: #f5f5f5">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Upload</span>
      </div>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="file" id="file">
        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
      </div>
    </div>
    <script>
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>
    <input type="submit" name="submit" class="btn btn-primary" value="Analyse">
    <button type="reset" class="btn btn-secondary">Clear</button>
  </form>
</main><br><br>

</body>

<?php include "footer.php"; ?>
