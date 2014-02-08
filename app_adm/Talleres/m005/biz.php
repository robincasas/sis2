<?php

require "vie.php";
require "dat.php";

class biz extends fwo_biz {

  function __construct($header) {
    $this->vie = new vie;
    $this->dat = new dat;
    $this->header($header);
  }

  function inicio() {
    $this->vie->inicio();
  }

  function detalle_c($id_alumno) {
    echo $this->dat->detalle_c($id_alumno);
  }
  function buscar_alu($q) {
    echo $this->dat->buscar_alu($q);
  }
  function ins_alu($idalumno,$idprograma,$obs) {
    echo $this->dat->ins_alu($idalumno,$idprograma,$obs);
  }
function anu_alu($idalumno,$obs) {
    echo $this->dat->anu_alu($idalumno,$obs);
  }






  function nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins) {
    $r = $this->dat->nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins);
    $this->vie->json($r);
  }

  function editar_recuperar($id) {
    $r = $this->dat->editar_recuperar($id);
    $this->vie->json($r);
  }
  function editar_grabar($id, $nick, $pass, $correo, $estado, $rol, $caduca) {
    $r = $this->dat->editar_grabar($id, $nick, $pass, $correo, $estado, $rol, $caduca);
    $this->vie->json($r);
  }
  function borrar_evaluar($id){
    $r = $this->dat->borrar_evaluar($id);
    $this->vie->json($r);
  }
  function borrar_si($id){
    $r = $this->dat->borrar_si($id);
    $this->vie->json($r);
  }
}

?>
