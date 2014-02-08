$(document).ready(function(){
    var m003_eve="app_adm/Talleres/m003/eve.php";    
    $('#m003_2da_deudor').focus();
    $("#m003_2da_deudor").kendoAutoComplete({
        minLength:3,
        dataTextField: "valor",
        dataValueField: "id",
        dataSource: {
        serverFiltering: true,
        transport: {
            read: {
                url : m003_eve,
                data : {
                    evento: 'buscar_alu',
                    q: function(){
                        return $("#m003_2da_deudor").data("kendoAutoComplete").value();
                    }
                }
            }
        }
        },
        placeholder: "Buscar Alumnos",
        select: function(e) {
            var dataItem = this.dataItem(e.item.index());
            $("#seg_003_idalumno").val(dataItem["id"]);
            $("#seg_003_nomalu").val(dataItem["valor"]);
            $("#detalle_c_2da").css("visibility","visible");
            llena_form(dataItem["id"]);
        }
    });

    $("#m003_2da_fp").kendoDatePicker({
      format: "dd/MM/yyyy",
      value: new Date()
    });  


  $("#m003_2da_cancelar").click(function(){
    $("#detalle_c_2da").css("visibility","hidden");
    $("#m003_2da_deudor").val("");
  }); 


  $("#m003_2da_aceptar").click(function(){
      if($("#seg_003_idalumno").val()=="" || $("#monto_2da_003").val()=="")
        alert("Le falta seleccionar algunos campos importantes");
      else{
        if(confirm("Esta seguro de registrar segundo Pago?")){
          var cxps = {}; $(".cxp2").each(function(){cxps[ $(this).data('cod') ] = $(this).val();})
          $.ajax({
            url: m003_eve,
            type: 'POST',
            data : {
              evento:"ins_alu",
              idalumno:$("#seg_003_idalumno").val(),
              canti: $("#monto_2da_003").val(),
              obs:$("#obs_2da").val(),
              fecpag: $("#m003_2da_fp").val(),
              cxp2: cxps
            },
            dataType: 'json',
            success: function(r){
              if (r.exito==1){
                history(r.mensaje);
                cursor_off("#m003_2da_aceptar");
                $("#detalle_c_2da").css("visibility","hidden");
                alert("Se genero el numero de recibo: "+r.numrec);
                $("#m003_2da_deudor").val("");
                window.open('app_adm/Reportes/recibo_pago.php?id_pago='+r.numrec);


              }else{
                history(r.mensaje);
                cursor_off("#m003_2da_aceptar");
                alert("Existen Campos claves vacios_")
              }
            }
          });
        }
        else return false;  //del confirm
      }      //del if idalumno
  });

});
function llena_form(id_alumno){
	var m003_eve="app_adm/Talleres/m003/eve.php";

    $.ajax({
        url: m003_eve,
        type: 'POST',
        data: "evento=detalle_c&id_alumno="+id_alumno,
        dataType: 'json', 
        success:function(r){
          //$("#obs_2da").focus();
          $("#numrec_003").html(r.numrec);
          $("#monto_2da_003").val(r.rsp.n_resta);
          $("#nomcur_2da_003").html(r.rsp.c_nomcur);  
          if(r.paquetes.length>0){
            $("#nomcur_2da_003").html("");
            $.each(r.paquetes,function(k,value){
              $("#nomcur_2da_003").append("<tr><td>"+value.C_NOMCUR+"</td><td><input class='cxp2' type='text' size='3' data-cod='"+value.ID_PAGO+"' name=cxp2["+value.ID_PAGO+"]></td></tr>") ;
            });
          }
        }
  	});    
}

