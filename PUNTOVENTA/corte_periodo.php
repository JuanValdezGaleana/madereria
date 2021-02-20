<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$idPer=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];


/* REFRESCA LA PAGINA CADA CIERTOS SEGUNDOS EN ESTE CASO 10 SEGUNDOS
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:10; url=$self"); //Refrescamos cada 300 segundos
*/


if($_GET['f1']=='' && $_GET['f2']==''){
$fInicioAx=$_POST['fecha_inicio']."00:00:00";
$fFinAx=$_POST['fecha_fin']." 23:59:59";
}
if($_GET['f1']!='' && $_GET['f2']!=''){
	$fInicioAx=$_GET['f1'];
	$fFinAx=$_GET['f2'];
	
}



$fInicio = date("Y-m-d H:i:s", strtotime($fInicioAx));
$fFin = date("Y-m-d H:i:s", strtotime($fFinAx));




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div class="surtir_logo stretchRight"><img src="../imagenes/registradora.png"/></div>
<div class="surtir_tit stretchRight"><strong>CORTE POR PERIODO DE FECHAS</strong></div>
<div class="espacio_calendario">
<a href="corte_periodo_v.php"><div class="items_surtir slideDown">POR VENTA</div></a>
<a href=""><div class="items_surtir slideDown item_surtir_sel">POR TIPO</div></a>
<a target="_blank" href="reporte_ventas.php?fInicio=<?php echo $fInicio; ?>&fFin=<?php echo $fFin; ?>">
<div class="items_surtir slideDown ">
REPORTE</div></a>
</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">

<?php

echo "DE: $fInicio<br/>";
echo "HASTA: $fFin</br>";
?>
<form name="form" action="corte_periodo.php" method="post">
<table width="100%" height="48px" border="0">
  <tr>
    <td width="12%" align="right" valign="middle">DE:</td>
    <td width="28%" valign="middle">
    <input type="text" name="fecha_inicio"  class="campofecha" size="12" id="fecha_inicio">
    </td>
    <td width="8%" align="right" valign="middle">HASTA:</td>
    <td width="27%" valign="middle">
    <input type="text" name="fecha_fin" class="campofecha" size="12" id="fecha_fin">
    </td>
    <td width="25%" valign="middle"><label>
      <input type="submit" name="button" id="button" value="BUSCAR" />
    </label></td>
  </tr>
</table>

</form>
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
					SUM(IF(B.TIPO_PRES_PROD='A GRANEL',(D.PRECIO_VENTA),IF(B.TIPO_PRES_PROD='RECARGA',D.CANTIDAD_VEN*A.PRECIO_FINAL,D.PRECIO_VENTA) ) )AS SUMA_TIPO
					FROM productos A
					INNER JOIN cat_tipos_producto C
					ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
					INNER JOIN ventas_salidas D
					ON D.ID_PRODUCTO=A.ID_PRODUCTO
					INNER JOIN cat_tipo_pres_prod B
					ON A.ID_TIPO_PRES_PROD=B.ID_TIPO_PRES_PROD
					WHERE D.FECHA
					BETWEEN  '$fInicio'
					AND  '$fFin'
					AND A.ID_ESTABLECIMIENTO = $id_establecimiento
					GROUP BY C.TIPO_PRODUCTO
					;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
?>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="18%" align="center" valign="middle">&nbsp;</td>
    <td width="31%" align="center" valign="middle">PRODUCTO</td>
    <td width="26%" align="center" valign="middle">SUMA UNITARIA</td>
    <td width="25%" align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <?php while($rDat=mysql_fetch_array($cRepo)){ ?>
  
  <tr class="hover_lista">
    <td>&nbsp;</td>
    <td><?php echo $rDat['TIPO_PRODUCTO'];  ?></td>
    <td align="right"><?php echo   "$ ".number_format($rDat['SUMA_TIPO'], 2, ".", ",");       ?></td>
    <td>
    <a href="detalle_periodo_t.php?idp=<?php echo $rDat['ID_TIPO_PRODUCTO']; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a>  
    
    </td>
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
<?php 
if($fInicio!='0000-00-00 00:00:00'){ ?>
<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td align="center">SALIDAS DE PRODUCTOS</td>
  </tr>
  
    <?php
    $cont_num=mysql_query("
	SELECT
	DISTINCT(NUM_SALIDA) AS NUM_DIF
	FROM salidas_producto
	WHERE FECHA
	BETWEEN '".$fInicio."'
	AND '".$fFin."';
	")
	or die("No se pudieron consultar los numeros de salidas.<br />".mysql_error());
	
	while($d_cont_num=mysql_fetch_array($cont_num)){
	$num_salida=$d_cont_num['NUM_DIF'];	
	
	?>
  <tr>
   <?php
   $dats=mysql_query("
   SELECT
	DATE_FORMAT(FECHA,'%d-%m-%Y') as FECH,
	A.OBSERVACION,
	CONCAT(B.NOMBRE,' ',B.AP_PATERNO,' ',B.AP_MATERNO) AS NOM
	FROM salidas_producto A
	INNER JOIN persona B
	ON A.ID_PERSONA=B.ID_PERSONA
	WHERE NUM_SALIDA=".$d_cont_num['NUM_DIF']."
	LIMIT 1;
   ")
   or die("No se pudieron consultar los datos.<br />".mysql_error());
   $d_dats=mysql_fetch_array($dats);
   ?>
   <td>FECHA: <?php echo $d_dats['FECH']; ?></td>
  </tr>
  <tr>
    <td>NOTA: <?php echo $d_dats['OBSERVACION']; ?></td>
  </tr>
  <tr>
    <td>AUTORIZÓ: <?php echo $d_dats['NOM']; ?></td>
  </tr>
  <tr>
    <td>PRODUCTOS</td>
  </tr>
  
  <?php 
  $q_prod=mysql_query("
  SELECT
	B.DESCRIPCION
	FROM salidas_producto A
	INNER JOIN productos B
	ON A.ID_PRODUCTO=B.ID_PRODUCTO
	WHERE NUM_SALIDA=".$d_cont_num['NUM_DIF'].";
  ")
  or die("No se pudieron obtener los productos de salidas sobre fechas.<>br /".mysql_error());
  while($d_prod=mysql_fetch_array($q_prod)){
   ?>
   <tr>
    <td><?php echo $d_prod['DESCRIPCION'] ?></td>
   </tr>
   
  <?php } ?>
 <tr>
     <td align="center"><a target="_blank" href="imp_salida.php?n=<?php echo base64_encode($num_salida); ?>">Imprimir</a></td>
   </tr>
  <tr>
    <td style="background:#A0FA9C;">&nbsp;</td>
  </tr>
  <?php }  ?>
</table>
<?php }  ?>

<p>&nbsp;</p>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td colspan="3" align="center">PRODUCTOS INGRESADOS</td>
    </tr>
  <tr class="bgtabla">
    <td>FECHA</td>
    <td>PRODUCTO</td>
    <td>CANTIDAD</td>
  </tr>
  <?php 
    /*consultamos los diferentes usuarios que han ingresado material en el rango de fechas*/
  $q_usuarios=mysql_query("
  SELECT
DISTINCT(A.ID_PERSONA),
CONCAT(B.NOMBRE,' ',B.AP_PATERNO,' ',B.AP_MATERNO) AS NOMBRE
FROM registro_cant_producto A
INNER JOIN persona B
ON A.ID_PERSONA=B.ID_PERSONA
WHERE A.FECHA_ALTA
BETWEEN '".$fInicio."'
AND '".$fFin."'
;
  ")
  or die("No se pudo hacel la consulta de los usuarios.<br />".mysql_error());
while($d_susarios=mysql_fetch_array($q_usuarios)){

$nombre=$d_susarios['NOMBRE'];
  
   ?>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Productos ingresados por <?php echo $nombre;  ?></td>
    </tr>
  <?php 

  $cons_inser=mysql_query("
SELECT
A.FECHA_ALTA,
B.DESCRIPCION,
A.CANTIDAD_ALTA,
CONCAT(C.NOMBRE,' ',C.AP_PATERNO,' ',C.AP_MATERNO) AS NOMBRE
FROM registro_cant_producto A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
WHERE A.ID_PERSONA=".$d_susarios['ID_PERSONA']."
AND A.FECHA_ALTA
BETWEEN '".$fInicio."'
AND '".$fFin."';
  ")
  or die("No se pudo hace la consulta de producto agregados.<br />".mysql_error());
  while($dat_ins=mysql_fetch_array($cons_inser)){
   ?>
  
  <tr>
    <td><?php echo $dat_ins['FECHA_ALTA']; ?></td>
    <td><?php echo $dat_ins['DESCRIPCION']; ?></td>
    <td><?php echo $dat_ins['CANTIDAD_ALTA']; ?></td>
  </tr>
  
  <?php }
  
  }
   ?>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
    <a href="reporte_ingresos.php?fInicio=<?php echo $fInicio; ?>&fFin=<?php echo $fFin; ?>" target="_blank">
    Imprimir
    </a>
    </td>
  </tr>
  <tr style="background:#A0FA9C;">
    <td colspan="3">&nbsp;</td>
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
