<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m003/vie.js"></script>

    <h1>Talleres de Verano</h1>
    <h3>Segundo Pago.</h3>

<?  
    echo "<br><hr>";  
    $this->input("string:50",   "Nombre Alumno",    "m003_2da_deudor");
    echo "<br><hr>";
    date_default_timezone_set('UTC');  
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

    <div id="detalle_c_2da" style="float:right;width:650px;visibility: hidden" >    
    <table style="border-spacing: 0px;border-collapse: collapse;border: 1px solid #DDD;width:550px;" border="1">
    <tbody>
      <tr>
        <td style="text-align: right;">Recibo:</td>
        <td align="center">
        <big style="font-style: italic;"><div id="numrec_003" style="color: rgb(255, 0, 0); font-weight: bold;"></div></big>
        </td>
        <td colspan="2" rowspan="1" style="text-align: center;">
        <big style="font-style: italic;"><span style="color: rgb(255, 0, 0); font-weight: bold;">
        <div id="fechahoy_"><?=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');?></div>
        </span></big></td>
      </tr>
      <tr>
        <td style="text-align: right;">Pago Total</td>
        <td>
	<select disabled name="tot_" id="tot_" class="text_area" >
        <option selected value="TOT">TOT</option>
        <option value="1RA">1RA</option>
        </select>
        </td>
        <td colspan="2" rowspan="1" style="text-align: right;">Meses
	<select disabled name="meses_" id="meses_">
        <option value="0" selected>--</option>        
        <option value="1">1</option>
        <option value="2">2</option>
        </select>
        &nbsp; &nbsp; Vcs x Semana 
        <select disabled name="vxsem_" id="vxsem_" >
        <option value="0" selected>--</option>        
        <option value="2">2</option>
        <option value="3">3</option>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="1" rowspan="2" style="text-align: center;"><a href="#" id="adduser_"><img src="tema/imgs/addusers.png" border="0"></a></td>
        <td colspan="2" rowspan="1">Nombre del&nbsp;Alumno</td>
        <td>Cod. Alumno</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="1">
            <input size="45" style="text-transform:uppercase;" id="seg_003_nomalu" name="seg_003_nomalu" onfocus="this.select()"></td>
        <td><input size="11" name="seg_003_idalumno" id="seg_003_idalumno" class="text_area" readonly="readonly"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" rowspan="1">
        <div id="nomcur_2da_003" style="color: rgb(255, 0, 0); font-weight: bold;"></div></td>
        <td></td>
      </tr>
      <tr>
        <td >Monto Pagado:</td>
        <td>
            <input size="6" name="monto_2da_003" id="monto_2da_003" maxlength="4"  readonly="readonly">
        </td>
        <td style="text-align: right;">Debe:</td>
        <td> <input size="6" name="debe_" id="debe_" readonly="readonly" maxlength="4" value="0"></td>
      </tr>
      <tr>
        <td>Fecha Pago:</td>
        <td><?$this->input("date","","m003_2da_fp");?></td>
        <td><? $this->boton("m003_2da_aceptar","Pagar Deuda");?>
	</td>
        <td><? $this->boton("m003_2da_cancelar","Cancelar");?></td>
      </tr>
      <tr>
        <td>Observaci&oacute;n:</td>
        <td colspan="3" ><textarea id="obs_2da" rows="3" cols="40"></textarea></td>

      </tr>

    </tbody>
  </table>
    </div>
</td></tr></table>

  <?
  }
}
?>