<?php 
require("../aut_verifica.inc.php");

$id_persona=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=1;
$entra_codigo= $_POST['codigo_granel'];
$id_tipo_venta=1; /*   EL UNO ES TEMPORAL     */
$cantGr=$_POST['cantGr'];


/*//////////////// CONSULTAMOS EL ID DEL PRODUCTO QUE SE ACABA DE INGRESAR MEDIANTE LA CLAVE DE PRODUCTO*/
$cIDProd=mysql_query(" SELECT ID_PRODUCTO,PRECIO_FINAL FROM productos WHERE CVE_PRODUCTO='$entra_codigo' ")
	or die("Error al consultar el identificador del producto. <br/>.".mysql_error());
	$dIDProd=mysql_fetch_array($cIDProd);
	$id_producto=$dIDProd['ID_PRODUCTO'];
	$precio_venta2=$dIDProd['PRECIO_FINAL'];
	$precio_venta=($precio_venta2/1000)*$cantGr;
	
	
	
	
	//echo "ID DEL PRODUCTO $id_producto <br/>";
/*//////////////////////////  VERIFICAMOS SI YA EXISTE  LA PRIMERA CLAVE GENERADA DE LA VENTA DE UN HOSPITAL DETERMINADO */	
	$cContar=mysql_query("SELECT COUNT(ID_VENTA_SALIDA) FROM ventas_salidas WHERE ID_ESTABLECIMIENTO='$id_establecimiento'")
	or die("No se pudo hacer el conteo de registros. ".mysql_error());
	$dContar=mysql_fetch_array($cContar);
	$num=$dContar['COUNT(ID_VENTA_SALIDA)'];
	
	//echo "Num de conteo> $num <br/>";
$opc;	
	if($num==0){$opc=1;} /* SI NO HAY REGISTROS A $opc LE ASIGNAMOS EL NÚMERO 1 PARA QUE ENTRA AL CASE 1 */
	if($num>0){$opc=2;} /* SI YA HAY REGISTROS LE ASIGNAMOS 2 PARA ENTRAR AL CASE 2 */
	
	
	switch($opc){
		
		case 1:	
		/*////  SI NO SE HA ECHO LA PRIMERA VENTA, NO SE HA GENERADO LA CLAVE DE VENTA PARA HACER SU CONSECUTIVO. ENTONCES LA GENERAMOS   */	
		if($cantGr>=250 && $cantGr<=999 ){
			  $precio_venta=$precio_venta+5;
			}
		

			$clave_venta=1;
			$cVenta=mysql_query("
					INSERT INTO ventas_salidas VALUES(
					'','$clave_venta',$cantGr,NOW(),$id_persona,$id_producto,3,'','',$id_establecimiento,$precio_venta,0,0
					  )")
			or die("Error al insertar el producto en la venta. (case 1:)<br/>".mysql_error());
			header("Location: index.php?cv=$clave_venta");
			
		break;
		
		case 2:
		/*echo "CLAVE VENTA: $clave_venta <br/>";
		echo "ID TIPO VENTA: $id_tipo_venta <br/>";
		echo "ID PRODUCTO: $id_producto <br/>";
		echo "CANTIDAD GRAMOS: $cantGr <br/>";
		echo "ID PERSONA: $id_persona <br/>";
		echo "ID HOSPITAL: $id_establecimiento <br/>";*/
		
		$clave_venta=$_POST['clave_venta'];
		
		/*/////////////////////////////////////////////////////////////////////////////////////////////*/
		/*////////////////// PARA AUMENTARLE 5 PESOS EN EL RANGO DE 1GR A 999GR /////////////////////*/
		/*/////////////////////////////////////////////////////////////////////////////////////////////*/
		if($cantGr>=1 && $cantGr<=999 ){
			  $precio_venta=$precio_venta+5;
			}
		/*/////////////////////////////////////////////////////////////////////////////////////////////*/
		/*/////////////////////////////////////////////////////////////////////////////////////////////*/
		/*/////////////////////////////////////////////////////////////////////////////////////////////*/
		
		$cVenta=mysql_query("
					INSERT INTO ventas_salidas VALUES('','$clave_venta',$cantGr,NOW(),$id_persona,$id_producto,3,'','',$id_establecimiento,$precio_venta,0,0
					  )")
			or die("
				  
				   <script language='javascript'> 
					alert
					('Es un código no valido'); 
					history.back(-1);
					</script>
				 
				   ".mysql_error());
			header("Location: index.php?cv=$clave_venta");
		
		
		break;
		
		default:
		echo "Ha ocurrido un error inesperado";
		break;
		
		
		}

			
	
	
	

?>

