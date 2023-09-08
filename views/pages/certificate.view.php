<?php
//Librería para generar PDF
require ("libraries/fpdf186/fpdf.php");
//Conexión a la base de datos
require ("classes/db_connection.class.php");
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();

?>