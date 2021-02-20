<?php
require("../aut_verifica.inc.php");

$cantidad=base64_decode($_GET['c']);
$id_producto=base64_decode($_GET['d']);
$id_cantidad_producto=base64_decode($_GET['ip']);

$cant_act=mysql_query("
	SELECT
CANTIDAD_ACTUAL
FROM inventario
WHERE ID_PRODUCTO=".$id_producto.";
")
or die("No se pudo cunsultar la cantidad actual.<br />".mysql_error());
$d_cant_act=mysql_fetch_array($cant_act);
$cantidad_actual=$d_cant_act['CANTIDAD_ACTUAL'];

/*Hacemos la resta*/
$aux=$cantidad_actual-$cantidad;

/*Se hace el descuento en la tabla de inventario*/
$upd_cantidad=mysql_query("
	UPDATE inventario SET CANTIDAD_ACTUAL=$aux WHERE ID_PRODUCTO=$id_producto;
")
or die("No se pudo hacer la actualizacion de las cantodades. <br />".mysql_error());

/*borramos el registro de la tabla registro_cant_producto*/
$borrar=mysql_query("
		DELETE FROM registro_cant_producto WHERE ID_CANTIDAD_PRODUCTO=".$id_cantidad_producto.";
")
or die("No se pudo borrar el registro.<br />".mysql_error());

/*Insertamos un registro en la tabla de historial*/
$hist=mysql_query("
		INSERT INTO historial_inventario VALUES(
		'',$id_producto,$cantidad_actual,NOW()
		);
")
or die("No se pudo crear el registro en el historial.<br />".mysql_error());

if($hist){ ?>
	<script type="text/javascript">
	alert('Se ha eliminado el registro');
	location.href="alta_productos.php";
	</script>
<?php	}

?>