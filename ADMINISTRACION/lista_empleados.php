<?php require("../aut_verifica.inc.php"); 
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EMPLEADOS</title>
<link rel="stylesheet" href="../PUNTOVENTA/css/1estilos.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />	
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>



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
			
			$("#BUSCAR_NOM").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_AREA").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_CUE").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_PUESTO").fancybox({
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
    <li class="menu_right menu_activo"><a class="drop">EMPLEADOS</a><!-- Begin 3 columns Item -->
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
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a> </li>
</ul>
</div>

<div class="contenedor">

<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>LISTA DE EMPLEADOS</strong></div>

</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
  
  <?php 
  if($grupo==""||$orden==""){
	  $grupo="B.AP_PATERNO";
	  $orden="ASC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }
  
  $dato_usuario=$_POST['dato_usuario'];
  $tipo_dato=$_POST['tipo_dato'];
    
  switch($tipo_dato){
		
		case "nombre":
		$donde="WHERE CONCAT(B.AP_PATERNO,B.AP_MATERNO,B.NOMBRE) LIKE '%$dato_usuario%' ";
		break;
		
		case "area":
		$donde="WHERE D.AREA LIKE '%$dato_usuario%' ";
		break;
		
		case "cue":
		$donde="WHERE B.CUE LIKE '%$dato_usuario%' ";
		break;
		
		case "puesto":
		$donde="WHERE E.PUESTO LIKE '%$dato_usuario%' ";
		break;
	
	}
  
  
 require("../aut_config.inc.php"); 
$empleado_consulta = mysql_query("

SELECT
B.ID_PERSONA,
B.CUE,
B.NOMBRE,
B.AP_PATERNO,
B.AP_MATERNO,
A.TIPO_PERSONA
FROM persona B
INNER JOIN cat_tipo_empleado A
ON B.ID_TIPO_PERSONA=A.ID_TIPO_PERSONA
WHERE B.ID_ESTATUS_ACTIVO=1
AND B.ID_ESTABLECIMIENTO=$id_establecimiento
$donde
ORDER BY $grupo $orden
") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

?>


<table width="100%" border="1" class="tabla_usuarios propTabla">
  <tr>
    
    <td width="14%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">CLAVE</span>
      <a href="lista_empleados.php?grupo=<?php echo "B.CUE"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
      <a href="lista_empleados.php?grupo=<?php echo "B.CUE"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a></td>
    <td width="27%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">NOMBRE</span>  
      <a href="lista_empleados.php?grupo=<?php echo "B.AP_PATERNO"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
      <a href="lista_empleados.php?grupo=<?php echo "B.AP_PATERNO"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a></td>
    <td width="15%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">PERSONA</span>
      <a href="lista_empleados.php?grupo=<?php echo "E.TIPO_PERSONA"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
      <a href="lista_empleados.php?grupo=<?php echo "E.TIPO_PERSONA"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a></td>
    <td colspan="22" align="center" valign="middle" class="bgtabla">
      <span><a href="alta_empleado.php" class="tabla_encabezado">NUEVO EMPLEADO</a></span></td>
  </tr>
  <?php  
  while($res_datos=mysql_fetch_array($empleado_consulta)){
  ?>
  <tr class="hover_lista">
    
    <td align="center" valign="middle"><?php echo $res_datos[CUE];?></td>
    <td align="left" valign="middle"><?php echo $res_datos[AP_PATERNO]." ".$res_datos[AP_MATERNO]." ".$res_datos[NOMBRE];?></td>
    <td align="center" valign="middle"><?php echo $res_datos[TIPO_PERSONA];?></td>
    <td width="5%" align="center" valign="middle" class="boton_modificar" title="MODIFICAR DATOS DE EMPLEADO"><a href="modificar_empleado.php?emp_cue=<?php echo $res_datos[CUE]; ?>">
      <div class="iconos"><img src="../imagenes/modificar_usuario.png" /></div></a></td>
    <td width="6%" align="center" valign="middle" class="boton_borrar" title="DAR DE BAJA AL EMPLEADO"><a href="baja_empleado.php?emp_id=<?php echo $res_datos[ID_PERSONA]; ?>"><div class="iconos"><img src="../imagenes/borrar_usuario.png" /></div></a></td>
  </tr>
  <?php
  }
  ?>
</table>
    <p>&nbsp;</p>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
</div>

<!-- ************************** Inicio de info del establecimiento y usuario que inició sesión ********************** -->

<div class="esp_mod">
<?php if($_SESSION['SESSION_GRUPO']=="SUPER ADMINISTRADOR"){ 
echo' 
		<div class="bot_mod mod_seleccionado">USUARIOS</div>
	<a href="../PUNTOVENTA/">
    	<div class="bot_mod">PUNTO DE VENTA</div>
	</a>	
 ';
 } ?>
 
 <div class="info_usu_estab">
 	<?php 
	echo ' || ';
	echo $_SESSION['SESSION_RAZON_SOCIAL'];
	echo ' || ';
	echo $_SESSION['SESSION_AP_PATERNO'].' '.$_SESSION['SESSION_AP_MATERNO'].' '.$_SESSION['SESSION_NOMBRE'];
	echo ' || ';
	?>
 </div>
 </div>
<!-- **************************** Inicio de info del establecimiento y usuario que inició sesión *********************** --> 
</div> <!--FIN DEL DIV CONTENEDOR class="contenedor"-->
</body>
</html>
