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
    //$this->vie->cursos = $this->dat->cursos();
    //$this->vie->lista_doc = $this->dat->lista_doc();
    //$this->vie->dias = $this->dat->dias();  
    $this->vie->sex = $this->dat->sex();
    $this->vie->lista_cursos_p2 = $this->dat->lista_cursos_p2(); 
    $this->vie->inicio();
  }

  function lista_cursos_p($ano) {
    echo $this->dat->lista_cursos_p($ano);
  }
  function detalle_c($ano,$programa) {
    echo $this->dat->detalle_c($ano,$programa);
  }
  function buscar_alu($q) {
    echo $this->dat->buscar_alu($q);
  }
  function costo($programa,$tiempo) {
    echo $this->dat->costo($programa,$tiempo);
  }
  function debe($monto,$programa,$tiempo) {
    echo $this->dat->debe($monto,$programa,$tiempo);
  }
  function new_alu($apepat, $apemat, $nombres, $apoderado, $correo, $fono1,$fono2,$sex,$ano) {
    echo $this->dat->new_alu($apepat, $apemat, $nombres, $apoderado, $correo, $fono1,$fono2,$sex,$ano);
  }
  function ins_alu($idalumno,$fecpag,$idprograma,$partes,$canti,$resta,$obs,$cxp) {
    echo $this->dat->ins_alu($idalumno,$fecpag,$idprograma,$partes,$canti,$resta,$obs,$cxp);
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
