<?php 
require("../aut_verifica.inc.php"); 

$id_persona=$_POST['id_persona'];
$id_establecimiento=$_POST['ID_ESTABLECIMIENTO'];

$dia_entrada=$_POST['dia_entrada'];
$h_entrada=$_POST['h_entrada'];
$m_entrada=$_POST['m_entrada'];
$ampmEntrada=$_POST['ampmEntrada'];
$dia_salida=$_POST['dia_salida'];
$h_salida=$_POST['h_salida'];
$m_salida=$_POST['m_salida'];
$ampmSalida=$_POST['ampmSalida'];


		
	$hora_entrada=$h_entrada.':'.$m_entrada.':00'.$ampmEntrada;	
	$cadena1 = strtotime($hora_entrada);
	$hora_entrada=date("H:i:s",$cadena1);
			
    $hora_salida=$h_salida.':'.$m_salida.':00'.$ampmSalida;
	$cadena2 = strtotime($hora_salida);
	$hora_salida=date("H:i:s",$cadena2);


$insertar=mysql_query("INSERT INTO asoc_horarios_persona
					  VALUES('',$id_establecimiento,$id_persona,'$dia_entrada','$hora_entrada','$dia_salida','$hora_salida')
					  ;")
or die("No se pudo hacer la insecón del horario. <br/>".mysql_error());

header("Location: asignar_horario.php?id_persona=$id_persona");


?>