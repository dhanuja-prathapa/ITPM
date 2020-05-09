<?php

require('fpdf.php');

//SESSION START
session_start();

//SESSION VALUES FROM ACTION_PAGE.PHP
$total = $_SESSION['total'];
$fileNames = $_SESSION['fileNames'];

//create new pdf
$pdf = new FPDF();
$pdf->SetAutoPageBreak(true, 10);

//define the table columns
$pdf->AddPage('P', 'A4');
$title = " File Complexities and Final Total Program Complexity";
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(190, 10, $title, 0, 1, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(25, 10, 'File Order', 1, 0, 'C', 0);
$pdf->Cell(110, 10, 'File Name', 1, 0, 'C', 0);
$pdf->Cell(60, 10, 'Total Complexity Value', 1, 0, 'C', 0);

$pdf->Ln();

//create variable for final total program complexity
$totalPC = 0;
//set font style
$pdf->SetFont('Arial', '', 12);
for ($i = 0; $i < sizeof($total); $i++) {

    $pdf->Cell(25, 10, $i + 1, 1, 0, 'C', false);
    $pdf->Cell(110, 10, $fileNames[$i], 1, 0, 'L', false);
    $pdf->Cell(60, 10, $total[$i], 1, 0, 'C', false);
    $totalPC += $total[$i];
    $pdf->Ln();

}
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(135, 10, 'Final Total Program Complexity', 1, 0, 'C', false);
$pdf->Cell(60, 10, $totalPC, 1, 0, 'C', false);


//output pdf
$pdf->Output();
