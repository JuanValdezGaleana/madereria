<?php require("../aut_verifica.inc.php"); 

$cue=$_POST['cue'];

$verificar=mysql_query("
					    SELECT
						A.CUE,
						A.ID_PERSONA AS EN_PERSONA,
						B.ID_PERSONA AS EN_USUARIOS
						FROM
						persona A
						INNER JOIN usuarios B
						ON B.ID_PERSONA=A.ID_PERSONA
						WHERE A.CUE='$cue'
					   ")
or die("No se pudo hacer la consulta. <br/>".mysql_error());
$numReg=mysql_num_rows($verificar);

if($numReg==1){
?>
<script language="javascript"> 
alert
('Ya existe un usuario para este empleado.'); 
location.href = "lista_usuarios.php";
</script>
<?php
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ALTA</title>
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
			
			$("#CLAVE2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
		});
	</script>
<!--FIN FANCYBOX-->

		<script src="validar/scriptaculous/lib/prototype.js" type="text/javascript"></script>
		<script src="validar/scriptaculous/src/effects.js" type="text/javascript"></script>
		<script type="text/javascript" src="validar/fabtabulous.js"></script>
		<script type="text/javascript" src="validar/validation.js"></script>
        <link rel="stylesheet" type="text/css" href="validar/style.css" />

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
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a></li>
</ul>
</div>

<div class="contenedor">
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>NUEVO USUARIO DE SISTEMA</strong></div>
<div class="espacio_calendario">

</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
  
 <?php
 
  $contar=mysql_query("
  SELECT COUNT(CUE) FROM persona WHERE CUE='$cue'
  ")
  or die("Error en el conteo. <br>".mysql_error());
  
  $res=mysql_fetch_array($contar);
  
  if($res[0]==0){
  		?>
        <!--SCRIPT-->
        <script language="javascript"> 
		alert
		('¡No se ha encontrado ningún empleado con la clave <?php echo $cue; ?>!'); 
		window.history.back(2);
		</script>
        <?php
  }else{
  		
		if($res[0]==1){
				
				?>
  <form id="test" method="post" action="insert_usuario.php" >
  
  <?php
  
  $cue=$_POST['cue'];
  
  $empleado_consulta = mysql_query("
SELECT 
ID_PERSONA,
CUE,
NOMBRE,
AP_PATERNO,
AP_MATERNO
FROM persona
 WHERE CUE='$cue'

") or die("No se pudo realizar la consulta a la Base de datos. <br/>".mysql_error());

$datos=mysql_fetch_array($empleado_consulta);

  
  ?>
  
  			
              <table width="100%" border="0">
  <tr>
    <td width="50%" align="right" valign="middle">NOMBRE:</td>
    <td width="50%" align="left" valign="middle"> <?php echo $datos['NOMBRE']." ".$datos['AP_PATERNO']." ".$datos['AP_MATERNO']; ?>
      <input name="emp_id" id="emp_id" type="hidden"  value="<?php echo $datos['ID_PERSONA']; ?>" />
      </td>
  </tr>
  <tr>
    <td align="right" valign="middle">USUARIO:</td>
    <td align="left" valign="middle"><input type="text" name="usuario" id="usuario"/></td>
  </tr>
  <tr>
    <td align="right" valign="top">CONTRASEÑA:</td>
    <td align="left" valign="middle"><div class="field-widget"><input type="password" name="contrasena" id="contrasena" class="required validate-password" /></div></td>
  </tr>
  <tr>
    <td align="right" valign="top">CONFIRMAR CONTRASEÑA:</td>
    <td align="left" valign="middle"><input type="password" name="conf_contrasena" id="conf_contrasena" class="required validate-password-confirm"/></td>
  </tr>
  <tr>
    <td align="right" valign="middle">GRUPO DE USUARIO:</td>
    <td align="left" valign="middle">
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
    <td colspan="2" align="center" valign="middle">
      <input type="submit" name="button" id="button" value="Guardar" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>		
<p>&nbsp;</p>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
<script type="text/javascript">
						function formCallback(result, form) {
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
						}
						
						var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});
						Validation.addAllThese([
							['validate-password', 'La contraseña debe tener minimo 4 caracteres. No debe ser \'contraseña\' o tu nombre de usuario', {
								minLength : 4,
								notOneOf : ['contraseña','CONTRASEÑA','1234','0123'],
								notEqualToField : 'usuario'
							}],
							['validate-password-confirm', 'No coincide la contraseña.', {
								equalToField : 'contrasena'
							}]
						]);
					</script>

				<?php
		}//fin if
  
  }//fin else
  
 ?>

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
