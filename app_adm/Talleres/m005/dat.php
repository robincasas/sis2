<?php

class dat {

    function __construct() {
        $this->bd = new fwo_dat("bd");
    }

    function detalle_c($id_alumno){
        list($id_alumno,$numrec_pago) = explode('-', $id_alumno);        
        $ano="20".substr($numrec_pago,0,2);


        $nomcur=$this->bd->fetch_cell("select c_nomcur+' '+rtrim(c_seccion)+', Horario: '+dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia)  as c_nomcur
            from TB_taller_pagos pa inner join tb_taller_programacion pr on(pa.id_programacion=pr.id_programacion)
            inner join tb_taller_cursos cu on cu.id_curso=pr.id_curso
            where id_pago='$numrec_pago'");

    	$sql="select id_programacion as value,c_nomcur+' '+rtrim(c_seccion)+', '+dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia)+',  VAC/MAT: '+CONVERT( VARCHAR(10),n_vacantes)+
             '/' +CONVERT( VARCHAR(10),(select count(id_pago) from tb_taller_pagos where c_partes in ('1RA','TOT') and c_activo='1' and id_programacion=p.id_programacion)) as caption
               FROM TB_TALLER_PROGRAMACION p inner join TB_TALLER_CURSOS c on p.id_curso=c.id_curso
               where p.c_ano='$ano' order by c_nomcur,c_seccion";
        $rs = $this->bd->fetch_result($sql);
        $r["nomcur"]=$nomcur;
        $r["rs"]=$rs;
    	return json_encode($r);
    }
    function buscar_alu($q){
        $q=strtoupper(utf8_decode($_REQUEST["q"]));
        for($k=0; $k<strlen($q); $k++){
            if ($q[$k]==utf8_decode("ñ"))
                $q[$k]=utf8_decode("Ñ");
        }
        $rs=$this->bd->fetch_result("select aludgr_alumno+'-'+CONVERT( VARCHAR(10),id_pago) as id,aludgr_apepat+' '+aludgr_apemat+' '+aludgr_nombres+' '+c_nomcur+' '+CONVERT( VARCHAR(10),id_pago) as valor 
                    from v_taller_alu_cur
                    where c_partes in('TOT','1RA') and c_activo='1' and  aludgr_apepat+' '+aludgr_apemat+' '+aludgr_nombres like '$q%'");
        $rs2=$this->bd->utf8json($rs);
        header('Content-type: application/json');
        echo json_encode($rs2);
    }
    
    function ins_alu($idalumno,$idprograma,$obs) {
        list($id_alumno,$numrec_pago) = explode('-', $idalumno);
        if (empty($idalumno) or ($idprograma==""))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            $nummat=$this->bd->fetch_cell("SELECT count(id_pago) from TB_TALLER_PAGOS where c_activo='1' and C_PARTES IN ('1RA','TOT') AND ID_PROGRAMACION='$idprograma';");
            $numvac=$this->bd->fetch_cell("select n_vacantes from TB_TALLER_PROGRAMACION where id_programacion='$idprograma'");
            if($nummat>=$numvac)
                $r = array( "exito"=>"0", "mensaje"=>"Ya no queda vacantes en este curso");
            else{
                $id_progra_old=$this->bd->fetch_cell("SELECT id_programacion from TB_TALLER_PAGOS where id_pago='$numrec_pago'");
                $sql="UPDATE TB_TALLER_PAGOS SET id_programacion='$idprograma',C_OBS='$obs' where id_alumno='$id_alumno' and id_programacion='$id_progra_old'";
                $this->bd->exe_sql($sql);
                $this->bd->exe_sql("INSERT INTO TB_TALLER_LOG(C_SQL,C_USER)values('".$this->bd->my_str($sql)."','$_SESSION[N_USUCOD]');");
                $r = array( "exito"=>"1", "mensaje"=>"Se Cambio de curso al alumno correctamente");
            }            
        }
        echo json_encode($r);
    }
    function anu_alu($idalumno,$obs) {
        list($id_alumno,$numrec_pago) = explode('-', $idalumno);
        if (empty($idalumno))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            if(trim($obs)=="") $cad_obs="";
            else $cad_obs=",C_OBS='$obs'";
            $id_progra_old=$this->bd->fetch_cell("SELECT id_programacion from TB_TALLER_PAGOS where id_pago='$numrec_pago'");
            $sql="UPDATE TB_TALLER_PAGOS set c_activo='0' $cad_obs where id_alumno='$id_alumno' and id_programacion='$id_progra_old'";
            $this->bd->exe_sql($sql);
            $this->bd->exe_sql("INSERT INTO TB_TALLER_LOG(C_SQL,C_USER)values('".$this->bd->my_str($sql)."','$_SESSION[N_USUCOD]');");
            $r = array( "exito"=>"1", "mensaje"=>"SE ANULO LA MATRICULA ".$numrec_pago." CORRECTAMENTE!!!!!");
        }
        echo json_encode($r);
    }
















    function estados() {
        $sql = "select N_ESTCOD as VALUE, C_ESTDES AS CAPTION from TB_USUARIO_ESTADO";
        return $this->estados = $this->bd->fetch_result($sql);
    }

    function listar($orderby, $top, $skip,$ano) {
        $sql = "SELECT N_USUCOD, C_USUNIC, C_USUCOR, C_ESTDES, C_ROLNOM, F_USUVEN FROM VW_USUARIO";
        $sql = "select id_programacion,c_nomcur,c_seccion,c_pridia+'-'+c_segdia+'-'+c_terdia as horario ,CONVERT( VARCHAR(10),d_inicio, 103)ini ,CONVERT( VARCHAR(10),d_fin, 103)fin,n_vacantes 
                from TB_TALLER_PROGRAMACION p inner join TB_TALLER_CURSOS c on p.id_curso=c.id_curso
                where c_ano='$ano' ";
        $rs = $this->bd->fetch_result($sql, $orderby, $top, $skip);
        return json_encode(array(
                    "total" => $this->bd->sql_count,
                    "rows" => $rs,
                    "sql" => $this->bd->sql_new
                        )
        );
    }
    function dias(){
        $d1 = array( "VALUE" => "L", "CAPTION" => "LUNES" ); 
        $d2 = array( "VALUE" => "M", "CAPTION" => "MARTES" );
        $d3 = array( "VALUE" => "R", "CAPTION" => "MIERCOLES");
        $d4 = array( "VALUE" => "J", "CAPTION" => "JUEVES");
        $d5 = array( "VALUE" => "V", "CAPTION" => "VIERNES" ); 
        $d6 = array( "VALUE" => "S", "CAPTION" => "SABADO" );        
        $d=array($d1,$d2,$d3,$d4,$d5,$d6); 
        return $d;    
    }
    function horas(){
        $h1 = array("VALUE" => "08","CAPTION"=>"08");
        $h2 = array("VALUE" => "09","CAPTION"=>"09");
        $h3 = array("VALUE" => "10","CAPTION"=>"10");
        $h4 = array("VALUE" => "11","CAPTION"=>"11");
        $h5 = array("VALUE" => "12","CAPTION"=>"12");
        $h6 = array("VALUE" => "13","CAPTION"=>"13");
        $h7 = array("VALUE" => "14","CAPTION"=>"14"); 
        $h=array($h1,$h2,$h3,$h4,$h5,$h6,$h7);
        return $h;
    }
    function lista_doc(){
        $sql = "select id_instructor as VALUE,c_apepat+'-'+c_apemat+'-'+c_nombres AS CAPTION from TB_TALLER_INSTRUCTOR order by c_apepat";
        return $this->cursos = $this->bd->fetch_result($sql);
    }

    function nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins) {
        $sec=trim($sec);
        $vac=trim($vac);
        if (empty($sec) or empty($vac) or empty($ini))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            /*$sql="select n_usucod from tb_usuario where c_usunic='$nick' or c_usucor='$correo' ";
            $e=$this->bd->fetch_cell($sql);
            if ($e){
                $r = array( "exito"=>0, "mensaje"=>"Nick o Correo duplicado");
            }else{
                $sql="select isnull( max(n_usucod)+1 ,1)  from tb_usuario ";
                $id=$this->bd->fetch_cell($sql);
*/
                $sql = "insert into tb_taller_programacion(id_costo,id_curso,c_ano,d_inicio,d_fin,c_seccion,id_profe,c_pridia,c_segdia,c_terdia,n_vacantes)
                    values ('1','$curso','2013','$ini','$fin','$sec','$ins','$dia1$d1h1$d1h2','$dia2$d2h1$d2h2','$dia3$d3h1$d3h2','$vac');";
                   
                $this->bd->exe_sql($sql);

                /*$sql = "insert into tbusuari(usuari_codigo, usuari_pass, usuari_apepat, usuari_apemat, usuari_nombre)
                    values ('$nick','".trim($pass)."','$pat', '$mat', '$nom')";
                $this->bds->exe_sql($sql);*/
                $r = array( "exito"=>"1", "mensaje"=>"Se inserto el curso");
           // }
        }
        return $r;
    }
    
    function editar_recuperar($id){
      $sql = "SELECT N_USUCOD, C_USUNIC, F_USUVEN, C_USUCOR, N_ESTCOD, N_ROLCOD, C_APEPAT, C_APEMAT, C_USUNOM 
              FROM TB_USUARIO 
              WHERE
              N_USUCOD = '$id'";
      return $this->bd->fetch_row($sql);
    }
    
    function editar_grabar($id, $nick, $pass, $correo, $estado, $rol, $caduca) {
        $nick=trim($nick);
        $correo=trim($correo);
        if (empty($nick) or empty($correo) or empty($pass))
            $r = array( "exito"=>0, "mensaje"=>"Nick, correo y clave no pueden estar vacios");
        else{
            $sql="select n_usucod from tb_usuario where n_usucod<>$id and ( c_usunic='$nick' or c_usucor='$correo')";
            $e=$this->bd->fetch_cell($sql);
            if ($e){
                $r = array( "exito"=>0, "mensaje"=>"Otro usuario esta usando el Nick o Correo");
            }else{
                $sql = "update tb_usuario 
                    set c_usunic='$nick', c_usupas='".md5(trim($pass))."', c_usucor='$correo', 
                        n_estcod='$estado', n_rolcod='$rol', f_usuven='$caduca'
                    where n_usucod='$id'";
                $this->bd->exe_sql($sql);
                $r = array( "exito"=>1, "mensaje"=>"Se modifico datos de: $nick");
            }
        }
        return $r;
    }
    function borrar_evaluar($id){
        $sql = "SELECT c_usunic FROM TB_USUARIO whERE n_usucod='$id'";
        $r= $this->bd->fetch_row($sql);
        //$r = $this->bd->exec_sp($sql, array(":nick",":exito", ":mensaje"));
        return array("id"=>$id, "exito" => 1, "mensaje" => "Se puede eliminar", "c_usunic"=>$r["c_usunic"]);
    }
    function borrar_si($id){
        $sql = "delete from tb_usuario where n_usucod='$id'";
        $r = $this->bd->exe_sql($sql);
        return array("exito" => 1, "mensaje" => "Se elimino al usuario");
    }
}

?>
