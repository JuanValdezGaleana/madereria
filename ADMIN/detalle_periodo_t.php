<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");

$idp=$_GET['idp'];
$f1=$_GET['f1'];
$f2=$_GET['f2'];

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
	<a href="corte_periodo.php?f1=<?php echo $f1; ?>&f2=<?php echo $f2; ?>"><img src="../imagenes/back.png"/></a>
</div>
<div class="surtir_logo stretchRight"><img src="../imagenes/registradora.png"/></div>
<div class="surtir_tit2 stretchRight"><strong><?php echo $dtp['TIPO_PRODUCTO']; ?></strong></div>
<div class="espacio_calendario">
<a href="corte_periodo_v.php"><div class="items_surtir slideDown">POR VENTA</div></a>
<a href=""><div class="items_surtir slideDown item_surtir_sel">POR TIPO</div></a>
</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">


<?php

	function fechaesp($date) {
    $dia = explode("-", $date, 3);
    $year = $dia[0];
    $month = (string)(int)$dia[1];
    $day = (string)(int)$dia[2];
    $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles" ,"Jueves","Viernes","S&aacute;bado");
    $tomadia = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
}

echo "DE: $f1 <br/>";
echo "HASTA: $f2 <br/>";

/*

SELECT

D.FECHA,
A.DESCRIPCION,

D.CVE_VENTA,
E.ESTATUS_VENTA,
IF(C.TIPO_PRES_PROD='A GRANEL',(((A.PRECIO_FINAL)/10)*(D.CANTIDAD_VEN/100)),IF(C.TIPO_PRES_PROD='RECARGA',D.CANTIDAD_VEN*A.PRECIO_FINAL,A.PRECIO_FINAL) ) AS PRECIO
FROM productos A
INNER JOIN ventas_salidas B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_tipo_pres_prod C
ON A.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
INNER JOIN ventas_salidas D
ON A.ID_PRODUCTO=D.ID_PRODUCTO
INNER JOIN cat_estatus_venta E
ON D.ID_ESTATUS_VENTA=E.ID_ESTATUS_VENTA
WHERE D.FECHA
BETWEEN '$f1'
AND '$f2'
AND A.ID_TIPO_PRODUCTO=$idp	
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
GROUP BY A.DESCRIPCION
ORDER BY D.CVE_VENTA DESC	
					;
*/

$idPer=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];

$cRepo=mysql_query("
				   SELECT
A.CVE_VENTA,
/*A.CANTIDAD_VEN AS CANT,*/
B.DESCRIPCION,
/*A.CANTIDAD_VEN,*/
A.FECHA,
C.ESTATUS_VENTA,
/*D.TIPO_PRES_PROD,*/
IF(D.TIPO_PRES_PROD='A GRANEL',(A.PRECIO_VENTA),IF(D.TIPO_PRES_PROD='RECARGA',(A.CANTIDAD_VEN)*B.PRECIO_FINAL,(B.PRECIO_FINAL)*A.CANTIDAD_VEN) ) AS PRECIO
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_estatus_venta C
ON A.ID_ESTATUS_VENTA=C.ID_ESTATUS_VENTA
INNER JOIN cat_tipo_pres_prod D
ON B.ID_TIPO_PRES_PROD=D.ID_TIPO_PRES_PROD
WHERE A.FECHA
BETWEEN '$f1'
AND '$f2'
AND B.ID_TIPO_PRODUCTO=$idp	
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.CVE_VENTA DESC
;
 ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
?>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="20%" align="center" valign="middle">FECHA</td>
    <td width="6%" align="center" valign="middle">CANT.</td>
    <td width="41%" align="center" valign="middle">PRODUCTO</td>
    <td width="9%" align="center" valign="middle">PRECIO</td>
    <td width="12%" align="center" valign="middle">CLAVE DE VENTA</td>
    <td width="12%" align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <?php while($rDat=mysql_fetch_array($cRepo)){ ?>
  <?php  
  if($rDat['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0"';}
  if($rDat['ESTATUS_VENTA']=='SIN COBRAR'){$color='style="color:#F00"';}
  ?> 
  <tr class="hover_lista">
    <td><?php $date = $rDat['FECHA'];echo fechaesp($date); ?></td>
    <td align="center" valign="top"><?php echo $rDat['CANT'];  ?></td>
    <td><?php echo $rDat['DESCRIPCION'];  ?></td>
    <td align="right"><?php echo  "$ ",number_format( $rDat['PRECIO'], 2, ".", ",")         ?></td>
    <td align="center">  
    <a <?php if($rDat['ESTATUS_VENTA']=='SIN COBRAR'){ ?>href="detalle_nota.php?cv=<?php  echo  $rDat['CVE_VENTA'];  ?>" <?php } echo $color; ?>> 
    
	<?php  echo  $rDat['CVE_VENTA']; ?>
    
    </a></td>
    <td align="left"><a href="detalle_venta.php?cv=<?php echo $rDat['CVE_VENTA']; ?>&r=5&idp=<?php echo $idp;  ?>&f1=<?php echo $f1; ?>&f2=<?php echo $f2 ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
  </tr>
  
<?php 
$sumaAux=$sumaAux+$rDat['PRECIO'];
} ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="bgtabla"> <?php echo "<strong>SUMA TOTAL <br/> $ ".number_format($sumaAux, 2, ".", ",")."</strong>";             ?>
    </td>
    <td>&nbsp;</td>
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
