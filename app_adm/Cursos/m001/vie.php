<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Cursos/m001/vie.js"></script>
    <h1>Capacidades por curso</h1>
    <h3>Definir Capacidades por curso</h3>
<?  
    echo "<br><hr>";  
    $this->input("select",      utf8_decode("Año Escolar"),               "m001_cap_anos", "2013", $this->anos);
    $this->input("select",      utf8_decode("Grado"),               "m001_cap_grado", "", $this->grados);    
    //$this->boton("m001_btn_listar","Listar Cursos");    
    echo "<br><hr>";
    //$this->input("select", "Seleccionar Curso:", "m031_cbo_curso", 0, $this->cursos);
?>
    <div id="m001_grd_capacidades"></div>
    <br>
<?
    $this->boton("m001_btn_nuevo","Nuevo");
    $this->boton("m002_btn_editar","Editar");
    $this->boton("m002_btn_borrar","Borrar");

    $this->nuevo();
    $this->editar();
    $this->borrar();
}

function nuevo(){
?>
    <div id="m001_nuevo_win">
        <?
        $this->input("select",      "Curso",                "m001_nuevo_inp_cursos", "", $this->cursos);
        $this->input("string:3",   "Secci&oacute;n",       "m001_nuevo_inp_sec");
        $this->input("input2:4",   "Vacantes",    "m001_nuevo_inp_vac");
        $this->input("date",        "Inicia",               "m001_ini");
        $this->input("date",        "Finaliza",             "m001_fin");                
        $this->input("select",      "Dia1",               "m001_dia1", "", $this->dias);
        $this->input("select",      "Ini",               "m001_d1h1", "", $this->horas);
        $this->input("select",      "Fin",               "m001_d1h2", "", $this->horas);        
        $this->input("select",      "Dia2",               "m001_dia2", "", $this->dias); 
        $this->input("select",      "Ini",               "m001_d2h1", "", $this->horas);
        $this->input("select",      "Fin",               "m001_d2h2", "", $this->horas);        
        $this->input("select",      "Dia2",               "m001_dia3", "", $this->dias);
        $this->input("select",      "Ini",               "m001_d3h1", "", $this->horas);
        $this->input("select",      "Fin",               "m001_d3h2", "", $this->horas);  
        $this->input("select",      "Instructor",       "m001_lista_doc", "", $this->lista_doc);      
        echo "<br><hr>";
        $this->boton("m001_nuevo_btn_grabar","Grabar");
        ?>
    </div>
<?
}

function editar(){
?>
    <div id="m002_editar_win">
        <?
        $this->input("hidden:20",   "id",                   "m002_editar_inp_id");
        $this->input("string:20",   "Nick",                 "m002_editar_inp_nick");
        $this->input("string:10",   "Contrase&ntilde;a",    "m002_editar_inp_pass");
        
        $this->input("string:40",   "Paterno",    "m002_editar_inp_pat");
        $this->input("string:40",   "Materno",    "m002_editar_inp_mat");
        $this->input("string:40",   "Nombres",    "m002_editar_inp_nom");
        
        $this->input("string:50",   "Correo",               "m002_editar_inp_correo");
        $this->input("select",      "Estado",               "m002_editar_inp_estado", "", $this->estados);
        $this->input("select",      "Rol",                  "m002_editar_inp_rol", "", $this->roles);
        $this->input("date",        "Caduca",               "m002_editar_inp_caduca");
        echo "<br><hr>";
        $this->boton("m002_editar_btn_grabar","Grabar");
        ?>
    </div>
<?
}
function borrar(){
?>
    <div id="m002_borrar_win">
        <?
        $this->input("hidden:20",   "id",   "m002_borrar_inp_id");
        $this->input("string:20",   "Nick", "m002_borrar_inp_nick");
        $this->div(450,"Observaciones:","m002_borrar_inp_obs");
        $this->boton("m002_borrar_btn_si","Si, Borrar");
        ?>
    </div>
<?
}



}
?>
