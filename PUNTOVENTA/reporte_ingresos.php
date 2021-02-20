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
<table width="100%" border="0" class="propTabla" style=" border-collapse:collapse;font-size:11px;">
  <tr class="bgtabla">
    <td colspan="3" align="center"><?php echo $_SESSION['SESSION_RAZON_SOCIAL'];  ?> <br /></td>
  </tr>
  <tr class="bgtabla">
    <td colspan="3" align="center">REPORTE DE PRODUCTOS INGRESADOS</td>
    </tr>
  <tr class="bgtabla">
    <td colspan="3" align="left">
    FECHA DE INICIO: <?php echo date("d-m-Y",strtotime($fInicio)); ?><br />
    FECHA DE FIN: <?php echo date("d-m-Y",   strtotime($fFin)); ?>
    </td>
  </tr>
  <tr class="bgtabla">
    <td colspan="3" align="left">&nbsp;</td>
  </tr>
  <tr class="bgtabla">
    <td>FECHA</td>
    <td>PRODUCTO</td>
    <td align="right">CANT</td>
  </tr>
  <?php 
    /*consultamos los diferentes usuarios que han ingresado material en el rango de fechas*/
  $q_usuarios=mysql_query("
  SELECT
DISTINCT(A.ID_PERSONA),
CONCAT(B.NOMBRE,' ',B.AP_PATERNO,' ',B.AP_MATERNO) AS NOMBRE
FROM registro_cant_producto A
INNER JOIN persona B
ON A.ID_PERSONA=B.ID_PERSONA
WHERE A.FECHA_ALTA
BETWEEN '".$fInicio."'
AND '".$fFin."'
;
  ")
  or die("No se pudo hacel la consulta de los usuarios.<br />".mysql_error());
while($d_susarios=mysql_fetch_array($q_usuarios)){

$nombre=$d_susarios['NOMBRE'];
  
   ?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top">Productos ingresados por <?php echo $nombre;  ?></td>
    </tr>
  <?php 

  $cons_inser=mysql_query("
SELECT
A.FECHA_ALTA,
B.DESCRIPCION,
A.CANTIDAD_ALTA,
CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS NOMBRE
FROM registro_cant_producto A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
WHERE A.ID_PERSONA=".$d_susarios['ID_PERSONA']."
AND A.FECHA_ALTA
BETWEEN '".$fInicio."'
AND '".$fFin."';
  ")
  or die("No se pudo hace la consulta de producto agregados.<br />".mysql_error());
  while($dat_ins=mysql_fetch_array($cons_inser)){
   ?>
  
  <tr>
    <td valign="top"><?php echo $dat_ins['FECHA_ALTA']; ?></td>
    <td><?php echo $dat_ins['DESCRIPCION']; ?></td>
    <td align="right" valign="top"><?php echo $dat_ins['CANTIDAD_ALTA']; ?></td>
  </tr>
  
  <?php }
  
  }
   ?>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
</table>




</body>
</html>
