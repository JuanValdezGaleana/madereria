<?php
require("../aut_verifica.inc.php");

$id_prov=$_GET['i'];

$cambiar=mysql_query("
					 UPDATE establecimiento SET
					 ID_ESTATUS_ACTIVO=2
					 WHERE ID_ESTABLECIMIENTO=$id_prov
					 ;
					 
					 ")
or die("No se pudo quitar al proveedor. <br>".mysql_error());

switch($_GET['te']){
	case 4:
		header("Location: proveedores.php");
	break;
	
	case 3:
		header("Location: clientes.php");
	break;
	}


?>