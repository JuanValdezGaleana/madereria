<?php

require("aut_verifica.inc.php");


//echo $_SESSION['SESSION_USU_NOMBRE_USSR'] ;

/* if($_SESSION['SESSION_MODULO']=="PUNTO DE VENTA"){
 header("Location: ./PUNTOVENTA");
 }*/
 if($_SESSION['SESSION_MODULO']=="PUNTO DE VENTA"){
 header("Location: ./PUNTOVENTA");
 }
 if($_SESSION['SESSION_MODULO']=="ADMIN"){
 header("Location: ./ADMIN");
 }

?>