<?php 
require("../aut_verifica.inc.php");


/*phpinfo();*/

$totalVenta=$_POST['totalVenta'];
$cant_efectivo=$_POST['cant_efectivo'];
$clave_venta=$_GET['clave_venta'];
$id_cliente=$_POST['id_cliente'];
/*CAMBIAMOS EL ESTATUS DE LA VENTA DE COMO 'NO COBRADO' A 'COBRADO'*/
$cambiar_stat=mysql_query("
						  UPDATE ventas_salidas SET
						  ID_ESTATUS_VENTA='2'
						  WHERE CVE_VENTA='$clave_venta';
						  ")
or die("Error al cambiar el estatus de los productos en ventaa.</br> ".mysql_error());

/*CONSULTAMOS TODOS LOS PRODUCTOS QUE COINCIDAN CON LA CLAVE '$clave_venta' PARA PODER DESCONTARLOS DE LA TABLA 'inventario' Y DESPUES INSERTAR A LA TABLA 'historial_inventario'*/

/*  CONSULTAMOS EL ID_DEL PRODUCTO Y LA CANTIDAD VENDIDA QUE COINCIDAN CON '$clave_venta' */

$cProd=mysql_query("
SELECT
SUM(A.CANTIDAD_VEN) AS CANTIDAD,
/*B.DESCRIPCION,*/
C.TIPO_PRODUCTO,
A.ID_PRODUCTO,
A.FECHA,
A.ID_PERSONA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_tipos_producto C
ON B.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
WHERE A.CVE_VENTA='$clave_venta'
GROUP BY ID_PRODUCTO 
ORDER BY FECHA DESC;")
or die("No se pudieron consultar los identificadores de los productos. <br/>".mysql_error());

while($dProd=mysql_fetch_array($cProd)){
$id_vendedor=$dProd['TIPO_PRODUCTO'];
if($dProd['TIPO_PRODUCTO']!='RECARGAS'){   /* SE VALIDA SI EL PRODUCTO ES DIFERENTE A UNA RECARGA, SI ES RECARGA SE DIRECCIONA AL ELSE */
	/*////////////////////  SE CONSULTA LA CANTIDAD TOTAL DEL PRODUCTO PARA RESTARLE LA NUEVA CANTIDAD DE ENTRADA*/
					    $cUltimaCant=mysql_query("
											 SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO = $dProd[ID_PRODUCTO];
										  ")
            	       or die("Error al consultar la cantidad total del producto. <br/>".mysql_error());
				   		$dUltimaCant=mysql_fetch_array($cUltimaCant);
						       $cantActual=$dUltimaCant[CANTIDAD_ACTUAL];
						$cantidadActualAux=$dUltimaCant[CANTIDAD_ACTUAL];/*SE VA A GUARDAR LA CANTIDAD QUE ESTABA ANTES DE QUE SE ACTUALIZE*/
						//echo "Ultima Cantidad actual $cantActual";
						
						//////////////////////////// SE HACE LA RESTA
						$cantActual=$cantActual+$dProd[CANTIDAD];
						
							//////////////////////////  SE ACTUALIZA LA CANTIDAD TOTAL DEL PRODUCTO
						$actualizarTotal=mysql_query("
													UPDATE inventario SET
													CANTIDAD_ACTUAL=$cantActual,
													FECHA_ACTUALIZACION=NOW()
													WHERE ID_PRODUCTO=$dProd[ID_PRODUCTO];
													")
						or die("Error al insertar el nuevo total de la cantidad del producto. <br/>".mysql_error());
						
					//////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		   
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES 
										  ('',$dProd[ID_PRODUCTO],$cantActual,NOW())
										  ")
            	       or die("Error al insertar en la tabla del historial del inventario. <br/>".mysql_error());
						
		} /* FIN if($dProd['TIPO_PRODUCTO']!'RECARGAS') */
	  else{/* EN CASO DE QUE EL REGISTRO SEA UN RECARGA ENTRA AQUI Y NUEVAMENTE SE VALIDA QUE SEA RECARGA */
		  	if($dProd['TIPO_PRODUCTO']=='RECARGAS'){
				/* SE CONSULTAN LOS ID's DE LOS REGISTROS QUE SEAN RECARGA PARA POSTERIORMENTE HACER EL UPDATE PARA DEJAR TODOS LOS REGISTROS CON LA MISMA CANTIDAD DE SALDO DISPONIBLE */
				$cIdRecarga=mysql_query("
										SELECT
										A.ID_PRODUCTO,
										/*A.DESCRIPCION,*/
										B.CANTIDAD_ACTUAL
										FROM productos A
										INNER JOIN inventario B
										ON A.ID_PRODUCTO=B.ID_PRODUCTO
										INNER JOIN cat_tipos_producto C
										ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
										WHERE C.TIPO_PRODUCTO='RECARGAS'
										;
										")
				or die ("No se pudieron consultar los identificdores de los registros de las recargas.<br/> ".mysql_error());
				
				$cant_vendida=$dProd['CANTIDAD'];
				
				
				while($dIdRecarga=mysql_fetch_array($cIdRecarga)){
					$id_prod=$dIdRecarga['ID_PRODUCTO'];
					$cant_actual2=$dIdRecarga['CANTIDAD_ACTUAL'];
				
					
					/*SE HACE LA RESTA DEL SALDO*/
					$auxCantActual=$cant_actual2-$cant_vendida;
					
					/*echo "ID_PRODUCTO: $id_prod <br/>";
					echo "CANTIDAD VENDIDA DENTRO: $cant_vendida <br/>";
					echo "CANT ACTUAL2: $cant_actual2 <br/>";
					echo "CANTIDAD RESTANTE $auxCantActual <br/>";
					echo "----------------------------------------------- <br>";*/
					
					$actualizarTotalRecargas=mysql_query("
													UPDATE inventario SET
													CANTIDAD_ACTUAL=$auxCantActual,
													FECHA_ACTUALIZACION=NOW()
													WHERE ID_PRODUCTO=$id_prod;
													")
						or die("Error al insertar el nuevo total de la cantidad del producto de recarga. <br/>".mysql_error());
						
					//////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		   
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES 
										  ('',$dProd[ID_PRODUCTO],$cant_actual2,NOW());
										  ")
            	       or die("Error al insertar en la tabla del historial del inventario para recarga. <br/>".mysql_error());
					
					}
				
				
				} /*if($dProd['TIPO_PRODUCTO']=='RECARGAS')*/
		  } /* FIN else  */
	}/* FIN while($dProd=$mysql_fetch_array($cProd))  */

/*///////////////  CÓDIGO PARA IMPRIMIR  ///////////////*/
/*$handle = printer_open("Samsung ML-1610 Series");
printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);
$font = printer_create_font("Arial",55,30,400,false,false, false,0);
printer_select_font($handle, $font);
$mostrar="ESTOY TRATANDO DE HACER FUNCIONAR ESTA COSA...";
$mostrar2= "Sigo intentando, pero en la otra linea";
printer_draw_text($handle,$mostrar,50,400);
printer_draw_text($handle,$mostrar2,50,900);
printer_delete_font($font);
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);*/
/*//////////////////////////////////////////////////////*/
?>

<?php


/*require("ticket.php");*/
/*header("Location: index.php?cv=$clave_venta&sv=1&c=$cambio&e=$cant_efectivo");*/


?>
<script language="javascript"> 
 location.href = "corte_diario_t.php";
 
</script>
<?php
exit();
	/*  FIN else 1  */
	

?>
