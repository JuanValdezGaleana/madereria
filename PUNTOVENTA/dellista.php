<?php  require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

$opc=base64_decode($_GET['opc']);
  $i=base64_decode($_GET['i']);


switch($opc){
	 case 'presentacion' :
	 $del_pres=mysql_query("
	 DELETE FROM cat_tipo_pres_prod WHERE ID_TIPO_PRES_PROD=$i;
	 ")
	 or die("No se pudo eliminar el tipo de presentación.<br/>".mysql_error()); ?>
     <script type="text/javascript">
     alert('Se ha eliminado de la lista');
	 location.href='alta_productos.php';
	 </script>
     <?php
	 break;
	 
	 case 'medida' :
	 $del_med=mysql_query("
	 DELETE FROM cat_unidad_medida WHERE ID_UNIDAD_MEDIDA=$i;
	 ")
	 or die("No se pudo eliminar el tipo de presentación.<br/>".mysql_error()); ?>
     <script type="text/javascript">
     alert('Se ha eliminado de la lista');
	 location.href='alta_productos.php';
	 </script>
     <?php
	 break;
	 
	 case 'producto' :
	 $del_prod=mysql_query("
	 DELETE FROM cat_tipos_producto WHERE ID_TIPO_PRODUCTO=$i;
	 ")
	 or die("No se pudo eliminar el tipo de presentación.<br/>".mysql_error()); ?>
     <script type="text/javascript">
     alert('Se ha eliminado de la lista');
	 location.href='alta_productos.php';
	 </script>
     <?php
	 break;
	
	} 	
exit();



?>