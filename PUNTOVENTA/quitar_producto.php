<?php
require("../aut_verifica.inc.php");
$i=$_GET['i'];
$cve=$_GET['cve'];
$r=$_GET['r'];


$cQuitar=mysql_query("
					 DELETE  FROM ventas_salidas WHERE ID_VENTA_SALIDA=$i;
					 ")
or die("No se pudo realizar la eliminación del producto. <br/>".mysql_error());
switch($r){
	case 1:
	header("Location: index.php?cv=$cve");
	break;
	
	case 2:
	header("Location: detalle_nota.php?cv=$cve");
	break;
	
	
	}


?>