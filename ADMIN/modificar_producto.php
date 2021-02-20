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
<title><?php echo $nom_negocio;  ?></title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="css/formulario.css" type="text/css">
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
                	 <li><a href="index.php">CORTE ADMIN.</a></li>
                                                
               </ul>   
            </div>
        </div><!-- End 3 columns container -->
        </li><!-- End 3 columns Item -->
                <!-- End 3 columns Item -->
       
  </ul>
</div>

<div class="contenedor">

<div class="surtir_espacio">
  <div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/modificar.png"/></div>
<div class="surtir_tit stretchRight"><strong>BUSCAR Y MODIFICAR PRODUCTOS</strong></div>
<div class="buscar_cod">
<form name="foemulario" action="modificar_producto.php" method="post">
<table width="100%" border="0">
  <tr>
    <td width="49%" valign="top">CODIGO:</td>
    <td width="51%" rowspan="2" valign="top"><label>
      <input type="submit" name="button" id="button" value="BUSCAR" class="boton_verde"/>
    </label></td>
  </tr>
  <tr>
    <td valign="top"><label>
      <input type="text" name="busCod" id="busCod" />
    </label></td>
    </tr>
</table>

</form>
</div>
<div class="buscar_nombre">
<form name="foemulario" action="modificar_producto.php" method="post">
<table width="100%" border="0">
  <tr>
    <td width="49%" valign="top">NOMBRE:</td>
    <td width="51%" rowspan="2" valign="top"><label>
      <input type="submit" name="button" id="button" value="BUSCAR" class="boton_verde"/>
    </label></td>
  </tr>
  <tr>
    <td valign="top"><label>
      <input type="text" name="busNom" id="busNom" autofocus="autofocus" onchange="javascript:this.value=this.value.toUpperCase();"/>
    </label></td>
    </tr>
</table>

</form>
</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
<?php
if($_POST['busCod']==''){
	$busNom=$_POST['busNom'];
	$txt=$busNom;
	$consulta="
	SELECT 
	A.ID_PRODUCTO,
	A.CVE_PRODUCTO,A.NOMBRE_PRODUCTO,
	A.DESCRIPCION, A.ID_TIPO_PRODUCTO,
	A.ID_TIPO_PRES_PROD,A.PRECIO_COMPRA,
	A.PRECIO_VENTA,A.ID_UNIDAD_MEDIDA,
	A.ID_PROVEEDOR,DESCUENTO,PORCENTAJE_IMPUESTO,
	PRECIO_FINAL,B.CANTIDAD_ACTUAL
	FROM productos A
	INNER JOIN inventario B
	ON A.ID_PRODUCTO=B.ID_PRODUCTO
	WHERE A.DESCRIPCION LIKE '%".$busNom."%'
	AND A.ID_ESTABLECIMIENTO=$id_establecimiento
	ORDER BY A.ID_PRODUCTO DESC;
	";
	}else{
		if($_POST['busNom']==''){
			$busCod=$_POST['busCod'];
			$txt=$busCod;
			$consulta=" 
				SELECT 
				A.ID_PRODUCTO,
				A.CVE_PRODUCTO,A.NOMBRE_PRODUCTO,
				A.DESCRIPCION, A.ID_TIPO_PRODUCTO,
				A.ID_TIPO_PRES_PROD,A.PRECIO_COMPRA,
				A.PRECIO_VENTA,A.ID_UNIDAD_MEDIDA,
				A.ID_PROVEEDOR,DESCUENTO,PORCENTAJE_IMPUESTO,
				PRECIO_FINAL,B.CANTIDAD_ACTUAL
				FROM productos A
				INNER JOIN inventario B
				ON A.ID_PRODUCTO=B.ID_PRODUCTO
				WHERE A.CVE_PRODUCTO LIKE '%".$busCod."%'
				AND A.ID_ESTABLECIMIENTO=$id_establecimiento
				ORDER BY A.ID_PRODUCTO DESC;";
			}
		}

if($_POST['busCod']==''&&$_POST['busNom']==''){$consulta="SELECT NOW();";}
 /* /////////////// INICIO DE LA MUSTRA DE LOS RESULTADOS  //////////////////////////////// */ 


/* CONSULTA PARA MOSTRAR LOS PRODUCTOS POR BÚSQUEDA */
$consultaDatos=mysql_query($consulta )
or die("Error al consultar los datos. <br/>".mysql_error());
/*HACE EL CONTEO TOTAL DE LOS REGISTROS ENCONTRADOS*/
$cuentaDatos=mysql_num_rows($consultaDatos)
or die("No se pudieron contar lo resultados los datos. <br/>".mysql_error());

 if($_SESSION['SESSION_GRUPO']=='USUARIO DE CAPTURA'){
	 /*$cambiar='readonly="readonly"';
	 $cambiarlista='disabled="disabled"';
	 $habilitarBot='disabled="disabled"';*/
	 
	 $cambiar='';
	 $cambiarlista='';
	 $habilitarBot='';
	 
	 
	 }else{$cambiar=''; $habilitarBot='';}
	
 echo 'RESULTADOS PARA: "'. $txt.'"<br/>';
 echo "SE ENCONTRARON $cuentaDatos RESULTADOS";
?>


  <table width="100%" border="1" class="propTabla">
    <tr class="bgtabla datos">
      <td align="center" valign="middle">
      <div class="flecha_up"></div>
      <div class="flecha_down"></div>
      </td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr class="bgtabla datos">
      <td width="9%" align="center" valign="middle">CLAVE</td>
      <td width="10%" align="center" valign="middle">PRODUCTO</td>
      <td width="13%" align="center" valign="middle">DESCRIPCION</td>
      <td width="12%" align="center" valign="middle">TIPO PRODUCTO</td>
      <td width="8%" align="center" valign="middle">TIPO PRES.</td>
      <td width="7%" align="center" valign="middle">$ COMPRA</td>
      <td width="7%" align="center" valign="middle">$VENTA</td>
      <td width="7%" align="center" valign="middle">IMP.</td>
      <td width="8%" align="center" valign="middle">% DESC</td>
      <td width="8%" align="center" valign="middle">$ FINAL</td>
      <td width="5%" align="center" valign="middle">CANT.</td>
      <td width="6%" align="center" valign="middle">UNIDAD</td>
      <td width="7%" align="center" valign="middle">&nbsp;</td>
    </tr>
    
    
    <?php 
	
	
	while($res_datos=mysql_fetch_array($consultaDatos)){
	
	?>
  <tr  class="datos hover_lista">  
<form name="form" action="actualizar_lista.php?r=2" method="post">
      <td align="center" valign="top">
	      <input name="cve_productotb" type="text"  class="datos bordes_formulario ancho_form" id="cve_productotb" 
          value="<?php echo $res_datos['CVE_PRODUCTO'];  ?>" 
             />
        </td>
      <td valign="top">
      <textarea name="nombre_productotb"  rows="2"  <?php echo $cambiar; ?> class="datos bordes_formulario ancho_form" 
      onchange="javascript:this.value=this.value.toUpperCase();"><?php echo $res_datos['NOMBRE_PRODUCTO'];  ?></textarea>
        </td>
      <td valign="top"><textarea name="descripciontb" rows="2"  <?php echo $cambiar; ?>  class="datos bordes_formulario ancho_form"
      onchange="javascript:this.value=this.value.toUpperCase();"><?php echo $res_datos['DESCRIPCION'];  ?></textarea></td>
      <td valign="top">
      <!-- INICIO CAMPO  id_tipo_producto -->
       <?php  
	   //Consulta para mostrar todos los tipos de productos
	   	$cProducto=mysql_query("SELECT ID_TIPO_PRODUCTO, TIPO_PRODUCTO FROM cat_tipos_producto WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY TIPO_PRODUCTO ASC;")
		or die("Error al consultar los datos de las presentaciones. <br/>");
	   ?>
       <select name="id_tipo_productotb" id="id_tipo_productotb" <?php echo $cambiarlista; ?>  class="datos bordes_formulario ancho_form">
       <?php  while($rProducto=mysql_fetch_array($cProducto)) { ?>
         <option value="<?php echo $rProducto['ID_TIPO_PRODUCTO']; ?>"
         <?php if($res_datos['ID_TIPO_PRODUCTO']==$rProducto['ID_TIPO_PRODUCTO']) {echo 'selected="selected"';} ?> >	 
		 <?php echo $rProducto['TIPO_PRODUCTO']; ?></option>   
         <?php } ?>
       </select>
       <!-- FIN CAMPO  id_tipo_producto --> 
       
       
       </td>
      <td valign="top">
      <!-- INICIO CAMPO  id_tipo_presentacion -->
      <?php  
	   //Consulta para mostrar todos los tipos de presentacion
	   	$cPresent=mysql_query("SELECT ID_TIPO_PRES_PROD, TIPO_PRES_PROD FROM cat_tipo_pres_prod WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY TIPO_PRES_PROD ASC;")
		or die("Error al consultar los datos de las presentaciones. <br/>");
	   ?>
      <select name="id_tipo_presentaciontb" id="id_tipo_presentaciontb" <?php echo $cambiarlista; ?> class="datos bordes_formulario ancho_form">
       <?php  while($rPresent=mysql_fetch_array($cPresent)) { ?>
         <option value="<?php echo $rPresent['ID_TIPO_PRES_PROD']; ?>"
         <?php if($res_datos['ID_TIPO_PRES_PROD']==$rPresent['ID_TIPO_PRES_PROD']) {echo 'selected="selected"';} ?> >	 
		 <?php echo $rPresent['TIPO_PRES_PROD']; ?></option>   
         <?php } ?>
       </select>
       <!-- INICIO CAMPO  id_tipo_presentacion -->
      
      </td>
      
      <td align="right" valign="top">
     
       
      $<input name="precio_compratb" id="precio_compratb" type="text" size="4" class="datos bordes_formulario alineacion_numeros" <?php echo $cambiar; ?>
      value="<?php echo $res_datos['PRECIO_COMPRA'];  ?>" />
      
      </td>
      <td align="right" valign="top">
      $<input name="precio_ventatb" id="precio_ventatb" type="text" size="4" 
      class="datos bordes_formulario alineacion_numeros" 
      value="<?php echo $res_datos['PRECIO_VENTA'];  ?>" />
      </td>
      <td align="right" valign="top">
      <input name="impuestotb" id="impuestotb" type="text" size="3" style="text-align:right;" 
      class="datos bordes_formulario alineacion_numeros"  value="<?php echo $res_datos['PORCENTAJE_IMPUESTO'] ?>" />%
      </td>
      <td align="right" valign="top">
         <!-- INICIO CAMPO  descuento -->
      <input name="descuentotb" id="descuentotb" type="text" size="3" style="text-align:right;" 
      class="datos bordes_formulario alineacion_numeros"  value="<?php echo $res_datos['DESCUENTO']; ?>" />%
      
       <!-- FIN CAMPO  descuento -->
      </td>
      <td align="right" valign="top">
      $<input name="precio_finaltb" id="precio_finaltb" type="text" size="4" 
      class="datos bordes_formulario alineacion_numeros" readonly="readonly"
      value="<?php echo $res_datos['PRECIO_FINAL'];  ?>" />
      </td>
      <td align="center" valign="top">
	  <input name="cant_act" type="text" style="width:97%;"  class="datos bordes_formulario alineacion_numeros" value="<?php  echo $res_datos['CANTIDAD_ACTUAL']  ?>" />
	 </td>
 	  <td valign="top">      
 	    <!-- INICIO CAMPO  id_unidad_medida -->
 	    <?php  
	   //Consulta para mostrar todos los tipos de presentacion
	   	$cUMedida=mysql_query("SELECT ID_UNIDAD_MEDIDA, ACRONIMO FROM cat_unidad_medida")
		or die("Error al consultar los datos de las presentaciones. <br/>");
	   ?>
 	    <select name="id_unidad_medidatb" <?php echo $cambiarlista; ?> class="datos bordes_formulario">
 	      <?php  while($rUMedida=mysql_fetch_array($cUMedida)) { ?>
 	      <option value="<?php echo $rUMedida['ID_UNIDAD_MEDIDA']; ?>"
         <?php if($res_datos['ID_UNIDAD_MEDIDA']==$rUMedida['ID_UNIDAD_MEDIDA']) {echo 'selected="selected"';} ?> >	 
 	        <?php echo $rUMedida['ACRONIMO']; ?></option>   
 	      <?php } ?>
 	      </select>
 	    <!-- INICIO CAMPO  id_unidad_medida -->
 	    
 	    </td>
      <td align="center" valign="middle">
     <input name="id_productotb" type="hidden" value="<?php echo $res_datos['ID_PRODUCTO']; ?>" />
     <input name="busCod" type="hidden" value="<?php echo $busCod; ?>" />
     <input name="busNom" type="hidden" value="<?php echo $busNom; ?>" />
     
        <label>
          <input type="submit" name="button2" id="button2" value="Modificar"  <?php echo $habilitarBot; ?> />
        </label></td>
</form>


 	</tr>
<?php } ?>
   
    <tr class="bgtabla">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
   
    
  </table>

<?php /* /////////////// FIN DE LA MUSTRA DE LOS RESULTADOS  //////////////////////////////// */ ?>  
 <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p> 
</div>
<!-- ************************** Inicio de info del establecimiento y usuario que inició sesión ********************** -->

<div class="esp_mod">
<?php if($_SESSION['SESSION_GRUPO']=="SUPER ADMINISTRADOR"){ 
echo' 
	
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
