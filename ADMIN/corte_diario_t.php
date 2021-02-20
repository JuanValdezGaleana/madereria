<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");

$idPer=$_SESSION['SESSION_ID_PERSONA'];
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
<div class="surtir_logo stretchRight"><img src="../imagenes/registradora.png"/></div>

<div class="surtir_tit stretchRight"><strong>CORTE DIARIO</strong></div>

<div class="espacio_calendario">
<a href=""><div class="items_surtir slideDown item_surtir_sel">POR VENTA</div></a>
<a href="corte_diario.php"><div class="items_surtir slideDown ">POR TIPO</div></a></div>
</div>
</div>



<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
<?php
$fechaHoy=date("Y-m-d");


/*
SELECT
	A.CVE_VENTA,
	A.FECHA,
	SUM(A.CANTIDAD_VEN) AS PROD_VENDIDOS,
	SUM(B.PRECIO_FINAL) AS TOT
	FROM ventas_salidas A
	INNER JOIN productos B
	ON A.ID_PRODUCTO=B.ID_PRODUCTO
	WHERE FECHA LIKE '%$fechaHoy%'
	AND A.ID_PERSONA=$idPer
	AND A.ID_ESTABLECIMIENTO=$id_establecimiento
	GROUP BY A.CVE_VENTA;
*/
  if($grupo==""||$orden==""){
	  $grupo="CVE_VENTA";
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
  WHERE  DATE_FORMAT(A.FECHA,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
	AND A.ID_PERSONA=$idPer
	AND A.ID_ESTABLECIMIENTO=$id_establecimiento
	GROUP BY A.CVE_VENTA
    ORDER BY $grupo $orden;
	")
or die("Error al consultar las ventas del día. <br/>".mysql_error());
?>


<table width="100%" border="1" class=" propTabla">
  <tr class="bgtabla">
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">
     <a href="corte_diario_t.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "ASC"; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_diario_t.php?grupo=<?php echo "CVE_VENTA"; ?>&orden=<?php echo "DESC"; ?>"> 
     <div class="flecha_down"></div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_diario_t.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "ASC"; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_diario_t.php?grupo=<?php echo "FECHA"; ?>&orden=<?php echo "DESC"; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_diario_t.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "ASC"; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_diario_t.php?grupo=<?php echo "PROD_VENDIDOS"; ?>&orden=<?php echo "DESC"; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_diario_t.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "ASC"; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_diario_t.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "DESC"; ?>"> 
     <div class="flecha_down"> </div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="corte_diario_t.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "ASC"; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="corte_diario_t.php?grupo=<?php echo "ESTATUS_VENTA"; ?>&orden=<?php echo "DESC"; ?>"> 
     <div class="flecha_down"> </div>
     </a> </td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr class="bgtabla">
    <td width="2%" align="center" valign="middle">&nbsp;</td>
    <td width="11%" align="center" valign="middle">CLAVE DE LA VENTA</td>
    <td width="16%" align="center" valign="middle">FECHA Y HORA</td>
    <td width="18%" align="center" valign="middle">NO. DE PRODUCTOS VENDIDOS</td>
    <td width="26%" align="center" valign="middle">TOTAL DE LA VENTA</td>
    <td width="14%" align="center" valign="middle">ESTATUS</td>
    <td width="13%" align="center" valign="middle">&nbsp;</td>
  </tr>

<?php
  $VentaSuma=0;
  $auxnumR=0;
while($dTicket=mysql_fetch_array($consultaTicket)) { $auxnumR++; 
if($dTicket['ESTATUS_VENTA']=='VENTA'){$color='style="color:#0C0"';}
if($dTicket['ESTATUS_VENTA']=='SIN COBRAR'){$color='style="color:#F00"';}
?>
  <tr class="hover_lista">
    <td><?php echo $auxnumR; ?></td>
    <td align="center"><?php echo $dTicket['CVE_VENTA']; ?></td>
    <td align="center"><?php echo $dTicket['FECHA']; ?></td>
    <td align="center"><?php echo $dTicket['PROD_VENDIDOS']; ?></td>
    <td align="right" ><?php echo "$  ".number_format($dTicket['TOT'],2); ?></td>
    <td align="center" >
    
    <a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>></a>
    
    
    <a title="Cobrar" <?php if($dTicket['ESTATUS_VENTA']=="SIN COBRAR"){ ?> href="detalle_nota.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>" <?php } ?> <?php echo $color ?>><?php echo $dTicket['ESTATUS_VENTA']; ?></a>
    
    
    
    </td>
    <td><a href="detalle_venta.php?cv=<?php echo $dTicket['CVE_VENTA']; ?>&r=1" style="text-decoration:none; color:#000;"><div class="fondo stretchLeft"><div class="iconos_lista">DETALLE</div></div></a></td>
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
    <td align="right" >&nbsp;</td>
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
