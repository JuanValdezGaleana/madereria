<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
/* REFRESCA LA PAGINA CADA CIERTOS SEGUNDOS EN ESTE CASO 10 SEGUNDOS
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:10; url=$self"); //Refrescamos cada 300 segundos
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $nom_negocio;  ?></title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="css/surtir.css" type="text/css">
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="css/estilo_iconos.css" type="text/css">
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
                     <li><a href="modificar_producto.php">MODIFICAR PRODUCTO</a></li>
                     <li><a href="proveedores.php">ALTA PROVEEDORES</a></li>            
                     <li><a href="clientes.php">ALTA CLIENTES</a></li>                   
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
        </li><!-- End 3 columns Item -->
    <li class="menu_right menu_activo"><a href="almacen.php" >ALMACEN</a></li>
    <li class="menu_right">REPORTES<!-- Begin 3 columns Item -->
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
             <div class="col_1">
                <ul class="greybox">
                	 <li><a href="corte_diario.php">CORTE DIARIO</a></li>
                     <li><a href="corte_periodo.php">CORTE POR PERIODO</a></li>
                     <?php if($_SESSION['SESSION_GRUPO']=='SUPER ADMINISTRADOR'){ ?>
                     <li><a href="corte_periodo_adm.php">CORTE ADMIN.</a></li>  
                     <?php } ?>      
               </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li><!-- End 3 columns Item -->
                <!-- End 3 columns Item -->
    <li class="menu_right"><a href="index.php" >PUNTO DE VENTA</a></li>
 		 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
  </ul>
</div>

<div class="contenedor">

<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/stock.png"/></div>
<div class="surtir_tit stretchRight"><strong>STOCK</strong></div>
<div class="espacio_calendario">
<a href="almacen_proveedor.php"><div class="items_surtir slideDown item_surtir_sel">PROVEEDOR</div></a>
<a href="almacen.php"><div class="items_surtir slideDown">TIPO</div></a>

</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">


<?php

$cRepo=mysql_query("
SELECT
A.ID_ESTABLECIMIENTO,
A.RAZON_SOCIAL,
A.RFC,
CONCAT(A.CALLE,' ',NUMERO) AS DIRECCION_FISCAL,
A.OBSERVACIONES
FROM establecimiento A
INNER JOIN cat_estatus_activo B
ON A.ID_ESTATUS_ACTIVO=B.ID_ESTATUS_ACTIVO
WHERE B.ESTATUS_ACTIVO='ACTIVO'
AND A.ID_MATRIZ=$id_establecimiento
AND A.ID_TIPO_ESTABLECIMIENTO=4;


				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
?>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="21%" align="center" valign="middle">RAZÓN SOCIAL</td>
    <td width="9%" align="center" valign="middle">RFC</td>
    <td width="19%" align="center" valign="middle">DIRECCIÓN FISCAL</td>
    <td width="14%" align="center" valign="middle">OBSERVACIONES</td>
    <td width="10%" align="center" valign="middle">NUM. PRODUCT.</td>
    <td width="17%" align="center" valign="middle">SUMA</td>
    <td width="10%" align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <?php 
  $totalFinalProd=0;
  while($rDat=mysql_fetch_array($cRepo)){ ?>
  
  <tr class="hover_lista">
    <td><?php echo $rDat['RAZON_SOCIAL'];  ?></td>
    <td><?php echo $rDat['RFC'];  ?></td>
    <td align="center"><?php echo $rDat['DIRECCION_FISCAL'];  ?></td>
    <td align="center"><?php echo $rDat['OBSERVACIONES'];  ?></td>
    <td align="center">
    <?php 
	
	  $sumProv0=mysql_query("
					SELECT
					C.ID_TIPO_PRODUCTO,
					C.TIPO_PRODUCTO,
                    COUNT(NOMBRE_PRODUCTO) AS CANT				
FROM productos A
INNER JOIN inventario B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_tipos_producto C
ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
INNER JOIN cat_tipo_pres_prod D
ON A.ID_TIPO_PRES_PROD=D.ID_TIPO_PRES_PROD
WHERE A.ID_ESTABLECIMIENTO=".$id_establecimiento."
AND A.ID_PROVEEDOR=".$rDat['ID_ESTABLECIMIENTO']."
GROUP BY C.TIPO_PRODUCTO;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());


	$totProd=0;
while($dSumProv0=mysql_fetch_array($sumProv0)){
		
	$totProd=$totProd+$dSumProv0['CANT'];
	
	
}/*Fin de while($dSumProv0=mysql_fetch_array($sumProv0))*/
	echo $totProd; 
	 $totalFinalProd=$totalFinalProd+$totProd;
	
	       ?>
    </td>
    <td align="right"><?php 
	
	  $sumProv=mysql_query("
					SELECT
					C.ID_TIPO_PRODUCTO,
					C.TIPO_PRODUCTO,
                    COUNT(NOMBRE_PRODUCTO) AS CANT,
					/*A.NOMBRE_PRODUCTO,*/
					/*A.PRECIO_FINAL,*/
		  		/*B.CANTIDAD_ACTUAL,*/   /* */
          /*D.TIPO_PRES_PROD,*/
          SUM(
           IF(D.TIPO_PRES_PROD='A GRANEL',((B.CANTIDAD_ACTUAL)*(A.PRECIO_FINAL/1000)),
                IF(D.TIPO_PRES_PROD='RECARGA',((B.CANTIDAD_ACTUAL)/(A.PRECIO_FINAL))/5,
                      A.PRECIO_FINAL*B.CANTIDAD_ACTUAL
                   )
                                          )
              )
AS SUMA_TIPO
/*SUM(A.PRECIO_FINAL*CANTIDAD_ACTUAL) AS SUMA_TIPO*/
FROM productos A
INNER JOIN inventario B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_tipos_producto C
ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
INNER JOIN cat_tipo_pres_prod D
ON A.ID_TIPO_PRES_PROD=D.ID_TIPO_PRES_PROD
WHERE A.ID_ESTABLECIMIENTO=".$id_establecimiento."
AND A.ID_PROVEEDOR=".$rDat['ID_ESTABLECIMIENTO']."
GROUP BY C.TIPO_PRODUCTO;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());

	$totSum=0;
	while($dSumProv=mysql_fetch_array($sumProv)){
		
	$totSum=$totSum+$dSumProv['SUMA_TIPO'];
	
	}/*Fin del while($dSumProv=mysql_fetch_array($sumProv))*/
	
	echo number_format($totSum,2); 
	
	       ?>
           
           </td>
    <td>
    <a href="detalle_almacen_proveedor.php?ip=<?php echo $rDat['ID_ESTABLECIMIENTO'];  ?>" style="text-decoration:none; color:#000;">
    <div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a>
    </td>
  </tr>
  
<?php 
	 
      $sumaAux=$sumaAux+$totSum;
} ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center" class="bgtabla"><?php echo "<strong>".$totalFinalProd." PRODUCTOS</strong>";             ?></td>
    <td align="right" class="bgtabla"><?php echo "<strong>SUMA TOTAL $ ".number_format($sumaAux, 2, ".", ",")."</strong>";             ?></td>
    <td>&nbsp;</td>
  </tr>
  
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
