<?php require("../aut_verifica.inc.php");
$idPer=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$num_salida=base64_decode($_GET['n']);
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
    <td align="center">NOMBRE Y FORMA DE QUIEN SE LLEVA EL MATERIAL</td>
  </tr>
</table>


</body>
</html>