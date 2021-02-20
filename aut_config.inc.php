<?
// Nombre de la session (puede dejar este mismo)
$usuarios_sesion="puntoDeVenta";

// Datos conexi�n a la Base de datos (MySql)
$sql_host="";  // Host, nombre del servidor o IP del servidor Mysql.
$sql_usuario="publico2_uvb";        // Usuario de Mysql
$sql_pass="12**//uvb3";           // contrase�a de Mysql
$sql_db="publico2_pv_m";     // Base de datos que se usar�.

//$sql_tabla="usuarios"; // Nombre de la tabla que contendr� los datos de los usuarios

$enlace= mysql_connect($sql_host, $sql_usuario, $sql_pass) or die("No se pudo conectar a la Base de datos.".mysql_error());
mysql_select_db($sql_db,$enlace) or die(mysql_error());
mysql_query('SET NAMES \'utf8\''); //hace que aparezcan bien las � y los acentos


?>
