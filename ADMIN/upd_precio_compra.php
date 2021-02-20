<?php
require("../aut_verifica.inc.php");

$precio_c=$_POST['precio_c'];
$precio_v=$_POST['precio_v'];
$precio_f=$_POST['precio_f'];
/*echo '<br />';*/
$id_producto=$_POST['id_producto'];
/*echo '<br />';*/
$tp=$_POST['tp'];


$upd_prec=mysql_query("
UPDATE productos SET PRECIO_COMPRA=$precio_c, PRECIO_VENTA=$precio_v, PRECIO_FINAL=$precio_f WHERE ID_PRODUCTO=$id_producto;
")
or die("No se pudo hacer la actualizacion del precio final de salida.<br/>".mysql_error());

header("Location: detalle_tp.php?tp=$tp");
?>