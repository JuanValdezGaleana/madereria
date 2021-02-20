<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];


$opc=$_POST['opc'];

switch($opc){
	case 'presentacion':
		 $pres=$_POST['pres'];
	     $ins_pres=mysql_query("
		 INSERT INTO cat_tipo_pres_prod VALUES('','$pres',$id_establecimiento);
		 ")
		 or die("No se pudo guardar el tipo de presentación en la lista.<br/>".mysql_error());
	break;
	case 'medida':
		 $med=$_POST['med'];
		 $acronimo=$_POST['acronimo'];
	     $ins_med=mysql_query("
		 INSERT INTO cat_unidad_medida VALUES('','$med','$acronimo',$id_establecimiento);
		 ")
		 or die("No se pudo guardar el tipo de medida en la lista.<br/>".mysql_error());
	break;
	
	case 'producto':
	     $prod=$_POST['prod'];
	     $ins_prod=mysql_query("
		 INSERT INTO cat_tipos_producto VALUES('','$prod',$id_establecimiento);
		 ")
		 or die("No se pudo guardar el tipo de producto en la lista.<br/>".mysql_error());
	break;
	} ?>
	
<script type="text/javascript">
alert('Se ha guardado en la lista');
location.href='alta_productos.php';
</script>
    
<?php	
exit();
?>
