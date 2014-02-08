<?php
require('../../inc/pdf/fpdf.php');
require "../../inc/fwo_main.php";
$bd = new fwo_dat("bd");

$pdf = new FPDF();
$pdf->AddPage();

/*$rows1[] = Array('C_ANO'=>'2014','c_nomcur'=>'AQUABEBE','C_SECCION'=>'A','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000','C_APEPAT'=>'profe','C_APEMAT'=>'profe','C_NOMBRES'=>'profe');
$row1 = $rows1[0];

$rows2[] = Array('aludgr_apepat'=>'QUIROZ','aludgr_apemat'=>'MAMANI','aludgr_nombres'=>'RAQUEL','ID_PAGO'=>'14001','N_CANTIDAD'=>'100','N_RESTA'=>'50','C_DEBE'=>'NO','C_FONOS'=>'97/2745','C_EMAIL'=>'sdefedf@usa.net');
$rows2[] = Array('aludgr_apepat'=>'MAMANI','aludgr_apemat'=>'PANCHO','aludgr_nombres'=>'JUAN','ID_PAGO'=>'14001','N_CANTIDAD'=>'100','N_RESTA'=>'50','C_DEBE'=>'NO','C_FONOS'=>'97/2745','C_EMAIL'=>'sdefedf@usa.net');*/

$sql="SELECT C_ANO,id_programacion,C_NOMCUR,C_SECCION,dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia) as horario,C_NOMBRES, C_APEPAT,C_APEMAT 
	  from TB_TALLER_PROGRAMACION p inner join TB_TALLER_CURSOS c on p.id_curso=c.id_curso
	  inner join TB_TALLER_INSTRUCTOR i on p.id_profe=i.id_instructor
	  where id_programacion='$_GET[id_programacion]'";
$row1=$bd->fetch_row($sql);

$sql="SELECT  aludgr_apepat,aludgr_apemat,aludgr_nombres,ID_PAGO,N_CANTIDAD,N_RESTA,C_DEBE,C_FONO1,C_FONO2,C_EMAIL
		FROM V_ALUDGR_TALLER FI inner join TB_TALLER_PAGOS PA ON FI.ALUDGR_ALUMNO=PA.ID_ALUMNO
		WHERE id_programacion='$_GET[id_programacion]'";
$rows2=$bd->fetch_result($sql);


$pdf->SetFont('Arial','',8);
$pdf->Cell(100,5,'Colegio Peruano Aleman BEATA IMELDA',0);
$pdf->Cell(50,5,'',0);
$date = date('d/m/Y');
$pdf->Cell(35,5,$date,0);
$pdf->Ln();

$pdf->Cell(100,5,'Talleres',0);
$pdf->Ln();

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,5,'CONTROL TALLER',0,1,'C');
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Período:',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5, $row1['C_ANO'] ,0);
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Curso Sección:',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5, $row1['C_NOMCUR'] .' - '. $row1['C_SECCION'] ,0);
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Horario:',0);
$pdf->SetFont('Arial','',10);
/*$txt_horario = '';
$txt_horario .= ($row1['C_PRIDIA']=='000')?'':( substr($row1['C_PRIDIA'],0,1).' '.substr($row1['C_PRIDIA'],1,2).'-'.substr($row1['C_PRIDIA'],3,2).'  ' );
$txt_horario .= ($row1['C_SEGDIA']=='000')?'':( substr($row1['C_SEGDIA'],0,1).' '.substr($row1['C_SEGDIA'],1,2).'-'.substr($row1['C_SEGDIA'],3,2).'  ' );
$txt_horario .= ($row1['C_TERDIA']=='000')?'':( substr($row1['C_TERDIA'],0,1).' '.substr($row1['C_TERDIA'],1,2).'-'.substr($row1['C_TERDIA'],3,2).'  ' );*/
$pdf->Cell(0,5, $row1['horario'] ,0);
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Profesor:',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5, $row1['C_APEPAT'] .' '. $row1['C_APEMAT'] .', '. $row1['C_NOMBRES'] ,0);
$pdf->Ln();

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'N°',1,0,'C');
$pdf->Cell(70,5,'Apellidos y Nombres',1,0,'C');
$pdf->Cell(18,5, 'Recibo' ,1,0,'C');
$pdf->Cell(15,5, 'Pago' ,1,0,'C');
$pdf->Cell(15,5, 'Resta' ,1,0,'C');
$pdf->Cell(12,5, 'Debe' ,1,0,'C');
$pdf->Cell(20,5, 'Fonos' ,1,0,'C');
$pdf->Cell(30,5, 'Email' ,1,0,'C');
$pdf->Ln();

$pdf->SetFont('Arial','',8);
$j = 0;
foreach($rows2 as $row2){$j++;
$pdf->Cell(7,5,$j,1,0,'C');
$pdf->Cell(70,5, $row2['aludgr_apepat'].' '.$row2['aludgr_apemat'].', '.$row2['aludgr_nombres'],1,0);
$pdf->Cell(18,5, $row2['ID_PAGO'] ,1,0,'C');
$pdf->Cell(15,5, $row2['N_CANTIDAD'] ,1,0,'C');
$pdf->Cell(15,5, $row2['N_RESTA'] ,1,0,'C');
$pdf->Cell(12,5, $row2['C_DEBE'] ,1,0,'C');
$pdf->Cell(20,5, $row2['C_FONO1'] ,1,0,'C');
$pdf->Cell(30,5, $row2['C_EMAIL'] ,1,0,'C');
$pdf->Ln();
}

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