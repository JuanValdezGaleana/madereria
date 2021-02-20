<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACTUALIZAR</title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>

<body>

<?php

$emp_id=$_POST['emp_id'];
$emp_nom=$_POST['nombre'];
$emp_apat=$_POST['ap_pat'];
$emp_amat=$_POST['ap_mat'];
$fecha_nac=$_POST['anio_nac']."-".$_POST['mes_nac']."-".$_POST['dia_nac'];
$tel_telefono =$_POST['telefono_1'];
$ctt_id =$_POST['tipo_tel_1'];
$e_mail=$_POST['e_mail'];

if($_POST['LOCALIDADES']==0){  /*Se verifica si la lista seleccionable manda valor de '0' y se obtiene el valor auxiliar*/
	$id_localidad=$_POST['id_loc_aux'];
	}else{
		  if($_POST['LOCALIDADES']!=0){  /* Si es diferente de '0' quiere decir que se ha seleccionado una opci[on de la lista */
		  $id_localidad=$_POST['LOCALIDADES'];}
		  }	  
$calle=$_POST['calle'];
$numero=$_POST['numero'];
$fecha_ingreso=$_POST['anio_ingreso']."-".$_POST['mes_ingreso']."-".$_POST['dia_ingreso'];
$id_t_p=$_POST['id_t_p'];

	/*echo "EMP ID>$emp_id<br/>";
	echo "EMP CUE>$emp_cue<br/>";
	echo "CVE ENTERA>$cve_entera<br/>";
	echo "NUMERO>$numero<br/>";
	echo "EMP APAT>$emp_apat<br/>";
	echo "EMP AMAT>$emp_amat<br/>";
	echo "EMP NOM>$emp_nom<br/>";
	echo "TEL>$tel_telefono<br/>";
	echo "E MAIL> $e_mail<br/>";
	echo "NOMBRE ARCHIVO>$nombre_archivo<br/>";*/

//include("subir_foto.php");

$consulta=mysql_query("UPDATE persona SET
AP_PATERNO='$emp_apat',
AP_MATERNO='$emp_amat',
NOMBRE='$emp_nom',
FECHA_NAC='$fecha_nac',
TELEFONO='$tel_telefono',
E_MAIL='$e_mail',
ID_TIPO_TELEFONO=$ctt_id,
ID_TIPO_PERSONA=$id_t_p,
FECHA_INGRESO='$fecha_ingreso'
WHERE ID_PERSONA=$emp_id;
")
or die("Error al actualizar los datos del empleado.<br/>".mysql_error());


?>

<script language="javascript"> 
alert
('¡Se han actualizado los datos!'); 
location.href = "lista_empleados.php";
</script>

<?php
//}
?>
</body>
</html>
