<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>

<body>

<?php 

$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

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

/*echo "area_id> $area_id <br/>";
echo "carateres 0>  $ar <br/>";
echo "carateres 0 y 2> $ap <br/>";
echo "carateres 0> $am <br/>";
echo "carateres 0>  $no <br/>";
echo "cadena: $ap $am $no <br/>";


*/

//INSERTA LOS IDENTIFICADORES EN LA TABLA ASOCIATIVA
$consulta=mysql_query("
INSERT INTO empleados_cargo VALUES(
'',$id_establecimiento,$emp_id,$puesto_id
)
")or die("Error al guardar datos.<br/>".mysql_error());

//SACA EL ULTIMO IDENTIFICADOR PARA FORMAR LA CLAVE DEL EMPLEADO
$sacar_identificador=mysql_query("
	select last_insert_id();
")or die("¡Error en al consultar el último identificador insertado! <br>".mysql_error());
$identificador_eca=mysql_fetch_array($sacar_identificador);
$numero=$identificador_eca['last_insert_id()'];

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
//(UPDATE)  INSERTA LA CLAVE (CUE) DE EMPLEADO

$actualiza_cue=mysql_query("
UPDATE PERSONA set 
CUE='$cve_entera'
 where ID_PERSONA=$emp_id;
")
or die("Error al actualizar los datos del usuario.<br/>".mysql_error());

?>
<script language="javascript"> 
alert
('Se han guardado satisfactoriamente el área y puesto. La clave del empleado es: <?php echo $cve_entera; ?>'); 
location.href = "lista_empleados.php";
</script>
</body>
</html>
