<?php require("../aut_verifica.inc.php"); 
$clave_venta=base64_decode($_GET['c']);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nota</title>
<style type="text/css">
.bot_generar{
	background:#36F; color:#FFF; border:none; padding-top:15px; padding-bottom:15px;}
.bot_generar:hover{ background:#06F;}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="ins_salida_prod.php">
<table width="100%" border="0">
  <tr>
    <td align="center">ESCRIBE TU NOTA DE SALIDA</td>
  </tr>
  <tr>
    <td align="center">
      <label for="nota_sal"></label>
      <textarea name="nota_sal" rows="4" id="nota_sal" style="width:95%;" autofocus="autofocus" onchange="javascript:this.value=this.value.toUpperCase();" required="required"></textarea>
    </td>
  </tr>
  <tr>
    <td align="center">
    <select name="id_sal_prod">
    <?php 
	$q_c_sal=mysql_query("
	SELECT ID_SAL_PROD, SALIDA_PRODUCTO FROM cat_salida_producto
	")
	or die("No se pudo hacer la consulta del catalogo de salidas. <br />".mysql_error());
	while($d_c_sal=mysql_fetch_array($q_c_sal)){
	 ?>
      <option value="<?php echo $d_c_sal['ID_SAL_PROD']; ?>"><?php echo $d_c_sal['SALIDA_PRODUCTO']; ?></option>
      <?php } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td align="center">
    <input name="c" type="hidden" value="<?php echo $clave_venta; ?>" />
    <input type="submit" name="button" id="button" value="Generar nota de salida" class="bot_generar"/></td>
  </tr>
</table>
</form>

</body>
</html>