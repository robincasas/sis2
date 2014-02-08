<?php

class dat {

    function __construct() {
        $this->bd = new fwo_dat("bd");
    }

    function anos() {
        $sql = "select ".utf8_decode("TEA_AÑO")." as VALUE, ".utf8_decode("TEA_AÑO")." AS CAPTION 
            from TBESTACT ORDER BY ".utf8_decode("TEA_AÑO")." DESC";
        return $this->anos = $this->bd->fetch_result($sql);       
    }
    function grados() {
        $sql = "select distinct asiper_grado as VALUE, asiper_grado AS CAPTION 
                FROM TBASIPER WHERE asiper_grado LIKE 'MM%' ORDER BY asiper_grado";
        return $this->grados = $this->bd->fetch_result($sql);
    }

    function listar($orderby, $top, $skip,$grado,$ano) { 

        $sql = "select id_capxcurso,asiper_codigo,curso_ce,C_DESCRIP,N_ORD  
                    from v_cursos_x_grado cg
                    inner join TB_CAPACIDAD_X_CURSO cc on cg.asiper_codigo=cc.c_codcur
                    where asiper_grado='$grado' and asiper_ano='$ano' order by asiper_codigo,n_ord ";
        $rs = $this->bd->fetch_result($sql, $orderby, $top, $skip);
        $rs2=$this->bd->utf8json($rs);
        return json_encode(array(
                    "total" => $this->bd->sql_count,
                    "rows" => $rs2,
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
