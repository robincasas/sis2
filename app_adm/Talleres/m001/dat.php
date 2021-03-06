<?php

class dat {

    function __construct() {
        $this->bd = new fwo_dat("bd");
    }

    function cursos() {
        //$sql = "select N_ROLCOD as VALUE, C_ROLNOM AS CAPTION from TB_MODULO_ROL";
        $sql = "select id_curso as VALUE,c_nomcur AS CAPTION from TB_TALLER_CURSOS";

        return $this->cursos = $this->bd->fetch_result($sql);
       
    }

    function costos() {
        $sql = "select ID_COSTO as VALUE,'1M2S:S/.'+CONVERT(VARCHAR(10),M1S2)+', 1M3S:S/.'+CONVERT(VARCHAR(10),M1S3)+', 2M2S:S/.'+CONVERT(VARCHAR(10),M2S2)+', 2M3S:S/.'+CONVERT(VARCHAR(10),M2S3) AS CAPTION
            from TB_TALLER_COSTOS";
        return $this->estados = $this->bd->fetch_result($sql);
    }

    function listar($orderby, $top, $skip,$ano) {
        $sql = "select id_programacion,c_nomcur,c_seccion,dbo.HORARIO(c_pridia)+' '+dbo.HORARIO(c_segdia)+' '+dbo.HORARIO(c_terdia) as horario ,CONVERT( VARCHAR(10),d_inicio, 103)ini ,CONVERT( VARCHAR(10),d_fin, 103)fin,n_vacantes,
                (select count(id_pago) from tb_taller_pagos where c_partes in ('1RA','TOT') and c_activo='1' and id_programacion=p.id_programacion) as mat,
                isnull((select sum(n_cantidad) from tb_taller_pagos where c_activo='1' and id_programacion=p.id_programacion),0) as rec
                FROM TB_TALLER_PROGRAMACION p inner join TB_TALLER_CURSOS c on p.id_curso=c.id_curso
                where c_ano='$ano' order by c_nomcur";
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

    function nuevo_grabar($curso, $sec, $vac, $ini, $fin, $dia1,$d1h1,$d1h2,$dia2,$d2h1,$d2h2, $dia3,$d3h1,$d3h2,$ins,$ano,$obs,$cos) {
        $sec=strtoupper(trim($sec));
        $vac=trim($vac);
        $dh1=trim($dia1).trim($d1h1).trim($d1h2);
        $dh2=trim($dia2).trim($d2h1).trim($d2h2);
        $dh3=trim($dia3).trim($d3h1).trim($d3h2);
        if($dh2=="000") $dh2="";
        if($dh3=="000") $dh3="";
        if (empty($sec) or empty($vac) or empty($ini))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            $existeSec=$this->bd->fetch_cell("select count(*) from tb_taller_programacion where id_curso='$curso' and c_ano='$ano' and c_seccion='$sec' ");
            if($existeSec>0)
                $r = array( "exito"=>"0", "mensaje"=>"SECCION ya Existente, escriba otra letra para la seccion");
            else{
                $sql = "insert into tb_taller_programacion(id_costo,id_curso,c_ano,d_inicio,d_fin,c_seccion,id_profe,c_pridia,c_segdia,c_terdia,n_vacantes,C_OBS,ID_USER)
                        values ('$cos','$curso','$ano','$ini','$fin','$sec','$ins','$dh1','$dh2','$dh3','$vac','$obs','$_SESSION[N_USUCOD]');";                   
                $this->bd->exe_sql($sql);
                $r = array( "exito"=>"1", "mensaje"=>"Se inserto el curso");
            }
        }
        return $r;
    }
    
    function editar_recuperar($id){
      $sql = "SELECT ID_CURSO,CONVERT(VARCHAR(10),D_INICIO, 103) as D_INICIO,CONVERT(VARCHAR(10),D_FIN,103) D_FIN,C_SECCION,ID_PROFE,
                left(C_PRIDIA,1) as d1,substring(C_PRIDIA,2,2) as d1h1,right(C_PRIDIA,2) as d1h2,
                left(C_SEGDIA,1) as d2,substring(C_SEGDIA,2,2) as d2h1,right(C_SEGDIA,2) as d2h2,
                left(C_TERDIA,1) as d3,substring(C_TERDIA,2,2) as d3h1,right(C_TERDIA,2) as d3h2,
                N_VACANTES,C_OBS,ID_COSTO
              FROM TB_TALLER_PROGRAMACION 
              WHERE
              ID_PROGRAMACION = '$id'";
      return $this->bd->fetch_row($sql);
    }
    
    function editar_grabar($id_prg,$idcurso, $seccion, $vacantes, $inicio, $fin, $d1,$d1h1,$d1h2,$d2,$d2h1,$d2h2, $d3,$d3h1,$d3h2,$profe,$ano,$obs,$cos) {
        $sec=trim($seccion);
        $vac=trim($vacantes);
        if(trim($d3).trim($d3h1).trim($d3h2)=='000') $d3.$d3h1.$d3h2="";
        if(trim($d2).trim($d2h1).trim($d2h2)=='000') $d2.$d2h1.$d2h2="";
        if (empty($sec) or empty($vac) or empty($inicio) or empty($id_prg))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            /*$matri=$this->bd->fetch_cell("select count(*) from tb_taller_pagos where c_partes in ('1RA','TOT') and c_activo='1'");
            if($matri>0)
                $r = array( "exito"=>"0", "mensaje"=>"Existen alumnos Matriculados, no se puede modificar");
            else{*/
                $sql = "update tb_taller_programacion set id_curso='$idcurso',c_ano=$ano,d_inicio='$inicio',d_fin='$fin',c_seccion='$sec',
                            c_pridia='$d1$d1h1$d1h2',c_segdia='$d2$d2h1$d2h2',c_terdia='$d3$d3h1$d3h2',
                            id_profe='$profe',n_vacantes='$vac' , C_OBS='$obs',ID_COSTO='$cos',ID_USER='$_SESSION[N_USUCOD]'
                            where id_programacion='$id_prg'"; 
                $this->bd->exe_sql($sql);
                           // echo $sql;
                $r = array( "exito"=>"1", "mensaje"=>"Se Actualizo correctamente");
        //    }
        }
        return $r;
    }
    function borrar_pr($id){
        $matri=$this->bd->fetch_cell("select count(*) from tb_taller_pagos where id_programacion='$id'");
        if($matri>0)
            $r = array( "exito"=>"0", "mensaje"=>"Existen alumnos Matriculados, no se puede Eliminar");
        else{
            $sql = "delete from tb_taller_programacion where id_programacion='$id'";
            $this->bd->exe_sql($sql);
            $r = array("exito" => 1, "mensaje" => "Se elimino el programa");
        }
        return $r;
    }
}

?>
