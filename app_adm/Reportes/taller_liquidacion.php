<?php
require('../../inc/pdf/fpdf.php');
require "../../inc/fwo_main.php";
$bd = new fwo_dat("bd");

$pdf = new FPDF();
$pdf->AddPage();

$sql="SELECT * FROM V_TALLER_ALU_CUR
		WHERE d_fecpag='$_GET[fecha]' and c_activo='1'";
$rows2=$bd->fetch_result($sql);

$suma=$bd->fetch_cell("SELECT sum(n_cantidad) FROM V_TALLER_ALU_CUR
		WHERE d_fecpag='$_GET[fecha]' and c_activo='1'");



$pdf->SetFont('Arial','',8);
$pdf->Cell(100,5,'Colegio Peruano Aleman BEATA IMELDA',0);
$pdf->Cell(50,5,'',0);
$date = date('d/m/Y');
$pdf->Cell(35,5,$date,0);
$pdf->Ln();

$pdf->Cell(100,5,'Talleres',0);
$pdf->Ln();

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,5,'LIQUIDACION DE INGRESOS POR DIA',0,1,'C');
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Período:',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5, '2014',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Monto Recaudado en la Fecha: '.$_GET[fecha].' ',0);

$pdf->Ln();


$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'N°',1,0,'C');
$pdf->Cell(70,5,'Apellidos y Nombres',1,0,'C');
$pdf->Cell(70,5, 'Curso' ,1,0,'C');
$pdf->Cell(15,5, 'Recibo' ,1,0,'C');
$pdf->Cell(15,5, 'Pago' ,1,0,'C');
$pdf->Ln();

$pdf->SetFont('Arial','',8);
$j = 0;
foreach($rows2 as $row2){
	$j++;
	$pdf->Cell(7,5,$j,1,0,'C');
	$pdf->Cell(70,5, $row2['aludgr_apepat'].' '.$row2['aludgr_apemat'].', '.$row2['aludgr_nombres'],1,0);
	$pdf->Cell(70,5, $row2['C_NOMCUR'] ,1,0,'L');
	$pdf->Cell(15,5, $row2['ID_PAGO'] ,1,0,'C');
	$pdf->Cell(15,5, $row2['N_CANTIDAD'] ,1,0,'C');
	$pdf->Ln();
}
$pdf->Cell(177,5,'Total Recaudado S/. '.$suma ,0,0,'R');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->Cell(120,5,'',0,0);
$pdf->Cell(50,0,'',1,0,'C');
$pdf->Ln();
$pdf->Cell(100,5,'',0,0);
$pdf->Cell(90,5, 'ADMINISTRACION' ,0,0,'C');
$pdf->Ln();
$pdf->Output();
?>