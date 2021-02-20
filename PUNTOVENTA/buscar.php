<?php require("../aut_verifica.inc.php");

$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
/* REFRESCA LA PAGINA CADA CIERTOS SEGUNDOS EN ESTE CASO 10 SEGUNDOS
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:10; url=$self"); //Refrescamos cada 300 segundos
*/
$clave_venta=$_GET['clave_venta'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nom_negocio;  ?></title>

<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="css/formulario.css" type="text/css">
<link rel="stylesheet" href="css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="css/ordenlistas.css" type="text/css">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

<!--INICIO ARCHIVOS DEL BUSCADOR-->
<link rel="stylesheet" href="buscador/pagination.css" media="screen">
<link rel="stylesheet" href="buscador/style.css" media="screen">
<script src="buscador/include/buscador.js" type="text/javascript" language="javascript"></script>
<!--FIN ARCHIVOS DEL BUSCADOR-->

<!--INICIO VALIDADOR DE CAMPOS -->

<script type="text/javascript" src="js/lv.js"></script>

<!--FIN VALIDADOR DE CAMPOS-->




<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="../engine1/style.css" />
	<script type="text/javascript" src="../engine1/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->

<link rel="stylesheet" href="buscador/pagination.css" media="screen">
<link rel="stylesheet" href="buscador/style.css" media="screen">
<script src="buscador/include/buscador.js" type="text/javascript" language="javascript"></script>
		
<!--FANCYBOX-->    
      <script>
		!window.jQuery && document.write('<script src="../fancybox/jquery-1.4.3.min.js"><\/script>');
	 </script>
   
    <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />	
	<script type="text/javascript">
		$(document).ready(function() {		
			$("#CLAVE").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
		});
	</script>
<!--FIN FANCYBOX-->

 <script type="text/javascript">      
			function jsselect(){
				document.getElementById('palabras').focus();
				}
        </script>
	
</head>


<body>
<div class="espacio_menu">
<ul id="menu">
         
         <li class="menu_right"><a href="../aut_logout.php" >CERRAR SESIÓN</a></li>
          <li class="menu_right">ALTAS<!-- Begin 3 columns Item -->
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
             <div class="col_1">
                <ul class="greybox">
                     <li><a href="alta_productos.php">ALTA PRODUCTOS</a></li>
                                          
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
        </li><!-- End 3 columns Item -->
         <li class="menu_right"><a href="almacen.php" >ALMACEN</a></li>
        
                <!-- End 3 columns Item -->
	     <li class="menu_right menu_activo"><a href="index.php" >PUNTO DE VENTA</a></li>
 		 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
  </ul>
</div>



<div class="contenedor">

<?php
if($_GET['palabras']==''){
	$txt=$_POST['palabras'];
	}
if($_POST['palabras']==''){
	$txt=$_GET['palabras'];
	}
	

?>
<div style="height:50px; width:100%;  box-shadow:0 0 20px #333333;">
<form  action="buscar.php?clave_venta=<?php echo $clave_venta; ?>" method="post">
<table width="100%" border="0">
  <tr>
    <td width="10%" align="left" valign="middle"><a class="button" href="index.php?cv=<?php echo $clave_venta; ?>">REGRESAR</a></td>
    <td width="90%" align="center" valign="middle"><label style="font-size:20px">PRODUCTO:</label>
      <input style="width:50%; font-size:18px;" id="palabras" name="palabras" type="text" onchange="javascript:this.value=this.value.toUpperCase();" autofocus  />
      <input style="height:40px; width:80px;" name="input" type="submit" value="BUSCAR" /></td>
    </tr>
</table>
</form>
</div>

<div style="width:100%; height:calc(100% - 35px); overflow: auto;">



<?php if ($txt!=""){ ?>
<div style="height:20px; background:#D0FFCA; color:#04A800;">
RESULTADOS DE <?php echo "<strong>'".$txt."</strong>'"; ?>
</div>
<?php } 

   if($grupo==""||$orden==""){
	  $grupo="DESCRIPCION";
	  $orden="ASC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }
  
 if($txt!=""){
	 
	 
$espacio =" " ;
$q = $txt;
$q = str_replace($espacio, "(.*)", $q);
 
$con=mysql_query("
SELECT A.* , C.CANTIDAD_ACTUAL
FROM productos A
LEFT OUTER JOIN cat_tipo_pres_prod B
ON A.ID_TIPO_PRES_PROD=B.ID_TIPO_PRES_PROD
INNER JOIN inventario C
ON A.ID_PRODUCTO=C.ID_PRODUCTO	
WHERE DESCRIPCION REGEXP '$q'
AND B.TIPO_PRES_PROD!='A GRANEL'
AND B.TIPO_PRES_PROD!='RECARGA'
ORDER BY $grupo $orden;")
or die("No se pudo hacer la consulta de los resultados.<br/>".mysql_error());


?>
<table width="100%" border="1" class="propTabla">
              <tr class="bgtabla">
                <td>
                <a href="buscar.php?grupo=<?php echo "CVE_PRODUCTO"; ?>&orden=<?php echo "ASC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_up"></div>
                 </a>
                 <a href="buscar.php?grupo=<?php echo "CVE_PRODUCTO"; ?>&orden=<?php echo "DESC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_down"></div>
                 </a> 
                </td>
                <td>&nbsp;</td>
                <td>
                <a href="buscar.php?grupo=<?php echo "DESCRIPCION"; ?>&orden=<?php echo "ASC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_up"></div>
                 </a>
                 <a href="buscar.php?grupo=<?php echo "DESCRIPCION"; ?>&orden=<?php echo "DESC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_down"></div>
                 </a>
                </td>
                <td align="right">
                <a href="buscar.php?grupo=<?php echo "PRECIO_FINAL"; ?>&orden=<?php echo "ASC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_up"></div>
                 </a>
                 <a href="buscar.php?grupo=<?php echo "PRECIO_FINAL"; ?>&orden=<?php echo "DESC"; ?>&clave_venta=<?php echo $clave_venta; ?>&palabras=<?php echo $txt; ?>"> 
                <div class="flecha_down"></div>
                 </a>
                </td>
              </tr>
              <tr class="bgtabla">
                <td width="14%">CLAVE</td>
                <td width="5%">CANT.</td>
                <td width="59%">DESCRIPCIÓN</td>
                <td width="22%" align="right">PRECIO</td>
              </tr>
 <?php 

 
 while($row=mysql_fetch_array($con)){  ?>             
            <tr class="hover_lista_b" style="cursor:pointer;"> 
            <td valign="middle" style="color: #000;"><?php echo $row['CVE_PRODUCTO']; ?></td>
            <td align="center" valign="middle"><?php echo $row['CANTIDAD_ACTUAL']; ?></td>
            
            <td valign="middle"><a class="lista_busq" 
              href="index.php?entra_c=<?php echo $row['CVE_PRODUCTO'] ?>&cv=<?php echo $clave_venta; ?>"><?php echo $row['DESCRIPCION']; ?></a></td>
            
            
            <td align="right" valign="middle"><a class="lista_busq" 
            href="index.php?entra_c=<?php echo $row['CVE_PRODUCTO'] ?>&cv=<?php echo $clave_venta; ?>"><?php echo"$ ". $row['PRECIO_FINAL']; ?></a></td>
          </tr>
 <?php } }?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</div>
<!-- ************************** Inicio de info del establecimiento y usuario que inició sesión ********************** -->

<div class="esp_mod">
<?php if($_SESSION['SESSION_GRUPO']=="SUPER ADMINISTRADOR"){ 
echo' 
	<a href="../ADMINISTRACION/">
		<div class="bot_mod">USUARIOS</div>
	</a>
    	<div class="bot_mod mod_seleccionado">PUNTO DE VENTA</div>
 ';
 } ?>
 
 <div class="info_usu_estab">
 	<?php 
	echo ' || ';
	echo $_SESSION['SESSION_RAZON_SOCIAL'];
	echo ' || ';
	echo $_SESSION['SESSION_AP_PATERNO'].' '.$_SESSION['SESSION_AP_MATERNO'].' '.$_SESSION['SESSION_NOMBRE'];
	echo ' || ';
	?>
 </div>
 </div>
<!-- **************************** Inicio de info del establecimiento y usuario que inició sesión *********************** -->
</div> <!--FIN DEL DIV CONTENEDOR class="contenedor"-->



</body>
</html>
