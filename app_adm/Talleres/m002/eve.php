<?php

require "../../../inc/fwo_main.php";
require "biz.php";
$biz = new biz($_REQUEST["header"]);
switch ($_REQUEST["evento"]) {
  case "inicio" :
    $biz->inicio();
    break;
  case "lista_cursos_p":
    $biz->lista_cursos_p($_REQUEST['ano']);
    break;    
  case "detalle_c":
    $biz->detalle_c($_REQUEST['ano'],$_REQUEST['programa']);
    break;    
  case "buscar_alu":
    $biz->buscar_alu($_REQUEST['q']);
    break;
  case "costo":
    $biz->costo($_REQUEST['programa'],$_REQUEST['tiempo']);
    break;
  case "debe":
    $biz->debe($_REQUEST['monto'],$_REQUEST['programa'],$_REQUEST['tiempo']);
    break;
  case "new_alu" :
    $biz->new_alu($_REQUEST['apepat'], $_REQUEST['apemat'], $_REQUEST['nombres'], $_REQUEST['apoderado'], $_REQUEST['correo'], $_REQUEST['fono1'],$_REQUEST['fono2'],$_REQUEST['sex'],$_REQUEST['ano']);
    break;
  case "ins_alu" :
    $biz->ins_alu($_REQUEST['idalumno'], $_REQUEST['fecpag'], $_REQUEST['idprograma'], $_REQUEST['partes'], $_REQUEST['canti'], $_REQUEST['resta'],$_REQUEST['obs'],$_REQUEST['cxp']);
    break;



  case "nuevo_grabar" :
    $biz->nuevo_grabar($_REQUEST['curso'], $_REQUEST['sec'], $_REQUEST['vac'], $_REQUEST['ini'], $_REQUEST['fin'], $_REQUEST['dia1'],$_REQUEST['d1h1'],$_REQUEST['d1h2'],$_REQUEST['dia2'],$_REQUEST['d2h1'],$_REQUEST['d2h2'], $_REQUEST['dia3'],$_REQUEST['d3h1'],$_REQUEST['d3h2'],$_REQUEST['ins']);
    break;
  case "editar_recuperar" :
    $biz->editar_recuperar($_REQUEST['id']);
    break;
  case "editar_grabar" :
    $biz->editar_grabar($_REQUEST['id'], $_REQUEST['nick'], $_REQUEST['pass'], $_REQUEST['correo'], $_REQUEST['estado'], $_REQUEST['rol'], $_REQUEST['caduca']);
    break;
  case "borrar_evaluar" :
    $biz->borrar_evaluar($_REQUEST['id']);
    break;
  case "borrar_si" :
    $biz->borrar_si($_REQUEST['id']);
    break;
}
?>
