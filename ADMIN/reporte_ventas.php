<?php require("../aut_verifica.inc.php");
require_once('../class.ezpdf.php');
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

if($_GET['fInicio']==''){
	$fInicio=$_POST['fInicio'];
	}elseif($_POST['fInicio']==''){
		$fInicio=$_GET['fInicio'];
		}
		
		
if($_POST['fFin']==''){
	$fFin=$_GET['fFin'];
	}elseif($_GET['fFin']==''){
		$fFin=$_POST['fFin'];
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte</title>
</head>

<!--<body style="margin:0; height:auto;font-family:Agency FB;src: url(fonts/AGENCYR.TTF);">-->
<!--<body style="margin:0; height:auto;font-family:Arial;">-->
<body style="margin:0; height:auto;font-family:Rockwell Condensed;src: url(fonts/ROCC.TTF);">
<!--<body style="margin:0; height:auto;font-family:Arial Narrow;src: url(fonts/ARIALNB.TTF);">-->
<?php
$qventas=mysql_query("
SELECT
A.FECHA,
A.CANTIDAD_VEN,
B.DESCRIPCION,
A.PRECIO_VENTA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON A.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
WHERE A.FECHA
BETWEEN '".$fInicio."'
AND '".$fFin."'
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.ID_VENTA_SALIDA ;")
or die("No se pudo hacer la consulta.<br/>".mysql_error());

?>

<table width="100%" border="0" style="font-size:10px;">
<tr style="font-size:11px;">
  <td colspan="3" align="center"  style="font-size:11px;">
  <?php echo $_SESSION['SESSION_RAZON_SOCIAL'];  ?> <br />
  </td>
</tr>
<tr style="font-size:11px;">
  <td colspan="3">
  REPORTE DE VENTAS
  DE <?php echo $fInicio; ?> <br />
  AL <?php echo $fFin;  ?>
  </td>
  </tr>
<tr>
    <td>FECHA </td>
    <td>DESCRIPCIÓN</td>
    <td align="right">PRECIO</td>
  </tr>
<?php
$suma=0;
while( $datventas=mysql_fetch_array($qventas)){
 ?>
  
  <tr>
    <td><?php echo $datventas['FECHA']; ?></td>
    <td><?php echo $datventas['DESCRIPCION']; ?></td>
    <td align="right"><?php echo $datventas['PRECIO_VENTA']; ?></td>
  </tr>
 
 <?php
 $suma=$suma+$datventas['PRECIO_VENTA'];
  } 
  
  
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right">TOTAL $ <?php echo number_format($suma,2); ?></td>
  </tr>
</table>


</body>
</html>
