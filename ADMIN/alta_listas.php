<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Alta de lista</title>
<style type="text/css">
body{
	font-family:Arial;
	}
.contenedor{
max-height:500px;
	overflow:auto;}
table{
	border-collapse:collapse;
}
table td{
	padding:2px;
	}
.titulo_tabla{
	
	background:#009513;
	color:#FFF;}
.eliminar{
	color:#A80004;}
.eliminar:hover{
	color:#FF2025;}
.linea_link{
	text-decoration:none;}
.letras_chicas{
	font-size:0.8em;}
.hover_lista:hover{
text-shadow:#000000;
background-color:#DAFFD9;
}
</style>
</head>

<body>
<div class="contenedor">
<?php
$lista=base64_decode($_GET['lista']);


switch($lista){
	
	case 'presentacion': ?>
<form id="form1" name="form1" method="post" action="insert_lista.php">
        <table width="100%" border="1">
        <?php 
		$contagranel=mysql_query("
		SELECT
		COUNT(ID_TIPO_PRES_PROD)
		FROM cat_tipo_pres_prod
		WHERE TIPO_PRES_PROD='A GRANEL'
		AND ID_ESTABLECIMIENTO=$id_establecimiento;
		")
		or die("No se pudo hacer el conteo de registros a granel.<br/>".mysql_error());
		$dcontagranel=mysql_fetch_array($contagranel);
		$numagranel=$dcontagranel['COUNT(ID_TIPO_PRES_PROD)'];
		if($numagranel==0){
		 ?>
          <tr>
            <td colspan="3" align="center">AGREGAR 'A GRANEL' 
            <a href="ins_agranel.php">
            <img src="../imagenes/agregar.png" width="17" height="18" alt="+" />
            </a>
            </td>
          </tr>
        <?php } ?>  
          <tr>
            <td align="right">Tipo de presentación:</td>
            <td align="center">
              <label for="textfield">
              <input autofocus="autofocus" type="text" name="pres" id="pres" onchange="javascript:this.value=this.value.toUpperCase();" />
              </label>
            </td>
            <td align="center">
            <input type="submit" name="agregar" id="agregar" value="Agregar" />
            <input name="opc" type="hidden" value="presentacion" />
            </td>
          </tr>
        </table>
  <p></p>
  

        <table width="100%" border="1" class="letras_chicas">
  <tr class="titulo_tabla">
    <td width="97%">LISTA DE PRESENTACIONES</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php 
  $lista_pres=mysql_query("
  SELECT
  ID_TIPO_PRES_PROD,
  TIPO_PRES_PROD
  FROM cat_tipo_pres_prod
  WHERE ID_ESTABLECIMIENTO=$id_establecimiento;
  ")
  or die("No se pudo consultar la lista de los tipos de presentaciones.<br/>".mysql_error());
  while($dat_li_pres=mysql_fetch_array($lista_pres)){
   ?>
  <tr class="hover_lista">
    <td><?php echo $dat_li_pres['TIPO_PRES_PROD']; ?></td>
    <td align="center" valign="middle">
    <a class="linea_link" title="Eliminar" href="conf_eliminar_lista.php?opc=<?php echo base64_encode('presentacion'); ?>&i=<?php echo base64_encode($dat_li_pres['ID_TIPO_PRES_PROD']); ?>">
    <div class="eliminar">X</div>
    </a>
    </td>
  </tr>
  <?php } ?>
</table>
</form>
    
<?php break;
	
	case 'medida':  ?>
	<form id="form2" name="form2" method="post" action="insert_lista.php">
        <table width="100%" border="1">
          <tr>
            <td align="right">Tipo de medida:</td>
            <td align="center">
              <label for="textfield">
              <input autofocus="autofocus" type="text" name="med" id="med" onchange="javascript:this.value=this.value.toUpperCase();"/>
              </label>
            </td>
            <td align="right">Acronimo:</td>
            <td align="center"><label for="acronimo"></label>
            <input type="text" name="acronimo" id="acronimo" onchange="javascript:this.value=this.value.toUpperCase();"/></td>
            <td align="center">
            <input type="submit" name="agregar" id="agregar" value="Agregar" />
            <input name="opc" type="hidden" value="medida" />
            </td>
          </tr>
        </table>
      <p></p>
        <table width="100%" border="1" class="letras_chicas">
  <tr class="titulo_tabla">
    <td width="68%">LISTA DE UNIDADES DE MEDIDAS</td>
    <td width="29%">ACRÓNIMO</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php 
  $lista_med=mysql_query("
  SELECT
  ID_UNIDAD_MEDIDA,
  UNIDAD_MEDIDA,
  ACRONIMO
  FROM cat_unidad_medida
  WHERE ID_ESTABLECIMIENTO=$id_establecimiento;
  ")
  or die("No se pudo consultar la lista de los tipos de unidades de medida.<br/>".mysql_error());
  while($dat_li_med=mysql_fetch_array($lista_med)){
   ?>
  <tr class="hover_lista">
    <td><?php echo $dat_li_med['UNIDAD_MEDIDA']; ?></td>
    <td><?php echo $dat_li_med['ACRONIMO']; ?></td>
    <td align="center" valign="middle">
    <a class="linea_link" title="Eliminar" href="conf_eliminar_lista.php?opc=<?php echo base64_encode('medida'); ?>&i=<?php echo base64_encode($dat_li_med['ID_UNIDAD_MEDIDA']); ?>">
    <div class="eliminar">X</div>
    </a>
    </td>
  </tr>
  <?php } ?>
</table>
</form>
<?php	break;
	
	case 'producto': ?>
<form id="form3" name="form3" method="post" action="insert_lista.php">
        <table width="100%" border="1">
          <tr>
            <td align="right">Tipo de producto:</td>
            <td align="center">
              <label for="textfield">
              <input autofocus="autofocus" type="text" name="prod" id="prod" onchange="javascript:this.value=this.value.toUpperCase();"/>
              </label>
            </td>
            <td align="center">
            <input type="submit" name="agregar" id="agregar" value="Agregar" />
            <input name="opc" type="hidden" value="producto" />
            </td>
          </tr>
        </table>
  <p></p>
    <table width="100%" border="1" class="letras_chicas">
  <tr class="titulo_tabla">
    <td width="97%">LISTA DE TIPOS DE PRODUCTOS</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php 
  $lista_prod=mysql_query("
  SELECT
  ID_TIPO_PRODUCTO,
  TIPO_PRODUCTO
  FROM cat_tipos_producto
  WHERE ID_ESTABLECIMIENTO=$id_establecimiento;
  ")
  or die("No se pudo consultar la lista de tipos de productos.<br/>".mysql_error());
  while($dat_li_prod=mysql_fetch_array($lista_prod)){
   ?>
  <tr class="hover_lista">
    <td><?php echo $dat_li_prod['TIPO_PRODUCTO']; ?></td>
    <td align="center" valign="middle">
    <a class="linea_link" title="Eliminar" href="conf_eliminar_lista.php?opc=<?php echo base64_encode('producto'); ?>&i=<?php echo base64_encode($dat_li_prod['ID_TIPO_PRODUCTO']); ?>">
    <div class="eliminar">X</div>
    </a>
    </td>
  </tr>
  <?php } ?>
</table>
  </form>
<?php	break;
	
	
	} 

?>


</div>
</body>
</html>