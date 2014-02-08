<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m006/vie.js"></script>
    <h1>Talleres de Verano</h1>
    <h3>Mantenimiento Docentes - alumnos</h3>
     <!--<style scoped>
        .k-dropdown{
                    width: 250px;
                    vertical-align: middle;
                }
     </style>-->
<?  
    echo "<br><hr>";  
    $this->input("select",      "Actores",               "m006_select_actores", "", $this->actores);
    echo "<br><hr>";
    //$this->input("select", "Seleccionar Curso:", "m031_cbo_curso", 0, $this->cursos);
?>
    <div id="m006_grd_taller_docentes" >        
    </div>
    <div id="m006_btn_doc" style="display:none;">
        <?
        $this->boton("m006_btn_nuevo_doc","Nuevo");
        $this->boton("m006_btn_editar_doc","Editar");
        $this->boton("m006_btn_borrar_doc","Borrar");
        ?>
    </div>
    <div id="m006_taller_mante_alumno" style="display:none;">
        <?
        $this->input("string:50",   "Nombre Alumno",    "m006_nomalu_modi_dat");
        $this->input("string:10",   "Codigo",    "m006_inp_cod","","readonly=readonly");           
        $this->input("string:30",   "Paterno",    "m006_inp_pat");   
        $this->input("string:30",   "Materno",    "m006_inp_mat");   
        $this->input("string:30",   "Nombres",    "m006_inp_nom");   
        $this->input("string:30",   "Correo",    "m006_inp_mail");   
        $this->input("string:30",   "Fono",    "m006_inp_fono");                   
        echo "<br><br><br>";  
        $this->boton("m006_mante_alu_save","Guardar Cambios");
        $this->boton("m006_mante_alu_cancel","Cancelar");        
        echo "<br><hr>";  
        ?>        
    </div>    
    <br>
<?
    
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
