<?php
require("../aut_verifica.inc.php");

$id_persona=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

$clave_venta=$_POST['clave_venta'];
$id_producto=$_POST['id_recarga'];
$id_tipo_venta=1; /*   EL UNO ES TEMPORAL     */
$cantRecarga=$_POST['cantRecarga'];

/*//////////////////////////  VERIFICAMOS SI YA EXISTE  LA PRIMERA CLAVE GENERADA DE LA VENTA DE UN HOSPITAL DETERMINADO */	
	$cContar=mysql_query("SELECT COUNT(ID_VENTA_SALIDA) FROM ventas_salidas WHERE ID_ESTABLECIMIENTO='$id_establecimiento'")
	or die("No se pudo hacer el conteo de registros. ".mysql_error());
	$dContar=mysql_fetch_array($cContar);
	$num=$dContar['COUNT(ID_VENTA_SALIDA)'];

$opc;	
	if($num==0){$opc=1;} /* SI NO HAY REGISTROS A $opc LE ASIGNAMOS EL NÚMERO 1 PARA QUE ENTRA AL CASE 1 */
	if($num>0){$opc=2;} /* SI YA HAY REGISTROS LE ASIGNAMOS 2 PARA ENTRAR AL CASE 2 */
	
	
	switch($opc){
		case 1:	
			/*////  SI NO SE HA ECHO LA PRIMERA VENTA, NO SE HA GENERADO LA CLAVE DE VENTA PARA HACER SU CONSECUTIVO. ENTONCES LA GENERAMOS   */	
	
				$clave_venta="$id_establecimiento-1";
				$cVenta=mysql_query("
						INSERT INTO ventas_salidas VALUES(
						'','$clave_venta',$id_tipo_venta,$id_producto,
						$cantRecarga,NOW(),3,'null',$id_persona,$id_establecimiento
						  );")
				or die("Error al insertar el producto en la venta. (case 1:)<br/>".mysql_error());
				header("Location: index.php?cv=$clave_venta");
				
			break;
			
			case 2:
			/*echo "CLAVE VENTA: $clave_venta <br/>";
			echo "ID TIPO VENTA: $id_tipo_venta <br/>";
			echo "ID PRODUCTO: $id_producto <br/>";
			echo "CANTIDAD RECARGA: $cantGr <br/>";
			echo "ID PERSONA: $id_persona <br/>";
			echo "ID HOSPITAL: $id_establecimiento <br/>";*/
		
				$clave_venta=$_POST['clave_venta'];
				$cVenta=mysql_query("
							INSERT INTO ventas_salidas VALUES(
				            '','$clave_venta',$id_tipo_venta,$id_producto,
							$cantRecarga,NOW(),3,'null',$id_persona,$id_establecimiento
							  );")
					or die("
						  
						   <script language='javascript'> 
							alert
							('Es un código no valido'); 
							history.back(-1);
							</script>
						 
						   ".mysql_error());
					header("Location: index.php?cv=$clave_venta");

			break;
	
	
	}



?>