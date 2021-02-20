<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="images/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<title>ACTUALIZAR</title>
</head>

<body>

<?php
$emp_id=$_GET['emp_id'];

if($_POST['estatus']==""){
	$estatus=$_GET['estatus'];
}
if($_GET['estatus']==""){
	$estatus=$_POST['estatus'];
}


switch($estatus){

 case 1 :
 
 //Cambio de estus a activo en la tabla de empleado
$baja_empleado=mysql_query("
UPDATE persona SET ID_ESTATUS_ACTIVO=$estatus WHERE ID_PERSONA=$emp_id;
")
or die("Error al poner activo el estatus del usuario.<br/>".mysql_error());
 
 	?>
		<script language="Javascript">
        alert
        ('¡Se ha reingresado al empleado!'); 
        location.href = "lista_empleados.php";
        </script>
    <?php
 break;

 case 2:
 
 //Cambio de estus a inactivo en la tabla de empleado
$baja_empleado=mysql_query("
UPDATE persona SET ID_ESTATUS_ACTIVO=$estatus WHERE ID_PERSONA=$emp_id;
")
or die("Error al poner inactivo el estatus del usuario.<br/>".mysql_error());
 
 ?>
		<script language="Javascript">
        alert
        ('¡Se ha dado de baja el empleado!'); 
        location.href = "lista_empleados.php";
        </script>
 <?php
 break;

}

?>

</body>
</html>
