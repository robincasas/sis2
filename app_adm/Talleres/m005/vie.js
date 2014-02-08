$(document).ready(function(){
    var m005_eve="app_adm/Talleres/m005/eve.php";  
    $('#m005_nomalu_modi_matri').focus();
    $("#m005_nomalu_modi_matri").kendoAutoComplete({
        minLength:3,
        dataTextField: "valor",
        dataValueField: "id",
        dataSource: {
        serverFiltering: true,
        transport: {
            read: {
                url : m005_eve,
                data : {
                    evento: 'buscar_alu',
                    q: function(){
                        return $("#m005_nomalu_modi_matri").data("kendoAutoComplete").value();
                    }
                }
            }
        }
        },
        placeholder: "Buscar Alumnos",
        select: function(e) {
            var dataItem = this.dataItem(e.item.index());
            $("#change_005_idalumno").val(dataItem["id"]);
            $("#change_005_nomalu").val(dataItem["valor"]);
            $("#detalle_005_change").css("visibility","visible");
            $("#m005_change_cur_msg").html("");
            llena_form(dataItem["id"]);
        }
    });

  $("#m005_2da_cancelar").click(function(){
    $("#detalle_005_change").css("visibility","hidden");
    $("#m005_nomalu_modi_matri").val("");
  }); 


  $("#m005_2da_aceptar").click(function(){
      if($("#m005_sel_curso_cambio").val()=="0")
        alert("Seleccione un curso para el cambio.");
      else{
        if(confirm("Esta seguro de cambiar de curso al alumno?")){
          $.ajax({
            url: m005_eve,
            type: 'POST',
            data : {
              evento:"ins_alu",
              idalumno:$("#change_005_idalumno").val(),
              idprograma:$("#m005_sel_curso_cambio").val(),
              obs:$("#005_obs_change_cur").val()
            },
            dataType: 'json',
            success: function(r){              
              if (r.exito==1){
                $("#detalle_005_change").css("visibility","hidden");
                alert(r.mensaje);
                $("#m005_nomalu_modi_matri").val("");
                $("#m005_sel_curso_cambio").val("0");
                $("#005_obs_change_cur").val("");
              }else{
                alert(r.mensaje);
                $("#m005_change_cur_msg").html("NO HAY VACANTES");
              }
            }
          });
        }
        else return false;  //del confirm
      }      //del if idalumno
  });
  $("#m005_2da_anular").click(function(){
      if(confirm("ESTA SEGURO DE ANULAR LA MATRICULA DE: \n "+$("#change_005_nomalu").val()+"!!!!!!" )){
          $.ajax({
            url: m005_eve,
            type: 'POST',
            data : {
              evento:"anu_alu",
              idalumno:$("#change_005_idalumno").val(),
              obs:$("#005_obs_change_cur").val()
            },
            dataType: 'json',
            success: function(r){
              if (r.exito==1){
                $("#detalle_005_change").css("visibility","hidden");
                alert(r.mensaje);
                $("#m005_nomalu_modi_matri").val("");
                $("#m005_sel_curso_cambio").val("0");
                $("#005_obs_change_cur").val("");
              }else{
                alert(r.mensaje);                
              }
            }
          }); 
      }
      else return false;  //del confirm
  });  
});
function llena_form(id_alumno){
	var m005_eve="app_adm/Talleres/m005/eve.php";
    $.ajax({
        url: m005_eve,
        type: 'POST',
        data: "evento=detalle_c&id_alumno="+id_alumno,
        dataType: 'json', 
        success:function(r){
          $("#005_obs_change_cur").focus();
          $("#nomcur_change_cur_005").html(r.nomcur);
          $.each(r.rs,function(k,value){
            $("#m005_sel_curso_cambio").append("<option value="+value.value+">"+value.caption+"</option>");
          });           
        }
  	});    
}

