<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m005/vie.js"></script>

    <h1>Talleres de Verano</h1>
    <h3>Cambio de Cursos.</h3>

<?  
    echo "<br><hr>"; 
    $this->input("string:50",   "Nombre Alumno",    "m005_nomalu_modi_matri");
    echo "<br><hr>";
     
?>

<style scoped>
        .k-autocomplete
                {
                    width: 250px;
                    vertical-align: middle;
                }

            </style>
    <table><tr><td>

    <div id="detalle_005_change" style="float:right;width:650px;visibility: hidden" >    
    <table style="border-spacing: 0px;border-collapse: collapse;border: 1px solid #DDD;width:550px;" border="1">
    <tbody>
      
      
      <tr>
        <td colspan="1" rowspan="2" style="text-align: center;"><a href="#" id="adduser_"><img src="tema/imgs/addusers.png" border="0"></a></td>
        <td colspan="2" rowspan="1">Nombre del&nbsp;Alumno</td>
        <td>Cod. Alumno</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="1">
            <input size="45" id="change_005_nomalu" readonly="readonly" name="change_005_nomalu"></td>
        <td><input size="11" name="change_005_idalumno" id="change_005_idalumno" readonly="readonly"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" rowspan="1"><div id="nomcur_change_cur_005" style="color: rgb(255, 0, 0); font-weight: bold;"><big style="font-style: italic;"></big></div></td>
        <td><div id="m005_change_cur_msg" style="color: blue; font-weight: bold;"><big style="font-style: italic;"></big></div></td>
      </tr>
      <tr>
        <td colspan="1">Cambiar A:</td>
        <td colspan="3"><?$this->input("select2","","m005_sel_curso_cambio","",$this->cursos_change,"80");?></td>        
      </tr>
      <tr>
        <td></td>
        <td><? $this->boton("m005_2da_aceptar","Cambiar de Curso");?></td>
        <td><? $this->boton("m005_2da_anular","ANULAR MATRICULA");?>
	</td>
        <td><? $this->boton("m005_2da_cancelar","Cancelar");?></td>
      </tr>
      <tr>
        <td>Observaci&oacute;n:</td>
        <td colspan="3" ><textarea id="005_obs_change_cur" rows="3" cols="40"></textarea> </td>
<div id="msg"></div>
      </tr>

    </tbody>
  </table>
    </div>
</td></tr></table>

  <?
  }
}
?>