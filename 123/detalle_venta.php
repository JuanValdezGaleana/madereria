<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$cv=$_GET['cv'];

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
<link rel="stylesheet" href="css/ordenlistas.css" type="text/css">
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
         <li class="menu_right"><a href="almacen.php" >ALMACEN</a></li>
    <li class="menu_right menu_activo">REPORTES<!-- Begin 3 columns Item -->
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
<div class="surtir_back">

<?php 
$r=$_GET['r'];
switch($r){
	case 1:
	?>
	<a href="corte_diario_t.php"><img src="../imagenes/back.png"/></a>
    <?php
	break;
	case 2:
	$f1=$_GET['f1'];
	$f2=$_GET['f2'];
	$g=$_GET['g'];
	$o=$_GET['o'];
	?>
	<a href="corte_periodo_v.php?f1=<?php echo $f1; ?>&f2=<?php echo $f2; ?>&grupo=<?php echo $g; ?>&orden=<?php echo $o; ?>"><img src="../imagenes/back.png"/></a>
    <?php
	break;
	case 3:
	$f1=$_GET['f1'];
	$f2=$_GET['f2'];
	$g=$_GET['g'];
	$o=$_GET['o'];
	?>
	<a href="corte_periodo_adm.php?f1=<?php echo $f1; ?>&f2=<?php echo $f2; ?>&grupo=<?php echo $g; ?>&orden=<?php echo $o; ?>"><img src="../imagenes/back.png"/></a>
    <?php
	break;
	
	
	case 4:
	$idp=$_GET['idp'];
	
	?>
	<a href="detalle_diario_t.php?idp=<?php echo $idp; ?>"><img src="../imagenes/back.png"/></a>
    <?php
	break;
	
	case 5:
	$idp=$_GET['idp'];
	$f1=$_GET['f1'];
	$f2=$_GET['f2'];
	
	?>
	<a href="detalle_periodo_t.php?idp=<?php echo $idp; ?>&f1=<?php echo $f1; ?>&f2=<?php echo $f2; ?>"><img src="../imagenes/back.png"/></a>
    <?php
	break;
	
	
	}

?>


</div>
<div class="surtir_tit stretchRight"><strong>DETALLE DE LA VENTA '<?php echo $cv;  ?>'</strong></div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
<?php

$consultaVenta=mysql_query("
	SELECT
	CVE_PRODUCTO,
	/*SUM(B.CANTIDAD_VEN) AS CANT,*/
	B.CANTIDAD_VEN AS CANT,
	A.DESCRIPCION,
/*	SUM(A.PRECIO_FINAL) AS PREC,*/
	B.CVE_VENTA,
  /*A.PRECIO_FINAL,*/
  /*B.CANTIDAD_VEN,*/
(IF(C.TIPO_PRES_PROD='A GRANEL',(B.PRECIO_VENTA),IF(C.TIPO_PRES_PROD='RECARGA',B.CANTIDAD_VEN*A.PRECIO_FINAL,(B.CANTIDAD_VEN*A.PRECIO_FINAL)) ) )AS PREC,
D.ESTATUS_VENTA
  /*C.TIPO_PRES_PROD*/
	FROM productos A
	INNER JOIN ventas_salidas B
	ON A.ID_PRODUCTO=B.ID_PRODUCTO
  INNER JOIN cat_tipo_pres_prod C
  ON A.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
  INNER JOIN cat_estatus_venta D
  ON B.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
	WHERE B.CVE_VENTA='$cv'
	/*GROUP BY A.DESCRIPCION ASC*/;
	")
or die("Error al consultar las ventas del día. <br/>".mysql_error());
?>


<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="3%" align="center" valign="middle">&nbsp;</td>
    <td width="12%" align="center" valign="middle">CLAVE</td>
    <td width="6%" align="center" valign="middle">CANT.</td>
    <td width="53%" align="center" valign="middle">DESCRIPCIÓN</td>
    <td width="14%" align="center" valign="middle">IMPORTE</td>
    <td width="11%" align="center" valign="middle">&nbsp;</td>
    </tr>

<?php
  $VentaSuma=0;
  $auxnumR=0;
while($dVenta=mysql_fetch_array($consultaVenta)) { $auxnumR++; 
if($dVenta['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0;"';}
if($dVenta['ESTATUS_VENTA']=='SIN COBRAR'){$color='style="color:#F00;"';}
?>

  <tr class="hover_lista">
    <td align="center"><?php echo $auxnumR; ?></td>
    <td align="center"><?php echo $dVenta['CVE_PRODUCTO']; ?></td>
    <td align="center"><?php echo $dVenta['CANT']; ?></td>
    <td align="left"><?php echo $dVenta['DESCRIPCION']; ?></td>
    <td align="right"><?php echo "$  ".number_format($dVenta['PREC'],2); ?></td>

    
    
    <td align="center"><a title="Cobrar" <?php if($dVenta['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dVenta['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>><?php echo $dVenta['ESTATUS_VENTA']; ?></a></td>
    
    <?php 
$VentaSuma=$VentaSuma+$dVenta['PREC'];
} ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="bgtabla"><?php echo "<strong>TOTAL $  ".number_format($VentaSuma,2)."</strong>"; ?></td>
    <td align="right" >&nbsp;</td>
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
