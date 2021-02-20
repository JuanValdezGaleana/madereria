<?php
require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_SESSION['SESSION_ID_PERSONA'];



$cod_entrada=$_POST['cod_entrada'];
$cant_entrada=$_POST['cant_entrada'];



/*Verificamos si existen registros con el codigo insertado*/
$consulta1="
SELECT
COUNT(ID_PRODUCTO) AS NUM_REG
FROM productos
WHERE CVE_PRODUCTO='".$cod_entrada."';
";

$cons_contar=mysql_query($consulta1)
or die("No se pudo hacer la consulta para contar el numero de registros. <br/>".mysql_error());

$num_registros=mysql_fetch_array($cons_contar);

if($num_registros['NUM_REG']==0){$opc=0;}
if($num_registros['NUM_REG']==1){$opc=1;}
if($num_registros['NUM_REG']>=2){$opc=2;}
 
switch($opc){
	
	    case 0: ?>
			<script type="text/javascript">
			alert('No existe ningun producto con el codigo <?php echo $cod_entrada; ?>');
			location.href="alta_productos.php#reg_productos";
			</script>
<?php	break;
	
	    case 1: 

	$consulta2="
SELECT
A.ID_PRODUCTO,
B.CANTIDAD_ACTUAL
FROM productos A
INNER JOIN inventario B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
WHERE A.CVE_PRODUCTO='".$cod_entrada."';
";

	$cons_datos=mysql_query($consulta2)
	or die("No se pudo hacer la consulta de los datos. <br/>".mysql_error());

	$datos=mysql_fetch_array($cons_datos);
	
	$id_producto=$datos['ID_PRODUCTO'];
	$cantidad_actual=$datos['CANTIDAD_ACTUAL'];
	
	
	/*Creamos el registro de los productos y la cantidad ingresada*/
	
	$ins_reg=mysql_query("
		INSERT INTO registro_cant_producto VALUES(
		$id_producto,'',$cant_entrada,NOW(),$id_persona
		);
	")
	or die("No se pudo crear el registro de la insercion de los productos. <br />".mysql_error());
	
	
	if($ins_reg){
		/*Hacemos la suma de las cantidades*/
			$nueva_cantidad=$cantidad_actual+$cant_entrada;
		
/*Actualizamos la cantidad del producto en el inventario*/
			$upd_cant_almacen=mysql_query("
				UPDATE inventario SET CANTIDAD_ACTUAL=$nueva_cantidad WHERE ID_PRODUCTO=$id_producto;
			")
			or die("No se pudo hacer la actualizacion de la cantidad en almacen. <br />".mysql_error());
		
		/*Insertamos un registro en la tabla de historial de inventario*/
			$ins_historial=mysql_query("
				INSERT INTO historial_inventario VALUES(
				'',$id_producto,$cantidad_actual,NOW()
				);
			")
			or die("No se pudo crear el registro de historial de inventario.<br />".mysql_error());
			
			if($ins_historial){ ?>  
			<script type="text/javascript">
			alert('Se ha cargado la cantidad con exito \nCantidad anterior: <?php echo $cantidad_actual; ?>\nCantidad insertada: <?php echo $cant_entrada; ?>\nTOTAL: <?php echo $nueva_cantidad;  ?>');
			location.href="alta_productos.php";
			</script>
			
			<?php }
			
		}/*fin del if($ins_reg)*/
	
	    break;
	
	    case 2: ?>
				<script type="text/javascript">
				alert('No se puede hacer hacer la insercion porque existe mas de un producto con la misma clave\n<?php echo $cod_entrada; ?>.\n');
				history.back(1);
				</script>
	    break; <?php
	
	}












?>