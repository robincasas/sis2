<?php
require('../../inc/pdf/fpdf.php');
require "../../inc/fwo_main.php";
$bd = new fwo_dat("bd");
$sql="select PR.ID_PROGRAMACION,aludgr_apepat,aludgr_apemat,aludgr_nombres,c_nomcur,D_INICIO,D_FIN,C_PRIDIA,C_SEGDIA,C_TERDIA 
	from v_aludgr_taller fi 
	inner join tb_taller_pagos pa on fi.aludgr_alumno=pa.id_alumno and c_partes in ('1RA','TOT') and c_activo='1'
	inner join tb_taller_programacion pr on pr.id_programacion=pa.id_programacion
	inner join tb_taller_cursos cu on cu.id_curso=pr.id_curso
	where PR.ID_PROGRAMACION='$_GET[id_programacion]'";
$tempo=	$bd->fetch_cell("select c_ano from tb_taller_programacion where ID_PROGRAMACION='$_GET[id_programacion]'");
$rows=$bd->fetch_result($sql);	

/*$rows[] = Array('aludgr_apepat'=>'QUIROZ','aludgr_apemat'=>'MAMANI','aludgr_nombres'=>'RAQUEL','c_nomcur'=>'AQUABEBE','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000');
$rows[] = Array('aludgr_apepat'=>'AYALA','aludgr_apemat'=>'NOLE','aludgr_nombres'=>'Diana Calorina','c_nomcur'=>'AQUABEBE','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000');
$rows[] = Array('aludgr_apepat'=>'ALIGERI','aludgr_apemat'=>'SAMAN','aludgr_nombres'=>'JOSE ALEJANDRO','c_nomcur'=>'AQUABEBE','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000');
$rows[] = Array('aludgr_apepat'=>'QUIROZ','aludgr_apemat'=>'MAMANI','aludgr_nombres'=>'RAQUEL','c_nomcur'=>'AQUABEBE','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000');*/



$_w_sq = 15; //width square //Ancho del Cuadro
$_h_sq = 15; //height square //Alto del Cuadro

$_w_ln = 6; //width len //Numero de Columnas
$_h_ln = 4; //height len //Numero de Filas

$_title = 'TALLERES DE VERANO CBI';
$_h_tit = 10; //Altura Cuadro Titulo
$_m_tit = 5; // Margen Inf Cuadro Titulo

$_f_tit = 10; //Font Title
$_f_txt = 7; //Font dias

$_w = 90;
$_h = 5;

$_w_img = 30; //width image
$_w_txt = 60; //width text box

$pdf = new FPDF();
$pdf->SetLeftMargin(110);
$pdf->AddPage();

$i = 0;
foreach( $rows as $row ){ $i++;

	$pdf->SetFont('Arial','',$_f_txt);
	///////////////////////////////////////////////////////////
	$_x_i = $pdf->GetX();$_y_i = $pdf->GetY();
	//$pdf->SetFont('Arial','B',$_f_tit);
	$pdf->AddFont('tahoma');
	$pdf->SetFont('tahoma','',$_f_tit);
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h*2,'Beata Imelda Schule',0,1,'C');
	$pdf->SetFont('Arial','',$_f_txt);
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'Carretera Central Km 29 - Chosica L15',0,1,'C');
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'Telef.: 7619727 / 360-3119',0,1,'C');
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'Nextel: 99404*1407',0,1,'C');
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'http://www.cbi.edu.pe',0,1,'C');
	$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'',0,1,'C');
	$_y = $pdf->GetY();
	$pdf->Image('php-logo.jpg',$_x_i,$_y_i,$_w_img,$_h*7);
	$_txt1 =  $row['aludgr_apepat'].' '.$row['aludgr_apemat'].', '.$row['aludgr_nombres'];
	$pdf->SetFont('Arial','B',$_f_txt);
	$pdf->Cell($_w_txt,$_h,'ALUMNO:',0,1);
	$pdf->SetFont('Arial','',$_f_txt);
	$pdf->Cell($_w_txt,$_h, $_txt1 ,0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
	
	$_txt2 = $row['c_nomcur'];
	$pdf->SetFont('Arial','B',$_f_txt);
	$pdf->Cell($_w_txt,$_h,'TALLER:',0,1);
	$pdf->SetFont('Arial','',$_f_txt);
	$pdf->Cell($_w_txt,$_h, $_txt2 ,0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
	
	$_txt3 = $tempo;
	$pdf->SetFont('Arial','B',$_f_txt);
	$pdf->Cell($_w_txt,$_h,'TEMPORADA',0,1);
	$pdf->SetFont('Arial','',$_f_txt);
	$pdf->Cell($_w_txt,$_h, $_txt3 ,0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
	
	$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
	$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
	$_x = $pdf->GetX();
	$pdf->Rect($_x-2,$_y,$_w_txt,$_h*8+2);
	$pdf->Rect($_x+$_w_txt,$_y,$_w-$_w_txt,$_h*8+2);
	////////////////////////////////////////////////////////////


	$pdf->Cell($_w_sq*$_w_ln,10,'',0,1); // ESPACIO SEPARADOR
	
	if($i%3==0){$pdf->AddPage();}
}

$pdf->Output();
?>