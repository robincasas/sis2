<?php

require "../../../inc/fwo_main.php";
require "biz.php";
$biz = new biz($_REQUEST["header"]);
switch ($_REQUEST["evento"]) {
  case "inicio" :
    $biz->inicio();
    break;
  case "detalle_c":
    $biz->detalle_c($_REQUEST['id_alumno']);
    break;    
  case "buscar_alu":
    $biz->buscar_alu($_REQUEST['q']);
    break;
  case "ins_alu" :
    $biz->ins_alu($_REQUEST['idalumno'],$_REQUEST['idprograma'], $_REQUEST['obs']);
    break;
case "anu_alu" :
    $biz->anu_alu($_REQUEST['idalumno'], $_REQUEST['obs']);
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
