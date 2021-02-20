<?php require("../aut_verifica.inc.php"); 
$clave_venta=$_POST['c'];
$id_sal_prod=$_POST['id_sal_prod'];
$nota_sal=$_POST['nota_sal'];
$id_persona=$_SESSION['SESSION_ID_PERSONA'];
/*Consultamos el número de registrso que hay en la tabla de salidas_productos, si no hay ningun registro empezaremos con la primera salida y colocamos en número 1 en el campo NUM_SALIDA*/

$quer_regs=mysql_query("
SELECT COUNT(ID_SALIDA_PRODUCTO) FROM salidas_producto;
")
or die("No se pudo hacer el conteo de regitros. <br />".mysql_error());
$num_regs=mysql_fetch_array($quer_regs);

if($num_regs['COUNT(ID_SALIDA_PRODUCTO)']==0){$opc=0;}
if($num_regs['COUNT(ID_SALIDA_PRODUCTO)']>0){$opc=1;}

switch($opc){
	case 0:
	$num_salida=1;
	break;
	
	case 1:
	$q_num_sal=mysql_query("
	SELECT MAX(NUM_SALIDA) FROM salidas_producto;
	")
	or die("No se pudo crear el numero de salida.<br />".mysql_error());
	$dat_num_sal=mysql_fetch_array($q_num_sal);
	$num_salida=$dat_num_sal['MAX(NUM_SALIDA)']+1;
	break;
	}

/*Consultamos los productos que estén en la clave de venta enviada y los agregamos a la tabla de salidas*/
	$buscar_prods=mysql_query("
	SELECT ID_PRODUCTO FROM ventas_salidas WHERE CVE_VENTA='".$clave_venta."';
	")
	or die("No se pudo hacer la consulta de los productos de la clave enviada.<br />".mysql_error());
	$cont=0;
	while($dat_buscar_prods=mysql_fetch_array($buscar_prods)){
		$id_prod=$dat_buscar_prods['ID_PRODUCTO'];
		$cont=$cont+1;
		
		/*En cada iteración vamos a ir insertando el id del producto en la tabla salida_productos*/
		
		/*Hacemos un if para insertar solamente en el primer registro la nota*/
		if($cont==1){
			$ins_salidas=mysql_query("
		INSERT INTO salidas_producto VALUES('',$num_salida,$id_prod,1,NOW(),'$nota_sal',$id_sal_prod,$id_persona);
		")
		or die("No se pudo hacer la insercion. <br />".mysql_error());
			}elseif($cont>=2){
			$ins_salidas=mysql_query("
		INSERT INTO salidas_producto VALUES('',$num_salida,$id_prod,1,NOW(),'',$id_sal_prod,$id_persona);
		")
		or die("No se pudo hacer la insercion. <br />".mysql_error());
			}
			
			/*Tambien vamos a ir descontando de la tabla de inventario*/
			/*Consultamos cuantos productos hay*/
			$q_num_inventario=mysql_query("
			SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO=".$id_prod.";
			")
			or die("No se pudo hacer la consulta de cantidad en inventario. <br />".mysql_error());
			$dat_num_inventario=mysql_fetch_array($q_num_inventario);
			$num_inventario=$dat_num_inventario['CANTIDAD_ACTUAL'];
			
			$nueva_cant=$num_inventario-1;
			/*Restamos la cantidad y hacemos un update a la tabla de inventario*/
			$upd_num_inventario=mysql_query("
			UPDATE inventario SET CANTIDAD_ACTUAL=".$nueva_cant." WHERE ID_PRODUCTO=".$id_prod.";
			")
			or die("No se pudo hacer la consulta de cantidad en inventario. <br />".mysql_error());
			
		
		}
/*Borramos los productos de la tabla ventas_salidas*/
$del_ventas=mysql_query("
DELETE FROM ventas_salidas WHERE CVE_VENTA='".$clave_venta."';
")
or die("No se pudieron borrar los datos. <br />".mysql_error());
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VENTA</title>
</head>

<!--<body style="margin:0; height:auto;font-family:Agency FB;src: url(fonts/AGENCYR.TTF);">-->
<body style="margin:0; height:auto;font-size:11px;font-family:Rockwell Condensed;src: url(fonts/ROCC.TTF);">
<table width="100%" border="0">
  <tr>
    <td align="right">
    <a href="index.php" style="color:#F00; font-size:14px;">CERRAR</a></td>
  </tr>
  <tr>
    <td align="center">SALIDA DE MERCANCIA</td>
  </tr>
</table>

<table width="100%" border="0" style=" border-collapse:collapse">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PRODUCTO</td>
  </tr>
  <?php
  $q_lista_sal=mysql_query("
  SELECT
A.ID_SALIDA_PRODUCTO,
A.NUM_SALIDA,
B.DESCRIPCION,
A.FECHA
FROM salidas_producto A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
WHERE NUM_SALIDA=".$num_salida.";
  ")
  or die("No se pudo hacer la consulta de las salidas.<br />".mysql_error());
  while($d_lista_sal=mysql_fetch_array($q_lista_sal)){
    ?>
  <tr>
    <td> <?php echo $d_lista_sal['DESCRIPCION']; ?></td>
  </tr>
  
  <?php  
  }
  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
$qda=mysql_query("
SELECT
A.FECHA,
A.OBSERVACION,
CONCAT(B.NOMBRE,' ',B.AP_PATERNO,' ',B.AP_MATERNO) AS NOM
FROM salidas_producto A
INNER JOIN persona B
ON A.ID_PERSONA=B.ID_PERSONA
WHERE NUM_SALIDA=".$num_salida."
LIMIT 1;
")
or die("No se pudieron obtener los datos de la autorizacion de la salida.<br />".mysql_error());
$dda=mysql_fetch_array($qda);
?>
<table width="100%" border="0">
  <tr>
    <td>FECHA: <?php echo date("d-m-Y");  ?></td>
  </tr>
  <tr>
    <td>HORA: <?php echo date("H:i");  ?></td>
  </tr>
  <tr>
    <td>NOTA: <?php echo $dda['OBSERVACION']; ?></td>
  </tr>
  <tr>
    <td>AUTORIZÓ: <?php echo $dda['NOM']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">______________________________________</td>
  </tr>
  <tr>
    <td align="center">NOMBRE Y FIRMA DE QUIEN SE LLEVA EL MATERIAL</td>
  </tr>
</table>


</body>
</html>
