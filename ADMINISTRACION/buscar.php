<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BUSCAR</title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>

<body>
<?php $tipo=$_GET['tipo']; ?>
<form id="form1" name="form1" method="post" action="lista_empleados_busqueda.php">
<table width="100%" border="0">
  <tr>
    <td align="center" valign="middle"><span style="color:#FFFFFF">INGRESA ALGUN DATO DEL NOMBRE</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
    <p></p>
    <input name="dato_usuario" type="text" id="dato_usuario" maxlength="10"
    onchange="javascript:this.value=this.value.toUpperCase();" />
    <p>
      <input name="tipo_dato" type="hidden" id="tipo_dato" value="<?php echo "$tipo"; ?>" />
      <input type="submit" name="button" id="button" value="BUSCAR" />
    </p>    </td>
  </tr>
</table>
</form>
</body>
</html>
