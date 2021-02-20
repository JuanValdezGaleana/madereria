<?php

require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_SESSION['SESSION_ID_PERSONA'];

if($_GET['entra_c']==''){
$cve_producto=$_POST['entra_codigo'];
}else{
	if($_POST['entra_codigo']==''){
	 $cve_producto=$_GET['entra_c'];
				}
	}

/*echo "CODIGO DEL PRODUCTO: $cve_producto<br/>";*/

/*BUSCAMOS EL ID DEL PRODUCTO QUE TENGA LA CLAVE DE PRODUCTO ENVIADO DESDE EL FORMULARIO O LISTA DE PRODUCTOS*/
$cIdProd=mysql_query("
		SELECT ID_PRODUCTO FROM productos WHERE CVE_PRODUCTO='$cve_producto';
					 ")
or die("No se pudo consultar el identificador del producto.<br/>".mysql_error());
$dIdProd=mysql_fetch_array($cIdProd);
$id_producto=$dIdProd['ID_PRODUCTO'];/*ID DEL PRODUCTO QUE SE VA A INSERTAR*/
$numRegs=mysql_num_rows($cIdProd);
if($numRegs==0){
	?>
    <script language="javascript"> 
                    alert
                    ('No se encontró ningun producto con la clave <?php echo $cve_producto; ?>'); 
                    location.href = "s_consulta2.php?ic=<?php echo $ic; ?>";
                    </script>     
    <?php
	}else{ /*INICIO ELSE 1*/
		
		
	


/*$id_producto=$_POST['id_producto'];*/ /*ID DEL PRODUCTO QUE SE VA A INSERTAR Y QUE SE VA A DESCONTAR DEL INVENTARIO*/
$ihs=$_GET['ihs'];/*ID DEL HISTORIAL DE SERVICIO*/
/*echo "IHS: $ihs<br/>";*/

$ic=$_GET['ic'];
/*echo "IC: $ic<br/>";*/
/*echo "ID DE PRODUCTO $id_producto <br/>";
echo "ID DE IHS $ihs";*/


/*HACEMOS LA INSERCION DEL MATERIAL SELECCIONADO*/

$insMaterial=mysql_query("
	INSERT INTO historial_material VALUES(
		'',$ihs,NOW(),$id_persona,$id_producto
						 );")
or die("No se pudo registrar el material utilizado. <br>".mysql_error());

/*CONSULTAMOS LA CANTIDAD ACTUAL DEL PRODUCTO AL QUE SE LE VA A DESCONTAR*/
$cA=mysql_query("
		SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO=$id_producto;
				")
or die("No se pudo consultar cuantos productos hay en existencia. <br/>".mysql_error());
$dCA=mysql_fetch_array($cA);
$cantActual=$dCA['CANTIDAD_ACTUAL']; /*ESTA ES LA CANTIDAD ACTUAL DEL PRODUCTO*/

/*DESCONTAMOS EL PRODUCTO*/
$nuevaCant=$cantActual-1;


/*DESCONTAMOS EL PRODUCTO DEL INVENTARIO DE FARMACIA*/
$descInventario=mysql_query("
				UPDATE inventario SET
				CANTIDAD_ACTUAL=$nuevaCant
				WHERE ID_PRODUCTO=$id_producto;
							")
or die("Hubo un problema al descontar del inventario. <br/>".mysql_error());

/*INSERTAMOS UN REGISTRO EN LA TABLA historial_inventario LA CANTIDAD ANTERIOR QUE HABIA ANTER DE DESCONTAR*/
$CantAnterior=mysql_query("
				INSERT INTO historial_inventario VALUES(
				'',$id_producto,$cantActual,NOW()
				)
							")
or die("Hubo un problema al registrar en el historial de inventario. <br/>".mysql_error());

header("Location: s_consulta2.php?ip=$ip&ic=$ic");
exit();


	}/*FIN DEL ELSE 1*/
?>