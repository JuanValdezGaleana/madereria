<?php require("../aut_verifica.inc.php");


$idPer=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=1;

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
    <li class="menu_right"><a href="inventario.html" >INVENTARIO</a></li>
    <li class="menu_right">ALTAS<!-- Begin 3 columns Item -->
     <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
       <div class="col_1">
           <ul class="greybox">
               <li><a href="alta_productos.php">ALTA PRODUCTOS</a></li>
               <li><a href="alta_factura.html">ALTA FACTURAS</a></li>
               <li><a href="facturasCargadas.html">FACTURAS CARGADAS</a></li>
                                   
           </ul>   
       </div>
   </div><!-- End 3 columns container -->
 </li><!-- End 3 columns Item -->
    <li class="menu_right"><a href="almacen.php" >ALMACEN</a></li>
    <li class="menu_right menu_activo"><a href="corte_diario_t.php" >CORTE DIARIO</a></li>
    
   
           <!-- End 3 columns Item -->
  <li class="menu_right "><a href="index.php" >PUNTO DE VENTA</a></li>
 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
</ul>
</div>


<div class="contenedor">


<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/registradora.png"/></div>
<div class="surtir_tit stretchRight"><strong>CORTE POR PERIODO DE FECHAS</strong></div>
<div class="espacio_calendario">
<form name="form" action="corte_diario_t.php" method="post">
<table width="100%" height="48px" border="0">
  <tr>
    <td width="12%" align="right" valign="middle">DE:</td>
    <td width="28%" valign="middle">
    <input type="date" name="fecha_inicio"  class="campofecha" size="12" id="fecha_inicio">
    </td>
    <td width="8%" align="right" valign="middle">HASTA:</td>
    <td width="27%" valign="middle">
    <input type="date" name="fecha_fin" class="campofecha" size="12" id="fecha_fin">
    </td>
    <td width="25%" valign="middle"><label>
      <input type="submit" name="button" id="button" value="BUSCAR" />
    </label></td>
  </tr>
</table>

</form>
</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
<?php



  ?>

<table width="100%" border="0">
  <tr>
    <td width="79%"> <?php
    echo "DE: $fInicio<br/>";
	echo "HASTA: $fFin</br>";
?>  </td>
    <td width="21%">
    
   
    </td>
  </tr>
</table>

<?php

if($grupo==""||$orden==""){
  $grupo="FECHA";
  $orden="DESC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }

$consultaTicket=mysql_query("
SELECT
A.CVE_VENTA,
A.FECHA,
SUM( A.CANTIDAD_VEN ) AS PROD_VENDIDOS,
SUM( A.PRECIO_VENTA ) AS TOT,
C.NOMBRE,
C.AP_PATERNO,
C.AP_MATERNO,
D.ESTATUS_VENTA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO = B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON D.ID_ESTATUS_VENTA=A.ID_ESTATUS_VENTA
WHERE A.FECHA
BETWEEN  '$fInicio'
AND  '$fFin'
AND A.ID_ESTATUS_VENTA=1
AND A.ID_ENVIADO=0
GROUP BY A.CVE_VENTA
ORDER BY $grupo $orden;

	")
or die("Error al consultar las ventas del día. <br/>".mysql_error());
?>

<!-- TABLA DE VENTAS NORMALES  -->
<table width="100%" border="0">
  <tr>
    <td width="100%">
    <div style="width: 100%; float: left;"></div>
    <form target="_blank" action="reporte_ventas.php" method="post" style="float: right;">
    <!--<form target="_blank" action="reporte_ventas_pdf.php" method="post">-->
    <input name="fInicio" type="hidden" value="<?php echo $fInicio; ?>" />
    <input name="fFin" type="hidden" value="<?php echo $fFin; ?>" />
    <input name="enviar" type="submit" value="Reporte de ventas normales" class="boton_verde" />
    <input type="hidden" name="tipoVenta" value="1">
    </form>

    <form action="./php/enviarCorte.php" method="POST" style="float: right;">
        <input name="fInicio" type="hidden" value="<?php echo $fInicio; ?>" />
        <input name="fFin" type="hidden" value="<?php echo $fFin; ?>" />
        <input type="hidden" name="tipoVenta" value="1">
        <input name="enviar" type="submit" value="Enviar corte" class="boton_verde" />
    </form>

    </td>
  </tr>
</table>
<table width="100%" border="1" class="propTabla">
<tr class="bgtabla">
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">
     <a href="corte_periodo_adm.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"></div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo_adm.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo_adm.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo_adm.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo_adm.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> </td>
    <td align="center" valign="middle">
    <a href="corte_periodo_adm.php?grupo=<?php echo "NOMBRE"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo_adm.php?grupo=<?php echo "NOMBRE"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr class="bgtabla">
    <td width="2%" align="center" valign="middle">&nbsp;</td>
    <td width="17%" align="center" valign="middle">CLAVE DE LA VENTA</td>
    <td width="18%" align="center" valign="middle">FECHA Y HORA</td>
    <td width="20%" align="center" valign="middle">NO. DE PRODUCTOS VENDIDOS</td>
    <td width="16%" align="center" valign="middle">TOTAL DE LA VENTA</td>
    <td width="16%" align="center" valign="middle">ESTATUS VENTA</td>
    <td width="14%" align="center" valign="middle">VENDIÓ</td>
    <td width="13%" align="center" valign="middle">&nbsp;</td>
    <td width="13%" align="center" valign="middle">&nbsp;</td>
    <td width="13%" align="center" valign="middle">&nbsp;</td>
  </tr>


<?php
  $VentaSuma=0;
  $auxnumR=0;
while($dTicket=mysql_fetch_array($consultaTicket)) { $auxnumR++; 
if($dTicket['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0"';}
if($dTicket['ESTATUS_VENTA']=='SIN COBRAR' || $dTicket['ESTATUS_VENTA']=='DEVOLUCION'){$color='style="color:#F00"';}?>

  <tr class="hover_lista">
    <td align="center" ><?php echo $auxnumR; ?></td>
    <td align="center"><?php echo $dTicket['CVE_VENTA']; ?></td>
    <td align="center"><?php echo $dTicket['FECHA']; ?></td>
    <td align="center"><?php echo $dTicket['PROD_VENDIDOS']; ?></td>
    <td align="right"><?php echo "$  ".$dTicket['TOT']; ?></td>
    <td align="center" ><a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>></a><a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>><?php echo $dTicket['ESTATUS_VENTA']; ?></a></td>
    <td align="right" title="<?php echo $dTicket['NOMBRE'].' '.$dTicket['AP_PATERNO'].' '.$dTicket['AP_MATERNO']; ?>"><?php echo $dTicket['NOMBRE']; ?></td>
    <td ><a href="detalle_venta.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>&r=3&f1=<?php echo $fInicioAx; ?>&f2=<?php echo $fFinAx;?>&g=<?php echo $grupo; ?>&o=<?php echo $orden; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
     <td ><a href="fn.php?cve=<?php echo base64_encode($dTicket['CVE_VENTA']); ?>" target="_blank" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">IMPRIMIR</div></div></a></td>
     <td ><a href="cancela_ticket.php?clave_venta=<?php echo $dTicket['CVE_VENTA']; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">CANCELAR</div></div></a></td>
  </tr>
<?php 
	if($dTicket['ESTATUS_VENTA']=='DEVOLUCION'){
		
	}else{
		$VentaSuma=$VentaSuma+$dTicket['TOT'];
	}												

} ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="bgtabla"><?php echo "<strong>TOTAL $  ".number_format($VentaSuma,2)."</strong>"; ?></td>
    <td align="right" class="bgtabla">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
 
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
$consultaTicket2=mysql_query("
SELECT
A.CVE_VENTA,
A.FECHA,
SUM( A.CANTIDAD_VEN ) AS PROD_VENDIDOS,
SUM( A.PRECIO_VENTA ) AS TOT,
C.NOMBRE,
C.AP_PATERNO,
C.AP_MATERNO,
D.ESTATUS_VENTA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO = B.ID_PRODUCTO
INNER JOIN persona C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON D.ID_ESTATUS_VENTA=A.ID_ESTATUS_VENTA
WHERE A.FECHA
BETWEEN  '$fInicio'
AND  '$fFin'
AND A.ID_ESTATUS_VENTA=4
AND A.ID_ENVIADO=0
GROUP BY A.CVE_VENTA
ORDER BY $grupo $orden;

	")
or die("Error al consultar las ventas del día. <br/>".mysql_error());
?>
<!--  TABLAS DE VENTAS CONTABLES  -->
<table width="100%" border="0">
  <tr>
    <td width="100%">
    
    <form target="_blank" action="reporte_ventas.php" method="post" style="float: right;">
    <!--<form target="_blank" action="reporte_ventas_pdf.php" method="post">-->
    <input name="fInicio" type="hidden" value="<?php echo $fInicio; ?>" />
    <input name="fFin" type="hidden" value="<?php echo $fFin; ?>" />
    <input name="enviar" type="submit" value="Reporte de ventas contables" class="boton_verde" />
    <input type="hidden" name="tipoVenta" value="4">
    </form>
    <form action="./php/enviarCorte.php" method="POST" style="float: right;">
      <input name="fInicio" type="hidden" value="<?php echo $fInicio; ?>" />
      <input name="fFin" type="hidden" value="<?php echo $fFin; ?>" />
      <input type="hidden" name="tipoVenta" value="4">
      <input name="enviar" type="submit" value="Enviar corte" class="boton_verde" />
  </form>
    </td>
  </tr>
</table>
<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">
       <a href="corte_periodo_adm.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"></div>
       </a> 
      </td>
      <td align="center" valign="middle">
       <a href="corte_periodo_adm.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"> </div>
       </a> 
      </td>
      <td align="center" valign="middle">
       <a href="corte_periodo_adm.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"> </div>
       </a> 
      </td>
      <td align="center" valign="middle">
       <a href="corte_periodo_adm.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"> </div>
       </a> 
      </td>
      <td align="center" valign="middle">
       <a href="corte_periodo_adm.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"> </div>
       </a> </td>
      <td align="center" valign="middle">
      <a href="corte_periodo_adm.php?grupo=<?php echo "NOMBRE"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_up"> </div>
       </a>
       <a href="corte_periodo_adm.php?grupo=<?php echo "NOMBRE"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
       <div class="flecha_down"> </div>
       </a> 
      </td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr class="bgtabla">
      <td width="2%" align="center" valign="middle">&nbsp;</td>
      <td width="17%" align="center" valign="middle">CLAVE DE LA VENTA</td>
      <td width="18%" align="center" valign="middle">FECHA Y HORA</td>
      <td width="20%" align="center" valign="middle">NO. DE PRODUCTOS VENDIDOS</td>
      <td width="16%" align="center" valign="middle">TOTAL DE LA VENTA</td>
      <td width="16%" align="center" valign="middle">ESTATUS VENTA</td>
      <td width="14%" align="center" valign="middle">VENDIÓ</td>
      <td width="13%" align="center" valign="middle">&nbsp;</td>
      <td width="13%" align="center" valign="middle">&nbsp;</td>
      <td width="13%" align="center" valign="middle">&nbsp;</td>
    </tr>
  
  
  <?php
    $VentaSuma2=0;
    $auxnumR2=0;
  while($dTicket2=mysql_fetch_array($consultaTicket2)) { $auxnumR2++; 
  if($dTicket2['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0"';}
  if($dTicket2['ESTATUS_VENTA']=='SIN COBRAR' || $dTicket2['ESTATUS_VENTA']=='DEVOLUCION'){$color='style="color:#F00"';}?>
  
    <tr class="hover_lista">
      <td align="center" ><?php echo $auxnumR; ?></td>
      <td align="center"><?php echo $dTicket2['CVE_VENTA']; ?></td>
      <td align="center"><?php echo $dTicket2['FECHA']; ?></td>
      <td align="center"><?php echo $dTicket2['PROD_VENDIDOS']; ?></td>
      <td align="right"><?php echo "$  ".$dTicket2['TOT']; ?></td>
      <td align="center" ><a title="Cobrar" <?php if($dTicket2['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket2['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>></a><a title="Cobrar" <?php if($dTicket2['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket2['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>><?php echo $dTicket2['ESTATUS_VENTA']; ?></a></td>
      <td align="right" title="<?php echo $dTicket2['NOMBRE'].' '.$dTicket2['AP_PATERNO'].' '.$dTicket2['AP_MATERNO']; ?>"><?php echo $dTicket2['NOMBRE']; ?></td>
      <td ><a href="detalle_venta.php?cv=<?php echo $dTicket2['CVE_VENTA']; ?>&r=3&f1=<?php echo $fInicioAx; ?>&f2=<?php echo $fFinAx;?>&g=<?php echo $grupo; ?>&o=<?php echo $orden; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
       <td ><a href="fn.php?cve=<?php echo base64_encode($dTicket2['CVE_VENTA']); ?>" target="_blank" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">IMPRIMIR</div></div></a></td>
       <td ><a href="cancela_ticket.php?clave_venta=<?php echo $dTicket2['CVE_VENTA']; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">CANCELAR</div></div></a></td>
    </tr>
  <?php 
    if($dTicket2['ESTATUS_VENTA']=='DEVOLUCION'){
      
    }else{
      $VentaSuma2=$VentaSuma2+$dTicket2['TOT'];
    }												
  
  } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right" class="bgtabla"><?php echo "<strong>TOTAL $  ".number_format($VentaSuma2,2)."</strong>"; ?></td>
      <td align="right" class="bgtabla">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
   
  </table>
<p>&nbsp;</p>
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
</div>
<div class="esp_mod">

 
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
