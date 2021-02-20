<?php
require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_SESSION['SESSION_ID_PERSONA'];

$ic=$_GET['ic'];/*ID DE LA CONSULTA*/
$im=$_GET['im'];/*ID DEL PRODUCTO EN LA CONSULTA QUE SE VA A CAMBIAR DE ESTATUS*/
$cantidad=1;/*CANTIDAD DEL PRODUCTO QUE SE VA A AUMENTAR*/

$id_receta=$_GET['ir'];/*ID DE LA RECETA*/

/*CONSULTAMOS LA CONTIDAD ACTUAL DEL PRODUCTO EN EL INVENTARIO */
$cCant=mysql_query("
	SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO=$im;
					  ")
or die("No se pudo consultar la cantidad del inventario. <br/>".mysql_error());
$cCant=mysql_fetch_array($cCant);
$cantActual=$cCant['CANTIDAD_ACTUAL'];/*CANTIDAD ACTUAL DEL PRODUCTO*/

/*AL REGRESAR EL PRODUCTO LO VOLVEMOS A SUMAR EN EL INVENTARIO Y EN EL HISTORIAL*/
$cantDescontada=$cantActual+$cantidad;

/*HACEMOS UN UPDATE HACIA LA TABLA DE 'inventario' PARA AUMENTAR EL PRODUCTO*/
$cDescont=mysql_query("
		UPDATE inventario SET CANTIDAD_ACTUAL=$cantDescontada WHERE ID_PRODUCTO=$im;
					  ")
or die("No se pudo descontar el producto del inventario. <br/>".mysql_error());

/*INSERTAMOS UN REGISTRO EN LA TABLA 'historial_inventario' para dar a conocer el moviemiento*/
$inHInv=mysql_query("
		INSERT INTO historial_inventario VALUES(
								'',$im,$cantActual,NOW()
												)")
or die("No se pudo descontar el producto del inventario. <br/>".mysql_error());





/* BUSCAMOS EN EL CATALOGO DE cat_estatus_activo DONDE EL ESTATUS SEA 'INACTIVO'	*/

$cEstatus=mysql_query("
			SELECT ID_ESTATUS_ACTIVO FROM cat_estatus_activo WHERE ESTATUS_ACTIVO = 'INACTIVO';
					  ")
or die("No se pudo consultar el estatus. <nr/>".mysql_error());
$estatus=mysql_fetch_array($cEstatus);
$id_estatus_activo=$estatus['ID_ESTATUS_ACTIVO'];

/*ACTUALIZAMOS EL REGISTRO PARA QUE TENGA UN ESTATUS DE ACTIVO Y SE PUEDA COBRAR*/
$upProdRec=mysql_query("
			UPDATE receta SET
			ID_ESTATUS_ACTIVO=$id_estatus_activo
			WHERE ID_CONSULTA=$ic
			AND ID_RECETA=$id_receta;
					   ")
or die("No se pudo actualizar el estatus del producto de la receta.<br/>".mysql_error());

header("Location: detalle_cobro.php?ic=$ic#receta");

?>