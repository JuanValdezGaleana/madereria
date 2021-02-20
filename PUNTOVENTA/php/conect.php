<?php
//include('conect.php');
$servidor='localhost';

/*$usuario="publico2_root";
$pass="1234567";
$bd="publico2_clinica";*/

$usuario="publico2_uvb";
$pass="12**//uvb3";
$bd="publico2_pv_m";

$conexion=new mysqli($servidor,$usuario,$pass,$bd);
$conexion->set_charset('utf8');
if($conexion->connect_errno){
    echo "Error al conectar la base de datos {$conexion->connect_errno}";
}
date_default_timezone_set("America/Mexico_City");

?>