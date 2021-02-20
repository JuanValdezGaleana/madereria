<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
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

$idPer=$_SESSION['SESSION_ID_PERSONA'];
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];


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
<a href=""><div class="items_surtir slideDown item_surtir_sel">POR VENTA</div></a>
<a href="corte_periodo.php"><div class="items_surtir slideDown ">POR TIPO</div></a>
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
<form name="form" action="corte_periodo_v.php" method="post">
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
if($grupo==""||$orden==""){
  $grupo="FECHA";
  $orden="DESC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }

$consultaTicket=mysql_query("
  SELECT
  B.DESCRIPCION,
	A.CVE_VENTA,
	A.FECHA,
	SUM(A.CANTIDAD_VEN) AS PROD_VENDIDOS,
/*	SUM(B.PRECIO_FINAL) AS TOT,*/
  C.ESTATUS_VENTA,
  /*D.TIPO_PRES_PROD,*/
SUM(IF(D.TIPO_PRES_PROD='A GRANEL',(A.PRECIO_VENTA),IF(D.TIPO_PRES_PROD='RECARGA',A.CANTIDAD_VEN*B.PRECIO_FINAL,B.PRECIO_FINAL) ) )AS TOT
	FROM ventas_salidas A
	INNER JOIN productos B
	ON A.ID_PRODUCTO=B.ID_PRODUCTO
  INNER JOIN cat_estatus_venta C
  ON C.ID_ESTATUS_VENTA=A.ID_ESTATUS_VENTA
  INNER JOIN cat_tipo_pres_prod D
  ON B.ID_TIPO_PRES_PROD=D.ID_TIPO_PRES_PROD
WHERE A.FECHA
BETWEEN  '$fInicio'
AND  '$fFin'
/*AND A.ID_PERSONA =$idPer*/
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
GROUP BY A.CVE_VENTA
ORDER BY $grupo $orden;
	")
or die("Error al consultar las ventas del día. <br/>".mysql_error());
?>


<table width="100%"border="1" class="propTabla">
<tr class="bgtabla">
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">
     <a href="corte_periodo.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"></div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_periodo.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "ASC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_periodo.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "DESC"; ?>&f1=<?php echo $fInicio; ?>&f2=<?php echo $fFin; ?>"> 
     <div class="flecha_down"> </div>
     </a> </td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr class="bgtabla">
    <td width="2%" align="center" valign="middle">&nbsp;</td>
    <td width="14%" align="center" valign="middle">CLAVE DE LA VENTA</td>
    <td width="19%" align="center" valign="middle">FECHA Y HORA</td>
    <td width="25%" align="center" valign="middle">NO. DE PRODUCTOS VENDIDOS</td>
    <td width="16%" align="center" valign="middle">TOTAL DE LA VENTA</td>
    <td width="12%" align="center" valign="middle">ESTATUS</td>
    <td width="12%" align="center" valign="middle">&nbsp;</td>
  </tr>

<?php
  $VentaSuma=0;
  $auxnumR=0;
while($dTicket=mysql_fetch_array($consultaTicket)) { $auxnumR++; 
if($dTicket['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0"';}
if($dTicket['ESTATUS_VENTA']=='SIN COBRAR'){$color='style="color:#F00"';}?>

  <tr class="hover_lista">
    <td><?php echo $auxnumR; ?></td>
    <td align="center"><?php echo $dTicket['CVE_VENTA']; ?></td>
    <td align="center"><?php echo $dTicket['FECHA']; ?></td>
    <td align="center"><?php echo $dTicket['PROD_VENDIDOS']; ?></td>
    <td align="right"><?php echo "$  ".number_format($dTicket['TOT'],2); ?></td>
    <td align="center" ><a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>></a><a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>><?php echo $dTicket['ESTATUS_VENTA']; ?></a></td>
    <td><a href="detalle_venta.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>&r=2&f1=<?php echo $fInicioAx; ?>&f2=<?php echo $fFinAx;?>&g=<?php echo $grupo; ?>&o=<?php echo $orden; ?>" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
  </tr>
<?php 
$VentaSuma=$VentaSuma+$dTicket['TOT'];
} ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="bgtabla"><?php echo "<strong>TOTAL $  ".number_format($VentaSuma,2)."</strong>"; ?></td>
    <td align="right" class="bgtabla">&nbsp;</td>
    <td align="right">&nbsp;</td>
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
