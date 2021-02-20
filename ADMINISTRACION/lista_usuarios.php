<?php require("../aut_verifica.inc.php"); 
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>USUARIOS</title>
<link rel="stylesheet" href="../PUNTOVENTA/css/1estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css">

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
  <li class="menu_right"><a href="../aut_logout.php" class="drop">CERRAR SESIÓN</a><!-- Begin 3 columns Item -->   </li>
  <li class="menu_right menu_activo"><a  class="drop">USUARIOS DE SISTEMA</a><!-- Begin 3 columns Item -->
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
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a> </li>
</ul>
</div>


<div class="contenedor">


<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>USUARIOS ACTIVOS</strong></div>
<div class="espacio_calendario">
<a href="lista_usuarios_baja.php"><div class="items_surtir2 slideDown">USUARIOS BAJA</div></a>
<a href="lista_usuarios.php"><div class="items_surtir2 slideDown item_surtir_sel">USUARIOS ACTIVOS</div></a>
</div>
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
$usuario_consulta = mysql_query("

SELECT 
A.NOMBRE_USSER,
A.ID_PERSONA,
B.CUE,
B.NOMBRE,
B.AP_PATERNO,
B.AP_MATERNO,
C.GRUPO
FROM usuarios A
INNER JOIN persona B
ON A.ID_PERSONA=B.ID_PERSONA
INNER JOIN cat_grupos C
ON A.ID_GRUPO=C.ID_GRUPO
WHERE B.ID_ESTABLECIMIENTO=$id_establecimiento
AND B.ID_ESTATUS_ACTIVO=1
AND A.ID_ESTATUS_ACTIVO=1
ORDER BY $grupo $orden

") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

?>
  <table width="100%" class="tabla_usuarios">
    <tr>
      <td width="13%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">USUARIO</span>
      <a href="lista_usuarios.php?grupo=<?php echo "A.NOMBRE_USSER"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
        <a href="lista_usuarios.php?grupo=<?php echo "A.NOMBRE_USSER"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a> 
      </td>
      <td width="12%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">CLAVE</span>
	<a href="lista_usuarios.php?grupo=<?php echo "B.CUE"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
        <a href="lista_usuarios.php?grupo=<?php echo "B.CUE"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a>
      </td>
      <td width="38%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">NOMBRE</span>
      <a href="lista_usuarios.php?grupo=<?php echo "B.AP_PATERNO"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
        <a href="lista_usuarios.php?grupo=<?php echo "B.AP_PATERNO"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a>
      </td>
      <td width="18%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">GRUPO</span>
        <a href="lista_usuarios.php?grupo=<?php echo "D.GRUPO"; ?>&orden=<?php echo "ASC"; ?>"><img class="flechas_ordenar_arriba"  src="../imagenes/ordena_arriba2.png" /></a>
        <a href="lista_usuarios.php?grupo=<?php echo "D.GRUPO"; ?>&orden=<?php echo "DESC"; ?>"><img class="flechas_ordenar_abajo" src="../imagenes/ordena_abajo2.png"  /></a>
      </td>
      <td colspan="22%" align="center" valign="middle"  class="boton_nuevo tabla_encabezado bgtabla"><a class="links" href="clave.php" id="CLAVE2" ><img src="../imagenes/nuevo_usuario.png" width="30" height="29" /><br/>
        NUEVO USUARIO</a></td>
    </tr>
    <?php  
  while($res_datos=mysql_fetch_array($usuario_consulta)){
  ?>
    <tr class="hover_lista">
      <td align="center" valign="middle"><?php echo $res_datos[NOMBRE_USSER];?></td>
      <td align="center" valign="middle"><?php echo $res_datos[CUE];?></td>
      <td align="left" valign="middle"><?php echo $res_datos[AP_PATERNO]." ".$res_datos[AP_MATERNO]." ".$res_datos[NOMBRE];?></td>
      <td align="center" valign="middle"><?php echo $res_datos[GRUPO];?></td>
      <td width="8%" align="center" valign="middle" class="boton_modificar" title="MODIFICAR" >
        <a href="modificar_usuario.php?emp_cue=<?php echo $res_datos[CUE]; ?>"> 
        <img <?php if($cont[0]==1){ if($res_datos[GRUPO]=="SUPER ADMINISTRADOR"){?> style="visibility:hidden" <?php }} ?> src="../imagenes/modificar_usuario.png" width="33" height="33" /></a></td>
      <td width="11%" align="center" valign="middle" class="boton_borrar" title="DAR DE BAJA">
      <a href="baja_usuario.php?usu_id=<?php echo $res_datos[ID_PERSONA]; ?>">
      <img <?php if($cont[0]==1){ if($res_datos[GRUPO]=="SUPER ADMINISTRADOR"){?> style="visibility:hidden" <?php }} ?> src="../imagenes/borrar_usuario.png" width="27" height="29" /></a></td>
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
