<?php

require "../../../inc/fwo_main.php";
require "biz.php";
$biz = new biz($_REQUEST["header"]);
switch ($_REQUEST["evento"]) {
  case "inicio" :
    $biz->inicio();
    break;
  case "listar" :
    $biz->listar($_REQUEST['orderby'], $_REQUEST['top'], $_REQUEST['skip']);
    break;
  case "buscar_alu":
      $biz->buscar_alu($_REQUEST['q']);
  break;
  case "save_change" :
    $biz->save_change($_REQUEST['codalu'], $_REQUEST['apepat'], $_REQUEST['apemat'], $_REQUEST['nomalu'], $_REQUEST['mail'], $_REQUEST['fono']);
  break;









  case "nuevo_grabar" :
    $biz->nuevo_grabar($_REQUEST['curso'], $_REQUEST['sec'], $_REQUEST['vac'], $_REQUEST['ini'], $_REQUEST['fin'], $_REQUEST['dia1'],$_REQUEST['d1h1'],$_REQUEST['d1h2'],$_REQUEST['dia2'],$_REQUEST['d2h1'],$_REQUEST['d2h2'], $_REQUEST['dia3'],$_REQUEST['d3h1'],$_REQUEST['d3h2'],$_REQUEST['ins'],$_REQUEST['ano'],$_REQUEST['obs'],$_REQUEST['cos']);
    break;
  case "editar_recuperar" :
    $biz->editar_recuperar($_REQUEST['id']);
    break;
  case "editar_grabar" :
    $biz->editar_grabar($_REQUEST['id_prg'],$_REQUEST['idcurso'], $_REQUEST['seccion'], $_REQUEST['vacantes'], $_REQUEST['inicio'], $_REQUEST['fin'], $_REQUEST['d1'],$_REQUEST['d1h1'],$_REQUEST['d1h2'],$_REQUEST['d2'],$_REQUEST['d2h1'],$_REQUEST['d2h2'], $_REQUEST['d3'],$_REQUEST['d3h1'],$_REQUEST['d3h2'],$_REQUEST['profe'],$_REQUEST['ano'],$_REQUEST['obs'],$_REQUEST['cos']);
    break;
  case "borrar_pr" :
    $biz->borrar_pr($_REQUEST['id']);
    break;



  case "borrar_si" :
    $biz->borrar_si($_REQUEST['id']);
    break;
}
?>
