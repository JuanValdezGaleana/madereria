<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<title>REINGRESAR EMPLEADO</title>
</head>

<?php


$ic=$_GET['ic'];
$ihm=$_GET['ihm'];
$iprod=$_GET['iprod'];

?>

<body onLoad="mi_alerta()">
<script language="Javascript">
function mi_alerta(){
confirmar=confirm("¿Realmente deseas quitar este producto?");
if (confirmar){
location.href = "del_producto.php?iprod=<?php echo $iprod; ?>&ihm=<?php echo $ihm; ?>&ic=<?php echo $ic; ?>";
}
else{
location.href = "s_consulta2.php?ic=<?php echo $ic; ?>";
}
}
</script>

</body>
</html>