<?php
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m002/vie.js"></script>
      <link rel="stylesheet" href="app_adm/Talleres/m002/chosen.min.css">

    <h1>Matricula Talleres de Verano</h1>
    <h3>Matricula por alumno.</h3>

<?  
    echo "<br><hr>";  
    $this->input("string:4",   "A&ntilde;o Taller",    "m002_listar_ano_mat");
    $this->boton("m002_btn_listar_mat","Listar Cursos");    

    $this->input("string:5",   "Recibo",    "m002_inp_print_rec_mat");
    $this->boton("m002_btn_print_rec_mat","Imprimir Recibo");
    echo "<br><hr>";
    
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
?>
<style scoped>
        .k-autocomplete
                {
                    width: 250px;
                    vertical-align: middle;
                }

            </style>
    <table><tr><td>
  <div style="float:left;width:240px;">
      <select style="font-size: 11px;" name="idprg" id="idprg" multiple="multiple" size="30"></select>
    </div>
    <div id="detalle_c" style="float:left;width:565px;visibility: hidden" >
    
    <table style="border-spacing: 0px;border-collapse: collapse;border: 1px solid #DDD;width:550px;" border="1">
    <tbody>
      <tr>
        <td style="text-align: right;">Recibo:</td>
        <td align="center">
        <big style="font-style: italic;"><div id="numrec" style="color: rgb(255, 0, 0); font-weight: bold;"></div></big>
        </td>
        <td colspan="2" rowspan="1" style="text-align: center;">
        <big style="font-style: italic;"><span style="color: rgb(255, 0, 0); font-weight: bold;">
        <div id="fechahoy"></div>
        </span></big></td>
      </tr>
      <tr>
        <td style="text-align: right;">Pago Total</td>
        <td>
  <select name="tot" id="tot" class="text_area" >
        <option selected value="TOT">TOT</option>
        <option value="1RA">1RA</option>
        </select>
        </td>
        <td colspan="2" rowspan="1" style="text-align: right;">Meses
  <select name="meses" id="meses">
        <option value="0" selected>--</option>        
        <option value="1">1</option>
        <option value="2">2</option>
        </select>
        &nbsp; &nbsp; Vcs x Semana 
        <select name="vxsem" id="vxsem" >
        <option value="0" selected>--</option>        
        <option value="2">2</option>
        <option value="3">3</option>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="1" rowspan="2" style="text-align: center;"><a href="#" id="adduser"><img src="tema/imgs/addusers.png" border="0"></a></td>
        <td colspan="2" rowspan="1">Nombre del&nbsp;Alumno</td>
        <td>Cod. Alumno</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="1">
            <input size="45" style="text-transform:uppercase;" id="nomalu" name="nomalu" onfocus="this.select()"></td>
        <td><input size="11" name="idalumno" id="idalumno" class="text_area" readonly="readonly"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" rowspan="1"><div id="nomcur" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td><div id="codcur" style="color: rgb(255, 0, 0); font-weight: bold;">
          
        <select data-placeholder="Cursos por paquetes....." class="chosen-select" multiple style="font-size: 9px;width:350px;" tabindex="4" id="all">
          <?php
            foreach ($this->lista_cursos_p2 as $val) {
              echo "<option style='font-size: 9px;' value='$val[ID]'>$val[C_NOMCUR]</option>";
            }
          ?>           
          </select>

        </div></td>
      </tr>
      
      <tr>
        <td colspan="2" rowspan="1"><a href="#" id="mxcurso1">Montos por Curso de paquetes:</a></td>
        <td colspan="2" rowspan="1"><div id="mxcurso2"></div></td>
      </tr>

      <tr>
        <td >Monto Pagado:</td>
        <td>
            <input size="6" name="monto" id="monto" maxlength="4"  onKeyPress="return soloNumerosAll(event)">
        </td>
        <td style="text-align: right;">Debe:</td>
        <td> <input size="6" name="debe" id="debe" maxlength="4" value="0"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><? $this->boton("m002_mat_aceptar","Inscribir Alumno");?>
  </td>
        <td><? $this->boton("m002_mat_cancelar","Cancelar Inscripci&oacute;n");?></td>
      </tr>
      <tr>
        <td>Observaci&oacute;n:</td>
        <td colspan="3" ><textarea id="obs_mat" rows="2" cols="40"></textarea></td>

      </tr>
      <tr>
        <td>Horario:</td>
        <td colspan="2" rowspan="1"><div id="horario" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td><?$this->input("date","","m002_mat_fp");?></td>
      </tr>
      <tr>
        <td>Inicio:</td>
        <td><div id="inicio" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td colspan="2" rowspan="2">

<table style="border-spacing: 0px;border-collapse: collapse;border: 1px solid #DDD;" border="1">
<tbody>
<tr style="background-color: rgb(153, 153, 153); font-weight: bold;">
    <td></td>
    <td >2VXS</td>
    <td >3VXS</td>
</tr>
<tr>
    <td style="vertical-align: top; background-color: rgb(153, 153, 153);"><span
    style="font-weight: bold;">1M</span></td>
    <td id="a"></td>
    <td id="b"></td>
</tr>
<tr>
    <td style="vertical-align: top; background-color: rgb(153, 153, 153);"><span
    style="font-weight: bold;">2M</span></td>
    <td id="c"></td>
    <td id="d"></td>
</tr>
</tbody>
</table>
</td>
      </tr>
      <tr>
        <td>Matriculados:</td>
        <td><div id="matriculados" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
      </tr>
      <tr>
        <td>Vacantes:</td>
        <td><div id="vacantes" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td><div id="docente" style="color: rgb(0, 0, 102); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
    </div>
</td></tr></table>
<input type="hidden" id="idprograma">
  <script src="app_adm/Talleres/m002/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }    
  </script>

<?    
}
}
?>
