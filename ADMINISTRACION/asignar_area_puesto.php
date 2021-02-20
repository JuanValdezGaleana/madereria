<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EMPLEDOS</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />	
<link href="images/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
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

if ($_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA" ){
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
    
    
    
    <li class="menu_right"><a class="drop">NOMINA</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
           
            
            <div class="col_1">
    
                <ul class="greybox">
                    <li><a href="#">VER NÓMINA</a></li>
                    
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    <li class="menu_right"><a href="asistencia.php" class="drop">ASISTENCIA</a> </li>
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
  
    $emp_id=$_GET['emp_id'];
    $area_id=$_POST['valor_area'];
   
 require("../aut_config.inc.php"); 
$empleado_consulta = mysql_query("
SELECT 
B.ID_PERSONA,       B.NOMBRE, 
B.AP_PATERNO,    B.AP_MATERNO   
FROM persona B
WHERE B.ID_PERSONA=$emp_id
") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());
$res_datos=mysql_fetch_array($empleado_consulta);
?>
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>ASIGNAR A:  <?php echo $res_datos['NOMBRE']." ".$res_datos['AP_PATERNO']." ".$res_datos['AP_MATERNO'];?></strong></div>
<div class="espacio_calendario">

</div>
</div>
</div>
<div class="pagina">
 
 


<form name="form1" method="post" action="asignar_area_puesto.php?emp_id=<?php echo $emp_id; ?>">
<?php $consulta_areas=mysql_query("
SELECT * FROM cat_areas;
")
 or die("No se pudo realizar la consulta de las áreas. <br/>".mysql_error());

?>
<table width="100%" border="0">
  <tr>
    <td width="50%" align="right">ÁREA: </td>
    <td width="50%">
    <select name="valor_area" id="valor_area">
    <?php
	while($res_areas=mysql_fetch_array($consulta_areas)){
	?>
      <option 
	  <?php if($area_id==$res_areas['ID_AREA']) { ?>  selected="selected" <?php }?>  
      value="<?php echo $res_areas['ID_AREA']; ?>">
	  <?php echo $res_areas['AREA']; ?>
      </option>
      <?php
	  }
		?>      
    </select>
    <input type="submit" name="button" id="button" value="BUSCAR PUESTOS" />    </td>
  </tr>
</table>

</form>


<form id="form2" name="form2" method="post" 
action="insert_area_puesto.php?emp_id=<?php echo $emp_id; ?>&area_id=<?php echo $area_id; ?>">
<?php
	if($area_id!=0){
 ?>
  <table width="100%" border="0">
    <tr>
      <td width="50%" align="right">PUESTOS DE <?php echo $res_areas['AREA'] ; ?>: </td>
      <td width="50%">
      <?php $consulta_puestos=mysql_query("
		SELECT
		A.ASOC_AREA_PUESTO,
		B.AREA,
		C.PUESTO
		FROM asoc_areas_puestos A
		INNER JOIN cat_areas B
		ON A.ID_AREA=B.ID_AREA
		INNER JOIN cat_puesto C
		ON A.ID_PUESTO=C.ID_PUESTO
		INNER JOIN cat_estatus_activo D
		ON A.ID_ESTATUS_ACTIVO=D.ID_ESTATUS_ACTIVO
		WHERE B.ID_AREA=$area_id
")
 or die("No se pudo realizar la consulta de los puestos. <br/>".mysql_error());

?>
      
      
      <select name="valor_puesto" id="valor_puesto">
        <?php
	while($res_puestos=mysql_fetch_array($consulta_puestos)){
	?>
      <option value="<?php echo $res_puestos['ASOC_AREA_PUESTO']; ?>"><?php echo $res_puestos['PUESTO']; ?></option>
      <?php
	  }
		?>  
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">  <!-- $res_datos[EMP_NOM]." ".$res_datos[EMP_APAT]." ".$res_datos[EMP_AMAT]-->
      
      <input name="ap" type="hidden" id="ap" value="<?php $ap=substr($res_datos['AP_PATERNO'], 0,2); echo $ap; ?>" />
      <input name="am" type="hidden" id="am" value="<?php $am=substr($res_datos['AP_MATERNO'], 0,1); echo $am; ?>" />
      <input name="no" type="hidden" id="no" value="<?php $no=substr($res_datos['NOMBRE'], 0,1); echo $no; ?>" />
      <input type="submit" name="button2" id="button2" value="GUARDAR" /></td>
      </tr>
  </table>
  <?php } ?>
  
</form>

</div>


</body>
</html>
