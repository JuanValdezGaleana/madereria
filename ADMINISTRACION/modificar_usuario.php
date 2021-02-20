<?php require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MODIFICAR DATOS</title>
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
//Validar si puede entrar a est[a página y si no está
//autorizado a está página te regresa a la anterior
if ($_SESSION['SESSION_CGRU_GRUPO']=="ADMINISTRADOR" || $_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA" ){
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
<div class="surtir_back"><a href="lista_usuarios.php"><img src="../imagenes/back.png"/></a></div>
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>MODIFICAR DATOS DEL USUARIO</strong></div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
 
    <?php
 require("../aut_config.inc.php");
$cue=$_GET['emp_cue'];
//Consulta los datos del usuario
$usuario_consulta = mysql_query("
SELECT 
A.NOMBRE_USSER,
A.ID_PERSONA,
B.CUE,
B.NOMBRE,
B.AP_PATERNO,
B.AP_MATERNO,
D.GRUPO
FROM usuarios A
INNER JOIN persona B
ON A.ID_PERSONA=B.ID_PERSONA
INNER JOIN cat_grupos D
ON A.ID_GRUPO=D.ID_GRUPO
WHERE B.CUE='$cue'
AND B.ID_ESTATUS_ACTIVO=1
AND B.ID_ESTABLECIMIENTO=$id_establecimiento;

") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

$datos=mysql_fetch_array($usuario_consulta);

?>

 
    <form id="form1" name="form1" method="post" action="update_usuario.php">
    
    <table width="100%" border="0" >
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="488" align="right">USUARIO DE SISTEMA:</td>
    <td width="24">&nbsp;</td>
    <td width="474"><?php echo $datos['NOMBRE_USSER']; ?></td>
  </tr>
  <tr>
    <td align="right">CLAVE DE EMPLEADO:</td>
    <td>&nbsp;</td>
    <td><?php echo $datos['CUE']; ?></td>
  </tr>
  <tr>
    <td align="right">NOMBRE:</td>
    <td>&nbsp;</td>
    <td><?php echo $datos['NOMBRE']." ".$datos['AP_PATERNO']." ".$datos['AP_MATERNO']; ?></td>
  </tr>
  <tr>
    <td align="right">GRUPO DE USUARIO:</td>
    <td>&nbsp;</td>
    <td>
      
      <select name="grupos" id="grupos">
        <?php	  
    $consulta_grupos=mysql_query(
	 "SELECT * FROM cat_grupos;"
	 )or die("Error en la consulta de los grupos de acceso.<br/>".mysql_error());
	 
	 while($res_grupos=mysql_fetch_array($consulta_grupos)){
    ?>
        <option value="<?php echo $res_grupos['ID_GRUPO'];?>"  <?php if($datos['GRUPO']==$res_grupos['GRUPO']){ echo 'selected="selected"'; } ?>  ><?php echo $res_grupos['GRUPO'];?></option> 
        
        
        
        <?php 
      } 
	  ?>
        </select>    </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input class=" boton_verde" style="width:200px; height:35px" type="submit" name="ACTUALIZAR" id="ACTUALIZAR" value="Actualizar" />
      <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $datos['ID_PERSONA']; ?>" />
      <input type="hidden" name="r" id="r" value="<?php echo $_GET['r']; ?>" /></td>
  </tr>
</table>
    
  </form>
  <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div> <!--FIN class"pagina"-->
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
