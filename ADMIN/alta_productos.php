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
<link rel="stylesheet" href="css/alta.css" type="text/css">
<link rel="stylesheet" href="css/ordenlistas.css" type="text/css">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

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
	<script type="text/javascript">      
			function jsselect(){
				document.getElementById('cve_producto').focus();
				}
        </script>
        <script type="text/javascript">
		function porcentaje(precio_venta,descuento,impuesto){
		
		var subtotal=0;
		var porciento=(parseInt(descuento.value)/100);
		
		
		subtotal=parseInt(precio_venta.value)+((parseInt(precio_venta.value)*porciento));
		var iva=((subtotal*((parseInt(impuesto.value)/100))))+subtotal;
		
		document.getElementById('precio_final').value = iva;
		}
			
		function impuesto(impuesto){
		
		var subtotal=0;
		var porciento=(parseInt(descuento.value)/100);
		
		
		subtotal=parseInt(precio_venta.value)+((parseInt(precio_venta.value)*porciento));
		var iva=((subtotal*((parseInt(impuesto.value)/100))))+subtotal;
		
		document.getElementById('precio_final').value = iva;
		}
        </script>

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
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">
  
  <fieldset class="alta_prod_bg">
<legend class="alta_titulo_bg"><strong>REGISTRAR PRODUCTO NUEVO</strong></legend>
 <form  id="fields-in-call" name="form1" method="post" action="insert_inventario.php" >

  <table width="100%" border="0">
    <tr>
      <td width="18%" align="right" valign="top">Clave de producto:</td>
      <td width="22%" valign="top"><label>
        <input type="text" name="cve_producto" id="cve_producto" class="required" onchange="javascript:this.value=this.value.toUpperCase();" />
      </label>
        <script type="text/javascript">
		            var clave_producto = new LiveValidation('cve_producto');
		            clave_producto.add(Validate.Presence);
		          </script>  
      
      </td>
      <td width="2%">&nbsp;</td>
      <td width="14%" align="right" valign="top"></td>
      <td width="44%" valign="top">
      
      </td>
    </tr>
    <tr>
      <td align="right" valign="top">Nombre del producto:</td>
      <td valign="top"><input type="text" name="nombre_producto" id="nombre_producto" onchange="javascript:this.value=this.value.toUpperCase();" />
      <script type="text/javascript">
		            var nombre_producto = new LiveValidation('nombre_producto');
		            nombre_producto.add(Validate.Presence);
		          </script> 
      
      </td>
      <td>&nbsp;</td>
      <td align="right" valign="top">Descripción:</td>
      <td rowspan="2" valign="top"><textarea name="descripcion" cols="40" rows="3" class="required" id="descripcion" onchange="javascript:this.value=this.value.toUpperCase();" ></textarea>
      <script type="text/javascript">
		            var descripcion = new LiveValidation('descripcion');
		            descripcion.add(Validate.Presence);
		          </script>  
      
      
      
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Presentación:</td>
      <td valign="top"><label>
                
            <?php 
			
			/*ID del registro a granel para este establecimiento*/
			$idgranest=mysql_query("
			SELECT
			A.ID_PRODUCTO,
			A.NOMBRE_PRODUCTO,
			B.ID_TIPO_PRES_PROD,
			B.TIPO_PRES_PROD
			FROM productos A
			INNER JOIN cat_tipo_pres_prod B
			ON A.ID_TIPO_PRES_PROD=B.ID_TIPO_PRES_PROD
			WHERE B.TIPO_PRES_PROD='A GRANEL'
			AND B.ID_ESTABLECIMIENTO=$id_establecimiento;
			")
			or die("No se pudo hacer la consulta del identificador de A GRANEL para este establecimiento.<br/>".mysql_error());
			$didgranest=mysql_fetch_array($idgranest);
			$idgran=$didgranest['ID_TIPO_PRES_PROD'];
			
			
	  $cTipoPres=mysql_query("
					SELECT ID_TIPO_PRES_PROD,TIPO_PRES_PROD FROM cat_tipo_pres_prod WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY TIPO_PRES_PROD ASC;
								")
	  or die("No se pudo consultar los datos de los proveedores. <br/>".mysql_error());
	  ?>
        <select name="id_tipo_pres_prod" id="id_tipo_pres_prod"
        onchange="if(this.value=='<?php echo $idgran; ?>') {document.getElementById('msjAGranel').style.display = 'block'} else {document.getElementById('msjAGranel').style.display = 'none'} ">
        <?php 
			while($dTipoPres=mysql_fetch_array($cTipoPres)){
		?>
          <option value="<?php echo $dTipoPres['ID_TIPO_PRES_PROD']; ?>"><?php echo $dTipoPres['TIPO_PRES_PROD']; ?></option>
          <?php } ?>
        </select>
        
        
        
        
      </label>        <script type="text/javascript">
		            var presentacion = new LiveValidation('presentacion');
		            presentacion.add(Validate.Presence);
		          </script>
                  
                   <script type="text/javascript">
		$(document).ready(function() {
			
			$("#presentacion").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			$("#medida").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#producto").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
		});
	</script>
                  
                  
       <a title="AGREGAR NUEVO TIPO DE PRESENTACIÓN A LA LISTA" id="presentacion" href="alta_listas.php?lista=<?php echo base64_encode("presentacion");  ?>">           
      <img title="Administrar lista de tipos de presentación" src="../imagenes/agregar.png" width="17" height="18" alt="+" longdesc="agregar" />
      </a>
      </td>
      <td>&nbsp;</td>
      <td align="right" valign="top"></td>
      </tr>
    <tr>
      <td align="right" valign="top">Unidad de medida:</td>
      <td valign="top"><label>
                
            <?php 
	  $cUniMed=mysql_query("
					SELECT ID_UNIDAD_MEDIDA,UNIDAD_MEDIDA,ACRONIMO FROM cat_unidad_medida WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY UNIDAD_MEDIDA ASC
								")
	  or die("No se pudo consultar los datos de los proveedores. <br/>".mysql_error());
	  ?>
        <select name="id_unidad_medida" id="id_unidad_medida">
        <?php 
			while($dUniMed=mysql_fetch_array($cUniMed)){
		?>
          <option value="<?php echo $dUniMed['ID_UNIDAD_MEDIDA']; ?>"><?php echo $dUniMed['UNIDAD_MEDIDA']; ?></option>
          <?php } ?>
        
        </select>
        
        
        
        
      </label> 
      <a title="AGREGAR NUEVA UNIDAD DE MEDIDA A LA LISTA" id="medida" href="alta_listas.php?lista=<?php echo base64_encode("medida");  ?>">           
      <img title="Administrar lista de unidades de medida" src="../imagenes/agregar.png" width="17" height="18" alt="+" longdesc="agregar" />
      </a>
      </td>
      <td valign="top">&nbsp;</td>
      <td align="right" valign="top">Tipo de producto:</td>
      <td valign="top">
      <label>
         <?php 
	  $cTipoMeds=mysql_query("
					SELECT ID_TIPO_PRODUCTO,TIPO_PRODUCTO FROM cat_tipos_producto WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY TIPO_PRODUCTO ASC
								")
	  or die("No se pudo consultar los datos de los proveedores. <br/>".mysql_error());
	  ?>
        <select name="id_tipo_producto" id="id_tipo_producto">
        <?php 
			while($dTipoMeds=mysql_fetch_array($cTipoMeds)){
		?>
          <option value="<?php echo $dTipoMeds['ID_TIPO_PRODUCTO']; ?>"><?php echo $dTipoMeds['TIPO_PRODUCTO']; ?></option>
          <?php } ?>
        </select>
        
        
      </label>
      <a title="AGREGAR NUEVO TIPO DE PRODUCTO A LA LISTA" id="producto" href="alta_listas.php?lista=<?php echo base64_encode("producto");  ?>">           
      <img title="Administrar lista de tipos de productos" src="../imagenes/agregar.png" width="17" height="18" alt="+" longdesc="agregar" />
      </a>
      </td>
    </tr>
    <tr>
      <td height="35" align="right" valign="top">Proveedor:</td>
      <td valign="top"><label>
      <?php 
	  $cProveedores=mysql_query("
					SELECT
						ID_ESTABLECIMIENTO,
						NOMBRE_COMERCIAL
						FROM establecimiento
						WHERE ID_MATRIZ=$id_establecimiento
						AND ID_ESTATUS_ACTIVO=1
						AND ID_TIPO_ESTABLECIMIENTO=4
						ORDER BY NOMBRE_COMERCIAL ASC;
								")
	  or die("No se pudo consultar los datos de los proveedores. <br/>".mysql_error());
	  ?>
        <select name="id_proveedor" id="id_proveedor">
        <?php 
			while($rProveedores=mysql_fetch_array($cProveedores)){
		?>
          <option value="<?php echo $rProveedores['ID_ESTABLECIMIENTO']; ?>"><?php echo $rProveedores['NOMBRE_COMERCIAL']; ?></option>
          <?php } ?>
        </select>
      </label>        <script type="text/javascript">
		            var proveedor = new LiveValidation('proveedor');
		            proveedor.add(Validate.Presence);
		          </script>
      </td>
      <td valign="top">&nbsp;</td>
      <td align="right" valign="top">Cantidad:</td>
      <td valign="top">
      <label>
        <input type="text" name="cantidad" id="cantidad" onchange="javascript:this.value=this.value.toUpperCase();" min="0" />
      </label>
        <script type="text/javascript">
		            var cantidad = new LiveValidation('cantidad');
					cantidad.add(Validate.Presence);
		            cantidad.add(Validate.Numericality, { onlyInteger: true } );
		          </script>  
      </td>
    </tr>
    <tr>
      <td align="right" valign="top">Precio compra:</td>
      <td valign="top">$
        <input type="text" name="precio_compra" id="precio_compra" value="0" min="0" />
        <script type="text/javascript">
		            var precio_compra = new LiveValidation('precio_compra');
		            precio_compra.add(Validate.Presence);
		            precio_compra.add(Validate.Numericality, { onlyInteger: false } );
		          </script>
        
        </td>
        
      <td>&nbsp;</td>
      <td align="right" valign="top">Precio venta:</td>
      <td valign="top">$
        <input type="text" name="precio_venta" id="precio_venta" value="0"  onkeyup="porcentaje(precio_venta,descuento,impuesto);"/>
        <script type="text/javascript">
		            var precio_venta = new LiveValidation('precio_venta');
		            precio_venta.add(Validate.Presence);
					precio_venta.add(Validate.Numericality, { onlyInteger: false } );
		          </script>
                  <span style="display: none; width:90%; color:#FF3C41;" id="msjAGranel">PARA PRODUCTOS 'A GRANEL' PONER EL PRECIO DE VENTA DE CADA 1,000 GRAMOS</span>
                  </td>
    </tr>
    <tr>
      <td align="right" valign="top">% de ganancia:</td>
      <td valign="top"><label>
<input name="descuento" type="text" id="descuento" size="3" style="text-align:right" value="0" onkeyup="porcentaje(precio_venta,descuento,impuesto);" min="0" />
%</label>
				
</td>
      <td><input type="hidden" name="opsw" id="opsw2" value="1" /></td>
      <td align="right" valign="top">Tipo de compra:</td>
      <td valign="top">
      <label>
      <select name="impuesto" id="impuesto" onkeyup="porcentaje(precio_venta,descuento,impuesto);">
      	<option value="0">particular</option>
      	<option value="16">empresa</option>
      </select>
</label>
     </td>
  
    </tr>
    <tr>
      <td align="right" valign="top">Precio Final:</td>
      <td valign="top"><script type="text/javascript">
		            var descuento = new LiveValidation('descuento');
					descuento.add(Validate.Presence);
					descuento.add(Validate.Numericality, { minimum: 0, maximum: 100, onlyInteger: true } );
		          </script>
		            <label>$
		              <input type="text" name="precio_final" id="precio_final" value="0"  />
            </label>
                    <input type="hidden" name="id_persona" id="id_persona"  value="<?php echo $_SESSION['SESSION_ID_PERSONA']; ?>"/>
          <input type="hidden" name="ID_ESTABLECIMIENTO" id="ID_ESTABLECIMIENTO" value="<?php echo $_SESSION['SESSION_ID_ESTABLECIMIENTO']; ?>"/></td>
      <td>&nbsp;</td>
      <td align="right" valign="top"></td>
      <td valign="top">
       
      </td>
    </tr>
    <tr>
      <td colspan="5" align="center">
        <input style="width:110px; height:50px; font-size:20px;" type="submit" name="guardar" id="guardar" value="Guardar" /></td>
       
    </tr>
  </table>

 </form> 
 
 </fieldset>
 <p>
 <div id="reg_productos">
<fieldset class="alta_prod_bg">
<legend class="alta_titulo_bg"><strong>REGISTRAR PRODUCTOS ENVIADOS</strong></legend>
<form action="cargar_prods.php" method="post">

<table width="100%" border="0">
  <tr class="bgtabla">
    <td width="39%" align="right">Código del producto</td>
    <td width="9%" align="left">&nbsp;</td>
    <td width="15%">Cantidad a registrar</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><label for="cod_entrada"></label>
      <input name="cod_entrada" type="text" id="cod_entrada" size="30" required="required" /></td>
    <td>&nbsp;</td>
    <td><input type="number" name="cant_entrada" min="1" id="cant_entrada" required="required" /></td>
    <td><input type="submit" name="guardar_entrada" id="guardar_entrada" value="Guardar" /></td>
  </tr>
</table>




</form>

<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td colspan="3" align="center">PRODUCTOS REGISTRADOS EL DÍA DE HOY</td>
    </tr>
    <?php 
	$q_ingresos=mysql_query('
SELECT
A.ID_CANTIDAD_PRODUCTO,
A.ID_PRODUCTO,
A.CANTIDAD_ALTA,
B.DESCRIPCION
FROM registro_cant_producto A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
WHERE DATE_FORMAT(A.FECHA_ALTA,"%Y-%m-%d")=CURDATE();
	')
	or die("No se pudo hacer la consulta de los ingresos. <br />".mysql_error());
	
	while($d_ingresos=mysql_fetch_array($q_ingresos)){
	 ?>
     <form action="del_ingreso.php" method="post"></form>
  <tr>
    <td width="48%"><?php echo $d_ingresos['DESCRIPCION']; ?></td>
    <td width="15%" align="center"><?php echo $d_ingresos['CANTIDAD_ALTA']; ?></td>
    <td width="37%">
    <a href="del_ingreso.php?d=<?php echo  base64_encode($d_ingresos['ID_PRODUCTO']); ?>&c=<?php echo base64_encode($d_ingresos['CANTIDAD_ALTA']); ?>&ip=<?php echo base64_encode($d_ingresos['ID_CANTIDAD_PRODUCTO']); ?>" style="color:#F00;">
    Eliminar
    </a>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>




</fieldset>
</div>
 </p>
 <div class="cont_aum_cons">
 <div class="aumentar_cantidad">
<fieldset  class="alta_prod_bg">
<legend class="alta_titulo_bg"><strong>AUMENTAR CANTIDAD DE PRODUCTO</strong></legend>

  <form id="fields-in-call2"  name="form2" method="post" action="insert_inventario.php">
  
  <table width="100%" border="0">
  <tr>
    <td width="17%" align="right">Clave de producto:</td>
    <td width="16%"><input type="text" name="clave_producto2" id="clave_producto2" class="required" onchange="javascript:this.value=this.value.toUpperCase();" />
    
    <script type="text/javascript">
		            var clave_producto2 = new LiveValidation('clave_producto2');
		            clave_producto2.add(Validate.Presence);
		          </script>
    </td>
    <td width="67%">&nbsp;</td>
    </tr>
  <tr>
    <td align="right">Cantidad:</td>
    <td><input type="text" name="cantidad2" id="cantidad2" onchange="javascript:this.value=this.value.toUpperCase();" />
      <script type="text/javascript">
		            var cantidad2 = new LiveValidation('cantidad2');
					cantidad2.add(Validate.Presence);
		            cantidad2.add(Validate.Numericality, { onlyInteger: true } );
		          </script>
    </td>
    <td width="67%"><input type="submit" name="button" id="button" value="ACTUALIZAR"  /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name="opsw" id="opsw" value="2" /></td>
    <td>&nbsp;</td>
  </tr>
  </table>

  </form>

 </fieldset>
</div>

<div class="mostrar_existencia">
<?php $buscar_cod=$_POST['buscar_cod'];

$contar=mysql_query("SELECT COUNT(CVE_PRODUCTO)
						 FROM productos
						 WHERE CVE_PRODUCTO =  '$buscar_cod'
						 AND ID_ESTABLECIMIENTO=$id_establecimiento")
or die("Error al contar. <br/>".mysql_error());
$nContar=mysql_fetch_array($contar);
$numC=$nContar['COUNT(CVE_PRODUCTO)'];

if($numC==0){
	
	if($buscar_cod==""){}
	if($buscar_cod!=""){
	
	$bClave="";
	$bDescripcion="NO EXISTE EL PRODUCTO CON ESTA CLAVE: <strong> '$buscar_cod'</strong>";
	$bCantidad="";
	}
}//  FIN if($numC==0)

if($numC>=1){

	$conCantidad=mysql_query("
						 SELECT A.CVE_PRODUCTO, A.DESCRIPCION, B.CANTIDAD_ACTUAL
						 FROM productos A
						 INNER JOIN inventario B ON A.ID_PRODUCTO = B.ID_PRODUCTO
						 WHERE A.CVE_PRODUCTO =  '$buscar_cod'
						 AND A.ID_ESTABLECIMIENTO=$id_establecimiento")
					or die("Error al consultar los detalles y cantidad del producto. <br/>".mysql_error());
					$datCantidad=mysql_fetch_array($conCantidad);
					$bClave=$datCantidad['CVE_PRODUCTO'];
					$bDescripcion=$datCantidad['DESCRIPCION'];
					$bCantidad=$datCantidad['CANTIDAD_ACTUAL'];
	
	
	
	}//  FIN if($numC>=0)


	  
	  
	  
?>
<fieldset class="alta_prod_bg">
<legend class="alta_titulo_bg"><strong>CONSULTAR CANTIDAD DE PRODUCTO</strong></legend>
<form id="form3" name="form3" method="post" action="alta_productos.php">
<table width="100%" border="0">
  <tr>
    <td width="35%"><label>
      <input type="text" name="buscar_cod" id="buscar_cod" />
    </label></td>
    <td width="65%"><label>
      <input type="submit" name="consultar" id="consultar" value="Consultar" />
    </label></td>
  </tr>
</table>
</form>
<table width="100%" border="0">
  <tr class="bgtabla">
    <td align="center">CLAVE</td>
    <td align="center">DESCRIPCION</td>
    <td align="center">CANT</td>
  </tr>
  <tr>
    <td><?php echo $bClave; ?></td>
    <td class="alertaCant"><?php echo $bDescripcion; ?></td>
    <td align="center"><?php echo $bCantidad; ?></td>
  </tr>
</table>

</fieldset>
</div>
</div>
<?php


/*CONSULTA PARA MOSTRAR LOS ULTIMOS 10 PRODUCTOS DADOS DE ALTA*/

$consultaDatos=mysql_query("
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
						   WHERE A.ID_ESTABLECIMIENTO=$id_establecimiento
						   ORDER BY A.ID_PRODUCTO DESC
						   LIMIT 15
						   ")
or die("Error al consultar los datos. <br/>".mysql_error());

 if($_SESSION['SESSION_GRUPO']=='USUARIO DE CAPTURA'){
	 $cambiar='readonly="readonly"';
	 $cambiarlista='disabled="disabled"';
	 $habilitarBot='disabled="disabled"';
	 
	 }else{$cambiar=''; $habilitarBot='';}
	

?>

<p>&nbsp;</p>
  <table width="100%"border="1" class="propTabla">
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
      <td width="7%" align="center" valign="middle">$COMPRA</td>
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
<form name="form" action="actualizar_lista.php?r=1" method="post">
      <td align="center" valign="top">
	    
	      <input name="cve_productotb" type="text" class="datos bordes_formulario ancho_form" id="cve_productotb" 
          value="<?php echo $res_datos['CVE_PRODUCTO'];  ?>" 
             />
        </td>
      <td valign="top">
      <textarea name="nombre_productotb" rows="2"  <?php echo $cambiar; ?> class="datos bordes_formulario ancho_form" 
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
	   	$cPresent=mysql_query("SELECT ID_TIPO_PRES_PROD, TIPO_PRES_PROD FROM cat_tipo_pres_prod")
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
      class="datos bordes_formulario alineacion_numeros"  value="<?php echo $res_datos['DESCUENTO'] ?>" />%
      
       <!-- FIN CAMPO  descuento -->
      </td>
      <td align="right" valign="top">
      $<input name="precio_finaltb" id="precio_finaltb" type="text" size="4" 
      class="datos bordes_formulario alineacion_numeros" readonly="readonly"
      value="<?php echo $res_datos['PRECIO_FINAL'];  ?>" />
      </td>
      <td align="center" valign="top">
	  <input name="cant_act" type="text" style="width:97%;" readonly="readonly" class="datos bordes_formulario alineacion_numeros" value="<?php  echo number_format($res_datos['CANTIDAD_ACTUAL'],',')  ?>" /></td>
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
      <td align="center" valign="top">
      <input name="id_productotb" type="hidden" value="<?php echo $res_datos['ID_PRODUCTO']; ?>" />
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
