<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nom_negocio;  ?></title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="../css/barra_titulos.css" type="text/css"> 
<link rel="stylesheet" href="css/formulario.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

<!--INICIO VALIDADOR DE CAMPOS -->

<!--'<script type="text/javascript" src="js/lv.js"></script>-->

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
				document.getElementById('razon_social').focus();
				}
        </script>
        
        
 <style type="text/css">

.eliminar{
	text-align:center;
	color:#FFF;
	background:#F90;
	display:block;
	border-radius:5px;}
.eliminar:hover{
	background:#F00;
	}
</style>
	
</head>


<body onload="jsselect()">
<div class="espacio_menu">
<ul id="menu">
         
    <li class="menu_right"><a href="../aut_logout.php" >CERRAR SESIÓN</a></li>
          <li class="menu_right menu_activo">ALTAS<!-- Begin 3 columns Item -->
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
    <li class="menu_right"><a href="index.php" >PUNTO DE VENTA</a></li>
 		 <!--<a href="index.php"          ><li class="menu_right menu_activo">PUNTO DE VENTA</li></a>-->  
  </ul>
</div>

<div class="contenedor">
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">

<fieldset>
<legend>ALTA DE CLIENTES</legend>

<form action="insert_proveedor.php" method="post">
<table width="100%" border="0">
  <tr>
    <td width="19%" align="right" valign="top">NOMBRE:</td>
    <td width="29%" align="left" valign="top"><input name="razon_social" type="text" id="razon_social" size="40"  onchange="javascript:this.value=this.value.toUpperCase();" required="required"  autofocus="autofocus"/></td>
    <td width="5%" align="left" valign="top">&nbsp;</td>
    <td width="18%" align="right" valign="top">&nbsp;</td>
    <td width="29%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top">CORREO ELECTRÓNICO:</td>
    <td align="left" valign="top"><input name="e_mail" type="email" id="e_mail" size="40" required="required"/></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">TELEFONO:</td>
    <td align="left" valign="top"><label for="telefono"></label>
      <input type="number" name="telefono" id="telefono" /></td>
  </tr>
  <tr>
    <td align="right" valign="top">RFC:</td>
    <td align="left" valign="top"><input name="rfc" type="text" id="rfc" size="40"  onchange="javascript:this.value=this.value.toUpperCase();" required="required" /></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">OBSERVACIONES:</td>
    <td align="left" valign="top"><textarea name="observaciones" cols="40" rows="3" id="observaciones"   onchange="javascript:this.value=this.value.toUpperCase();" ></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center" valign="top"><label>
      <input name="tipo_establecimiento" id="tipo_establecimiento" type="hidden" value="3" />
      <input type="submit" name="button" id="button" value="GUARDAR" />
      </label></td>
  </tr>
</table>
</form>
</fieldset>
<p></p>
<table width="100%" border="1" class="propTabla">
  <tr class="bgtabla">
    <td width="2%">&nbsp;</td>
    <td width="24%">CLIENTE</td>
    <td width="12%">RFC</td>
    <td width="12%">CORREO ELECTRÓNICO</td>
    <td width="12%">TELEFONO</td>
    <td width="13%">OBSERVACIONES</td>
    <td width="7%">&nbsp;</td>
  </tr>
 <?php
 
 if($_SESSION['SESSION_GRUPO']=='USUARIO DE CAPTURA'){
	 $cambiar='readonly="readonly"';
	 $habilitarBot='disabled="disabled"';
	 }else{$cambiar=''; $habilitarBot='';}
 
 $cProveedores=mysql_query("
						SELECT
						ID_ESTABLECIMIENTO,
						RAZON_SOCIAL,
						RFC,
						E_MAIL,
						CONCAT(CALLE,' NO. ',NUMERO) AS DIRECCION_FISCAL,
						TELEFONO,
						OBSERVACIONES
						FROM establecimiento
						WHERE ID_MATRIZ=$id_establecimiento
						AND ID_ESTATUS_ACTIVO=1
						AND ID_TIPO_ESTABLECIMIENTO=3;
						 
	          ")or die("No se pudo consultar los datos de los proveedores. ".mysql_error());
 
 
 while($dP=mysql_fetch_array($cProveedores)){
	 
	 	
		
 
 ?>
 
  
  <tr class="hover_lista">
    <td title="Eliminar"><a href="confirmar_eliminar.php?te=3&i=<?php echo $dP['ID_ESTABLECIMIENTO']; ?>" style="text-decoration:none;"><div class="eliminar">
   X
   </div></a></td>
    <form name="form" action="update_proveedor.php" method="post">
      <td><input class="bordes_formulario ancho_form" name="rz" type="text" <?php echo $cambiar; ?> value="<?php echo $dP['RAZON_SOCIAL']; ?>"
    onchange="javascript:this.value=this.value.toUpperCase();"/></td>
      <td align="center"><label for="rfc"></label>
        <input type="text" name="rfc" id="rfc" style="width:97%;" value="<?php echo $dP['RFC']; ?>" onchange="javascript:this.value=this.value.toUpperCase();"/></td>
      <td align="center"><input class="bordes_formulario ancho_form" name="e_mailtb" type="text" <?php echo $cambiar; ?>  value="<?php echo $dP['E_MAIL']; ?>" 
    onchange="javascript:this.value=this.value.toUpperCase();"  style="width:97%;"/></td>
      <td align="center"><input class="bordes_formulario ancho_form" name="teltb" type="text" <?php echo $cambiar; ?>   value="<?php echo $dP['TELEFONO']; ?>"
    onchange="javascript:this.value=this.value.toUpperCase();" style="width:97%;" /></td>
      <td align="center"><textarea name="observ" rows="1" class="bordes_formulario ancho_form" <?php echo $cambiar; ?>="<?php echo $cambiar; ?>" onchange="javascript:this.value=this.value.toUpperCase();"><?php echo $dP['OBSERVACIONES']; ?></textarea>
        </td>
      <td align="center" valign="middle"><label>
      <?php if($dP['RAZON_SOCIAL']=="CLIENTE DE MOSTRADOR"){ /*No muestra el botón*/ }
	   else{
		  		echo '<input type="submit" name="modificar" id="modificar" value="Modificar" '.$habilitarBot.'/>';
		  } ?>  
        <input name="tipo_establecimiento" id="tipo_establecimiento" type="hidden" value="3" />
        <input type="hidden" name="id_proveedor" id="hiddenField"  value="<?php echo $dP['ID_ESTABLECIMIENTO']; ?>"/>
        </label></td>
    </form>
  </tr>
  

  <?php
  	}
  ?>
  
  <tr class="bgtabla">
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
