<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EMPLEADOS</title>
<link rel="stylesheet" href="../PUNTOVENTA/css/1estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />	
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css"> 


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
		});
	</script>
<!--FIN FANCYBOX-->

</head>
<?php 

/*if ($_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA" )*/
if ($_SESSION['SESSION_GRUPO']=="EMPLEADO" ){
?>
<script language="javascript"> 
alert
('¡No tienes privilegios para realizar esta acción!'); 
 history.back(1);
</script>
<?php
exit;
}

?>


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
<div class="surtir_tit stretchRight"><strong>EMPLEADOS QUE NO TIENEN ASIGNADO ÁREA Y PUESTO</strong></div>
<div class="espacio_calendario">

</div>
</div>
</div>
<div class="pagina"  style="height:calc(100% - 50px); overflow:auto;">
  
  <?php
 require("../aut_config.inc.php"); 
$empleado_consulta = mysql_query("
SELECT 
B.ID_PERSONA,      B.CUE,       B.AP_PATERNO, 
B.AP_MATERNO,    B.NOMBRE
FROM persona B
WHERE B.CUE =  ''
AND B.ID_ESTABLECIMIENTO=".$_SESSION['SESSION_ID_ESTABLECIMIENTO']."
ORDER BY B.ID_PERSONA DESC;
") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

?>


<table width="100%" border="1" class="tabla_usuarios propTabla">
  <tr>
    
    <td width="62%" align="center" valign="middle" class="bgtabla"><span class="tabla_encabezado">NOMBRE</span></td>
    <td width="38%"colspan="21" align="center" valign="middle"class="bgtabla" >&nbsp;            </td>
  </tr>

  <?php  
  while($res_datos=mysql_fetch_array($empleado_consulta)){
 
  ?>
   
 
  <tr class="hover_lista">
    
    <td align="center" valign="middle"><?php echo $res_datos['NOMBRE']." ".$res_datos['AP_PATERNO']." ".$res_datos['AP_MATERNO'];?></td>
    
    <td width="38%" align="center" valign="middle" class="boton_modificar" title="ASIGNAR"><a class="texto" href="asignar_area_puesto.php?emp_id=<?php echo $res_datos['ID_PERSONA'] ?>"><div>ASIGNAR AREA Y PUESTO <img align="middle" src="../imagenes/asignar.png"></div></a></td>
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
