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

$_f_tit = 8; //Font Title
$_f_day = 7; //Font dias
// bit mask /////////
//  L  M  X J V S D
// 64 32 16 8 4 2 1
$_bit = Array('L'=>64,'M'=>32,'R'=>16,'J'=>8,'V'=>4,'S'=>2,'D'=>1);
//
// Verifica si ese día esta en el horario
function checkDay($bm,$d){
	$_b = Array('1'=>6,'2'=>5,'3'=>4,'4'=>3,'5'=>2,'6'=>1,'7'=>0);//echo ':'.$_b[$d].':';	echo ':'.(1<<$_b[$d]).':';echo ':'.((1<<$_b[$d])^(127)).':';
	if( ($bm | ((1<<$_b[$d])^(127))) == 127 ){return true;}
	return false;
}
$_day = Array('1'=>'Lu','2'=>'Ma','3'=>'Mi','4'=>'Ju','5'=>'Vi','6'=>'Sa','7'=>'Do');
$pdf = new FPDF();
$pdf->AddPage();
$i = 0;
foreach( $rows as $row ){ $i++;
	$pdf->SetFont('Arial','B',$_f_tit);
	$pdf->Cell($_w_sq*$_w_ln,$_h_tit,$_title,1,1,'C');
	$pdf->Cell($_w_sq*$_w_ln,$_m_tit,'',0,1);
	$pdf->SetFont('Arial','',$_f_day);
	///////////////////////////////////////////////////////////////////
	$_ini_t = strtotime($row['D_INICIO']);//strtotime('10-12-2013');
	$_fin_t = strtotime($row['D_FIN']);//strtotime('31-12-2013');
	///////////////////////
	$C_P = substr($row['C_PRIDIA'],0,1);//'L'; //C_PRIDIA
	$C_S = substr($row['C_SEGDIA'],0,1);//'R'; //C_SEGDIA
	$C_T = substr($row['C_TERDIA'],0,1);//'V'; //C_TERDIA
	///////////////////////
	$_bm = 0;
	$_bm += ( isset($_bit[$C_P])?$_bit[$C_P]:0 );
	$_bm += ( isset($_bit[$C_S])?$_bit[$C_S]:0 );
	$_bm += ( isset($_bit[$C_T])?$_bit[$C_T]:0 );
	////////////////
	$_act_t = $_ini_t; //actual time
	$_w_i = 0;$_h_i = 0;
	//Imprimir Cuadros Con Fechas
	while($_act_t <= $_fin_t){
		$_n_day = date('N',$_act_t); //echo '_'.$_n_day.'_';
		if( checkDay($_bm,$_n_day) ){ $_w_i++;
			$_txt = '('.$_day[$_n_day].') '.date(' d/m',$_act_t); // TEXTO A MOSTRARSE EN EL CUADRO
			
			$pdf->Cell($_w_sq,$_h_sq,$_txt,1,0,'C');
		}
		if($_w_i == $_w_ln){$_w_i = 0;$_h_i++; $pdf->Ln(); }
		if($_h_i >= $_h_ln){break;}
		$_act_t = strtotime ( '+1 day' , $_act_t ) ;
	}
	//Completar Cuadros Vacios
	while($_h_i < $_h_ln){$_w_i++;$pdf->Cell($_w_sq,$_h_sq,'',1);if($_w_i == $_w_ln){$_w_i = 0;$_h_i++;$pdf->Ln();}}
	//////////////////////////////////////////////////////////////////////


	$pdf->Cell($_w_sq*$_w_ln,10,'',0,1); // ESPACIO SEPARADOR

	if($i%3==0){$pdf->AddPage();}
}



//$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
?>
