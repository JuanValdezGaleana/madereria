<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$idPer=$_SESSION['SESSION_ID_PERSONA'];
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
<!--CALENDARIO-->
<link href="calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET">
<script type="text/javascript" src="calendario_dw/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$(".campofecha").calendarioDW();
	})
	</script>
<!-- FIN CALENDARIO--> 	
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
         <li class="menu_right"><a href="almacen.php" >ALMACEN</a></li>
    <li class="menu_right menu_activo">REPORTES<!-- Begin 3 columns Item -->
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
             <div class="col_1">
                <ul class="greybox">
                	 <li><a href="corte_diario.php">CORTE DIARIO</a></li>
                     <li><a href="index.php">CORTE POR PERIODO</a></li>
                     
                     <li><a href="corte_periodo_adm.php">CORTE ADMIN.</a></li>  
                            
               </ul>   
            </div>
        </div><!-- End 3 columns container -->
        </li><!-- End 3 columns Item -->
                <!-- End 3 columns Item -->
       
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
<div class="surtir_logo stretchRight"><img src="../imagenes/registradora.png"/></div>
<div class="surtir_tit stretchRight"><strong>CORTE DIARIO</strong></div>
<div class="espacio_calendario">
<a href="corte_diario_t.php"><div class="items_surtir slideDown">POR VENTA</div></a>
<a href=""><div class="items_surtir slideDown item_surtir_sel">POR TIPO</div></a>
</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">


<?php

$cRepo=mysql_query("
SELECT
C.ID_TIPO_PRODUCTO,				
C.TIPO_PRODUCTO,
/*A.DESCRIPCION,*/
/*D.FECHA,*/
/*A.PRECIO_FINAL,*/
/*D.CANTIDAD_VEN,*/
/*SUM(D.CANTIDAD_VEN) AS PRODS_VENDIDOS,*/
/*SUM(A.PRECIO_FINAL) AS SUMA_TIPO*/
/*B.TIPO_PRES_PROD,*/
D.CANTIDAD_VEN,
SUM(IF(B.TIPO_PRES_PROD='A GRANEL',(D.PRECIO_VENTA),IF(B.TIPO_PRES_PROD='RECARGA',D.CANTIDAD_VEN*A.PRECIO_FINAL,(A.PRECIO_FINAL*D.CANTIDAD_VEN)) ) )AS SUMA_TIPO
FROM productos A
INNER JOIN cat_tipos_producto C
ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
INNER JOIN ventas_salidas D
ON D.ID_PRODUCTO=A.ID_PRODUCTO
INNER JOIN cat_tipo_pres_prod B
ON A.ID_TIPO_PRES_PROD=B.ID_TIPO_PRES_PROD
WHERE DATE_FORMAT(D.FECHA,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
AND D.ID_PERSONA=$idPer
GROUP BY C.TIPO_PRODUCTO
					
					;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
?>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="18%" align="center" valign="middle">&nbsp;</td>
    <td width="31%" align="center" valign="middle">TIPO DE PRODUCTO</td>
    <td width="26%" align="center" valign="middle">SUMA UNITARIA</td>
    <td width="25%" align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <?php while($rDat=mysql_fetch_array($cRepo)){ ?>
  
  <tr class="hover_lista">
    <td>&nbsp;</td>
    <td><?php echo $rDat['TIPO_PRODUCTO'];  ?></td>
    <td align="right"><?php echo   "$ ".number_format($rDat['SUMA_TIPO'], 2, ".", ",");       ?></td>
    <td align="left"><a href="detalle_diario_t.php?idp=<?php echo $rDat['ID_TIPO_PRODUCTO']; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
  </tr>
  
<?php 
      $sumaAux=$sumaAux+$rDat['SUMA_TIPO'];
} ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
