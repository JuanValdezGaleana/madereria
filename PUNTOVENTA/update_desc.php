<?php 
require("../aut_verifica.inc.php");
$pre_vent=$_POST['pre_vent'];
$id_prod=$_POST['id_prod'];
$desc=$_POST['desc'];
$cv=$_POST['cv']; 
$precio_l=$_POST['precio_l'];
$cantidad=$_POST['cantidad'];
$id_venta_salida=$_POST['id_venta_salida'];

$cProdVenta=mysql_query("
							SELECT
							C.TIPO_PRES_PROD
							FROM ventas_salidas A
							INNER JOIN productos B
							ON A.ID_PRODUCTO=B.ID_PRODUCTO
							INNER JOIN cat_tipo_pres_prod C
							ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
							LEFT OUTER JOIN cat_unidad_medida D
							ON B.ID_UNIDAD_MEDIDA=D.ID_UNIDAD_MEDIDA
							WHERE A.ID_VENTA_SALIDA='$id_venta_salida'
							AND A.ID_ESTATUS_VENTA=3
							
							")
	or die("No se pudo consultar la lista de los productos vendidos (2). <br/>".mysql_error());
 $dProdVenta=mysql_fetch_array($cProdVenta);
$aux=$dProdVenta['TIPO_PRES_PROD'];

if($aux=="A GRANEL"){
		$presUnit=($precio_l/1000)*$cantidad;
	
	$pre_fin=$presUnit-($presUnit*($desc/100));
}else{
	if($desc==0){
	$pre_fin=$pre_vent-($pre_vent*($desc/100));
	$pre_fin=$pre_fin*$cantidad;
	
}else{
	
	$pre_fin=$pre_vent-($pre_vent*($desc/100));
	$pre_fin=$pre_fin*$cantidad;
	
}
	
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
$upd_venta1=mysql_query("
					  UPDATE productos SET PRECIO_FINAL='$precio_l' WHERE ID_PRODUCTO=$id_prod;
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());

$upd_venta=mysql_query("
					  UPDATE ventas_salidas SET PRECIO_VENTA='$pre_fin', DESCUENTO='$desc',CANTIDAD_VEN='$cantidad' WHERE ID_VENTA_SALIDA=$id_venta_salida AND CVE_VENTA='$cv';
					  ")
or die("No se pudo hacer la actualizacion del descuento. <br/>".mysql_error());

header("Location:index.php?cv=$cv");
?>