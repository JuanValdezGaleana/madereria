<?php require("../aut_verifica.inc.php");
require_once('../class.ezpdf.php');
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

$clave_venta=base64_decode($_GET['cve']);
$r=base64_decode($_GET['r']);
$cambio=base64_decode($_GET['c']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VENTA</title>
</head>

<!--<body style="margin:0; height:auto;font-family:Agency FB;src: url(fonts/AGENCYR.TTF);">-->
<body style="margin:0; height:auto;font-family:Rockwell Condensed;src: url(fonts/ROCC.TTF);">
<?php
$qventas1=mysql_query("
SELECT
A.CVE_VENTA,
A.FECHA,
A.CANTIDAD_VEN,
B.DESCRIPCION,
A.PRECIO_VENTA,
B.PRECIO_FINAL,
E.TOTAL_RECIBIDO,
E.CAMBIO
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON A.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
INNER JOIN efectivo_ventas E
ON E.ID_EFECTIVO_VENTA = A.ID_EFECTIVO_VENTA
WHERE A.CVE_VENTA='".$clave_venta."'
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.ID_VENTA_SALIDA DESC;
")
or die("No se pudo hacer la consulta.<br/>".mysql_error());

$datvent=mysql_fetch_array($qventas1);
?>

<table width="100%" border="0" style="font-size:11px;">

<tr>
  <td colspan="3" align="left">
  FECHA DE REIMPRESIÓN: <?php echo date("d-m-Y");  ?> <br />
  <?php echo $datvent['FECHA'];  ?> <br />
  
  </td>
</tr>
<tr>
  <td colspan="3" align="left">&nbsp;</td>
</tr>
<tr>
  <td>CANT.</td>
    <td>DESCRIPCIÓN</td>
    <td align="right">PRECIO UNITARIO</td>
    <td align="right">IMPORTE</td>
  </tr>
<?php
$suma=0;
$qventas=mysql_query("
SELECT
A.CVE_VENTA,
A.FECHA,
A.CANTIDAD_VEN,
B.DESCRIPCION,
A.PRECIO_VENTA,
B.PRECIO_FINAL
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON A.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
WHERE A.CVE_VENTA='".$clave_venta."'
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.ID_VENTA_SALIDA DESC;
")
or die("No se pudo hacer la consulta.<br/>".mysql_error());
while( $datventas=mysql_fetch_array($qventas)){
 ?>
  
  <tr>
    <td><?php echo $datventas['CANTIDAD_VEN']; ?></td>
    <td><?php echo $datventas['DESCRIPCION']; ?></td>
    <td align="right"><?php echo $datventas['PRECIO_FINAL']; ?></td>
    <td align="right"><?php echo $datventas['PRECIO_VENTA']; ?></td>
  </tr>
 
 <?php
 $suma=$suma+$datventas['PRECIO_VENTA'];
  } 
  
  
  ?>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">TOTAL</td>
    <td align="right"><?php echo "$ ".number_format($suma,2); ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">EFECTIVO</td>
    <td align="right"><?php echo "$ ".number_format($datvent['TOTAL_RECIBIDO'],2); ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">CAMBIO</td>
    <td align="right"><?php echo "$ ".number_format($datvent['CAMBIO'],2);  ?></td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left">
    <?php
	/*Consultamos e imprimimos el cliente*/
	$qcliente=mysql_query("
SELECT
A.ID_CLIENTE,
E.RAZON_SOCIAL
FROM ventas_salidas A
INNER JOIN establecimiento E
ON A.ID_CLIENTE=E.ID_ESTABLECIMIENTO
WHERE A.CVE_VENTA='".$clave_venta."'
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.ID_VENTA_SALIDA DESC
LIMIT 1;
")
or die("No se pudo hacer la consulta.<br/>".mysql_error());
	$dcliente=mysql_fetch_array($qcliente);
	echo $dcliente['RAZON_SOCIAL'];
	?>
    </td>
  </tr>
  
  <tr>
    <td colspan="3" align="center">TELEFONOS: 7131330060</td>
  </tr>
  
  <tr>
    <td colspan="3" align="center">¡GRACIAS POR SU COMPRA!</td>
  </tr>
</table>


</body>
</html>
