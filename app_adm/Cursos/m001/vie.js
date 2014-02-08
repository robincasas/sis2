$(document).ready(function(){
  var m002_eve="app_adm/Cursos/m001/eve.php";
  $("#m001_listar_inp_ano").focus();
  
  //$("#m001_btn_listar").click(function(){
  $("#m001_cap_grado").kendoDropDownList({
  change: function(e) {
    var ano=$("#m001_cap_anos").val();
    var grado=$("#m001_cap_grado").val();    
    $("#m001_grd_capacidades").kendoGrid({
    dataSource: {
      type: "odata",
      transport: {
        read: {
          url: m002_eve,
          dataType: "json",
          data: {
            header: 'json',
            evento: 'listar',
            ano: ano,
            grado: grado
          }
        }
      },
      schema: {
        data :"rows",
        total:"total",
        model: {
          fields: {
            id_capxcurso: {
              type: "number"
            },
            asiper_codigo: {
              type: "string"
            },
            curso_ce: {
              type: "string"
            },
            C_DESCRIP: {
              type: "string"
            },
            N_ORD: {
              type: "string"
            }
          }
        }
      },
      pageSize: 20,
      serverPaging: true,
      serverFiltering: true,
      serverSorting: true,
      orderBy:'id_capxcurso'
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
      field:"id_capxcurso",
      title: "ID",
      width: 10,
      filterable: false
    },
    {
      field:"asiper_codigo",
      title: "Cod",
      width: 10,
      filterable: false
    },
    {
      field:"curso_ce",
      title: "Nomcur",
      width: 90,
      filterable: false
    },
    {
      field:"C_DESCRIP",
      title: "Capacidad",
      width: 90,
      filterable: false
    },
    {
      field:"N_ORD",
      title: "Orden",
      width: 10,
      filterable: false
    }    
    ]
  });
  }
});
  


  var m001_grd_capacidades=$("#m001_grd_capacidades").data("kendoGrid");
  
  /*----------------------------------------------------------------- NUEVO   */
  $("#m001_nuevo_win").kendoWindow({
    width: "600px",
    title: "Nuevo Programa",
    visible: false,
    resizable: false
  });
  var m001_nuevo_win= $("#m001_nuevo_win").data("kendoWindow");
  $("#m001_btn_nuevo").click(function(){
    m001_nuevo_win.center();
    m001_nuevo_win.open();
  });

  $("#m001_cap_anos").kendoDropDownList();
  //$("#m001_cap_grado").kendoDropDownList();

  $("#m001_dia2").kendoDropDownList();
  $("#m001_dia3").kendoDropDownList();
  $("#m001_d1h1").kendoDropDownList();
  $("#m001_d1h2").kendoDropDownList();
  $("#m001_d2h1").kendoDropDownList();
  $("#m001_d2h2").kendoDropDownList();
  $("#m001_d3h1").kendoDropDownList();
  $("#m001_d3h2").kendoDropDownList();
  $("#m001_lista_doc").kendoDropDownList();
  $("#m001_ini").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
    $("#m001_fin").kendoDatePicker({
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

    ins     =   $("#m001_lista_doc")
    cursor_on("#m001_nuevo_btn_grabar");
    $.ajax({
      url: m002_eve,
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
        ins:ins.val()
      },
      datatype: "json",
      success:function(r){
        if (r.exito==1){
          history(r.mensaje);
          cursor_off("#m001_nuevo_btn_grabar");
          $("#m001_nuevo_inp_sec").val('');
          $("#m001_nuevo_inp_vac").val('');
          m002_nuevo_win.close();          
          var grid = $("#m001_grd_capacidades").data("kendoGrid");
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
  $("#m002_editar_win").kendoWindow({
    width: "605px",
    title: "Editar usuario",
    visible: false,
    resizable: false
  }).data("kendoWindow");
  var m002_editar_win= $("#m002_editar_win").data("kendoWindow");
  
  $("#m002_editar_inp_rol").kendoDropDownList();
  $("#m002_editar_inp_estado").kendoDropDownList();
  $("#m002_editar_inp_caduca").kendoDatePicker({
    format: "dd/MM/yyyy"
  });
  
  $("#m002_btn_editar").click(function(){
    var
    grd_id  = $('[data-uid="'+m001_grd_capacidades.select().data("uid")+'"] td:first').text();
    if (grd_id>0){
      cursor_on();
      $.ajax({
        url: m002_eve,
        type : "POST",
        data : {
          evento  : "editar_recuperar",
          header  : "json",
          id      : grd_id
        },
        datatype: "json",
        success  : function( r ){
          $("#m002_editar_inp_id").val(r.N_USUCOD);
          $("#m002_editar_inp_nick").val(r.C_USUNIC);
          $("#m002_editar_inp_correo").val(r.C_USUCOR); /*kendoComboBox*/
          $("#m002_editar_inp_rol").data("kendoDropDownList").value( r.N_ROLCOD );
          $("#m002_editar_inp_estado").data("kendoDropDownList").value( r.N_ESTCOD );
          $("#m002_editar_inp_caduca").val(r.F_USUVEN);
          m002_editar_win.open();
          m002_editar_win.center();
          cursor_off();
        }
      });
    }else
      alert("Seleccione un registro");
  });

  $("#m002_editar_btn_grabar").click(function(){
    var 
    id      =   $("#m002_editar_inp_id"),
    nick    =   $("#m002_editar_inp_nick"),
    pass    =   $("#m002_editar_inp_pass"),
    correo  =   $("#m002_editar_inp_correo"),
    estado  =   $("#m002_editar_inp_estado"),
    rol     =   $("#m002_editar_inp_rol"),
    caduca  =   $("#m002_editar_inp_caduca");
    cursor_on("#m002_editar_btn_grabar")
    $.ajax({
      url: m002_eve,
      type : "POST",
      data : {
        evento  : "editar_grabar",
        header  : "json",
        id      : id.val(),
        nick    : nick.val(),
        pass    : pass.val(),
        correo  : correo.val(),
        estado  : estado.val(),
        rol     : rol.val(),
        caduca  : caduca.val()
      },
      datatype  : "json",
      success : function( r ){
        if (r.exito==1){
          m002_editar_win.close();
          m001_grd_capacidades.dataSource.read();
          nick.val('');
          pass.val('');
          correo.val('');
          caduca.val('');
        }
        history(r.mensaje);
        cursor_off("#m002_editar_btn_grabar")
      }
    });
        
  });
  
  

  /*------------------------------------------------------- BORRAR             */
  $("#m002_borrar_win").kendoWindow({
    width: "605px",
    title: "Borrar usuario",
    visible: false,
    resizable: false
  });
  var m002_borrar_win = $("#m002_borrar_win").data("kendoWindow");
    
  $("#m002_btn_borrar").click(function(){
    var
    grd_id  = $('[data-uid="'+m001_grd_capacidades.select().data("uid")+'"] td:first').text();
    if (grd_id>0){
      cursor_on();
      $.ajax({
        url: m002_eve,
        type : "POST",
        data : {
          evento  : "borrar_evaluar",
          header  : "json",
          id      : grd_id
        },
        datatype: "json",
        success  : function( r ){
          $("#m002_borrar_inp_id").val(r.id);
          $("#m002_borrar_inp_nick").val(r.c_usunic);
          $("#m002_borrar_inp_obs").html(r.mensaje);
          history(r.mensaje);
          btn_state(r.exito,"#m002_borrar_btn_si");
          m002_borrar_win.open();
          m002_borrar_win.center();
          cursor_off();
        }
      });
    }else
      alert("Seleccione un registro");
  });


$("#m002_borrar_btn_si").click(function(){
    var 
    id    = $("#m002_borrar_inp_id");
    cursor_on("#m002_borrar_btn_si")
    $.ajax({
      url: m002_eve,
      type : "POST",
      data : {
        evento  : "borrar_si",
        header  : "json",
        id      : id.val()
      },
      datatype  : "json",
      success : function( r ){
        if (r.exito==1){
          m002_borrar_win.close();
          m002_grd_usuarios.dataSource.read();
          id.val('');
        }
        history(r.mensaje);
        cursor_off("#m002_borrar_btn_si")
      }
    });
        
  });
  
});
