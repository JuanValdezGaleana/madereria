<?php
 require("../aut_verifica.inc.php");
$pre_vent=$_POST['pre_vent'];
$id_prod=$_POST['id_prod'];
$desc=$_POST['desc'];
$cv=$_POST['cv'];
$cantidad=$_POST['cantidad'];
$id_venta_salida=$_POST['id_venta_salida'];

if($desc==0){
	
	$pre_fin=$pre_vent-($pre_vent*($desc/100));
	$pre_fin=$pre_fin*$cantidad;
}else{
	
	$pre_fin=number_format($pre_vent-($pre_vent*($desc/100)),0);
	$pre_fin=$pre_fin*$cantidad;
}


/*echo "PRECIO DE VENTA ".$pre_vent=$_POST['pre_vent']."<br />";
echo "ID DEL PRODUCTO ".$id_prod=$_POST['id_prod']."<br />";
echo "DESCUENTO ".$desc=$_POST['desc']."<br />";
echo "CLAVE DE VENTA ".$cv=$_POST['cv']."<br />";
echo "ID VENTA SALIDA ".$id_venta_salida=$_POST['id_venta_salida']."<br />";
echo "PRECIO FINAL ".$pre_fin=$pre_vent-($pre_vent*($desc/100))."<br />";

*/
/*$insertar=mysql_query("
					  UPDATE ventas_salidas SET DESCUENTO=$desc, PRECIO_FINAL=$pre_fin WHERE ID_PRODUCTO=$id_prod;
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());*/

$upd_venta=mysql_query("
					  UPDATE ventas_salidas SET PRECIO_VENTA='$pre_fin', DESCUENTO=$desc,CANTIDAD_VEN='$cantidad' WHERE ID_VENTA_SALIDA=$id_venta_salida AND CVE_VENTA='$cv';
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());

header("Location:index.php?cv=$cv");
?>