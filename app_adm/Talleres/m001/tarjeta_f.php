<?php
require('../../../inc/pdf/fpdf.php');

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
$pdf->AddPage();
$pdf->SetFont('Arial','',$_f_txt);

///////////////////////////////////////////////////////////
$_x_i = $pdf->GetX();$_y_i = $pdf->GetY();
$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h*2,'TITULO',0,1,'C');
$pdf->SetFont('Arial','',$_f_txt);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 1 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 2 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 3 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 4 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'',0,1,'C');
$_y = $pdf->GetY();
$pdf->Image('php-logo.png',$_x_i,$_y_i,$_w_img,$_h*7);
$pdf->Cell($_w_txt,$_h,'Titulo 1',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 2',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 3',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$_x = $pdf->GetX();
$pdf->Rect($_x-2,$_y,$_w_txt,$_h*8+2);
$pdf->Rect($_x+$_w_txt,$_y,$_w-$_w_txt,$_h*8+2);
////////////////////////////////////////////////////////////


$pdf->Cell($_w_sq*$_w_ln,10,'',0,1); // ESPACIO SEPARADOR


///////////////////////////////////////////////////////////
$_x_i = $pdf->GetX();$_y_i = $pdf->GetY();
$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h*2,'TITULO',0,1,'C');
$pdf->SetFont('Arial','',$_f_txt);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 1 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 2 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 3 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 4 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'',0,1,'C');
$_y = $pdf->GetY();
$pdf->Image('php-logo.png',$_x_i,$_y_i,$_w_img,$_h*7);
$pdf->Cell($_w_txt,$_h,'Titulo 1',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 2',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 3',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$_x = $pdf->GetX();
$pdf->Rect($_x-2,$_y,$_w_txt,$_h*8+2);
$pdf->Rect($_x+$_w_txt,$_y,$_w-$_w_txt,$_h*8+2);
////////////////////////////////////////////////////////////


$pdf->Cell($_w_sq*$_w_ln,10,'',0,1); // ESPACIO SEPARADOR


///////////////////////////////////////////////////////////
$_x_i = $pdf->GetX();$_y_i = $pdf->GetY();
$pdf->SetFont('Arial','B',$_f_tit);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h*2,'TITULO',0,1,'C');
$pdf->SetFont('Arial','',$_f_txt);
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 1 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 2 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 3 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'SUB TIT 4 XXXXXXXXXXXXXX',0,1,'C');
$pdf->Cell($_w_img,$_h,'',0);$pdf->Cell($_w-$_w_img,$_h,'',0,1,'C');
$_y = $pdf->GetY();
$pdf->Image('php-logo.png',$_x_i,$_y_i,$_w_img,$_h*7);
$pdf->Cell($_w_txt,$_h,'Titulo 1',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 2',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'Titulo 3',0,1);$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$pdf->Cell($_w_txt,$_h,'',0,1);$pdf->Cell($_w_txt-4,0,'',1,1);
$_x = $pdf->GetX();
$pdf->Rect($_x-2,$_y,$_w_txt,$_h*8+2);
$pdf->Rect($_x+$_w_txt,$_y,$_w-$_w_txt,$_h*8+2);
////////////////////////////////////////////////////////////


$pdf->Output();
?>