<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m001/vie.js"></script>
    <h1>Talleres de Verano</h1>
    <h3>Agregar, eliminar o actualizar Talleres por verano.</h3>
     <!--<style scoped>
        .k-dropdown{
                    width: 250px;
                    vertical-align: middle;
                }
     </style>-->
<?  
    echo "<br><hr>";  
    $this->input("string:4",   "A&ntilde;o Taller",    "m001_listar_inp_ano");
    $this->boton("m001_btn_listar","Listar Cursos");    
    echo "<br><hr>";
    //$this->input("select", "Seleccionar Curso:", "m031_cbo_curso", 0, $this->cursos);
?>
    <div id="m001_grd_programacion"></div>
    <br>
<?
    $this->boton("m001_btn_nuevo_pr","Nuevo");
    $this->boton("m001_btn_editar_pr","Editar");
    $this->boton("m001_btn_borrar_pr","Borrar");
    $this->boton("m001_btn_print1_pr","Carnets");
    $this->boton("m001_btn_print2_pr","Asistencia");
    $this->boton("m001_btn_print3_pr","Control");

    $this->nuevo();
    $this->editar();
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

        $this->input("select",      "Dia3",               "m001_dia3", "", $this->dias);
        $this->input("select",      "Ini",               "m001_d3h1", "", $this->horas);
        $this->input("select",      "Fin",               "m001_d3h2", "", $this->horas);  
        $this->input("select",      "Instructor",       "m001_lista_doc", "", $this->lista_doc); 
        $this->input("select",      "Costos",       "m001_lista_costos", "", $this->costos);        
        $this->input("string:30",   "OBS",    "m001_nuevo_inp_obs");   
        $this->br(); 
        $this->hr();          
        //echo "<br><hr>";
        $this->boton("m001_nuevo_btn_grabar","Grabar");
        ?>
    </div>
<?
}

function editar(){
?>
    <div id="m001_editar_win_pr">
        <?
        $this->input("hidden:20",   "idprg",   "m001_edit_inp_id_e");
        $this->input("select2",      "Curso",                "m001_nuevo_inp_cursos_e", "", $this->cursos);
        $this->input("string:3",   "Secci&oacute;n",       "m001_nuevo_inp_sec_e");
        $this->input("input2:4",   "Vacantes",    "m001_nuevo_inp_vac_e");
        $this->input("date",        "Inicia",               "m001_ini_e");
        $this->input("date",        "Finaliza",             "m001_fin_e");

        $this->input("select2",      "Dia1",               "m001_dia1_e", "", $this->dias,"45");
        $this->input("select2",      "",               "m001_d1h1_e", "", $this->horas,"15");
        $this->input("select2",      "",               "m001_d1h2_e", "", $this->horas,"15");        
        $this->br();
        $this->input("select2",      "Dia2",               "m001_dia2_e", "", $this->dias,"45"); 
        $this->input("select2",      "",               "m001_d2h1_e", "", $this->horas,"15");
        $this->input("select2",      "",               "m001_d2h2_e", "", $this->horas,"15");        
        $this->br();
        $this->input("select2",      "Dia3",               "m001_dia3_e", "", $this->dias,"45");
        $this->input("select2",      "",               "m001_d3h1_e", "", $this->horas,"15");
        $this->input("select2",      "",               "m001_d3h2_e", "", $this->horas,"15");  
        $this->br();        
        $this->input("select2",      "Instructor",       "m001_lista_doc_e", "", $this->lista_doc); 
        $this->br();
        $this->input("select2",      "Costos",       "m001_lista_costos_e", "", $this->costos);    
        $this->input("string:30",   "OBS",    "m001_nuevo_inp_obs_e");

        echo "<br><br><hr>";
        $this->boton("m001_nuevo_btn_grabar_e","Grabar");
        ?>
    </div>
<?
}



}
?>
