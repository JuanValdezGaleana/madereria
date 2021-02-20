<?php require("../aut_verifica.inc.php");
$clave_venta=$_GET['clave_venta'];
$pe=$_GET['e'];
$cam=$_GET['c'];
$id_vendedor=$_SESSION['SESSION_ID_PERSONA'];
/*OBTENEMOS LOS DATOS DEL VENDEDOR*/
$cVend=mysql_query("
				   SELECT CONCAT(NOMBRE,' ',AP_PATERNO,' ',AP_MATERNO)AS NOMBRE FROM persona WHERE ID_PERSONA=$id_vendedor;
				   ")
or die("No se pudo consultar los datos del vendedor. <br/>".mysql_error());
$dVendedor=mysql_fetch_array($cVend);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body{
	font-family:Arial;}
</style>
</head>
<body onload="window.print();">
<div style="margin:0 auto; width:230px; font-size:8px; padding:10px 15px 10px 15px;">
<div style="width:100%; height:25px; color:#000; text-align:center; font-size:12px;">
 <?php
 echo "FARMACIA NORMA <br/>";
 echo "<br/><br/>";
 ?>
</div>
<div style="width:100%; height:40px; color:#000; font-size:10px;">
 <?php
 echo "TICKET NO.: $clave_venta <br/>";
  echo "FECHA: ".date("d-m-Y H:i:s")." <br/>";
   echo "ATENDIO: ".$dVendedor['NOMBRE']." <br/>";
 ?>
</div>


<?php
echo "<br/>";
$aticket=mysql_query("
SELECT
			  SUM(A.CANTIDAD_VEN) AS CANTIDAD,
              D.ACRONIMO AS UM,
			  /*A.ID_PRODUCTO,*/
              /*A.ID_VENTA_SALIDA,*/
			  B.DESCRIPCION,
              IF(D.ACRONIMO='$',(SUM(A.CANTIDAD_VEN)*B.PRECIO_VENTA),
              IF(D.ACRONIMO='GR',(B.PRECIO_VENTA/1000)*(SUM(A.CANTIDAD_VEN)), B.PRECIO_VENTA)
              ) AS UNIT,
              IF(D.ACRONIMO='$',(SUM(A.CANTIDAD_VEN)*B.PRECIO_VENTA),
               IF(D.ACRONIMO='GR',(B.PRECIO_VENTA/1000)*(SUM(A.CANTIDAD_VEN)), B.PRECIO_VENTA*SUM(A.CANTIDAD_VEN))
              ) AS IMP
              /*C.TIPO_PRES_PROD,*/
			  /*B.DESCUENTO,*/
			  FROM ventas_salidas A
			  INNER JOIN productos B
			  ON A.ID_PRODUCTO=B.ID_PRODUCTO
			  INNER JOIN CAT_TIPO_PRES_PROD C
			  ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
			  INNER JOIN CAT_UNIDAD_MEDIDA D
			  ON B.ID_UNIDAD_MEDIDA=D.ID_UNIDAD_MEDIDA
			  WHERE A.CVE_VENTA='$clave_venta'
			  GROUP BY A.ID_PRODUCTO
			  ORDER BY A.ID_VENTA_SALIDA DESC;
			  ;
					 ")
or die("No se pudieron consultar los productos del ticket. <br>".mysql_error());
?>
	<table width="100%" border="0">
  <tr>
    <td width="14%">CANT.</td>
    <td width="67%">DESCRIPCION</td>
    <td width="10%">P.U.</td>
    <td width="9%">IMP</td>
  </tr>
<?php
while($dticket=mysql_fetch_array($aticket)){
	?>

  <tr>
    <td align="left" valign="top"><?php echo $dticket['CANTIDAD']." ".$dticket['UM']; ?></td>
    <td align="left" valign="top"><?php echo $dticket['DESCRIPCION']; ?></td>
    <td align="right" valign="top"><?php echo number_format($dticket['UNIT'],2); ?></td>
    <td align="right" valign="top"><?php echo number_format($dticket['IMP'],2); ?></td>
  </tr>

 
  
<?php
        $total=$total+$dticket['IMP'];
	}  
?>
  <tr>
    <td colspan="4" align="right"><?php 
					echo "TOTAL: $".number_format($total,2)."<br/>";
					echo "PAGO EN EFECTIVO: $".number_format($pe,2)."<br/>";
					echo "CAMBIO: $".number_format($cam,2)."<br/>";
					
					
					?></td>
    </tr>
 </table>
                 <div style=" text-align:center;">
                 <?php echo "========================================"; 
				       echo "<br/>";
				       echo "****** GRACIAS POR SU COMPRA ******" ?>
                 </div>
</div>

</body>
</html>
