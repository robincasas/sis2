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
    $this->vie->actores = $this->dat->actores();

    $this->vie->lista_doc = $this->dat->lista_doc();
    $this->vie->inicio();   
  }

  function listar($orderby = "", $top = 0, $skip = 0) {
    echo $this->dat->listar($orderby, $top, $skip);
  }
  function buscar_alu($q) {
    echo $this->dat->buscar_alu($q);
  }
  function save_change($codalu, $apepat, $apemat, $nomalu, $mail, $fono) {
    echo $this->dat->save_change($codalu, $apepat, $apemat, $nomalu, $mail, $fono);
    //$this->vie->json($r);
  }











  function nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins,$ano,$obs,$cos) {
    $r = $this->dat->nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins,$ano,$obs,$cos);
    $this->vie->json($r);
  }

  function editar_recuperar($id) {
    $r = $this->dat->editar_recuperar($id);
    $this->vie->json($r);
  }
  function editar_grabar($id_prg,$idcurso, $seccion, $vacantes, $inicio, $fin, $d1,$d1h1,$d1h2,$d2,$d2h1,$d2h2, $d3,$d3h1,$d3h2,$profe,$ano,$obs,$cos) {
    $r = $this->dat->editar_grabar($id_prg,$idcurso, $seccion, $vacantes, $inicio, $fin, $d1,$d1h1,$d1h2,$d2,$d2h1,$d2h2, $d3,$d3h1,$d3h2,$profe,$ano,$obs,$cos);
    $this->vie->json($r);
  }
  function borrar_pr($id){
    $r = $this->dat->borrar_pr($id);
    $this->vie->json($r);
  }





  function borrar_si($id){
    $r = $this->dat->borrar_si($id);
    $this->vie->json($r);
  }
}

?>
