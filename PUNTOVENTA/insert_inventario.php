<?php
require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_persona=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php 

	//$opsw2=$_POST['opsw2'];

	$cve_producto=$_POST['cve_producto'];
	$nombre_producto=$_POST['nombre_producto'];
	$id_tipo_pres_prod=$_POST['id_tipo_pres_prod'];
	$id_tipo_producto=$_POST['id_tipo_producto'];
	$id_proveedor=$_POST['id_proveedor'];
	$precio_compra=0;
	$id_unidad_medida=$_POST['id_unidad_medida'];
    $cantidad=0;				
	$descripcion=$_POST['descripcion'];
	$precio_venta=0;
    $id_persona=$_POST['id_persona'];
    //$id_establecimiento=$_POST['ID_ESTABLECIMIENTO'];
	$descuento=0;
	$precio_final=0;
	
	$porc_imp=$_POST['impuesto'];
	
	if($porc_imp==0){$id_facturacion=0;}
	if($porc_imp>0){$id_facturacion=1;}
	
	
	
	
/*echo "cve_producto > ".$cve_producto."<br/>";
	echo "nombre_producto > ".$nombre_producto."<br/>";
	echo "id_tipo_pres_prod > ".$id_tipo_pres_prod."<br/>";
	echo "id_tipo_producto > ".$id_tipo_producto."<br/>";
	echo "id_proveedor > ".$id_proveedor."<br/>";
	echo "precio_compra > ".$precio_compra."<br/>";
	echo "id_unidad_medida > ".$id_unidad_medida."<br/>";
	echo "cantidad > ".$cantidad."<br/>";
	echo "descripcion > ".$descripcion."<br/>";
	echo "precio_venta > ".$precio_venta."<br/>";
	echo "id_persona > ".$id_persona."<br/>";
	echo "ID_ESTABLECIMIENTO > ".$id_establecimiento."<br/>";
	echo "descuebto > ".$descuento."<br/>";
	echo "precio_final > ".$precio_final."<br/>";*/
	
$cve_producto2=$_POST['clave_producto2'];/////para el formulario de AUMENTAR CANTIDA DE PRODUCTO
$cantidad2=$_POST['cantidad2'];/////para el formulario de AUMENTAR CANTIDA DE PRODUCTO


$opsw=$_POST['opsw'];


switch($opsw){
	
	case 1: 
			
			$consulta_numregistros=mysql_query("SELECT COUNT(ID_PRODUCTO) FROM productos WHERE CVE_PRODUCTO = '$cve_producto';")
                  or die("Error al contar la cantida de registros. <br/>".mysql_error());
					$num=mysql_fetch_array($consulta_numregistros);
					$num_registros=$num['COUNT(ID_PRODUCTO)'];
			
			if($num_registros<=0){ 
			
			

					///////////////////////  SI NO EXISTE NINGUN REGISTRO DEL PRODUCTO SE CREA UNO NUEVO   ////////////////////////////////
					$insertar=mysql_query("INSERT INTO productos VALUES 
										  ('', '$cve_producto',
										   '$nombre_producto',
										   '$id_tipo_producto',
										   '$descripcion',
										   '$id_tipo_pres_prod',
										   '', '$precio_final',
										   '',
										   '','$precio_final',
										   '$id_unidad_medida',1,
										   '$id_persona',
										   '$id_proveedor',
										   'CURDATE()'
											);
										  ")
            	       or die("Error al insertar los datos del producto. <br/>".mysql_error());
			/////////////////////////////	SACAMOS EL ID DEL ÚLTIMO REGISTRO INSERTADO	   
					   $sacarID=mysql_query("
											 SELECT LAST_INSERT_ID();
										  ")
            	       or die("Error al sacar el ultimo ID. <br/>".mysql_error());
				   		$dID=mysql_fetch_array($sacarID);
						$ultimoID=$dID['LAST_INSERT_ID()'];
						//echo "Ultimo ID insertado $ultimoID";
			//////////////////////////////// SE INSERTA EL ID SACADO ANTERIORMENTE PARA INSERTARLO EN LA TABLA INVENTARIO CON LA CANTIDAD DE PRODUCTO
						$insertInventario=mysql_query("INSERT INTO inventario VALUES 
										  ($ultimoID,$cantidad,'NOW()');
										  ")
            	       or die("Error al insertar el ultimo ID en la tabla inventario. <br/>".mysql_error());
		
						$fecha=date("Y-m-d h:m:s");
			//////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		   
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES 
										  ('',$ultimoID,$cantidad,'$fecha')
										 ; ")
            	       or die("Error al insertar el ultimo ID en la tabla HISTORIAL_INVENTARIO. <br/>".mysql_error());
						
						
				   ?>
						<script language="javascript"> 
						alert
						('Producto registrado satisfactoriamente'); 
						location.href = "alta_productos.php";
						</script>                   
                   <?php 
			   
			
			} // FIN if($num_registros==0)
			
			
			
				if($num_registros>=1){ 
				?>
                <script language="javascript"> 
				alert
				('Ya existe un producto con esta clave'); 
				history.back(-1);
				</script>
                
				<?php 
				}   ///  FIN  if($num_registros>=1)
				
				
				
				
			
			
	break;
	
	
	case 2:
		////////////////////  SI YA EXISTE UN REGISTRO CON EL PRODUCTO, UNICAMENTE SE ACTUALIZA LA CANTIDAD DE XISTENCIA //////////////////
	
	$consulta_numregistros2=mysql_query("SELECT COUNT(ID_PRODUCTO) FROM productos WHERE CVE_PRODUCTO = '$cve_producto2';")
                  or die("Error al contar la cantida de registros. <br/>".mysql_error());
					$num2=mysql_fetch_array($consulta_numregistros2);
					$num_registros2=$num2['COUNT(ID_PRODUCTO)'];
	
	if($num_registros2==0){
		?>
					<script language="javascript"> 
                    alert
                    ('No se encontró ningun producto con ese código'); 
                    location.href = "alta_productos.php";
                    </script>         
		<?php 
		}
	
	
	if($num_registros2>=1){//// CUANDO SI SE ENCUENTRA ALGUN REGISTRO ENTRA A ESTE IF
	
	/////////////////CONSULTAMOS EL ID DEL PRODUCTO QUE COINCIDA CON LA CLAVE DE PRODUCTO INSERTADA
	
	$consulta_ID=mysql_query("
							SELECT
							A.ID_PRODUCTO,
							A.ID_TIPO_PRODUCTO,
							B.TIPO_PRODUCTO
							FROM productos A
							INNER JOIN cat_tipos_producto B
							ON A.ID_TIPO_PRODUCTO=B.ID_TIPO_PRODUCTO
							WHERE CVE_PRODUCTO = '$cve_producto2';")
                  or die("No se pudo consultar el id del producto. <br/>".mysql_error());
					$resID=mysql_fetch_array($consulta_ID);
					      $IDProd=$resID['ID_PRODUCTO'];
					$id_tipo_prod=$resID['ID_TIPO_PRODUCTO'];
					   $tipo_prod=$resID['TIPO_PRODUCTO'];
	
	////////////////////  SE CONSULTA LA CANTIDAD TOTAL DEL PRODUCTO PARA SUMARLE LA NUEVA CANTIDAD DE ENTRADA
					    $cUltimaCant=mysql_query("
											 SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO = $IDProd;
										  ")
            	       or die("Error al consultar la cantidad total del producto. <br/>".mysql_error());
				   		$dUltimaCant=mysql_fetch_array($cUltimaCant);
						$cantActual=$dUltimaCant['CANTIDAD_ACTUAL'];
						$cantidadActualAux=$dUltimaCant['CANTIDAD_ACTUAL'];
						//echo "Ultima Cantidad actual $cantActual";
						
		/*VERIFICAMOS SI EL TIPO DE PRODUCTO ES DIFERENTE A RECARGAS*/	
		if($tipo_prod!='RECARGAS'){	
						
			//////////////////////////// SE HACE LA SUMA
						$cantActual=$cantActual+$cantidad2;
						//echo "La suma es> $cantActual";
			//////////////////////////  SE ACTUALIZA LA CANTIDAD TOTAL DEL PRODUCTO
						$actualizarTotal=mysql_query("
													UPDATE inventario SET
													CANTIDAD_ACTUAL=$cantActual,
													FECHA_ACTUALIZACION=NOW()
													WHERE ID_PRODUCTO=$IDProd
													;")
						or die("Error al insertar el nuevo total de la cantidad del producto. <br/>".mysql_error());
	
	
		//////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		   
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES 
										  ('',$IDProd,$cantidadActualAux,NOW());
										  ")
            	       or die("Error al insertar en la tabla del historial del inventario. <br/>".mysql_error());
						
				}/* FIN if($tipo_prod!='RECARGAS') */
				else{/*SI EL TIPO DE PRODUCTO ES IGUAL A 'RECARGAS' SE HACE EL UPDATE DE TODOS LOS REGITROS QUE SEAN RECARGAS*/
				$cantActual=$cantActual+$cantidad2;
				/*echo"ENTRÓ A RECARGAS<br/>";
				echo"CANTIDAD ACTUAL $cantActual<br/>";
				echo"CANTIDAD2 $cantidad2<br/>";
				echo"<br/>";*/

				/*SE SACAN LOS ID's DE LOS REGISTRO QUE SEAN RECARGAS*/
					$cIDs=mysql_query("
									SELECT
									A.ID_PRODUCTO
									FROM productos A
									INNER JOIN cat_tipos_producto B
									ON A.ID_TIPO_PRODUCTO=B.ID_TIPO_PRODUCTO
									WHERE B.TIPO_PRODUCTO='RECARGAS'
									; ")
					or die("No se pudo hacer la counsulta de los identificadores de los registros de recargas.<br/>".mysql_error());
				
				/*SE ACTUALIZAN LOS REGISTROS CON LA NUEVA CANTIDAD*/	
					while($dIDs=mysql_fetch_array($cIDs)){
						$idRecar=$dIDs['ID_PRODUCTO'];
						
						$actualizar=mysql_query("
												UPDATE inventario SET
													CANTIDAD_ACTUAL=$cantActual,
													FECHA_ACTUALIZACION=NOW()
													WHERE ID_PRODUCTO=$idRecar;
						")or die("No se pudo hacer la actualización de las cantidades de las recargas. <br/>".mysql_error());
						
						//////////////////////// SE INSERTA LA CANTIDAD NUEVA DE ENTRADA EN LA TABLA HISTORIAL_INVENTARIO		   
					   $insertInventario=mysql_query("INSERT INTO historial_inventario VALUES 
										  ('',$idRecar,$cantidadActualAux,NOW());
										  ")
            	       or die("Error al insertar en la tabla del historial del inventario. <br/>".mysql_error());
						
						
						}/*  FIN while($dIDs=mysql_fetch_array($cIDs)) */
					
					}/* FIN DEL else{} */
	
				   ?>         
					<script language="javascript"> 
                    alert
                    ('Cantidad registrada satisfactoriamente'); 
                    location.href = "alta_productos.php";
                    </script>                   
                   <?php 
	}  //// FIN if($num_registros2>=1)
				   
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	break;
	
	
	
	
	
	
	}  ////  FIN switch($opsw)

?>



</body>
</html>