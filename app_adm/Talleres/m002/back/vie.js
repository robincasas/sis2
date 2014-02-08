   $(document).ready(function(){
    var m002_eve="app_adm/Talleres/m002/eve.php";    
    $('#m002_listar_ano_mat').focus();
    $("#m002_mat_fp").kendoDatePicker({
      format: "dd/MM/yyyy",
      value: new Date()
    });  

  $("#mxcurso1").click(function(){
    if($("#all").val()!=null){
      var mystr= $("#all").val();
      $("#mxcurso2").html("<table>");
      for (var i = 0; i < mystr.length; i++) {
        var myarr= mystr[i].split("-");
        $("#mxcurso2").append("<tr><td>"+mystr[i]+": </td><td><input type='text' size='3' name='m["+myarr[0]+"]'></td></tr>") ;
      }
      $("#mxcurso2").append("</table>");
    }
    else
      alert("PARA ESTA OPCION PRIMERO DEBE SELECCIONAR LOS CURSOS POR PAQUETES.");
  });
	$("#agregar").click(function(){
		$("#codcurs").append($("#idprograma").val()+'-'+$("#nomcur").html()+"<br>");
	});

    $("#m002_btn_listar_mat").click(function(){
    	var ano=$("#m002_listar_ano_mat").val();
        $.ajax({
            url: m002_eve,
            type: 'POST',
            data: "evento=lista_cursos_p&ano="+ano,
            //dataType: 'json', 
            success:function(r){
            	$("#idprg").html(r);
            }
  		});
  	});
    $("#m002_nuevo_win_mat").kendoWindow({
      width: "450px",
      title: "Nuevo Alumno Externo",
      visible: false,
      resizable: false
    });
    var m002_nuevo_win_mat= $("#m002_nuevo_win_mat").data("kendoWindow");
    $("#adduser").click(function(){
      m002_nuevo_win_mat.open();          
      m002_nuevo_win_mat.center();
      //cursor_off();
      $("#m002_new_mat_pat").val('');
      $("#m002_new_mat_mat").val('');
      $("#m002_new_mat_nom").val('');
      $("#m002_new_mat_apo").val(''); 
      $("#m002_new_mat_correo").val('');
      $("#m002_new_mat_fono1").val('');
      $("#m002_new_mat_fono2").val('');
      $("#m002_new_mat_sex").val('0');
      //cursor_off();
    });
    $("#nomalu").kendoAutoComplete({
        minLength:3,
        dataTextField: "valor",
        dataValueField: "id",
        dataSource: {
        serverFiltering: true,
        transport: {
            read: {
                url : m002_eve,
                data : {
                    evento: 'buscar_alu',
                    q: function(){
                        return $("#nomalu").data("kendoAutoComplete").value();
                    }
                }
            }
        }
        },
        placeholder: "Buscar Alumnos",
        select: function(e) {
            var dataItem = this.dataItem(e.item.index());
            $("#idalumno").val(dataItem["id"]); 
        }
    });
    $("#meses").change(function(){      
      if($("#vxsem").val()!=0 && $("#tot").val()!='1RA')
            costo();
    });
    $("#vxsem").change(function(){
      if($("#meses").val()!=0 && $("#tot").val()!='1RA') 
            costo();
    });
    
    $("#tot").change(function(){
      if($(this).val()=="TOT" && $("#meses").val()!=0 && $("#vxsem").val()!=0) 
        costo();
    });
    $("#monto").blur(function(){
      if($("#tot").val()=="1RA" && $("#meses").val()!=0 && $("#vxsem").val()!=0){
        var tiempo=$("#meses").val()+'*'+$("#vxsem").val();
        $.ajax({
          url: m002_eve,
          type: 'POST',
          data: "evento=debe&monto="+$(this).val()+"&programa="+$("#idprograma").val()+"&tiempo="+tiempo,
          dataType: 'json', 
          success:function(r){
              if(r<0){
                alert("MONTO NEGATIVO, VERIFIQUE");
                $("#monto").val("");
                $("#debe").val("");
                $("#monto").focus();
              }
              else
                $("#debe").val(r);
          }
        }); 
      }
    });
    $("#m002_new_mat_sex").kendoDropDownList();
  $("#m002_new_btn_mat_grabar").click(function(){
    if($("#m002_new_mat_pat").val()=="" || $("#m002_new_mat_mat").val()=="" || $("#m002_new_mat_nom").val()=="")
        alert("Le falta seleccionar algunos campos importantes");
    else{
      $.ajax({
          url: m002_eve,
          type: 'POST',
          data: "evento=new_alu&apepat="+$("#m002_new_mat_pat").val()+"&apemat="+$("#m002_new_mat_mat").val()+"&nombres="+$("#m002_new_mat_nom").val()+"&apoderado="+$("#m002_new_mat_apo").val()+"&correo="+$("#m002_new_mat_correo").val()+"&fono1="+$("#m002_new_mat_fono1").val()+"&fono2="+$("#m002_new_mat_fono2").val()+"&sex="+$("#m002_new_mat_sex").val()+"&ano="+$("#m002_listar_ano_mat").val(),
          dataType: 'json', 
          success:function(r){
            if (r.exito==1){
              history(r.mensaje);
              cursor_off("#m002_new_btn_mat_grabar");                           
              $("#nomalu").val($("#m002_new_mat_pat").val()+"-"+$("#m002_new_mat_mat").val()+"-"+$("#m002_new_mat_nom").val());
              $("#idalumno").val(r.newcod);
              m002_nuevo_win_mat.close();
              //alert(r.newcod);

            }else{
              history(r.mensaje);
              cursor_off("#m002_new_btn_mat_grabar");
            }
          }
      });
    } //else campos vacios
  });    
  $("#m002_mat_cancelar").click(function(){
    $("#detalle_c").css("visibility","hidden");
  }); 
  $("#m002_mat_aceptar").click(function(){    //matricular
      if($("#idalumno").val()=="" || $("#meses").val()=="0" || $("#vxsem").val()=="0" || ($("#monto").val()=="0" && $("#debe").val()=="0"))
        alert("Le falta seleccionar algunos campos importantes");
      else{
        if(confirm("Esta seguro de inscribir al alumno?")){
          $.ajax({
            url: m002_eve,
            type: 'POST',
            data : {
              evento:"ins_alu",
              idalumno:$("#idalumno").val(),
              fecpag: $("#m002_mat_fp").val(),
              idprograma:$("#idprograma").val(),
              partes:$("#tot").val(),
              canti:$("#monto").val(),
              resta:$("#debe").val(),
              obs:$("#obs_mat").val(),
              codcurs:$("#codcurs").html(),
              cxp: $("input[name='m']").val()
            },
            dataType: 'json',
            success: function(r){
              if (r.exito==1){
                history(r.mensaje);
                cursor_off("#m002_mat_aceptar");
                $("#detalle_c").css("visibility","hidden");
                alert("Se genero el numero de recibo: "+r.numrec);
                window.open('app_adm/Reportes/recibo_pago.php?id_pago='+r.numrec);

              }else{
                history(r.mensaje);
                cursor_off("#m002_mat_aceptar");
                alert("Existen Campos claves vacios_")
              }
            }
          });
        }
        else return false;  //del confirm
      }      //del if idalumno
  });
  $("#m002_btn_print_rec_mat").click(function(){
    var rec_print=$("#m002_inp_print_rec_mat").val();
    if(rec_print.length==5)
      window.open('app_adm/Reportes/recibo_pago.php?id_pago='+rec_print);
    else
      alert("FORMATO DE RECIBO INCORRECTO");
  });  
});
function selecc(programa){
	var m002_eve="app_adm/Talleres/m002/eve.php";
	var ano=$("#m002_listar_ano_mat").val();
  $("#idprograma").val(programa);
  $("#detalle_c").css("visibility","visible");
    $.ajax({
        url: m002_eve,
        type: 'POST',
        data: "evento=detalle_c&ano="+ano+"&programa="+programa,
        dataType: 'json', 
        success:function(r){
            $("#tot").val("tot");
            $("#meses").val("0");
            $("#vxsem").val("0");
            $("#monto").val("0");
            $("#debe").val("0");
            $("#nomalu").val("");
            $("#idalumno").val("");
            $("#obs_mat").val("");
            $("#numrec").html(r.numrec);
            $("#nomcur").html(r.rsp.C_NOMCUR);
            $("#matriculados").html(r.nummat);
            if(r.copado==1){
              $("#vacantes").html(r.rsp.N_VACANTES+" ...<span style=\"color:blue\">VAC. COPADAS!!</span>");
              $("#m002_mat_aceptar").prop("disabled",true);
            }
            else{
              $("#m002_mat_aceptar").prop("disabled",false);
              $("#vacantes").html(r.rsp.N_VACANTES);
            }
          	$("#inicio").html(r.rsp.D_INICIO);
            $("#horario").html(r.horario);
            
            $("#a").html(r.rsc.M1S2);
            $("#b").html(r.rsc.M1S3);
            $("#c").html(r.rsc.M2S2);
            $("#d").html(r.rsc.M2S3);
        }
  	});    
}
function costo(){
  var m002_eve="app_adm/Talleres/m002/eve.php";
  var tiempo=$("#meses").val()+'*'+$("#vxsem").val();
  $.ajax({
    url: m002_eve,
    type: 'POST',
    data: "evento=costo&programa="+$("#idprograma").val()+"&tiempo="+tiempo,
    dataType: 'json', 
    success:function(r){
      $("#monto").val(r);     
    }
  });
}
function soloNumerosAll(e){
  tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }

    if (tecla==13){
        xajax_debe();
        return true;
    }
        
    patron =/\d/
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
