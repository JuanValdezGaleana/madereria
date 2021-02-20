<?php 
require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
//$nombre_archivo = $HTTP_POST_FILES["userfile"]["name"];  
if($nombre_archivo==""){
$nombre_archivo= "SIN_FOTO.jpg"; 
}

$id_localidad=$_POST['LOCALIDADES'];

/*if($id_localidad=='')*/if(1==2){ ?>
	
 <!-- <script language="javascript"> 
alert
('Tienes que selecionar el municipio y la localidad'); 
 history.back(1);
</script>  -->
    
<?php	}else{


$emp_cue="";
$ap_paterno=$_POST['ap_pat'];
$ap_materno=$_POST['ap_mat'];
$nombre=$_POST['nombre'];

$fecha_nac=$_POST['anio_nac'].":".$_POST['mes_nac'].":".$_POST['dia_nac'];


$telefono =$_POST['telefono_1'];
$id_tipo_telefono =$_POST['tipo_tel_1'];

$e_mail=$_POST['e_mail'];
//include("subir_foto.php");

$id_tipo_persona=$_POST['id_t_p'];

$calle=$_POST['calle'];
$numero=$_POST['numero'];


$fecha_in=$_POST['anio_ingreso'].":".$_POST['mes_ingreso'].":".$_POST['dia_ingreso'];



$insertar1=mysql_query("
INSERT INTO persona VALUES(
'',
'$ap_paterno',
'$ap_materno',
'$nombre',
1,
'$telefono',
'$e_mail',
$id_tipo_telefono,
$id_tipo_persona,
'',
'$fecha_nac',
'$fecha_in',
$id_establecimiento
);
"
)or die("¡Error al insertar los datos del empleado! <br>".mysql_error());

//SACA EL ULTIMO IDENTIFICADOR PARA FORMAR LA CLAVE DEL EMPLEADO
$sacar_identificador=mysql_query("
	select last_insert_id();
")or die("¡Error en al consultar el último identificador insertado! <br>".mysql_error());
$identificador_eca=mysql_fetch_array($sacar_identificador);
$numero=$identificador_eca['last_insert_id()'];

  $ap=substr($ap_paterno, 0,2);
  $am=substr($ap_materno, 0,1);
  $no=substr($nombre, 0,1);
  
$cve_entera=$ap.$am.$no.$numero;

$actualiza_cue=mysql_query("
UPDATE PERSONA SET 
CUE='$cve_entera'
WHERE ID_PERSONA=$numero;
")
or die("Error al actualizar los datos del usuario.<br/>".mysql_error());

?>
<script language="javascript"> 
alert
('Se han guardado satisfactoriamente los datos'); 
location.href = "lista_empleados.php";
</script>
<?php
}
?>