<?php
session_start();
$CS_COL = $_SESSION['CS_COL'];
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(12,7,$CS_COL[0][1],0,0,'L');
$pdf->Output();
?>