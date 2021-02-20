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

$id_grupo=$_POST['grupos'];
$id_usuario=$_POST['id_usuario'];
$r=$_POST['r'];

$consulta=mysql_query("
update usuarios set ID_GRUPO=$id_grupo where ID_PERSONA='$id_usuario';
")
or die("¡Error al actualizar los datos del usuario!.<br/>".mysql_error());

if($r==2){
	?>
	<script language="javascript"> 
	alert
	('¡Se han actualizado los datos!'); 
	location.href = "lista_usuarios_baja.php";
	</script>
    
    <?
	}else{
?>

<script language="javascript"> 
alert
('¡Se han actualizado los datos!'); 
location.href = "lista_usuarios.php";
</script>
<?php } ?>
</body>
</html>
