<?php

global $CS_TABLE,$NKW_TABLE,$NID_TABLE,$NOP_TABLE,$NNV_TABLE,$NSL_TABLE,$WVS_TABLE,$NPDTV_TABLE,$NPCTV_TABLE,$CV_TABLE,$WMRT_TABLE,$NPDTP_TABLE,$NCDTP_TABLE,$CM_TABLE,$CCS_TABLE,$WTCS_TABLE,$NC_TABLE,$CCSPPS_TABLE;
global $i,$file_count,$codes;

require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40, 10, 'Test',1,0,'C');
for ($i=0 ; $i<$file_count ; $i++) {
    $lineno = 1;
    foreach ($codes as $line) {
        $pdf->Cell(40, 10, $CS_TABLE[$i][$lineno]->Test, 1, 0, 'C');
        $lineno++;
    }
}

$pdf->Output();

?>