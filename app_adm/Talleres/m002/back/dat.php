<?php

class dat {

    function __construct() {
        $this->bd = new fwo_dat("bd");
    }
    function lista_cursos_p2() {
        $sql="SELECT CONVERT(VARCHAR(3) ,ID_PROGRAMACION)+'-'+C_NOMCUR as ID,C_NOMCUR+'-'+C_SECCION as C_NOMCUR FROM TB_TALLER_PROGRAMACION P
                    INNER JOIN TB_TALLER_CURSOS C ON P.ID_CURSO=C.ID_CURSO 
                    WHERE C_ANO='2014' order by C_NOMCUR";
        $rs = $this->bd->fetch_result($sql);
        return $rs;            
    }
    function lista_cursos_p($ano) {
        $sql = "select * from tb_taller_disciplinas";
        $rs = $this->bd->fetch_result($sql);
		foreach ($rs as $row) {
			$html.="<optgroup label=$row[C_NOMDIC]>";		
        	$sql2 = "SELECT ID_PROGRAMACION,C_NOMCUR+'-'+C_SECCION as C_NOMCUR FROM TB_TALLER_PROGRAMACION P
					INNER JOIN TB_TALLER_CURSOS C ON P.ID_CURSO=C.ID_CURSO and id_diciplina='$row[ID_DISCIPLINA]'
					where C_ANO='$ano' order by C_NOMCUR";
			$rs2 = $this->bd->fetch_result($sql2);
			foreach ($rs2 as $row2) {
				$html.="<option value='$row2[ID_PROGRAMACION]' onclick=selecc('$row2[ID_PROGRAMACION]'); return false;>$row2[C_NOMCUR]</option>";
			}
			$html.="</optgroup>";
		}
		echo $html;
		//return json_encode($rs);
        //return $this->cursos = $this->bd->fetch_result($sql);       
    }
    function detalle_c($ano,$programa){
        $numrec=$this->bd->fetch_cell("SELECT ISNULL(max(right(id_pago,3))+1,1) from TB_TALLER_PAGOS");
        $numrec=substr($ano,-2).str_pad($numrec,3,'0',STR_PAD_LEFT);
        $nummat=$this->bd->fetch_cell("SELECT count(id_pago) from TB_TALLER_PAGOS where c_activo='1' and C_PARTES IN ('1RA','TOT') AND ID_PROGRAMACION='$programa';");
    	$sql="select ID_PROGRAMACION,CONVERT( VARCHAR(10),D_INICIO, 103) as D_INICIO,D_FIN,C_SECCION,ID_PROFE,C_PRIDIA,C_SEGDIA,C_TERDIA, N_VACANTES,C_OBS,ID_COSTO,C_NOMCUR
                from tb_taller_programacion p inner join tb_taller_cursos c on p.id_curso=c.id_curso
                where id_programacion='$programa' and c_ano='$ano'";
        $rs = $this->bd->fetch_row($sql);
        $sql2="SELECT * 
                FROM TB_TALLER_COSTOS where id_costo='$rs[ID_COSTO]'";
        $rs2 = $this->bd->fetch_row($sql2);
        $horario=$this->bd->hordia_pav($rs[C_PRIDIA])." ".$this->bd->hordia_pav($rs[C_SEGDIA])." ".$this->bd->hordia_pav($rs[C_TERDIA]);
        if($nummat>=$rs["N_VACANTES"])
            $r["copado"]=1;
        $r["nummat"]=$nummat;
        $r["numrec"]=$numrec;
        $r["horario"]=$horario;
        $r["rsp"]=$rs;
        $r["rsc"]=$rs2;
    	return json_encode($r);
    }
    function buscar_alu($q){
        $q=strtoupper(utf8_decode($_REQUEST["q"]));
        for($k=0; $k<strlen($q); $k++){
            if ($q[$k]==utf8_decode("ñ"))
                $q[$k]=utf8_decode("Ñ");
        }
        $rs=$this->bd->fetch_result("select aludgr_alumno as id, aludgr_apepat+' '+aludgr_apemat+' '+aludgr_nombres as valor  
from v_aludgr_taller where aludgr_apepat+' '+aludgr_apemat+' '+aludgr_nombres like '$q%'");
	$rs2=$this->bd->utf8json($rs);

        /*foreach ($rs as $key => $value) {
            $rs[]=array_map('utf8_encode',$rs);
        }*/
        header('Content-type: application/json');
        //if(!$rs)    $rs="-";*/
        echo json_encode($rs2);
    }
    function costo($programa,$tiempo){
        list($m,$d) = explode('*', $tiempo);
        $sql="select id_costo from tb_taller_programacion where id_programacion='$programa'";
        $idcosto = $this->bd->fetch_cell($sql);
        $sql="select M".$m."S".$d." from TB_TALLER_COSTOS where id_costo='$idcosto'";
        echo json_encode($this->bd->fetch_cell($sql));
        //echo $programa.$m.$d;
    }
    function debe($monto,$programa,$tiempo){
        list($m,$d) = explode('*', $tiempo);
        $sql="select id_costo from tb_taller_programacion where id_programacion='$programa'";
        $idcosto = $this->bd->fetch_cell($sql);
        $sql="select M".$m."S".$d." - $monto from TB_TALLER_COSTOS where id_costo='$idcosto'";
        echo json_encode($this->bd->fetch_cell($sql)); 
    }
    function sex(){
        $d1 = array( "VALUE" => "M", "CAPTION" => "MASCULINO" ); 
        $d2 = array( "VALUE" => "F", "CAPTION" => "FEMENINO" );
        $d=array($d1,$d2); 
        return $d;   
    }
    function new_alu($apepat, $apemat, $nombres, $apoderado, $correo, $fono1,$fono2,$sex,$ano){
        $apepat=$this->bd->my_str(trim(strtoupper($apepat)));
        $apemat=$this->bd->my_str(trim(strtoupper($apemat)));
        $nombres=$this->bd->my_str(trim(strtoupper($nombres)));
        $apoderado=$this->bd->my_str(trim(strtoupper($apoderado)));
        $correo=$this->bd->my_str(trim($correo));
        $fono1=$this->bd->my_str(trim($fono1));
        $fono2=$this->bd->my_str(trim($fono2));

        if (empty($apepat) or empty($apemat) or empty($nombres))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            $corr=$this->bd->fetch_cell("select ISNULL(max(right(id_codalu,3))+1,1) from TB_taller_ficha");
            $newcod=$ano."9".str_pad($corr,3,'0',STR_PAD_LEFT);
            //$newcod="20149".str_pad($corr,3,'0',STR_PAD_LEFT);
            $sql = "insert into tb_taller_ficha(ID_CODALU, C_APEPAT,C_APEMAT,C_NOMBRES,C_APODERADO,C_EMAIL,C_FONO1,C_FONO2,C_SEXO,ID_USER,C_ALUDGR)
                    values ('$newcod','$apepat', '$apemat', '$nombres', '$apoderado', '$correo', '$fono1','$fono2','$sex','$_SESSION[N_USUCOD]','-');";
            $this->bd->exe_sql($sql);
            //echo $sql;                    
            $r = array( "exito"=>"1", "mensaje"=>"Se inserto el curso","newcod"=>"$newcod");
        }
        echo json_encode($r);
    }
    function ins_alu($idalumno,$fecpag,$idprograma,$partes,$canti,$resta,$obs,$monhid,$codcurs,$cxp) {   //matricular
    	 list($idprog2,$demas) = explode('-', $codcurs);
        if (empty($idalumno) or empty($fecpag) or empty($idprograma) or ($canti==""))
            $r = array( "exito"=>"0", "mensaje"=>"Existen Campos claves vacios");
        else{
            if($resta==0)$debe=0;
            else $debe=1;
            $ano=$this->bd->fetch_cell("select c_ano from TB_TALLER_PROGRAMACION where id_programacion='$idprograma'");
            $numrec=$this->bd->fetch_cell("SELECT ISNULL(max(right(id_pago,3))+1,1) from TB_TALLER_PAGOS");
            $numrec=substr($ano,-2).str_pad($numrec,3,'0',STR_PAD_LEFT);
            $sql="insert into TB_TALLER_PAGOS(ID_PAGO,ID_ALUMNO,D_FECPAG,ID_PROGRAMACION,C_PARTES,N_CANTIDAD,N_RESTA,C_DEBE,ID_USER,C_OBS)
                VALUES('$numrec','$idalumno','$fecpag','$idprograma','$partes','$canti','$resta','$debe','$_SESSION[N_USUCOD]','$obs');";
            $this->bd->exe_sql($sql);
            $r = array( "exito"=>"1", "mensaje"=>"Se matriculo al alumno con exito","numrec"=>$numrec);
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
