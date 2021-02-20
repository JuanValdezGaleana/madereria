<?php

require("../aut_verifica.inc.php"); 
$hp=$_GET['hp'];
$p=$_GET['p'];
$borrar=mysql_query("
					DELETE FROM asoc_horarios_persona WHERE ID_ASOC_HOR_PERS=$hp;
					")
or die("Error al borrar el registro. <br/>".mysql_error());

header("Location: asignar_horario.php?id_persona=$p");

?>