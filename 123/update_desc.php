<?php
 require("../aut_verifica.inc.php");
$pre_vent=$_POST['pre_vent'];
$id_prod=$_POST['id_prod'];
$desc=$_POST['desc'];
$cv=$_POST['cv'];
$pre_fin=$pre_vent-($pre_vent*($desc/100));

$insertar=mysql_query("
					  UPDATE productos SET DESCUENTO=$desc, PRECIO_FINAL=$pre_fin WHERE ID_PRODUCTO=$id_prod;
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());

$upd_venta=mysql_query("
					  UPDATE ventas_salidas SET PRECIO_VENTA=$pre_fin WHERE ID_PRODUCTO=$id_prod AND CVE_VENTA='$cv';
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());

header("Location:index.php?cv=$cv");
?>