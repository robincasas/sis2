$(document).ready(function(){
  var m006_eve="app_adm/Talleres/m006/eve.php";
  $("#m006_select_actores").kendoDropDownList({
  change: function(e) {
    var value = this.value();
    if(value=="D") doc();
    else alu();
    }
  });

$("#m006_nomalu_modi_dat").kendoAutoComplete({
        minLength:3,
        dataTextField: "valor",
        dataValueField: "id",
        dataSource: {
        serverFiltering: true,
        transport: {
            read: {
                url : m006_eve,
                data : {
                    evento: 'buscar_alu',
                    q: function(){
                        return $("#m006_nomalu_modi_dat").data("kendoAutoComplete").value();
                    }
                }
            }
        }
        },
        placeholder: "Buscar Alumnos",
        select: function(e) {
            var dataItem = this.dataItem(e.item.index());
            $("#m006_inp_cod").val(dataItem["id"]);
            $("#m006_inp_pat").val(dataItem["C_APEPAT"]);
            $("#m006_inp_mat").val(dataItem["C_APEMAT"]);
            $("#m006_inp_nom").val(dataItem["C_NOMBRES"]);
            $("#m006_inp_mail").val(dataItem["C_EMAIL"]);
            $("#m006_inp_fono").val(dataItem["C_FONO1"]);
        }
    });

  

  var m006_grd_taller_docentes=$("#m006_grd_taller_docentes").data("kendoGrid");


  $("#m006_mante_alu_save").click(function(){
    var codalu=$("#m006_inp_cod").val();
    var apepat=$("#m006_inp_pat").val();
    var apemat=$("#m006_inp_mat").val();
    var nomalu=$("#m006_inp_nom").val();
    var mail=$("#m006_inp_mail").val();
    var fono=$("#m006_inp_fono").val();
      if(apepat=="" || apemat=="" || nomalu=="")
        alert("Campos claves, Vacios!!!!");
      else{
        $.ajax({
          url: m006_eve,
          type : 'POST',
          data : {
            evento:"save_change",
            codalu:codalu,
            apepat:apepat,
            apemat:apemat,
            nomalu:nomalu,
            mail:mail,
            fono:fono
          },
          dataType: 'json',
          success:function(r){
            if (r.exito==1){
              alert(r.mensaje);
              $("#m006_inp_mat").val("");
              $("#m006_inp_nom").val("");
              $("#m006_inp_mail").val("");
              $("#m006_inp_fono").val(""); 
              $("#m006_inp_pat").val(""); 
              $("#m006_inp_cod").val(""); 
              $("#m006_nomalu_modi_dat").val("");
              $("#m006_nomalu_modi_dat").focus();

            }else
              alert(r.exito);
          }
        });  
      }
  });
  







  /*----------------------------------------------------------------- NUEVO   */
  $("#m001_nuevo_win").kendoWindow({
    width: "600px",
    title: "Nuevo Programa",
    visible: false,
    resizable: false
  });
  var m001_nuevo_win= $("#m001_nuevo_win").data("kendoWindow");
  $("#m001_btn_nuevo_pr").click(function(){
    m001_nuevo_win.center();
    m001_nuevo_win.open();
  });

  $("#m001_nuevo_inp_cursos").kendoDropDownList();
  $("#m001_dia1").kendoDropDownList();
  $("#m001_dia2").kendoDropDownList();
  $("#m001_dia3").kendoDropDownList();
  $("#m001_d1h1").kendoDropDownList();
  $("#m001_d1h2").kendoDropDownList();
  $("#m001_d2h1").kendoDropDownList();
  $("#m001_d2h2").kendoDropDownList();
  $("#m001_d3h1").kendoDropDownList();
  $("#m001_d3h2").kendoDropDownList();
  $("#m001_lista_doc").kendoDropDownList();
  $("#m001_lista_costos").kendoDropDownList();
  $("#m001_ini").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
    $("#m001_fin").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
  $("#m001_ini_e").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
    $("#m001_fin_e").kendoDatePicker({
    format: "dd/MM/yyyy"
  });    
  $("#m001_nuevo_btn_grabar").click(function(){
    var 
    curso    =   $("#m001_nuevo_inp_cursos"),
    sec    =   $("#m001_nuevo_inp_sec"),
    vac  =   $("#m001_nuevo_inp_vac"),
    ini  =   $("#m001_ini"),
    fin     =   $("#m001_fin"),
    dia1  =   $("#m001_dia1"),
    d1h1  = $("#m001_d1h1"),
    d1h2  = $("#m001_d1h2"), 

    dia2  =   $("#m001_dia2"),
    d2h1  = $("#m001_d2h1"),
    d2h2  = $("#m001_d2h2"),    

    dia3  =   $("#m001_dia3"), 
    d3h1  = $("#m001_d3h1"),
    d3h2  = $("#m001_d3h2"),    

    ins     =   $("#m001_lista_doc"),
    obs = $("#m001_nuevo_inp_obs"),
    cos = $("#m001_lista_costos");

    cursor_on("#m001_nuevo_btn_grabar");
    $.ajax({
      url: m006_eve,
      type : "POST",
      data : {
        evento:"nuevo_grabar",
        header:"json",
        curso:curso.val(),
        sec:sec.val(),
        vac:vac.val(),
        ini:ini.val(),
        fin:fin.val(),
        dia1:dia1.val(),
        d1h1:d1h1.val(),
        d1h2:d1h2.val(),
        
        dia2:dia2.val(),
        d2h1:d2h1.val(),
        d2h2:d2h2.val(),
        
        dia3:dia3.val(),
        d3h1:d3h1.val(),
        d3h2:d3h2.val(),
        ins:ins.val(),        
        ano  : $("#m001_listar_inp_ano").val(),
        obs:obs.val(),
        cos:cos.val()
      },
      datatype: "json",
      success:function(r){
        if (r.exito==1){
          history(r.mensaje);
          cursor_off("#m001_nuevo_btn_grabar");
          $("#m001_nuevo_inp_sec").val('');
          $("#m001_nuevo_inp_vac").val('');
          $("#m001_nuevo_inp_obs").val('');
          m001_nuevo_win.close();          
          var grid = $("#m001_grd_programacion").data("kendoGrid");
          grid.dataSource.read();        

          
         /* vac.val('');
          ini.val('');
          fin.val('');
          dia1.val('0');*/
        }else{
          history(r.mensaje);
          cursor_off("#m001_nuevo_btn_grabar");
        }
      }
    });        
  });



  /*---------------------------------------------------------------- EDITAR   */
  $("#m001_editar_win_pr").kendoWindow({
    width: "605px",
    title: "Editar Programa",
    visible: false,
    resizable: false
  }).data("kendoWindow");
  var m001_editar_win_pr= $("#m001_editar_win_pr").data("kendoWindow");
  
  $("#m002_editar_inp_rol").kendoDropDownList();
  $("#m002_editar_inp_estado").kendoDropDownList();
  $("#m002_editar_inp_caduca").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
  
  $("#m001_btn_editar_pr").click(function(){
    var m001_grd_programacion=$("#m001_grd_programacion").data("kendoGrid");
    var grd_id  = $('[data-uid="'+m001_grd_programacion.select().data("uid")+'"] td:first').text();
    if (grd_id>0){
      cursor_on();
      $.ajax({
        url: m006_eve,
        type : "POST",
        data : {
          evento  : "editar_recuperar",
          header  : "json",
          id      : grd_id
        },
        datatype: "json",
        success  : function( r ){
          m001_editar_win_pr.center();
          m001_editar_win_pr.open();
          cursor_off();
          $("#m001_edit_inp_id_e").val(grd_id);
          $("#m001_nuevo_inp_cursos_e").val(r.ID_CURSO);
          $("#m001_nuevo_inp_sec_e").val(r.C_SECCION);
          $("#m001_nuevo_inp_vac_e").val(r.N_VACANTES);
          $("#m001_ini_e").val(r.D_INICIO);
          $("#m001_fin_e").val(r.D_FIN);
          $("#m001_dia1_e").val(r.d1);
          $("#m001_d1h1_e").val(r.d1h1);
          $("#m001_d1h2_e").val(r.d1h2);
          $("#m001_dia2_e").val(r.d2);
          $("#m001_d2h1_e").val(r.d2h1);
          $("#m001_d2h2_e").val(r.d2h2);
          $("#m001_dia3_e").val(r.d3);
          $("#m001_d3h1_e").val(r.d3h1);
          $("#m001_d3h2_e").val(r.d3h2);
          $("#m001_lista_doc_e").val(r.ID_PROFE);
          $("#m001_nuevo_inp_obs_e").val(r.C_OBS);
          $("#m001_lista_costos_e").val(r.ID_COSTO);          
          /*m001_editar_win_pr.open();
          m001_editar_win_pr.center();
          cursor_off();*/
        }
      });
    }else
      alert("Seleccione un registro");
  });

  $("#m001_nuevo_btn_grabar_e").click(function(){
    var 
    id_prg   =   $("#m001_edit_inp_id_e"),
    idcurso  =   $("#m001_nuevo_inp_cursos_e"),
    seccion  =   $("#m001_nuevo_inp_sec_e"),
    vacantes =   $("#m001_nuevo_inp_vac_e"),
    inicio   =   $("#m001_ini_e"),
    fin      =   $("#m001_fin_e"),
    d1       =   $("#m001_dia1_e"),
    d1h1     =   $("#m001_d1h1_e"),
    d1h2     =   $("#m001_d1h2_e"),
    d2       =   $("#m001_dia2_e"),
    d2h1     =   $("#m001_d2h1_e"),
    d2h2     =   $("#m001_d2h2_e"),
    d3       =   $("#m001_dia3_e"),
    d3h1     =   $("#m001_d3h1_e"),
    d3h2     =   $("#m001_d3h2_e"),
    profe    =   $("#m001_lista_doc_e");
    obs      =  $("#m001_nuevo_inp_obs_e");
    cos     = $("#m001_lista_costos_e");
    cursor_on("#m001_nuevo_btn_grabar_e")
    $.ajax({
      url: m006_eve,
      type : "POST",
      data : {
        evento  : "editar_grabar",
        header  : "json",
        id_prg   : id_prg.val(),
        idcurso      : idcurso.val(),
        seccion    : seccion.val(),
        vacantes    : vacantes.val(),
        inicio  : inicio.val(),
        fin  : fin.val(),
        d1     : d1.val(),
        d1h1  : d1h1.val(),
        d1h2  : d1h2.val(),
        d2     : d2.val(),
        d2h1  : d2h1.val(),
        d2h2  : d2h2.val(),
        d3     : d3.val(),
        d3h1  : d3h1.val(),
        d3h2  : d3h2.val(),
        profe : profe.val(),        
        ano  : $("#m001_listar_inp_ano").val(),
        obs : obs.val(),
        cos: cos.val()
      },
      datatype  : "json",
      success : function( r ){
        if (r.exito==1){
          history(r.mensaje);
          cursor_off("#m001_nuevo_btn_grabar_e");
          $("#m001_nuevo_inp_sec_e").val('');
          $("#m001_nuevo_inp_vac_e").val('');
          $("#m001_nuevo_inp_obs_e").val('');
          m001_editar_win_pr.close();          
          var grid = $("#m001_grd_programacion").data("kendoGrid");
          grid.dataSource.read();        
        }else{
          history(r.mensaje);
          cursor_off("#m001_nuevo_btn_grabar_e");
        }
      }
    });
        
  });
  
  $("#m001_btn_print1_pr").click(function(){    
    var m001_grd_programacion=$("#m001_grd_programacion").data("kendoGrid");
    var grd_id  = $('[data-uid="'+m001_grd_programacion.select().data("uid")+'"] td:first').text();
    if(grd_id>0){
      window.open('app_adm/Reportes/tarjeta_f.php?id_programacion='+grd_id);  
      window.open('app_adm/Reportes/tarjeta_b.php?id_programacion='+grd_id);    
    }else alert("Seleccione un curso Por favor");
  });    
  $("#m001_btn_print2_pr").click(function(){    
    var m001_grd_programacion=$("#m001_grd_programacion").data("kendoGrid");
    var grd_id  = $('[data-uid="'+m001_grd_programacion.select().data("uid")+'"] td:first').text();
    if(grd_id>0)
      window.open('app_adm/Reportes/control_asistencia.php?id_programacion='+grd_id);  
    else alert("Seleccione un curso Por favor");
  });
  $("#m001_btn_print3_pr").click(function(){    
    var m001_grd_programacion=$("#m001_grd_programacion").data("kendoGrid");
    var grd_id  = $('[data-uid="'+m001_grd_programacion.select().data("uid")+'"] td:first').text();
    if(grd_id>0)
      window.open('app_adm/Reportes/control_taller.php?id_programacion='+grd_id);  
    else alert("Seleccione un curso Por favor");
  });
  /*------------------------------------------------------- BORRAR             */
    
  $("#m001_btn_borrar_pr").click(function(){
    var m001_grd_programacion=$("#m001_grd_programacion").data("kendoGrid");
    var grd_id  = $('[data-uid="'+m001_grd_programacion.select().data("uid")+'"] td:first').text();
    if (grd_id>0){
      if (confirm('Seguro de Eliminar esta Programacion?')){
        cursor_on();
        $.ajax({
          url: m006_eve,
          type : "POST",
          data : {
            evento  : "borrar_pr",
            header  : "json",
            id      : grd_id
          },
          datatype: "json",
          success  : function( r ){
            if (r.exito==1){
              history(r.mensaje);
              alert("Se elimino con exito");
              cursor_off("#m001_btn_borrar_pr");
              var grid = $("#m001_grd_programacion").data("kendoGrid");
              grid.dataSource.read();        
            }else{
              history(r.mensaje);
              alert("No se puede Eliminar, existen alumnos Matriculados")
              cursor_off("#m001_btn_borrar_pr");
            }
          }
        });
      }
      else return false;
    }else
      alert("Seleccione un registro");
  });
  
});



function doc() {
  var m006_eve="app_adm/Talleres/m006/eve.php";
  $("#m006_grd_taller_docentes").show();
  $("#m006_taller_mante_alumno").css("display","none");    
      $("#m006_grd_taller_docentes").kendoGrid({
      dataSource: {
        type: "odata",
        transport: {
          read: {
            url: m006_eve,
            dataType: "json",
            data: {
              header: 'json',
              evento: 'listar'
            }
          }
        },
        schema: {
          data :"rows",
          total:"total",
          model: {
            fields: {
              ID_INSTRUCTOR: {
                type: "number"
              },
              C_APEPAT: {
                type: "string"
              },
              C_APEMAT: {
                type: "string"
              },
              C_NOMBRES: {
                type: "string"
              }
            }
          }
        },
        pageSize: 20,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
        orderBy:'ID_INSTRUCTOR'
      },
      height: 430,
      selectable: true,
      filterable: true,
      sortable: true,
      pageable: {
        pageSizes: [10, 25, 50],
        refresh: true,
        messages: {
          refresh: "Recargar grid"
        }
      },
      pageSizes: [10, 25, 50],
      columns: [
      {
        field:"ID_INSTRUCTOR",
        title: "ID",
        width: 30,
        filterable: false,hidden:true
      },
      {
        field:"C_APEPAT",
        title: "Paterno",
        width: 35,
        filterable: false
      },
      {
        field:"C_APEMAT",
        title: "Materno",
        width: 35,
        filterable: false
      },
      {
        field:"C_NOMBRES",
        title: "Nombres",
        width: 50,
        filterable: false
      }
      ]
    });
  $("#m006_btn_doc").show();  
  }
  function alu(){    
    $("#m006_grd_taller_docentes").css("display","none");
    $("#m006_btn_doc").css("display","none");
    $("#m006_taller_mante_alumno").show(); 
    $("#m006_nomalu_modi_dat").focus();

  }
