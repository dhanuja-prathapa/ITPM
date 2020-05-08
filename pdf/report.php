<?php
require('fpdf.php');
//SESSION START
session_start();

//SESSION VALUES FROM ACTION_PAGE.PHP
$CS_COL = $_SESSION['CS_COL'];
$NKW_COL = $_SESSION['NKW_COL'];
$NID_COL = $_SESSION['NID_COL'];
$NOP_COL = $_SESSION['NOP_COL'];
$NNV_COL = $_SESSION['NNV_COL'];
$NSL_COL = $_SESSION['NSL_COL'];
$WVS_COL = $_SESSION['WVS_COL'];
$NPDTV_COL = $_SESSION['NPDTV_COL'];
$NPCTV_COL = $_SESSION['NPCTV_COL'];
$CV_COL = $_SESSION['CV_COL'];
$WMRT_COL = $_SESSION['WMRT_COL'];
$NPDTP_COL = $_SESSION['NPDTP_COL'];
$NCDTP_COL = $_SESSION['NCDTP_COL'];
$CM_COL = $_SESSION['CM_COL'];
$CCS_COL = $_SESSION['CCS_COL'];
$WTCS_COL = $_SESSION['WTCS_COL'];
$NC_COL = $_SESSION['NC_COL'];
$CCSPPS_COL = $_SESSION['CCSPPS_COL'];
$fileCount=$_SESSION['FILE_COUNT'];
$codes = $_SESSION['CODES'];

$pdf = new FPDF();
$pdf->AddPage('L','A4');
$pdf->SetFont('Arial','B',8);

for ($j=0; $j<$fileCount; $j++) {

    $z = $j + 1;
    $title = "File " .$z."Complexity Due to Size";
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(45,10,$title,0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10, 10, 'Line No', 1, 0, 'C', 0);
    $pdf->Cell(210, 10, 'Program statements', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Nkw', 1, 0, 'L', 0);
    $pdf->Cell(10, 10, 'Nid', 1, 0, 'L', 0);
    $pdf->Cell(10, 10, 'Nop', 1, 0, 'L', 0);
    $pdf->Cell(10, 10, 'Nnv', 1, 0, 'L', 0);
    $pdf->Cell(10, 10, 'Nsl', 1, 0, 'L', 0);
    $pdf->Cell(10, 10, 'Cs', 1, 1, 'L', 0);
    $lineno = 1;
    foreach ($codes[$j] as $line){
        $pdf->Cell(10,10,$lineno,1,0,'L',false);
        $pdf->Cell(210,10,$line,1,0,'L',false);
        $pdf->Cell(10,10,$NKW_COL[$j][$lineno],1,0,'L',false);
        $pdf->Cell(10,10,$NID_COL[$j][$lineno],1,0,'L',false);
        $pdf->Cell(10,10,$NOP_COL[$j][$lineno],1,0,'L',false);
        $pdf->Cell(10,10,$NNV_COL[$j][$lineno],1,0,'L',false);
        $pdf->Cell(10,10,$NSL_COL[$j][$lineno],1,0,'L',false);
        $pdf->Cell(10,10,$CS_COL[$j][$lineno],1,1,'L',false);

        $lineno++;
        $pdf -> AddPage();
    }
$pdf ->Ln();

    // Complexity due to variables table
    $title = "File " .$z."Complexity Due to Variables";
    $pdf->Cell(10, 10, 'Line No', 1, 0, 'C', 0);
    $pdf->Cell(100, 10, 'Program statements', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Wvs', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Npdtv', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Ncdtv', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Cv', 1, 0, 'C', 0);

    $lineno = 1;
    foreach ($codes[$j] as $line){
        $pdf->Cell(10,10,$lineno,1,0,'C',false);
        $pdf->Cell(100,10,$line,1,0,'C',false);
        $pdf->Cell(10,10,$WVS_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$NPDTV_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$NPCTV_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$CV_COL[$j][$lineno],1,0,'C',false);

        $lineno++;
        $pdf -> AddPage();
    }
    $pdf ->Ln();
    // Complexity due to methods table
    $title = "File " .$z."Complexity Due to Methods";
    $pdf->Cell(10, 10, 'Line No', 1, 0, 'C', 0);
    $pdf->Cell(100, 10, 'Program statements', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Wmrt', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Npdtp', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Ncdtp', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Cm', 1, 0, 'C', 0);

    $lineno = 1;
    foreach ($codes[$j] as $line){
        $pdf->Cell(10,10,$lineno,1,0,'C',false);
        $pdf->Cell(100,10,$line,1,0,'C',false);
        $pdf->Cell(10,10,$WMRT_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$NPDTP_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$NCDTP_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$CM_COL[$j][$lineno],1,0,'C',false);

        $lineno++;
        $pdf -> AddPage();
    }
    $pdf ->Ln();
    // Complexity due to control structures table
    $title = "File " .$z."Complexity Due to Control Structures";
    $pdf->Cell(10, 10, 'Line No', 1, 0, 'C', 0);
    $pdf->Cell(100, 10, 'Program statements', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Wtcs', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'NC', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Ccspps', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'Ccs', 1, 0, 'C', 0);

    $lineno = 1;
    foreach ($codes[$j] as $line){
        $pdf->Cell(10,10,$lineno,1,0,'C',false);
        $pdf->Cell(100,10,$line,1,0,'C',false);
        $pdf->Cell(10,10,$WTCS_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$NC_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$CCSPPS_COL[$j][$lineno],1,0,'C',false);
        $pdf->Cell(10,10,$CCS_COL[$j][$lineno],1,0,'C',false);

        $lineno++;
        $pdf -> AddPage();
    }


}

$pdf->Output();
?>