$(document).ready(function(){
  var m004_eve="app_adm/Talleres/m004/eve.php";
  $("#m004_date_liq").kendoDatePicker({
    format: "dd/MM/yyyy",
    value: new Date()
  });
  $("#m004_btn_liq").click(function(){
    var fecha=$("#m004_date_liq").val();
    if(fecha!=""){
      window.open('app_adm/Reportes/taller_liquidacion.php?fecha='+fecha);  
    }
    else alert("Ingrese una fecha");

  });   
  
});
