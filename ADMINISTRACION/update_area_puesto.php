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
	$emp_id= $_GET['emp_id'];
	$area_id=$_GET['area_id'];
	$puesto_id=$_POST['valor_puesto'];
	
	$ap=$_POST['ap'];
	$am=$_POST['am'];  
	$no=$_POST['no'];
	
	$area=mysql_query("SELECT AREA FROM cat_areas WHERE ID_AREA = $area_id")
	or die("Error al consultar el área.<br/>".mysql_error());
	$strarea=mysql_fetch_array($area);
	$ar=substr($strarea['AREA'], 0,1);
	
	$query_numcve=mysql_query("
		SELECT ID_EMP_CARGO FROM empleados_cargo WHERE ID_PERSONA = '$emp_id'
	")or die("Error al consultar el núumero de clave empleado/cargo".mysql_error());
	$ftc=mysql_fetch_array($query_numcve);
	$numero=$ftc['ID_EMP_CARGO'];
/*	
	if($numero<=9){
	$numcve="000".$numero;
}
if($numero>=10&&$numero<=99){
	$numcve="00".$numero;
}
if($numero>=100&&$numero<=999){
	$numcve="0".$numero;
}
if($numero>=1000){
	$numcve=$numero;
}
	
*/	
	/*$cve_entera=$ar.$numcve."-".$ap.$am.$no;*/
	
	$cve_entera=$ap.$am.$no.$numero;
	
	//actualiza la CUE del empleado
	$actualiza_cue=mysql_query("
	UPDATE persona set 
	CUE='$cve_entera'
	 where ID_PERSONA=$emp_id;
	")
	or die("Error al actualizar los datos del usuario.<br/>".mysql_error());

	
	//INSERTA LOS IDENTIFICADORES EN LA TABLA ASOCIATIVA
$modificar=mysql_query("
UPDATE empleados_cargo set 
ASOC_AREA_PUESTO='$puesto_id'
 WHERE ID_PERSONA=$emp_id;
")or die("Error al guardar datos.<br/>".mysql_error());

?>
<script language="javascript"> 
alert
('Se han actualizado satisfactoriamente el área y puesto.'); 
location.href = "lista_empleados.php";
</script>
</body>
</html>
