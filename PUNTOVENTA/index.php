<?php require("../aut_verifica.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_SESSION['SESSION_ID_PERSONA'];
if($_GET['cv']!=""){
$clave_venta=$_GET['cv'];
}



/*INICIO PARA GENERAR LA SIGUIENTE CLAVE DE TICKET*/

/*CONSULTAMOS LA ULTIMA CLAVE DE TICKET GENERADA*/
if($_GET['sv']==""&&$_GET['cv']==""){ /*SI NO SE HAN MANDADO DATOS POR LA URL DE LA CLAVE DEL TICKET GENERAMOS LA NUEVA CLAVE*/
$ccveVenta=mysql_query("
			  SELECT CVE_VENTA FROM ventas_salidas WHERE ID_ESTABLECIMIENTO=$id_establecimiento ORDER BY ID_VENTA_SALIDA DESC LIMIT 1
			  ")
or die("Error al consultar la ultima clave. <br/>".mysql_error());
$dcveVenta=mysql_fetch_array($ccveVenta);
$UltimacveVenta=$dcveVenta['CVE_VENTA'];/*ultima clave de ticket guardada en la base de datos*/
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

$clave_venta=$arreglo[0]."-".$arreglo[1];  /*PROXIMA CLAVE DE TICKET A INSERTAR EN LA SIGUIENTE VENTA*/
/*echo "NUEVA CLAVE:  $clave_venta";*/
/*echo "LA NUEVA CLAVE ES: $clave_venta <br/>";*/
}
/*FIN PARA GENERAR LA SIGUIENTE CLAVE DE TICKET*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nom_negocio;  ?></title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<script language=Javascript>
     function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
   </script>
   
 <style type="text/css">
		.bot_nota_factura{
			padding:5px;
			background:#13CE21;
			color:#FFF;}
		.bot_nota_factura:hover{
			background:#41E24D;}
  </style>
   
   
   <!--FANCYBOX-->    
      <script>
		!window.jQuery && document.write('<script src="../fancybox/jquery-1.4.3.min.js"><\/script>');
	 </script>
   
    <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />	
	
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
         <li class="menu_right"><a href="corte_diario_t.php" >CORTE DIARIO</a></li>
         
        
                <!-- End 3 columns Item -->
	     <li class="menu_right menu_activo"><a href="index.php" >PUNTO DE VENTA</a></li>
 		 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
  </ul>
</div>

<div class="contenedor">

<div class="lista_productos_vendidos">
 <table width="100%" border="1"  class="propTabla">
  <tr class="bgtabla">
    <td width="10%" align="center" valign="middle">Cant.</td>
    <td width="54%" align="center" valign="middle">Descripción</td>
    <td width="7%" align="center" valign="middle">$ Unit.</td>
    <td width="7%" align="center" valign="middle">% Imp.</td>
    <td width="7%" align="center" valign="middle">% Desc.</td>
    <td width="9%" align="center" valign="middle">$ Importe</td>
    <td width="5%" align="center" valign="middle">&nbsp;</td>
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
							B.DESCRIPCION,
							B.NOMBRE_PRODUCTO,
							B.PRECIO_VENTA AS PRECIO_LISTA,
            				C.TIPO_PRES_PROD,
              				D.ACRONIMO AS UM,
							B.DESCUENTO,
							/*SUM(B.PRECIO_FINAL) AS IMPORTE*/
							A.PRECIO_VENTA AS IMPORTE
							FROM ventas_salidas A
							INNER JOIN productos B
							ON A.ID_PRODUCTO=B.ID_PRODUCTO
							INNER JOIN cat_tipo_pres_prod C
							ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
							LEFT OUTER JOIN cat_unidad_medida D
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
							CVE_PRODUCTO,
							/*SUM(A.CANTIDAD_VEN) AS CANTIDAD,*/
							A.CANTIDAD_VEN AS CANTIDAD,
							A.ID_PRODUCTO,
             				A.ID_VENTA_SALIDA,
							B.DESCRIPCION,
							B.NOMBRE_PRODUCTO,
							B.PRECIO_FINAL AS PRECIO_LISTA,
							B.PRECIO_VENTA AS PRECIO,
							B.PORCENTAJE_IMPUESTO,
            				C.TIPO_PRES_PROD,
              				D.ACRONIMO AS UM,
							A.DESCUENTO,
							A.PRECIO_VENTA AS IMPORTE
							/*SUM(B.PRECIO_FINAL) AS IMPORTE*/
							FROM ventas_salidas A
							INNER JOIN productos B
							ON A.ID_PRODUCTO=B.ID_PRODUCTO
							INNER JOIN cat_tipo_pres_prod C
							ON B.ID_TIPO_PRES_PROD=C.ID_TIPO_PRES_PROD
							LEFT OUTER JOIN cat_unidad_medida D
							ON B.ID_UNIDAD_MEDIDA=D.ID_UNIDAD_MEDIDA
							WHERE A.CVE_VENTA='$clave_venta'
              AND A.ID_ESTATUS_VENTA=3
              OR A.CVE_VENTA='$clave_venta'
              AND A.ID_ESTATUS_VENTA=4
							/*GROUP BY A.ID_PRODUCTO */
							ORDER BY A.ID_VENTA_SALIDA DESC;

							")
	or die("No se pudo consultar la lista de los productos vendidos (2). <br/>".mysql_error());
	}
	$SumT=0;
	
    while($dProdVenta=mysql_fetch_array($cProdVenta)){
		$precio_lista=$dProdVenta['PRECIO_LISTA'];
	?>   
  <tr class="hover_lista">
   <form action="update_desc.php" method="post">
    <td align="center"><input type="number" min="0" max="" name="cantidad" value="<?php echo $dProdVenta['CANTIDAD']; ?>"></td>
    <td><?php echo $dProdVenta['DESCRIPCION'];   ?></td>
    <td align="right"><input type="text" min="0" max="" style="width: 60px" name="precio_l" value="<?php echo number_format($dProdVenta['PRECIO_LISTA'],2); ?>"></td>
    <td align="right">
      <?php echo $dProdVenta['PORCENTAJE_IMPUESTO']; ?>
    </td>
    <td align="right"><label>
   
      <input name="desc" min="0" max="10" type="number" id="desc"  style="text-align:center;width:90%; height:90%;" value="<?php echo  number_format($dProdVenta['DESCUENTO'],0); ?>"/>
      <input name="id_venta_salida" type="hidden" value="<?php echo $dProdVenta['ID_VENTA_SALIDA']; ?>" />
     <input name="pre_vent" type="hidden" value="<?php echo $dProdVenta['PRECIO_LISTA']; ?>" />
    <input name="id_prod" type="hidden" value="<?php echo $dProdVenta['ID_PRODUCTO']; ?>" />
    <input name="cv" type="hidden" value="<?php echo $clave_venta; ?>" />
      <input style="width:100%; height:30px; font-size:8px;" type="submit" min="0" name="g" id="g" value="Guardar %"
      
       />
    </form>
    </label>      
      <?php /*echo  number_format($dProdVenta['DESCUENTO'],2);*/ ?></td>
    <td align="center"><?php	
	
       $aux=$dProdVenta['TIPO_PRES_PROD'];
	   
	  if($aux=="RECARGA"){
		 $presUnit=$dProdVenta['CANTIDAD'];
		 $SumT1=$SumT1+$presUnit;
		 /*echo number_format($presUnit,2);*/
		 ?>
      <form action="upd_precio_salida.php" method="post">
        <input name="prec_final_salida" type="text"  value="<?php echo $presUnit;  ?>" style="width:90%;"/>
        <input name="id_venta_salida" type="hidden" value="<?php echo $dProdVenta['ID_VENTA_SALIDA']; ?>" />
        <input name="cv" type="hidden" value="<?php echo $clave_venta; ?>" />
        <input name="" type="submit" value="cambiar" style="width:100%; height:30px; font-size:8px;"/>
        </form>
      <?php 
		 }else{
	   
	if($aux=="A GRANEL"){
		$presUnit=($dProdVenta['PRECIO_LISTA']/1000)*$dProdVenta['CANTIDAD'];
			
			  $SumT1=$SumT1+$presUnit;
		/*echo number_format($presUnit,2);*/
		 /*echo number_format($dProdVenta['IMPORTE'],2);*/
		 ?>
      <form action="upd_precio_salida.php" method="post">
        <input name="prec_final_salida" type="text"  value="<?php echo $presUnit;  ?>" style="width:90%;"/>
        <input name="id_venta_salida" type="hidden" value="<?php echo $dProdVenta['ID_VENTA_SALIDA']; ?>" />
        <input name="cv" type="hidden" value="<?php echo $clave_venta; ?>" />
        <input name="" type="submit" value="cambiar" style="width:100%; height:30px; font-size:8px;"/>
        </form>
      <?php 
		}
		if($aux!="A GRANEL"){
			 /*echo number_format($dProdVenta['IMPORTE'],2);*/
			 ?>
      <form action="upd_precio_salida.php" method="post">
        <input name="prec_final_salida" type="text"  value="<?php echo $dProdVenta['IMPORTE'];  ?>" style="width:90%;"/>
        <input name="id_venta_salida" type="hidden" value="<?php echo $dProdVenta['ID_VENTA_SALIDA']; ?>" />
        <input name="cv" type="hidden" value="<?php echo $clave_venta; ?>" />
        <input name="" type="submit" value="cambiar" style="width:100%; height:30px; font-size:8px;" />
        </form>
      <?php 
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
      <a href="quitar_producto.php?i=<?php echo $dProdVenta['ID_VENTA_SALIDA']?>&cve=<?php echo $clave_venta; ?>&r=1">
        <img src="../imagenes/x.png" width="13" height="13" /></a>
      <?php } ?>
    </td>
    
   </tr>

   <?php   
   }  ?>

 </table>
 <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
 </div>









<div class="datos_venta">
 
 <?php 
  if($_GET['sv']==1){
	  $bloquear='disabled="disabled"';
  }
  ?>
 
 
 <table width="100%" border="0">
  <?
	$cSinCobrar=mysql_query("SELECT COUNT(DISTINCT CVE_VENTA) FROM ventas_salidas WHERE ID_ESTATUS_VENTA=3 AND ID_PERSONA=$id_persona AND ID_ESTABLECIMIENTO=$id_establecimiento ;")
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
  <?php }
	?>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="3" align="center">
    <a href="fn.php?i=<?php echo base64_encode(1); ?>&cve=<?php echo base64_encode($clave_venta); ?>%&r=<?php echo base64_encode($ef); ?>&c=<?php echo base64_encode($cambio); ?>" target="_blank" style="text-decoration:none;">
    <div class="bot_nota_factura">Ver Ticket</div>
    </a>
    </td>
  </tr>
  
  <!--<tr>
    <td colspan="3" align="center">
    <a href="fn.php?i=<?php /*echo base64_encode(1);*/ ?>&cve=<?php /*echo base64_encode($clave_venta);*/ ?>%&r=<?php /*echo base64_encode($ef);*/ ?>&c=<?php /*echo base64_encode($cambio);*/ ?>" target="_blank" style="text-decoration:none;">
    <div class="bot_nota_factura">Imprimir nota con productos sin impuesto</div>
    </a>
    </td>
  </tr>-->
  
  <!--<tr>
    <td colspan="3" align="center">
    <a href="fn.php?i=<?php /*echo base64_encode(1);*/ ?>&cve=<?php /*echo base64_encode($clave_venta);*/ ?>%&r=<?php /*echo base64_encode($ef);*/ ?>&c=<?php /*echo base64_encode($cambio);*/ ?>" target="_blank" style="text-decoration:none;">
    <div class="bot_nota_factura">Imprimir prefactura con productos con impuesto</div>
    </a>
    </td>
  </tr>-->
  
  <!--<tr>
    <td colspan="3" align="center">
    <a href="fn.php?i=<?php /*echo base64_encode(2);*/ ?>" target="_blank" style="text-decoration:none;">
    <div class="bot_nota_factura">Imprimir nota con productos sin impuesto</div>
    </a>
    </td>
  </tr>-->
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3" align="center"><a class="button" href="index.php">NUEVA VENTA</a></td>
    </tr>
  <?php } ?>
 
 <!-- ------------------------------------------------------------------------------------  -->
  <?php 
  if($_GET['sv']!=1){ ?>
  <tr>
    <td colspan="3" align="center">
    <a style="text-decoration:none;" href="buscar.php?clave_venta=<?php echo $clave_venta; ?>">
       <div class="bot_buscar"> 
        <div class="im_bus ">
          <img src="../imagenes/buscar3.png"/></div>
        <div class="texto_buscar">
        BUSCAR PRODUCTO 
        </div>
         </div>
    </a>
    
    </td>
  </tr>
<?php } ?> 

 
  </table>
 <form action="insert_venta.php" method="post">
 <div class="esp_entracod">
 <?php  if($_GET['sv']!=1){ ?>
 <table width="100%" border="0" style="height:60px;">
  <tr>
    <td align="right">TIPO DE VENTA:</td>
    <td>
    <p>
      <!-- <input type="radio" name="id_estatus_venta" value="1" required>V<br>
      <input type="radio" name="id_estatus_venta" value="2"> DV<br>-->
      <input type="radio" name="id_estatus_venta" value="3" required> NORMAL<br><br> 
      <input type="radio" name="id_estatus_venta" value="4" required> MI AMOR
    </p>
  </td>
  </tr>
  <tr>
    <td width="37%" align="right">
    <input name="clave_venta" type="hidden" value="<?php echo $clave_venta; ?>" />
    ENTRA CÓDIGO:</td>
    <td width="40%"><label>
      <input type="text" required name="entra_codigo" id="entra_codigo" <?php echo $bloquear; ?> class="required" onchange="javascript:this.value=this.value.toUpperCase();" autofocus="autofocus" />
      </label>
      <script type="text/javascript">
		            var entra_codigo = new LiveValidation('entra_codigo');
		            entra_codigo.add(Validate.Presence);
		          </script>  
      
      </td>
   <td width="23%"><input type="submit" name="agregar" id="agregar" <?php echo $bloquear; ?> value="AGREGAR" /></td>
  </tr>
</table>
<?php } ?>
 </div><!-- FIN <div class="esp_entracod"> -->
</form>

<form  id="fields-in-call2" action="insert_venta_granel.php" method="post">
<div class="esp_estraGranel">
 <?php  if($_GET['sv']!=1){ ?>
<table width="100%" border="0" height="80px;">
  <tr>
    <td width="37%" align="right">PRODUCTOS A GRANEL:</td>
    <td width="42%"><label>
      <input type="text" name="codigo_granel" id="codigo_granel" <?php echo $bloquear; ?>  placeholder="Código a granel"/>
      <script type="text/javascript">
		            var codigo_granel = new LiveValidation('codigo_granel');
		            codigo_granel.add(Validate.Presence);
		          </script>  
      <input name="cantGr" type="number" min="0" id="cantGr" size="4" <?php echo $bloquear; ?>  style="text-align:right; width:80px;" onkeypress="return justNumbers(event);" placeholder="Cantidad gr." />
      Gr.
      <script type="text/javascript">
		            var cantGr = new LiveValidation('cantGr');
		            cantGr.add(Validate.Presence);
					cantGr.add( Validate.Numericality, { minimum: 250 } );
		          </script>  
      <input name="clave_venta" type="hidden" value="<?php echo $clave_venta; ?>" />
      </label></td>
    <td width="21%"><label>
      <input type="submit" name="bot2" id="bot2" value="AGREGAR"  <?php echo $bloquear; ?>/>
      </label></td>
  </tr>
  </table>
  <?php } ?>
</div> <!-- FIN <div class="esp_estraGranel">  -->
</form>

<form  id="form3" name="form3" method="post" action="insert_venta_recarga.php">
 <div class="esp_recarga">
  <?php  if(1==2){ ?>
  <table width="100%" border="0" style="height:60px;">
  <tr>
    <td width="37%" align="right">RECARGA:</td>
    <td width="42%"><label>
    
    <?php 
	$cRecargas=mysql_query("
     			SELECT
				A.ID_PRODUCTO,
				A.DESCRIPCION
				FROM productos A
				INNER JOIN cat_tipos_producto B
				ON A.ID_TIPO_PRODUCTO=B.ID_TIPO_PRODUCTO
				AND B.TIPO_PRODUCTO='RECARGAS'
				; ")or die("No se pudieron consultar la lista de los proveedores de recargas. <br>".mysql_error());
	
	?>
    
<select name="id_recarga">
<?php while($dRecargas=mysql_fetch_array($cRecargas)){ ?>
  <option value="<?php echo $dRecargas['ID_PRODUCTO']; ?>"><?php echo $dRecargas['DESCRIPCION']; ?></option>  
  <?php } ?> 
</select> 
</label>
$<input name="cantRecarga" type="text" id="cantRecarga" size="2" <?php echo $bloquear; ?>  style="text-align:right" onkeypress="return justNumbers(event);"  />
 			      <script type="text/javascript">
		            var cantGr = new LiveValidation('cantRecarga');
		            cantGr.add(Validate.Presence);
					
		          </script>  
    </td>
    <td width="21%"><label>
      <input type="submit" name="button"  value="AGREGAR" <?php echo $bloquear; ?> />
      <input name="clave_venta" type="hidden" value="<?php echo $clave_venta; ?>" />
    </label>
      
   </td>
  </tr>


</table >
<?php } ?>
</div><!-- FIN <div class="esp_efectivo"> -->
</form>

 <form  id="fields-in-call" name="form1" method="post" action="cobrar.php">
 <div class="esp_efectivo">
  <?php  if($_GET['sv']!=1){ ?>
  <table width="100%" border="0" style="height:60px;">
    
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
      <input style="height:40px; width:100px; font-size:30px;" type="text" required="required"  name="cant_efectivo" id="cant_efectivo" <?php echo $bloquear; ?> placeholder="$" onkeypress="return justNumbers(event);"  />
      <script type="text/javascript">
		            var cant_efectivo = new LiveValidation('cant_efectivo');
		            cant_efectivo.add(Validate.Presence);
					cant_efectivo.add( Validate.Numericality, { minimum: 1 } );
					cant_efectivo.add( Validate.Numericality );
		          </script>  
    </label></td>
    <td width="21%"><label>
      <input type="submit" name="button"  value="COBRAR" <?php echo $bloquear; ?> />
    </label>
    <input name="totalVenta"  id="totalVenta"type="hidden" value="<?php echo $totalSuma; ?>" />
      <input type="hidden" name="clave_venta" id="hiddenField" value="<?php echo $clave_venta; ?>" />
   </td>
  </tr>


</table >
<?php } ?>
</div><!-- FIN <div class="esp_efectivo"> -->
</form>
<!-- </form>-->
<style type="text/css">
.st_link{text-decoration:none;
	color:#FFF;}
.bot_salida{
	background:#6F6;
	color:#FFF; width:100%;
	padding-top:20px;
	padding-bottom:20px;
	text-align:center;}
.bot_salida:active{
	background:#6F6;}
</style>
<script type="text/javascript">
		$(document).ready(function() {		
			$("#SALIDA").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
		});
	</script>
<a href="nota_salida.php?c=<?php echo base64_encode($clave_venta) ?>" id="SALIDA" class="st_link">
<div class="bot_salida">
SALIDA DE MERCANCIA
</div>
</a>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
 </div>
 
 <!-- ************************** Inicio de info del establecimiento y usuario que inició sesión ********************** -->

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

<?php
  
if($_GET['entra_c']!=''){
  ?>
    <script>
      document.getElementById('entra_codigo').value = '<?php echo $_GET['entra_c']; ?>';
    </script>
  <?php
}elseif($_GET['entra_c']==''){
?>
<script>
  document.getElementById('entra_codigo').value = '';
</script>
<?php
}
?>
 
</body>
</html>