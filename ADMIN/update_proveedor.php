<?php 

require("../aut_verifica.inc.php");

$tipo_establecimiento=$_POST['tipo_establecimiento'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

switch($tipo_establecimiento){
	
	case 4:
	
	$rz=$_POST['rz'];
	$rfc=$_POST['rfc'];
	$teltb=$_POST['teltb'];
	$observ=$_POST['observ'];
	
	$id_proveedor=$_POST['id_proveedor'];
	
	$actulizar=mysql_query("
					   UPDATE establecimiento SET
					   RAZON_SOCIAL='$rz',
					   RFC='$rfc',
					   TELEFONO='$teltb',
					   OBSERVACIONES= '$observ'
					   WHERE ID_ESTABLECIMIENTO=$id_proveedor
					   AND ID_MATRIZ=$id_establecimiento;
					   ")
or die("No se pudieron actualizar los datos del proveedor. <br/>".mysql_error());
?>
<script language="javascript"> 
alert
('Se han guardado los datos del proveedor'); 
 location.href = "proveedores.php";
</script>
	
<?php
	break;
	
	case 3:
	
	$rz=$_POST['rz'];
	$rfc=$_POST['rfc'];
	$e_mailtb=$_POST['e_mailtb'];
	$teltb=$_POST['teltb'];
	$observ=$_POST['observ'];
	
	$id_proveedor=$_POST['id_proveedor'];
	
	$actulizar=mysql_query("
					   UPDATE establecimiento SET
					   RAZON_SOCIAL='$rz',
					   RFC='$rfc',
					   E_MAIL='$e_mailtb',
					   TELEFONO='$teltb',
					   OBSERVACIONES='$observ'
					   WHERE ID_ESTABLECIMIENTO=$id_proveedor
					   AND ID_MATRIZ=$id_establecimiento;
					   ")
or die("No se pudieron actualizar los datos del cliente. <br/>".mysql_error());
?>
<script language="javascript"> 
alert
('Se han guardado los datos del cliente'); 
 location.href = "clientes.php";
</script>
	
<?php
	
	break;
	
	}

exit();
?>
