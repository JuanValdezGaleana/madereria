<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>USUARIO</title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>
<body>

<?php 
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$emp_id=$_POST['emp_id'];
$usuario=$_POST['usuario'];
$contrasena2=$_POST['contrasena'];
$contrasena=md5($contrasena2);
$id_grupo=$_POST['grupos'];


//Insesrta los datos en la tabla usuarios
$insercion1=mysql_query("
INSERT INTO usuarios VALUES(
$emp_id,
'$usuario',
'$contrasena',
CURDATE(),
NULL,
1,
$id_grupo);")or die("¡Error al guardar datos de usuario!.<br/>".mysql_error());

?>
<script language="javascript"> 
alert
('Se han guardado satisfactoriamente el nuevo usuario'); 
location.href = "lista_usuarios.php";
</script>
</body>
</html>
