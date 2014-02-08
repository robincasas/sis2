<?php
require('../../../inc/pdf/fpdf.php');

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

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_sq*$_w_ln,$_h_tit,$_title,1,1,'C');
$pdf->Cell($_w_sq*$_w_ln,$_m_tit,'',0,1);
$pdf->SetFont('Arial','',$_f_day);
///////////////////////////////////////////////////////////////////
$_ini_t = strtotime('10-12-2013');
$_fin_t = strtotime('31-12-2013');
///////////////////////
$C_P = 'L'; //C_PRIDIA
$C_S = 'R'; //C_SEGDIA
$C_T = 'V'; //C_TERDIA
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
		$_txt = date('(D) d/m',$_act_t); // TEXTO A MOSTRARSE EN EL CUADRO
		
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



$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_sq*$_w_ln,$_h_tit,$_title,1,1,'C');
$pdf->Cell($_w_sq*$_w_ln,$_m_tit,'',0,1);
$pdf->SetFont('Arial','',$_f_day);
///////////////////////////////////////////////////////////////////
$_ini_t = strtotime('01-01-2014');
$_fin_t = strtotime('15-01-2014');
///////////////////////
$C_P = 'M'; //C_PRIDIA
$C_S = 'J'; //C_SEGDIA
$C_T = ''; //C_TERDIA
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
		$_txt = date('(D) d/m',$_act_t); // TEXTO A MOSTRARSE EN EL CUADRO
		
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


$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_sq*$_w_ln,$_h_tit,$_title,1,1,'C');
$pdf->Cell($_w_sq*$_w_ln,$_m_tit,'',0,1);
$pdf->SetFont('Arial','',$_f_day);
///////////////////////////////////////////////////////////////////
$_ini_t = strtotime('01-01-2014');
$_fin_t = strtotime('15-01-2014');
///////////////////////
$C_P = 'M'; //C_PRIDIA
$C_S = 'J'; //C_SEGDIA
$C_T = ''; //C_TERDIA
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
		$_txt = date('(D) d/m',$_act_t); // TEXTO A MOSTRARSE EN EL CUADRO
		
		$pdf->Cell($_w_sq,$_h_sq,$_txt,1,0,'C');
	}
	if($_w_i == $_w_ln){$_w_i = 0;$_h_i++; $pdf->Ln(); }
	if($_h_i >= $_h_ln){break;}
	$_act_t = strtotime ( '+1 day' , $_act_t ) ;
}
//Completar Cuadros Vacios
while($_h_i < $_h_ln){$_w_i++;$pdf->Cell($_w_sq,$_h_sq,'',1);if($_w_i == $_w_ln){$_w_i = 0;$_h_i++;$pdf->Ln();}}
//////////////////////////////////////////////////////////////////////


//$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
?>
