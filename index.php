<?php include "header.php"; ?>
<main style="margin-left: 20%;margin-right: 20%;"><br><br>
<form action="action_page.php" id="form1" method="post" class="rounded" style="padding: 4%;background-color: #f5f5f5">
    <h2>Paste the Code Here</h2>
    <div class="form-group">
    <textarea class="form-control border border-secondary rounded" name="code" style="width: 100%" rows="15"></textarea><br>
    </div>
    <input type="submit" class="btn btn-primary" value="Analyse">
    <button type="reset" class="btn btn-secondary">Clear</button>
</form>
</main><br><br>
<?php include "footer.php"; ?>
</body>
</html>