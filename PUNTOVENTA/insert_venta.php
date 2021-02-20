<?php 
require("../aut_verifica.inc.php");

if($_GET['entra_c']!=""){
	$entra_cod=$_GET['entra_c'];
	}
if($_POST['entra_codigo']!=""){
	$entra_cod=$_POST['entra_codigo'];
	}
	

$entra_codigo=trim($entra_cod);
$id_persona=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=1;
$id_tipo_venta=1;

$id_estatus_venta=$_POST['id_estatus_venta'];

/*echo "CODIGO: $entra_codigo<br/>";
echo "ID_PERSONA: $id_persona<br/>";
echo "ID_ESTABLECIMIENTO: $id_establecimiento<br/>";
echo "ID_TIPO_VENTA: $id_tipo_venta<br/>";

*/


/*//////////////// CONSULTAMOS EL ID DEL PRODUCTO QUE SE ACABA DE INGRESAR MEDIANTE LA CLAVE DE PRODUCTO*/
$cIDProd=mysql_query(" SELECT ID_PRODUCTO,PRECIO_FINAL FROM productos WHERE CVE_PRODUCTO='$entra_codigo' ")
	or die("Error al consultar el identificador del producto. <br/>.".mysql_error());
	$dIDProd=mysql_fetch_array($cIDProd);
	$id_producto=$dIDProd['ID_PRODUCTO'];
	$precio_venta=$dIDProd['PRECIO_FINAL'];
	
	//echo "ID DEL PRODUCTO $id_producto <br/>";
/*//////////////////////////  VERIFICAMOS SI YA EXISTE  LA PRIMERA CLAVE GENERADA DE LA VENTA DE UN HOSPITAL DETERMINADO */	
	$cContar=mysql_query("SELECT COUNT(ID_VENTA_SALIDA) FROM ventas_salidas;")
	or die("No se pudo hacer el conteo de registros. ".mysql_error());
	$dContar=mysql_fetch_array($cContar);
	$num=$dContar['COUNT(ID_VENTA_SALIDA)'];
	
	//echo "Num de conteo> $num <br/>";
$opc;	
	if($num==0){$opc=1;} /* SI NO HAY REGISTROS A $opc LE ASIGNAMOS EL N�MERO 1 PARA QUE ENTRA AL SWITCH */
	if($num>0){$opc=2;} /* SI YA HAY REGISTROS LE ASIGNAMOS 2 PARA ENTRAR AL SWITCH */
	
	
	switch($opc){
		
		case 1:	
		/*////  SI NO SE HA ECHO LA PRIMERA VENTA, NO SE HA GENERADO LA CLAVE DE VENTA PARA HACER SU CONSECUTIVO. ENTONCES LA GENERAMOS   */	
			$clave_venta="$id_establecimiento-1";
			$cVenta=mysql_query("
					INSERT INTO ventas_salidas VALUES(
					'','$clave_venta',1,NOW(),$id_persona,$id_producto,".$id_estatus_venta.",'','',$id_establecimiento,$precio_venta,0,0
					  )")
			or die("Error al insertar el producto en la venta. (case 1:)<br/>".mysql_error());
			header("Location: index.php?cv=$clave_venta");
			
		break;
		
		case 2:
		if($_GET['clave_venta']==""){
		$clave_venta=$_POST['clave_venta'];}
		if($_POST['clave_venta']==""){
		$clave_venta=$_GET['clave_venta'];}
		
		
		$cVenta=mysql_query("INSERT INTO ventas_salidas VALUES(
					'','$clave_venta',1,NOW(),$id_persona,$id_producto,".$id_estatus_venta.",'','',$id_establecimiento,$precio_venta,0,0
					  )")
			or die(mysql_error()."
				  
				   <script language='javascript'> 
					alert
					('No se encuentra el codigo: ".$id_estatus_venta."'); 
					history.back(-1);
					</script>
				 
				   ");
			header("Location: index.php?cv=$clave_venta"); ?>
		 		
		<?php
		break;
		
		default:
		echo "Ha ocurrido un error inesperado";
		break;
		
		
		}


?>
