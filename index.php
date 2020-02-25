<?php include "header.php"; ?>
<main style="margin-left: 20%;margin-right: 20%;"><br><br>
<form action="action_page.php" id="form1" method="post" class="rounded" style="padding: 4%;background-color: #f5f5f5">
    <h2>Paste the Code Here</h2>
    <div class="form-group">
    <textarea class="form-control border border-secondary rounded" name="code" style="width: 100%" rows="15"></textarea><br>
    </div>
    <div class="box__input">
    <input class="box__file" type="file" name="files[]" id="file" data-multiple-caption="{count} files selected" multiple />
    <label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
    <button class="box__button" type="submit">Upload</button>
  </div>
  <div class="box__uploading">Uploading&hellip;</div>
  <div class="box__success">Done!</div>
  <div class="box__error">Error! <span></span>.</div>
    <input type="submit" class="btn btn-primary" value="Analyse">
    <button type="reset" class="btn btn-secondary">Clear</button>
</form>
</main><br><br>
<?php include "footer.php"; ?>
</body>
</html>