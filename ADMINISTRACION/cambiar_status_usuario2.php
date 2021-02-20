<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="images/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<title>ACTUALIZAR</title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>

<body>

<?php
			$usu_id=$_GET['usu_id'];
			
			
			//Cambio a inactivo en la tabla de usuarios
			$baja_usuarios=mysql_query("
			update usuarios set ID_ESTATUS_ACTIVO=1 where ID_PERSONA='$usu_id';
			")
			or die("Error al actualizar los datos del usuario.<br/>".mysql_error());
			?> 
            <script language="Javascript">
				alert
				('¡Se ha reingresado el usuario usuario!'); 
				location.href = "lista_usuarios.php";
</script>

</body>
</html>
