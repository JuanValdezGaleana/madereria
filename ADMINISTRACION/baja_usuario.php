<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<title>BAJA DE USUARIO</title>
</head>
<?php

if ($_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA" || $_SESSION['SESSION_CGRU_GRUPO']=="ADMINISTRADOR" ){
?>
<script language="javascript"> 
alert
('¡No tienes privilegios para realizar esta acción!'); 
 history.back(1);
</script>
<?php
exit;
}

$usu_id=$_GET['usu_id'];

?>
<body onLoad="mi_alerta()">
<script language="Javascript">
function mi_alerta(){
confirmar=confirm("¿Realmente deseas dar de baja al usuario?");
if (confirmar){
	location.href = "cambiar_status_usuario.php?usu_id=<?php echo $usu_id; ?>";		
}
else{
location.href = "lista_usuarios.php";
}
}
</script>

</body>
</html>
