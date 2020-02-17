<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/style.css" >
    <title>WE_43</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<header>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/index.php" class="navbar-brand d-flex align-items-center">
                <strong>IT Project Management</strong>
            </a>
        </div>
    </div>
</header>
<main><br><br><div style="text-align: center;margin-left: 20%;margin-right:20%">
    <h5> Displaying the complexity of a program due to size</h5><br>
<?php
$maxcols = 5;
$i = 0;

//Open the table and its first row
echo "<table class=\"table table-bordered table-striped\">";
echo "<thead class=\"thead-dark\">";
echo "<tr>";
echo "<th scope=\"col\">Line no</th>";
echo "<th scope=\"col\">Program statements</th>";
echo "<th scope=\"col\">Nkw</th>";
echo "<th scope=\"col\">Nid</th>";
echo "<th scope=\"col\">Nop</th>";
echo "<th scope=\"col\">Nnv</th>";
echo "<th scope=\"col\">Nsl</th>";
echo "<th scope=\"col\">Cs</th>";
echo "</tr>";
echo "</thead>";
echo "<tr>";


//Add empty <td>'s to even up the amount of cells in a row:
while ($i <= $maxcols) {
    echo "<td>&nbsp; Hello</td>";
    $i++;
}

//Close the table row and the table
echo "</tr>";
echo "</table>";?></div>
</main>