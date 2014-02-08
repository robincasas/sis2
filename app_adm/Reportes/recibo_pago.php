<?php
require('../../inc/pdf/fpdf.php');
require "../../inc/fwo_main.php";
$bd = new fwo_dat("bd");
class EnLetras 
{ 
  var $Void = ""; 
  var $SP = " "; 
  var $Dot = "."; 
  var $Zero = "0"; 
  var $Neg = "Menos"; 
   
function ValorEnLetras($x, $Moneda )  
{ 
    $s=""; 
    $Ent=""; 
    $Frc=""; 
    $Signo=""; 
         
    if(floatVal($x) < 0) 
     $Signo = $this->Neg . " "; 
    else 
     $Signo = ""; 
     
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales 
      $s = number_format($x,2,'.',''); 
    else 
      $s = number_format($x,2,'.',''); 
        
    $Pto = strpos($s, $this->Dot); 
         
    if ($Pto === false) 
    { 
      $Ent = $s; 
      $Frc = $this->Void; 
    } 
    else 
    { 
      $Ent = substr($s, 0, $Pto ); 
      $Frc =  substr($s, $Pto+1); 
    } 

    if($Ent == $this->Zero || $Ent == $this->Void) 
       $s = "Cero "; 
    elseif( strlen($Ent) > 7) 
    { 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) .  
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
    } 
    else 
    { 
      $s = $this->SubValLetra(intval($Ent)); 
    } 

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ") 
       $s = $s . "de "; 

    $s = $s . $Moneda; 

    if($Frc != $this->Void) 
    { 
       $s = $s . " y " . $Frc. "/100"; 
       //$s = $s . " " . $Frc . "/100"; 
    } 
	/*
    $letrass=$Signo . $s . " M.N."; 
    return ($Signo . $s . " M.N."); 
	*/
	$letrass=$Signo . $s . " "; 
    return ($Signo . $s . " "); 
    
} 


function SubValLetra($numero)  
{ 
    $Ptr=""; 
    $n=0; 
    $i=0; 
    $x =""; 
    $Rtn =""; 
    $Tem =""; 

    $x = trim("$numero"); 
    $n = strlen($x); 

    $Tem = $this->Void; 
    $i = $n; 
     
    while( $i > 0) 
    { 
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1).  
                           str_repeat($this->Zero, $i - 1 ))); 
       If( $Tem != "Cero" ) 
          $Rtn .= $Tem . $this->SP; 
       $i = $i - 1; 
    } 

     
    //--------------------- GoSub FiltroMil ------------------------------ 
    $Rtn=str_replace(" Mil Mil", " Un Mil", $Rtn ); 
    while(1) 
    { 
       $Ptr = strpos($Rtn, "Mil ");        
       If(!($Ptr===false)) 
       { 
          If(! (strpos($Rtn, "Mil ",$Ptr + 1) === false )) 
            $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr); 
          Else 
           break; 
       } 
       else break; 
    } 

    //--------------------- GoSub FiltroCiento ------------------------------ 
    $Ptr = -1; 
    do{ 
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1); 
       if(!($Ptr===false)) 
       { 
          $Tem = substr($Rtn, $Ptr + 5 ,1); 
          if( $Tem == "M" || $Tem == $this->Void) 
             ; 
          else           
             $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr); 
       } 
    }while(!($Ptr === false)); 

    //--------------------- FiltroEspeciales ------------------------------ 
    $Rtn=str_replace("Diez Un", "Once", $Rtn ); 
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn ); 

    //--------------------- FiltroUn ------------------------------ 
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn; 
    //--------------------- Adicionar Y ------------------------------ 
    for($i=65; $i<=88; $i++) 
    { 
      If($i != 77) 
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn); 
    } 
    $Rtn=str_replace("*", "a" , $Rtn); 
    return($Rtn); 
} 


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) 
{ 
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr); 
} 


function Parte($x) 
{ 
    $Rtn=''; 
    $t=''; 
    $i=''; 
    Do 
    { 
      switch($x) 
      { 
         Case 0:  $t = "Cero";break; 
         Case 1:  $t = "Un";break; 
         Case 2:  $t = "Dos";break; 
         Case 3:  $t = "Tres";break; 
         Case 4:  $t = "Cuatro";break; 
         Case 5:  $t = "Cinco";break; 
         Case 6:  $t = "Seis";break; 
         Case 7:  $t = "Siete";break; 
         Case 8:  $t = "Ocho";break; 
         Case 9:  $t = "Nueve";break; 
         Case 10: $t = "Diez";break; 
         Case 20: $t = "Veinte";break; 
         Case 30: $t = "Treinta";break; 
         Case 40: $t = "Cuarenta";break; 
         Case 50: $t = "Cincuenta";break; 
         Case 60: $t = "Sesenta";break; 
         Case 70: $t = "Setenta";break; 
         Case 80: $t = "Ochenta";break; 
         Case 90: $t = "Noventa";break; 
         Case 100: $t = "Cien";break; 
         Case 200: $t = "Doscientos";break; 
         Case 300: $t = "Trescientos";break; 
         Case 400: $t = "Cuatrocientos";break; 
         Case 500: $t = "Quinientos";break; 
         Case 600: $t = "Seiscientos";break; 
         Case 700: $t = "Setecientos";break; 
         Case 800: $t = "Ochocientos";break; 
         Case 900: $t = "Novecientos";break; 
         Case 1000: $t = "Mil";break; 
         Case 1000000: $t = "Millón";break; 
      } 

      If($t == $this->Void) 
      { 
        $i = $i + 1; 
        $x = $x / 1000; 
        If($x== 0) $i = 0; 
      } 
      else 
         break; 
            
    }while($i != 0); 
    
    $Rtn = $t; 
    Switch($i) 
    { 
       Case 0: $t = $this->Void;break; 
       Case 1: $t = " Mil";break; 
       Case 2: $t = " Millones";break; 
       Case 3: $t = " Billones";break; 
    } 
    return($Rtn . $t); 
} 

} 
$sql="SELECT  ID_PAGO,aludgr_apepat,aludgr_apemat,aludgr_nombres,N_CANTIDAD,N_RESTA,C_NOMCUR,dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia) as horario,PA.C_OBS,C_PARTES
    FROM V_ALUDGR_TALLER FI 
    inner join TB_TALLER_PAGOS PA ON FI.ALUDGR_ALUMNO=PA.ID_ALUMNO
    inner join TB_TALLER_PROGRAMACION PR ON PR.ID_PROGRAMACION=PA.ID_PROGRAMACION
    INNER JOIN TB_TALLER_CURSOS CU ON CU.ID_CURSO=PR.ID_CURSO
    WHERE id_pago='$_GET[id_pago]'";
$row1=$bd->fetch_row($sql);

/*$rows1[] = Array('ID_PAGO'=>'14001','C_ANO'=>'2014','c_nomcur'=>'AQUABEBE','C_SECCION'=>'A','D_INICIO'=>'2014-01-06 00:00:00.0','D_FIN'=>'2014-02-15 00:00:00.0','C_PRIDIA'=>'M1213','C_SEGDIA'=>'J1213','C_TERDIA'=>'000','C_APEPAT'=>'QUIROZ','C_APEMAT'=>'MAMANI','C_NOMBRES'=>'JUAN','N_CANTIDAD'=>'100','N_RESTA'=>'50');
$row1 = $rows1[0];*/

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
$pdf->Cell(0,2,'' ,'LTR',1);

$pdf->Cell(20,5,'Recibi de:','L',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5, $row1['aludgr_apepat'].' '.$row1['aludgr_apemat'].', '.$row1['aludgr_nombres'] ,'R',1);

$pdf->Cell(0,5,'' ,'LR',1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(28,5,'La Cantidad de: ' ,'L',0);
$pdf->SetFont('Arial','B',10);
$_cantidad = $row1['N_CANTIDAD'];
//$_cantidad = 100;
//$txt_cantidad = num2letras($_cantidad);
 $V = new EnLetras(); 
 $txt_cantidad = strtoupper($V->ValorEnLetras($_cantidad,"NUEVOS SOLES") ); 
$pdf->Cell(0,5, $txt_cantidad ,'R',1);

$pdf->Cell(0,5,'' ,'LR',1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(45,5,'Por Concepto del Taller de: ' ,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5, $row1['C_NOMCUR'] ,'R',1);

$pdf->Cell(0,5,'' ,'LR',1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(15,5,'Horario: ' ,'L',0);
$pdf->SetFont('Arial','B',10);

/*$txt_horario = '';
$txt_horario .= ($row1['C_PRIDIA']=='000')?'':( substr($row1['C_PRIDIA'],0,1).' '.substr($row1['C_PRIDIA'],1,2).'-'.substr($row1['C_PRIDIA'],3,2).'  ' );
$txt_horario .= ($row1['C_SEGDIA']=='000')?'':( substr($row1['C_SEGDIA'],0,1).' '.substr($row1['C_SEGDIA'],1,2).'-'.substr($row1['C_SEGDIA'],3,2).'  ' );
$txt_horario .= ($row1['C_TERDIA']=='000')?'':( substr($row1['C_TERDIA'],0,1).' '.substr($row1['C_TERDIA'],1,2).'-'.substr($row1['C_TERDIA'],3,2).'  ' );*/

$pdf->Cell(0,5,$row1['horario'] ,'R',1);

$pdf->Cell(0,5,'' ,'LBR',1);

$pdf->Ln();

$pdf->SetFont('Arial','',10);

$pdf->Cell(130,5,'Observaciones:','LTR',0);
$pdf->Cell(10,5,'',0,0);$pdf->Cell(50,5,'' ,'TLR',1);
if($row1['N_RESTA']>0)
  $obs="Adeuda: S/. ". number_format($row1['N_RESTA'],2)."";
else 
  $obs="";

if($row1['C_PARTES']=='2DA')
  $obs.="PAGO DE 2DA CUOTA";
elseif ($row1['C_PARTES']=='1RA') 
  $obs.="PAGO DE 1RA CUOTA";
else
  $obs.="CANCELACION DEL TALLER $row1[C_NOMCUR] ";

$pdf->Cell(5,5,'','L',0);$pdf->Cell(125,5,$obs.'  '.$row1[C_OBS] ,'R',0);
$pdf->Cell(10,5,'',0,0);$pdf->Cell(50,5,'' ,'LR',1);

$pdf->Cell(5,5,'','L',0);$pdf->Cell(125,5,'','R',0);
$pdf->Cell(10,5,'',0,0);$pdf->Cell(50,5,'' ,'LR',1);

$pdf->Cell(5,5,'','L',0);$pdf->Cell(125,5,'','R',0);
$pdf->Cell(10,5,'',0,0);$pdf->Cell(50,5,'' ,'LR',1);


$pdf->Cell(5,5,'','LB',0);$pdf->Cell(125,5,'','BR',0);
$pdf->Cell(10,5,'',0,0);$pdf->Cell(50,5,'Firma y Sello' ,'BLR',1,'C');
/*
$pdf->Cell(130,20,'',0,0);$pdf->Cell(50,20,'' ,'TLR',1);
$pdf->Cell(130,5,'',0,0); $pdf->Cell(50,5,'Firma y Sello' ,'BLR',1,'C');
*/
$pdf->Output();
?>