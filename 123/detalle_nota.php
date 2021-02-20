<?php require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
if($_GET['cv']!=""){
$clave_venta=$_GET['cv'];
}

if($_GET['sv']==""&&$_GET['cv']==""){
$ccveVenta=mysql_query("
			  SELECT CVE_VENTA FROM ventas_salidas WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY ID_VENTA_SALIDA DESC LIMIT 1
			  ")
or die("Error al consultar la ultima clave. <br/>".mysql_error());
$dcveVenta=mysql_fetch_array($ccveVenta);
$UltimacveVenta=$dcveVenta['CVE_VENTA'];
/*echo "CLAVE ULTIMA: $UltimacveVenta <br/>";*/

$i=0;
$arreglo[3];
$cadena = $UltimacveVenta;
$tok = strtok ($cadena,"-");
while ($tok) {

/*echo "Palabra=$tok<br>";*/
$arreglo[$i]=$tok;
$tok = strtok ("-");

/*echo "Arreglo posicion ".$i." es: ".$arreglo[$i]."<br/>";*/

$i++;
}

$arreglo[1]=$arreglo[1]+1;

$clave_venta=$arreglo[0]."-".$arreglo[1];
/*echo "LA NUEVA CLAVE ES: $nueva_clave <br/>";*/
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FARMACIA</title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

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
				document.getElementById('cant_efectivo').focus();
				}
        </script>
 <link rel="stylesheet" type="text/css" media="screen" href="../validador/css/jquery.ketchup.css" />
<script type="text/javascript" src="../select_dependientes.js"></script>
<script type="text/javascript" src="../validador/assets/js/jquery.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.validations.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.helpers.js"></script>
<script type="text/javascript" src="../validador/docs/js/scaffold.js"></script>

<script language=Javascript>
     function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
   </script>
 
 
</head>


<body onload="jsselect()">


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
	     <li class="menu_right menu_activo"><a href="index.php" >PUNTO DE VENTA</a></li>
 		 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
  </ul>
</div>

<div class="contenedor">
  <div class="lista_productos_vendidos">
 <table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="11%" align="center" valign="middle">Cant.</td>
    <td width="49%" align="center" valign="middle">Descripción</td>
    <td width="12%" align="center" valign="middle">% Imp.</td>
    <td width="9%" align="center" valign="middle">$ Desc.</td>
    <td width="12%" align="center" valign="middle">$ Importe</td>
    <td width="7%" align="center" valign="middle">&nbsp;</td>
    </tr>
    <?php  
	/*LANZAR ESTE QUERY CUANDO LA VENTA YA SE HAYA TERMINADO O COBRADO*/	
	if($_GET['sv']==1){
    $cProdVenta=mysql_query("
							SELECT
							/*SUM(A.CANTIDAD_VEN) AS CANTIDAD,*/
							A.CANTIDAD_VEN AS CANTIDAD,
							A.ID_PRODUCTO,
             				A.ID_VENTA_SALIDA,
							B.NOMBRE_PRODUCTO,
							B.PRECIO_VENTA AS PRECIO,
            				C.TIPO_PRES_PROD,
              				D.ACRONIMO AS UM,
							B.DESCUENTO,
							/*SUM(B.PRECIO_FINAL) AS IMPORTE*/
							A.PRECIO_VENTA AS IMPORTE
							FROM ventas_salidas A
							INNER JOIN productos B
							ON A.ID_PRODUCTO=B.ID_PRODUCTO
							INNER JOIN CAT_TIPO_PRES_PROD C
							ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
							LEFT OUTER JOIN CAT_UNIDAD_MEDIDA D
							ON B.ID_UNIDAD_MEDIDA=D.ID_UNIDAD_MEDIDA
							WHERE A.CVE_VENTA='$clave_venta'
							/*GROUP BY A.ID_PRODUCTO*/ 
							ORDER BY A.ID_VENTA_SALIDA DESC;
							
							")
	or die("No se pudo consultar la lista de los productos vendidos (1). <br/>".mysql_error());
	}
	/*LANZAR ESTE QUERY CUANDO LA VENTA NO SE HAYA TERMINADO O COBRADO*/	
	if($_GET['sv']!=1){
    $cProdVenta=mysql_query("
							SELECT
							/*SUM(A.CANTIDAD_VEN) AS CANTIDAD,*/
							A.CANTIDAD_VEN AS CANTIDAD,
							A.ID_PRODUCTO,
             				A.ID_VENTA_SALIDA,
							B.NOMBRE_PRODUCTO,
							B.PRECIO_VENTA AS PRECIO,
							B.PORCENTAJE_IMPUESTO,
            				C.TIPO_PRES_PROD,
              				D.ACRONIMO AS UM,
							B.DESCUENTO,
							A.PRECIO_VENTA AS IMPORTE
							/*SUM(B.PRECIO_FINAL) AS IMPORTE*/
							FROM ventas_salidas A
							INNER JOIN productos B
							ON A.ID_PRODUCTO=B.ID_PRODUCTO
							INNER JOIN CAT_TIPO_PRES_PROD C
							ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
							LEFT OUTER JOIN CAT_UNIDAD_MEDIDA D
							ON B.ID_UNIDAD_MEDIDA=D.ID_UNIDAD_MEDIDA
							WHERE A.CVE_VENTA='$clave_venta'
							AND A.ID_ESTATUS_VENTA=3
							/*GROUP BY A.ID_PRODUCTO */
							ORDER BY A.ID_VENTA_SALIDA DESC;

							")
	or die("No se pudo consultar la lista de los productos vendidos (2). <br/>".mysql_error());
	}
	$SumT=0;
	
    while($dProdVenta=mysql_fetch_array($cProdVenta)){
	?>   
  <tr>
    <td align="center"><?php echo $dProdVenta['CANTIDAD']; ?></td>
    <td><?php echo $dProdVenta['NOMBRE_PRODUCTO']; ?></td>
    <td align="right">
      <?php echo $dProdVenta['PORCENTAJE_IMPUESTO']; ?></td>
    <td align="right"><?php echo  number_format($dProdVenta['DESCUENTO'],2); ?></td>
    <td align="right">
	<?php	
	
       $aux=$dProdVenta['TIPO_PRES_PROD'];
	   
	  if($aux=="RECARGA"){
		 $presUnit=$dProdVenta['CANTIDAD'];
		 $SumT1=$SumT1+$presUnit;
		 echo number_format($presUnit,2);
		 }else{
	   
	if($aux=="A GRANEL"){
		 $SumT1=$SumT1+$dProdVenta['IMPORTE'];
		/*echo number_format($presUnit,2);*/
		 echo number_format($dProdVenta['IMPORTE'],2);
		}
		if($aux!="A GRANEL"){
			 echo number_format($dProdVenta['IMPORTE'],2); 
			 $SumT2=$SumT2+$dProdVenta['IMPORTE'];
			 }
		 }
			 //DECLARO ESTAS VARIABLES AUXILIARES PARA PODERLAS CONSULTAR EN EL TOTAL DE LA VENTA
			  $cantAux=$dProdVenta['CANTIDAD'];
			  $tipo_prodAux=$dProdVenta['TIPO_PRES_PROD'];
			  $idProdAux=$dProdVenta['ID_PRODUCTO'];
			  $importeAux=$dProdVenta['IMPORTE'];
			 /* FIN DE LAS VRIABLES AUXILIARES  */
			  $SumT=$SumT1+$SumT2;
			
	?>

	</td>
    <td align="center" valign="middle">
	<?php if($_GET['sv']!=1){ ?>
    <a href="quitar_producto.php?i=<?php echo $dProdVenta['ID_VENTA_SALIDA']?>&cve=<?php echo $clave_venta; ?>&r=2">
    <img src="../imagenes/x.png" width="13" height="13" /></a>
    <?php } ?>
    </td>
   </tr>

   <?php   
   }  ?>

 </table>

 </div> 
 <!-- FIN <div class="lista_productos_vendidos">-->
 <div class="datos_venta">
 
 <?php 
 
  if($_GET['sv']==1){
	  $bloquear='disabled="disabled"';
  }
  ?>
 
 <form action="insert_venta.php" method="post">
 <table width="100%" border="0">
  <?
	$cSinCobrar=mysql_query("SELECT COUNT(DISTINCT CVE_VENTA) FROM ventas_salidas WHERE ID_ESTATUS_VENTA=3 AND ID_ESTABLECIMIENTO=1;")
	or die("No se pudieron consultar los tikets sin cobrar. <br/>".mysql_error());
	$dSinCobrar=mysql_fetch_array($cSinCobrar);
	$cont=$dSinCobrar['COUNT(DISTINCT CVE_VENTA)'];
	if($cont>=1){
		?>
  <tr>
  
    <td colspan="3" align="center" valign="middle" > <img src="../imagenes/atencion.png" width="20" height="18" /> <a class="atencion" href="sin_cobrar.php">  
<?php  echo "Hay $cont nota(s) sin cobrar"; ?>
      </a>
    </td>
    </tr>
    <?php 	} ?>
  <tr>
    <td colspan="3" align="center" valign="middle" class="pantalla_total"  >$<?php 	
	$totalSuma=$SumT;
	echo $totalSuma;
	
	?></td>
    </tr>
  
    
 <!-- ---------------------------------------------------------------------------  -->
 
 <?php 
	if($_GET['sv']==1){
	?>
  <tr>
    <td align="right">EFECTIVO:</td>
    <td colspan="2" align="center"  class="pantalla_total"><?php $ef=$_GET['e']; echo "$ $ef"; ?></td>
    </tr>
  <?php } 
  if($_GET['sv']==1){
	?>
 
  <tr>
    <td width="40%" align="right">CAMBIO:</td>
    <td colspan="2" align="center"  class="pantalla_total">
      <?php 
	if($_GET['sv']==1){
		$cambio=$_GET['c'];
		echo "$ ".number_format($cambio,2);
		
		?>    </td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="center">
    <a href="fn.php?i=<?php echo base64_encode(1); ?>&cve=<?php echo base64_encode($clave_venta); ?>%&r=<?php echo base64_encode($ef); ?>&c=<?php echo base64_encode($cambio); ?>" target="_blank" style="text-decoration:none;">
    <div class="bot_nota_factura">Ver Ticket</div>
    </a>
    </td>
  </tr>
  <?php }
	?>
  <tr>
  <td colspan="3" align="center"><a class="button" href="index.php">NUEVA VENTA</a></td>
    </tr>
  <?php } ?>
 
 <!-- ------------------------------------------------------------------------------------  -->
 

 
  </table><!-- FIN <div class="esp_entracod"> -->

 </form>
 <form  id="fields-in-call" name="form1" method="post" action="cobrar.php">
   <div class="esp_efectivo">
  <?php  if($_GET['sv']!=1){ ?>
  <table width="100%" border="0">
  <tr>
    <td colspan="3" align="center">
    <select name="id_cliente" style="border-radius:5px;">
    <?php  
	$q_id_cliente=mysql_query("
SELECT
ID_ESTABLECIMIENTO,
RAZON_SOCIAL
FROM establecimiento
WHERE ID_TIPO_ESTABLECIMIENTO=3
AND ID_MATRIZ=$id_establecimiento
AND ID_ESTATUS_ACTIVO=1;
	")
	or die("No se pudieron mostrar los clientes.<br/>".mysql_error());
	
	while($d_id_cliente=mysql_fetch_array($q_id_cliente)){
	?>
      <option value="<?php echo $d_id_cliente['ID_ESTABLECIMIENTO']; ?>"><?php echo $d_id_cliente['RAZON_SOCIAL']; ?></option>
    <?php 
	}
	 ?> 
    </select>
    </td>
    </tr>
  <tr>
    <td width="37%" align="right">EFECTIVO:</td>
    <td width="42%"><label>
    
      <input style="height:40px; width:100px; font-size:30px;" type="text" required="required"  name="cant_efectivo" id="cant_efectivo" <?php echo $bloquear; ?> placeholder="$" onkeypress="return justNumbers(event);" />
      
      
    </label></td>
    <td width="21%"><label>
      <input type="submit" name="button"  value="COBRAR" <?php echo $bloquear; ?> />
    </label>
    <input name="totalVenta"  id="totalVenta"type="hidden" value="<?php echo $totalSuma; ?>" />
      <input type="hidden" name="clave_venta" id="hiddenField" value="<?php echo $clave_venta; ?>" />
   </td>
  </tr>
   <script type="text/javascript">
		$('#fields-in-call').ketchup({}, {
		  '.required'    : 'required',              //all fields in the form with the class 'required'
		  //'#nombre': 'username', //one field in the form with the id 'fic-username'
		  //'#ap_pat': 'username, minlength(3)',
		  '#cant_efectivo': 'number'
		  //'#anio_nac': 'min(4),digits'
		  //'#calle': 'username, minlength(3)',
		  //'#num_exter': 'username, minlength(3)',
		  //'#num_inter': 'username, minlength(3)'
		});
    </script>
    <script type="text/javascript">
		$('#fields-in-call2').ketchup({}, {
		  '.required'    : 'required',              //all fields in the form with the class 'required'
		  //'#nombre': 'username', //one field in the form with the id 'fic-username'
		  //'#ap_pat': 'username, minlength(3)',
		  '#precioAgranel': 'number',
		  '#cantGr': 'min(10)'
		  //'#calle': 'username, minlength(3)',
		  //'#num_exter': 'username, minlength(3)',
		  //'#num_inter': 'username, minlength(3)'
		});
    </script>
</table >
<?php } ?>
</div><!-- FIN <div class="esp_efectivo"> -->
</form>
<!-- </form>-->

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
 </div>  
 <!--FIN <div class="datos_venta">-->
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
