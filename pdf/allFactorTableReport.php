<?php

require('fpdf.php');

//SESSION START
session_start();

//SESSION VALUES FROM ACTION_PAGE.PHP
$CS_COL = $_SESSION['CS_COL'];
$CV_COL = $_SESSION['CV_COL'];
$CM_COL = $_SESSION['CM_COL'];
$CCS_COL = $_SESSION['CCS_COL'];
$fileCount = $_SESSION['FILE_COUNT'];
$codes = $_SESSION['CODES'];
$fileNames = $_SESSION['fileNames'];

//create new pdf
$pdf = new FPDF();
$pdf->SetAutoPageBreak(true, 10);

//Complexity due to all factor table creation inside a loop for all the files
for ($j = 0; $j < $fileCount; $j++) {

    //define the table columns
    $pdf->AddPage('L', 'A4');
    $title =  $fileNames[$j] . " Complexity Due To All Factors";
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(260, 10, $title, 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(15, 10, 'Line No', 1, 0, 'C', 0);
    $pdf->Cell(210, 10, 'Program statements', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Cs', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Cv', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Cm', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Ccs', 1, 0, 'C', 0);
    $pdf->Cell(13, 10, 'TCps', 1, 0, 'C', 0);

    $pdf->Ln();
    $lineno = 1;
    $tcps = array();
    $tcs = 0;
    $tcv = 0;
    $tcm = 0;
    $tccs = 0;
    foreach ($codes[$j] as $line) {
        $pdf->SetFont('Arial', '', 10);
        //getting the value for total tcps each line
        $tcps[$j][$lineno] = $CS_COL[$j][$lineno] + $CV_COL[$j][$lineno] +  $CM_COL[$j][$lineno] + $CCS_COL[$j][$lineno];
        $tcs +=  $CS_COL[$j][$lineno];
        $tcv += $CV_COL[$j][$lineno];
        $tcm += $CM_COL[$j][$lineno];
        $tccs += $CCS_COL[$j][$lineno];
        $pdf->Cell(15, 10, $lineno, 1, 0, 'C', false);
        $pdf->Cell(210, 10, $line, 1, 0, 'L', false);
        $pdf->Cell(10, 10, $CS_COL[$j][$lineno], 1, 0, 'C', false);
        $pdf->Cell(10, 10, $CV_COL[$j][$lineno], 1, 0, 'C', false);
        $pdf->Cell(10, 10, $CM_COL[$j][$lineno], 1, 0, 'C', false);
        $pdf->Cell(10, 10, $CCS_COL[$j][$lineno], 1, 0, 'C', false);
        $pdf->Cell(13, 10,$tcps[$j][$lineno], 1, 0, 'C', false);
        $pdf->Ln();
        $lineno++;
    }
    //getting all total values for the main factors
    $finalTcps = $tcs +$tcv + $tcm + $tccs;

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(15, 10, "END", 1, 0, 'C', false);
    $pdf->Cell(210, 10, "TOTAL", 1, 0, 'C', false);
    $pdf->Cell(10, 10, $tcs, 1, 0, 'C', false);
    $pdf->Cell(10, 10, $tcv, 1, 0, 'C', false);
    $pdf->Cell(10, 10, $tcm, 1, 0, 'C', false);
    $pdf->Cell(10, 10, $tccs, 1, 0, 'C', false);
    $pdf->Cell(13, 10,$finalTcps, 1, 0, 'C', false);


}
//output pdf
$pdf->Output();
