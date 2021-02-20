<?php
require("../aut_verifica.inc.php");

$prec_final_salida=$_POST['prec_final_salida'];
/*echo '<br />';*/
$id_venta_salida=$_POST['id_venta_salida'];
/*echo '<br />';*/
$clave_venta=$_POST['cv'];

$upd_prec=mysql_query("
UPDATE ventas_salidas SET PRECIO_VENTA=$prec_final_salida WHERE ID_VENTA_SALIDA=$id_venta_salida;
")
or die("No se pudo hacer la actualizacion del precio final de salida.<br/>".mysql_error());

header("Location: index.php?cv=$clave_venta");
?>
