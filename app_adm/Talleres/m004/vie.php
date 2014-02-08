<?php
/* modulo : m002
 * Mantenimiento principal de talleres
 */
class vie extends fwo_view{
function inicio(){
?>
    <script type="text/javascript" src="app_adm/Talleres/m004/vie.js"></script>
    <h1>Talleres de Verano</h1>
    <h3>Liquidacion diaria.</h3>

<?  
    echo "<br><hr>";  
    $this->input("date",   "Fecha",    "m004_date_liq");
    $this->boton("m004_btn_liq","Abrir Reporte PDF");    
    echo "<br><hr>";
}}
?>