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
<?php 
$tp=$_GET['tp'];
$cTp=mysql_query("SELECT TIPO_PRODUCTO FROM cat_tipos_producto WHERE ID_TIPO_PRODUCTO=$tp;")
or die("No se pudo hacer la consulta del tipo de producto. <br/>".mysql_error());
$dTp=mysql_fetch_array($cTp);

?>
<div class="contenedor">
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_back">
	<a href="almacen.php"><img src="../imagenes/back.png"/></a>
</div>
<div class="surtir_tit stretchRight"><strong>STOCK DE <?php echo $dTp['TIPO_PRODUCTO']; ?></strong></div>
</div>
</div>

<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">

<?php

if($grupo==""||$orden==""){
  $grupo="DESCRIPCION";
  $orden="ASC";
  }else{
  $grupo=$_GET['grupo'];
  $orden=$_GET['orden'];
  }

$cRepo=mysql_query("				
SELECT
A.CVE_PRODUCTO,
C.TIPO_PRES_PROD,
A.DESCRIPCION,
A.PRECIO_COMPRA,
A.PRECIO_VENTA,
A.DESCUENTO,
A.PRECIO_FINAL,
B.CANTIDAD_ACTUAL AS EXISTENCIA,
D.TIPO_PRODUCTO,
E.RAZON_SOCIAL,
(A.PRECIO_FINAL*B.CANTIDAD_ACTUAL) AS TOT
FROM productos A
INNER JOIN inventario B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN cat_tipo_pres_prod C
ON A.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
INNER JOIN cat_tipos_producto D
ON A.ID_TIPO_PRODUCTO=D.ID_TIPO_PRODUCTO
LEFT OUTER JOIN establecimiento E
ON A.ID_PROVEEDOR=E.ID_ESTABLECIMIENTO
WHERE A.ID_TIPO_PRODUCTO=$tp
AND A.ID_ESTABLECIMIENTO=$id_establecimiento
ORDER BY $grupo $orden;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
?>



<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">
     <a href="detalle_tp.php?grupo=<?php echo "CVE_PRODUCTO"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "CVE_PRODUCTO"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a> 
    </td>
    <td align="center" valign="middle">
     <a href="detalle_tp.php?grupo=<?php echo "DESCRIPCION"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "DESCRIPCION"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "PRECIO_COMPRA"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "PRECIO_COMPRA"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "PRECIO_VENTA"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "PRECIO_VENTA"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "DESCUENTO"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "DESCUENTO"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "PRECIO_FINAL"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "PRECIO_FINAL"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "EXISTENCIA"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "EXISTENCIA"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
    <td align="left" valign="middle">
    <a href="detalle_tp.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "ASC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_up"> </div>
     </a>
     <a href="detalle_tp.php?grupo=<?php echo "TOT"; ?>&orden=<?php echo "DESC"; ?>&tp=<?php echo $tp; ?>"> 
     <div class="flecha_down"></div>
     </a>
    </td>
  </tr>
  <tr class="bgtabla">
    <td width="2%" align="center" valign="middle">&nbsp;</td>
    <td width="7%" align="center" valign="middle">CÓDIGO</td>
    <td width="39%" align="center" valign="middle">DESCRIPCIÓN</td>
    <td width="8%" align="center" valign="middle">$ COMPRA</td>
    <td width="8%" align="center" valign="middle">$ VENTA</td>
    <td width="8%" align="center" valign="middle">% DESC.</td>
    <td width="8%" align="center" valign="middle">$ FINAL</td>
    <td width="8%" align="center" valign="middle">CANT.</td>
    <td width="12%" align="center" valign="middle">TOTAL UNITARIO</td>
    </tr>
  
  <?php 
  $alerta1=2;
  $alerta2=5;
  $i=0; 
  while($rDat=mysql_fetch_array($cRepo)){  $i=$i+1;
   ?>
  <tr class="hover_lista" <?php  
  if($rDat['EXISTENCIA'] <= $alerta1){
	  /*echo $colorear='bgcolor="#FFC6C6"';*/
	  echo $colorear='style="color:#C10000;font-size:14px;"';}else{ /* else 1 */
  if($rDat['EXISTENCIA'] > $alerta1 && $rDat['EXISTENCIA'] <= $alerta2){
	  /*echo $colorear='bgcolor="#FFD991"';*/
	  echo $colorear='style="color:#EA7500;font-size:14px;"';}
	  else{echo $colorear='style="color:#006600;font-size:14px;"';}
	  }/* fin else 1 */
	  ?>>
    <td><?php echo $i; ?></td>
    <td><?php echo $rDat['CVE_PRODUCTO']; ?></td>
    <td title="<?php echo "PROVEEDOR: ".$rDat['RAZON_SOCIAL']; ?>"><?php echo $rDat['DESCRIPCION']; ?></td>
    <td align="right" <?php if($rDat['PRECIO_FINAL']<$rDat['PRECIO_COMPRA']){echo 'bgcolor="#FF0000" style="color:#FFF"';} ?> ><?php echo $rDat['PRECIO_COMPRA']; ?></td>
    <td align="right"><?php echo $rDat['PRECIO_VENTA']; ?></td>
    <td align="right"><?php echo $rDat['DESCUENTO']." %"; ?></td>
    <td align="right" <?php if($rDat['PRECIO_FINAL']<$rDat['PRECIO_COMPRA']){echo 'bgcolor="#FF0000" style="color:#FFF"';} ?> ><?php echo $rDat['PRECIO_FINAL']; ?></td>
    <td align="center"><?php echo number_format($rDat['EXISTENCIA'],','); if($rDat['TIPO_PRES_PROD']=='A GRANEL'){ echo " Gr.";} ?></td>
    <td align="right"><?php
	if($rDat['TIPO_PRES_PROD']=='A GRANEL'){
		$sum=($rDat['EXISTENCIA'])*($rDat['PRECIO_FINAL']/1000);
		echo number_format($sum,2); 
		}else{
			$sum=$rDat['TOT'];
	echo number_format($sum,2); 
		}
	?></td>
    </tr>
  
<?php 
      $sumaAux=$sumaAux+$sum;
	  $tip_producto=$rDat['TIPO_PRODUCTO'];
	 
} ?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="bgtabla"><?php 
	/*VERIFICAMOS SI EL TIPO DE PRODUCTO ES DIFERENTE DE RECARGA*/
    if(	$tip_producto!='RECARGAS' ){
		/*echo "ENTRA A NO ES RECARGA <br/>";*/
	echo "<strong>SUMA TOTAL <br/> $ ".number_format($sumaAux, 2, ".", ",")."</strong>";
	}else{/*EN EL CASO QUE EL TIPO DE PRODUCTO SEA 'RECARGAS' SE SACA EL NUMERO DE REGISTROS PARA DESPUES DIVIDIR LA SUMA DE CANTIDADES ENTRE EL NUMERO DE REGISTROS */
		/*echo "ENTRA A SI ES RECARGA <br/>";*/
		$num=mysql_query("
						SELECT
						COUNT(A.DESCRIPCION) AS DIVI
						FROM productos A
						INNER JOIN cat_tipos_producto B
						ON A.ID_TIPO_PRODUCTO=B.ID_TIPO_PRODUCTO
						WHERE B.TIPO_PRODUCTO='RECARGAS'
						;
						 ")
		or die("No se pudo consultar la cantidad de registros de recargas. <br>".mysql_error());
		$dNum=mysql_fetch_array($num);
		$dividir=$dNum['DIVI'];
		$dividido=$sumaAux/$dividir;
		/*echo "TIPO DE PRODUCTO:".$tip_producto." <br/>";
		echo "DIVIDIR: $dividir <br/>";
		echo "SUMA AUX: $sumaAux <br/>";
		echo "DIVIDIDO: $dividido <br/>";*/
		echo "<strong>SALDO DISPONIBLE <br/> $ ".number_format($dividido, 2, ".", ",")."</strong>";
		}
	?>
    </td>
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
