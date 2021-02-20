<?php
require("../aut_config.inc.php");

	$cve_producto=$_POST['cve_producto'];
	$nombre=$_POST['nombre_producto'];
	$descripcion=$_POST['descripcion'];
	$id_tipo_producto=$_POST['id_tipo_producto'];
	$id_tipo_presentacion=$_POST['id_tipo_presentacion'];
	$precio_compra=$_POST['precio_compra'];
	$precio_venta=$_POST['precio_venta'];
	$descuento=$_POST['descuento'];
	$precio_final=$_POST['precio_final'];
	$id_unidad_medida=$_POST['id_unidad_medida'];
	
	
	
	/*
	echo "cve_producto : $cve_producto <br/>";
	echo "nombre : $nombre <br/>";
	echo "descripcion : $descripcion <br/>";
	echo "id_tipo_producto : $id_tipo_producto <br/>";
	echo "id_tipo_presentacion : $id_tipo_presentacion <br/>";
	echo "precio_compra : $precio_compra <br/>";
	echo "precio_venta : $precio_venta <br/>";
	echo "id_unidad_medida : $id_unidad_medida <br/>";
	echo "id_proveedor : $id_proveedor <br/>";*/


$acttualizarLista=mysql_query("UPDATE PRODUCTOS SET
							   NOMBRE_PRODUCTO='$nombre',
							   DESCRIPCION='$descripcion',
							   ID_TIPO_PRODUCTO=$id_tipo_producto,
							   ID_TIPO_PRES_PROD=$id_tipo_presentacion,
						       PRECIO_COMPRA=$precio_compra,
						       PRECIO_VENTA=$precio_venta,
							   DESCUENTO=$descuento,
							   PRECIO_FINAL=$precio_final,
							   ID_UNIDAD_MEDIDA=$id_unidad_medida
							   WHERE CVE_PRODUCTO='$cve_producto'")
                   or die("Error al actualizar datos del producto. <br/>".mysql_error());

header("Location: almacen.php");

?>
