<?
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");                                   		// HTTP/1.0
require ("aut_config.inc.php");

$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script.
if ($_SERVER['HTTP_REFERER'] == ""){
//die (header("Location:../index.php"));

?>
<script language="javascript"> 
alert
('¡No puedes entrar al sistema si no te has logeado!'); 
location.href = "/clinica";
</script>
<?php 

exit;
}


// Chequeamos si se está autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {

// Conexión base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die(header ("Location:  $redir?error_login=0"));
mysql_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.


/*DATOS DEL USUARIO PARA MOSTRARLOS DURANTE LA SESIÓN*/
$usuario_consulta = mysql_query("
SELECT
A.RAZON_SOCIAL,
A.ID_ESTABLECIMIENTO,
A.RAZON_SOCIAL,
B.ID_PERSONA,
B.AP_PATERNO,
B.AP_MATERNO,
B.NOMBRE,
C.NOMBRE_USSER,
C.PASS,
D.GRUPO,
F.MODULO
FROM establecimiento A
INNER JOIN persona B
ON A.ID_ESTABLECIMIENTO=B.ID_ESTABLECIMIENTO
INNER JOIN usuarios C
ON B.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_grupos D
ON C.ID_GRUPO=D.ID_GRUPO
INNER JOIN asoc_usuarios_modulos E
ON E.ID_PERSONA= B.ID_PERSONA
INNER JOIN cat_modulos F
ON F.ID_MODULO=E.ID_MODULO
WHERE C.NOMBRE_USSER='".$_POST['user']."'
AND B.ID_ESTATUS_ACTIVO=1
AND C.ID_ESTATUS_ACTIVO=1;
")

 or die(header ("Location:  $redir?error_login=1"));

 // miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysql_num_rows($usuario_consulta) != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    $password = md5($_POST['pass']);

    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$usuario_datos = mysql_fetch_array($usuario_consulta);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.
    mysql_close($db_conexion);
    
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // página de error.
    if ($login != $usuario_datos['NOMBRE_USSER']) {
       	Header ("Location: $redir?error_login=4");
		exit;}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la página de error
    if ($password != $usuario_datos['PASS']) {
        Header ("Location: $redir?error_login=3");
	    exit;}

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset ($password);

    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.
    
     // le damos un mobre a la sesion.
    session_name($usuarios_sesion);
     // incia sessiones
    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta página.
    session_cache_limiter('nocache,private');
    
    // Asignamos variables de sesión con datos del Usuario para el uso en el
    // resto de páginas autentificadas.

    // definimos las variables de sesión con los valores de la consulta
	$_SESSION['SESSION_ID_ESTABLECIMIENTO']=$usuario_datos['ID_ESTABLECIMIENTO'];
	$_SESSION['SESSION_RAZON_SOCIAL']=$usuario_datos['RAZON_SOCIAL'];
	$_SESSION['SESSION_ID_PERSONA']=$usuario_datos['ID_PERSONA'];
    $_SESSION['SESSION_NOMBRE_USSER']=$usuario_datos['NOMBRE_USSER'];
    $_SESSION['SESSION_PASS']=$usuario_datos['PASS'];//definimos usuario_password con el password del usuario de la sesión actual (formato md5 encriptado)
	$_SESSION['SESSION_AP_PATERNO']=$usuario_datos['AP_PATERNO'];
	$_SESSION['SESSION_AP_MATERNO']=$usuario_datos['AP_MATERNO'];
	$_SESSION['SESSION_NOMBRE']=$usuario_datos['NOMBRE'];
	$_SESSION['SESSION_GRUPO']=$usuario_datos['GRUPO']; 
	$_SESSION['SESSION_MODULO']=$usuario_datos['MODULO'];
	$_SESSION['SESSION_RAZON_SOCIAL']=$usuario_datos['RAZON_SOCIAL'];   


    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;
    
   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
      exit;}
} else {

// -------- Chequear sesión existe -------

// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.

if (!isset($_SESSION['SESSION_NOMBRE_USSER']) && !isset($_SESSION['SESSION_PASS'])){
// Borramos la sesion creada por el inicio de session anterior
session_destroy();
die (header("Location: /index.php"));
exit;
}
}
?>
