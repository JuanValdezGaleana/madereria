<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

$ins=mysql_query("
INSERT INTO cat_tipo_pres_prod VALUES('','A GRANEL',$id_establecimiento )
")
or die("No se pudo hacer la inserción.<br/>".mysql_error());
if($ins){
?>

<script type="text/javascript">
alert('Se ha agragado "A GRANEL" a la lista de tipo de presentación de productos ');
location.href='alta_productos.php';

</script>

<?php } ?>