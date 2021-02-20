<?php require("../aut_verifica.inc.php"); ?>
<?php 
//Validar si puede entrar a est[a página y si no está
//autorizado a está página te regresa a la anterior
/*if ($_SESSION['SESSION_CGRU_GRUPO']!="SUPER ADMINISTRADOR"){
?>
<script language="javascript"> 
alert
('¡No tienes acceso a esta área!'); 
 location.href = "../index.php";
</script>
<?php
exit;
}
*/
 require("../aut_config.inc.php"); 
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_GET['i']; 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>USUARIOS</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css">
<link rel="stylesheet" href="../PUNTOVENTA/css/ordenlistas.css" type="text/css">
<link rel="stylesheet" href="../PUNTOVENTA/css/estilo_iconos.css" type="text/css">

<!--FANCYBOX-->    
      <script>
		!window.jQuery && document.write('<script src="../fancybox/jquery-1.4.3.min.js"><\/script>');
	 </script>
   
    <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />	
	<script type="text/javascript">
		$(document).ready(function() {		
			$("#CLAVE").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#CLAVE2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
		});
	</script>
<!--FIN FANCYBOX-->


</head>


<body>
<div class="espacio_menu">

<ul id="menu">
        
        <li>ADMINISTRACIÓN </li>
        
        <li class="menu_right"><a href="../aut_logout.php" class="drop">CERRAR SESIÓN</a><!-- Begin 3 columns Item -->   </li>
    
    <li class="menu_right"><a  class="drop">USUARIOS DE SISTEMA</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
           
            
            <div class="col_1">
    
                <ul class="greybox">
                    <li><a href="clave.php" id="CLAVE">NUEVO USUARIO</a></li>
                    <li><a href="lista_usuarios.php">LISTA DE USUARIOS</a></li>
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li><!-- End 3 columns Item -->
    
    
    <li class="menu_right"><a class="drop">EMPLEADOS</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
            
            
            
            <div class="col_1">
    
                <ul class="greybox">
                	<li><a href="empleados_deshabilitados.php">EMP. DESHABILITADOS</a></li>
                    <li><a href="alta_empleado.php">NUEVO EMPLEADO</a></li>
                    
                    <li><a href="lista_empleados.php">LISTA DE EMPLEADOS</a></li>
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    
    
    
    <li class="menu_right"><a class="drop">NOMINA</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
           
            
            <div class="col_1">
    
                <ul class="greybox">
                    <li><a href="#">VER NÓMINA</a></li>
                    
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    <li class="menu_right "><a href="asistencia.php" class="drop">ASISTENCIA</a> </li>
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a><!-- Begin 3 columns Item -->   </li>
 
</ul>

</div>

<div class="cabecera">

<div class="fotografia">
 <img src="../fotos_empleados/<?php echo $_SESSION['SESSION_FOTO']; ?>"  />

</div>

<div class="datos_sesion">
 <div class='nombre_empleado'><?php echo "<label><strong>".$_SESSION['SESSION_NOMBRE'] ." ".$_SESSION['SESSION_AP_PATERNO']." ".$_SESSION['SESSION_AP_MATERNO']."</strong></label><br/>"; ?> </div>

  </div>
  
</div>
<?php 
$cNom=mysql_query("
				  SELECT NOMBRE,AP_PATERNO,AP_MATERNO FROM persona WHERE ID_PERSONA='$id_persona'
				  ")
or die("Error al consultar los datos del empleado. <br/>".mysql_error());
$nom=mysql_fetch_array($cNom);

?>
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_back"><a href="asistencia.php"><img src="../imagenes/back.png"/></a></div>
<div class="surtir_logo stretchRight"><img src="../imagenes/checador_sm.png"/></div>
<div class="surtir_tit stretchRight"><strong>ASISTENCIA DE <?php echo $nom['AP_PATERNO']." ".$nom['AP_MATERNO']." ".$nom['NOMBRE'];   ?></strong></div>
</div>
</div>
<div class="pagina">
  
<?php 
  if($grupo==""||$orden==""){
	  $grupo="B.FECHA_INGRESO";
	  $orden="ASC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }
 
/* echo "GRUPO: $grupo <br/>";
  echo "ORDEN: $orden <br/>";*/
  

$usuario_consulta = mysql_query("
SELECT
B.FECHA_INGRESO,
DATE_FORMAT(B.FECHA_INGRESO,'%W %d %M %Y') AS FECHA,
B.HORA_INGRESO,
B.HORA_SALIDA,
IF(B.HORA_SALIDA='00:00:00',TIMEDIFF('23:59:59',B.HORA_INGRESO),IF(B.HORA_INGRESO='00:00:00',TIMEDIFF(B.HORA_SALIDA,'00:00:00'),TIMEDIFF(B.HORA_SALIDA,B.HORA_INGRESO))) AS HORAS_LABORADAS
FROM persona A
INNER JOIN asistencia_empleados B
ON A.ID_PERSONA=B.ID_PERSONA
AND B.ID_ESTABLECIMIENTO=$id_establecimiento
WHERE B.ID_PERSONA=$id_persona
ORDER BY $grupo $orden
;
") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

?>
 
 <table width="100%" border="0">
<!--<tr class="bgtabla">
    <td align="center" valign="middle">-->
    <!-- <a href="detalle_asistencia.php?grupo=<?php /*echo "B.FECHA_INGRESO";*/ ?>&orden=<?php /*echo "ASC";*/ ?>"> 
     <div class="flecha_up"> </div>
     </a>-->
     <!--<a href="detalle_asistencia.php?grupo=<?php /*echo "B.FECHA_INGRESO";*/ ?>&orden=<?php /*echo "DESC";*/ ?>"> 
     <div class="flecha_down"></div>
     </a> -->
    <!--</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    
    
    <td align="center" valign="middle">&nbsp;</td>
  </tr>-->
  <tr class="bgtabla">
    <td width="32%" align="center" valign="middle">FECHA</td>
    <td width="20%" align="center" valign="middle">H. ENTRADA</td>
    <td width="18%" align="center" valign="middle">H. SALIDA</td>
    <td width="17%" align="center" valign="middle">HRS. LABORADAS</td>
    <td width="13%">&nbsp;</td>
  </tr>
  <?php
  
	function fechaesp($date) {
    $dia = explode("-", $date, 3);
    $year = $dia[0];
    $month = (string)(int)$dia[1];
    $day = (string)(int)$dia[2];
    
    $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles" ,"Jueves","Viernes","S&aacute;bado");
    $tomadia = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
 
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    
    return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
}
  while($datos=mysql_fetch_array($usuario_consulta)){ ?>
  <tr class="hover_lista">
    <td align="center" valign="middle"><?php /*echo $datos['FECHA_INGRESO'];*/ $date = $datos['FECHA_INGRESO'];echo fechaesp($date); ?></td>
    <td align="center" valign="middle"><?php echo $datos['HORA_INGRESO'];?></td>
    <td align="center" valign="middle"><?php echo $datos['HORA_SALIDA']; ?></td>
    <td align="center" valign="middle"><?php echo $datos['HORAS_LABORADAS']; ?></td>
    <td align="center" valign="middle">
    <?php
	
	?>
    </td>
  </tr>
  <?php } ?>
</table>
<p></p>
  

</div>


</body>
</html>
