<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<title>REINGRESAR EMPLEADO</title>
</head>

<?php

if ($_SESSION['SESSION_GRUPO']=="USUARIO DE CAPTURA" ){
?>
<script language="javascript"> 
alert
('¡No tienes privilegios para realizar esta acción!'); 
 history.back(1);
</script>
<?php
exit;
}
$i=$_GET['i'];
$te=$_GET['te'];

?>

<body onLoad="mi_alerta()">
<script language="Javascript">
function mi_alerta(){
confirmar=confirm("¿Realmente deseas borrar este proveedor?");
if (confirmar){
location.href = "eliminar_proveedor.php?te=<?php echo $te; ?>&i=<?php echo $i; ?>";
}
else{
	<?php
	switch($te){
	case 4: ?>
		location.href = "proveedores.php";
<?php	break;
	
	case 3: ?>
		location.href = "clientes.php";
<?php	break;
	}
	?>
	
	

}
}
</script>

</body>
</html>