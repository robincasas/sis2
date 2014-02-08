<?php
require('../../inc/pdf/fpdf.php');
require "../../inc/fwo_main.php";
$bd = new fwo_dat("bd");
/*$sql="SELECT C_ANO,id_programacion,C_NOMCUR,C_SECCION,dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia) as horario,C_NOMBRES, C_APEPAT,C_APEMAT 
	  from TB_TALLER_PROGRAMACION p inner join TB_TALLER_CURSOS c on p.id_curso=c.id_curso
	  inner join TB_TALLER_INSTRUCTOR i on p.id_profe=i.id_instructor
	  where id_programacion='$_GET[id_programacion]'";
$row1=$bd->fetch_row($sql);

$sql="SELECT  aludgr_apepat,aludgr_apemat,aludgr_nombres,ID_PAGO,N_CANTIDAD,N_RESTA,C_DEBE,C_FONO1,C_FONO2,C_EMAIL
		FROM V_ALUDGR_TALLER FI inner join TB_TALLER_PAGOS PA ON FI.ALUDGR_ALUMNO=PA.ID_ALUMNO
		WHERE id_programacion='$_GET[id_programacion]'";*/
$rows1[] = Array('ID_PAGO'=>'14001','C_ANO'=>'2014','c_nomcur'=>'AQUABEBE','C_SECCION'=>'A','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000','C_APEPAT'=>'QUIROZ','C_APEMAT'=>'MAMANI','C_NOMBRES'=>'JUAN','N_CANTIDAD'=>'100','N_RESTA'=>'50');
$row1 = $rows1[0];

$pdf = new FPDF('L','mm','A5');
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$_x = $pdf->GetX();
$_y = $pdf->GetY();
$_img_w = 30;
$_img_h = 35;

$pdf->Image('php-logo.jpg',$_x,$_y,$_img_w,$_img_h);

$pdf->Cell($_img_w,10,'',0,0);
$pdf->Cell(20,10,'',0,0);

$pdf->SetFont('Arial','B',12);

$pdf->Cell(100,10,'COLEGIO PERUANO ALEMAN',0,0,'C');

$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(10,10,'',0,0);
$pdf->Cell(25,10,'N°: '. $row1['ID_PAGO'],0,0,'R');

$pdf->Ln();

$pdf->SetTextColor(0,0,0);

$pdf->Cell($_img_w,10,'',0,0);
$pdf->Cell(20,10,'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,10,'BEATA IMELDA',0,0,'C');
$pdf->Ln();


$pdf->SetFont('Arial','',10);

$pdf->Cell(0,5,'',0,1);
$pdf->Cell($_img_w,10,'',0,0);
$pdf->Cell(20,10,'',0,0);

$pdf->Cell(100,10,'Talleres Deportivos y Culturales CBI',1,0,'C');
$pdf->Cell(10,10,'',0,0);
$pdf->SetFont('Arial','B',10);
$_cantidad = number_format( $row1['N_CANTIDAD'] , 2 );
$pdf->Cell(25,10,'S/. '.$_cantidad ,0,0,'R');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,10,'Recibi de:',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,10, $row1['C_APEPAT'].' '.$row1['C_APEMAT'].', '.$row1['C_NOMBRES'] ,0,0);
$pdf->Ln();
$pdf->SetFont('Arial','',10);

$pdf->Cell(0,5,'Observaciones:',0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'Resta S/. '. number_format($row1['N_RESTA'],2) ,0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'' ,0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'' ,0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'' ,0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'' ,0,1);
$pdf->Cell(5,5,'',0,0);$pdf->Cell(0,5,'' ,0,1);

$pdf->Cell(130,20,'',0,0);$pdf->Cell(50,20,'' ,'TLR',1);
$pdf->Cell(130,5,'',0,0); $pdf->Cell(50,5,'Firma y Sello' ,'BLR',1,'C');
$pdf->Output();
?>