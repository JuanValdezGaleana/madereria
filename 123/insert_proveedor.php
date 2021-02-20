<?php

require("../aut_verifica.inc.php");

$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$razon_social =$_POST['razon_social'];
$nom_comercial=$_POST['nom_comercial'];
$dir_fiscal =$_POST['dir_fiscal'];
$rfc =$_POST['rfc'];
$telefono=$_POST['telefono'];
$observaciones=$_POST['observaciones'];
$tipo_establecimiento=$_POST['tipo_establecimiento'];

$insertar=mysql_query("
					  INSERT INTO establecimiento VALUES(
							'','$razon_social','$rfc','$observaciones',1,'','$nom_comercial','$telefono','','',$tipo_establecimiento,'','','', $id_establecimiento) ;")
or die("No se pudieron insertar los datos del proveedor. <br/>".mysql_error());

switch($tipo_establecimiento){
	case 4:
?>
<script language="javascript"> 
alert
('Se han guardado los datos del proveedor'); 
 location.href = "proveedores.php";
</script>
<?php 
	break;

	case 3: ?>
	<script language="javascript"> 
	alert
	('Se han guardado los datos del cliente'); 
	 location.href = "clientes.php";
	</script>
<?php	
	break;


} ?>