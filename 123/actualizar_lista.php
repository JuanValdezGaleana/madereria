<?php
require("../aut_config.inc.php");
$op=$_GET['r'];
	$cve_producto=$_POST['cve_productotb'];
	$nombre=$_POST['nombre_productotb'];
	$descripcion=$_POST['descripciontb'];
	$id_tipo_producto=$_POST['id_tipo_productotb'];
	$id_tipo_presentacion=$_POST['id_tipo_presentaciontb'];
	$precio_compra=$_POST['precio_compratb'];
	$precio_venta=$_POST['precio_ventatb'];
	$descuento=$_POST['descuentotb'];
	/*$precio_final=$_POST['precio_finaltb'];*/
	$id_unidad_medida=$_POST['id_unidad_medidatb'];
	$id_producto=$_POST['id_productotb'];
	$impuesto=$_POST['impuestotb'];
	$cant_act=number_format($_POST['cant_act'],0);
	if($impuesto==0){$id_facturacion=0;}
	if($impuesto>0){$id_facturacion=1;}
	
	$busCod=$_POST['busCod'];
	$busNom=$_POST['busNom'];
	
$precio_final_aux=$precio_venta-($precio_venta*($descuento/100));
$precio_final=($precio_final_aux*($impuesto/100))+$precio_final_aux;


$acttualizarLista=mysql_query("UPDATE PRODUCTOS SET
							   CVE_PRODUCTO='$cve_producto',
							   NOMBRE_PRODUCTO='$nombre',
							   ID_TIPO_PRODUCTO=$id_tipo_producto,
							   DESCRIPCION='$descripcion',
							   ID_TIPO_PRES_PROD=$id_tipo_presentacion,
						       PRECIO_COMPRA=$precio_compra,
						       PRECIO_VENTA=$precio_venta,
							   PORCENTAJE_IMPUESTO=$impuesto,
							   DESCUENTO=$descuento,
							   PRECIO_FINAL=$precio_final,
							   ID_UNIDAD_MEDIDA=$id_unidad_medida,
							   ID_FACTURACION=$id_facturacion
							   WHERE ID_PRODUCTO='$id_producto';")
                   or die("Error al actualizar datos del producto. <br/>".mysql_error());
				   
				   //////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		
				   				      
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES('',$id_producto,$cant_act,NOW());
										  ")
            	       or die("Error al insertar en la tabla del historial del inventario. <br/>".mysql_error());
						


switch($op){
		case 1:
		header("Location: alta_productos.php");
		break;
		
		case 2:
		?>
<script type="text/javascript">
function enviar(){
   document.forma.submit();
}
</script>		
<form method="post" name="forma" action="modificar_producto.php">
<input name="busCod" type="hidden" value="<?php echo $busCod; ?>" />
<input name="busNom" type="hidden" value="<?php echo $busNom; ?>" />
</form> 
<script type="text/javascript">
alert
('Se han guardado los datos satisfactoriamente');
enviar();
</script>


        <?php
		break;
	
	}



?>
