<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MODIFICAR DATOS</title>
<link rel="stylesheet" href="../PUNTOVENTA/css/1estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css"> 

<link rel="stylesheet" type="text/css" media="screen" href="../validador/css/jquery.ketchup.css" />
    
<script type="text/javascript" src="../select_dependientes.js"></script>
<script type="text/javascript" src="../validador/assets/js/jquery.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.validations.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.helpers.js"></script>
<script type="text/javascript" src="../validador/docs/js/scaffold.js"></script>

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
	<script type="text/javascript" language="javascript">
$(window).load(function(){

 $(function() {
  $('#file-input').change(function(e) {
      addImage(e); 
     });

     function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;
    
      if (!file.type.match(imageType))
       return;
  
      var reader = new FileReader();
      reader.onload = fileOnload;
      reader.readAsDataURL(file);
     }
  
     function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
	 
     }
    });
  });
</script>

    
    
    	
</head>
<?php

if ($_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA"){
?>
<script language="javascript"> 
alert
('¡No tienes privilegios para realizar esta acción!'); 
 history.back(1);
</script>
<?php
exit;
}

?>
<body>
<div class="espacio_menu">
		<ul id="menu">
        <li class="menu_right"><a href="../aut_logout.php" class="drop">CERRAR SESIÓN</a><!-- Begin 3 columns Item -->   </li>
        <li class="menu_right"><a  class="drop">USUARIOS DE SISTEMA</a><!-- Begin 3 columns Item -->
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
            <div class="col_1">
                <ul class="greybox">
                    <li><a href="clave.php" id="CLAVE">NUEVO USUARIO</a></li>
                    <li><a href="lista_usuarios.php">LISTA DE USUARIOS</a></li>
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li><!-- End 3 columns Item -->
    <li class="menu_right menu_activo"><a class="drop">EMPLEADOS</a><!-- Begin 3 columns Item -->
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
            <div class="col_1">
                <ul class="greybox">
                	 <li><a href="empleados_deshabilitados.php">EMP. DESHABILITADOS</a></li>
                     <li><a href="alta_empleado.php">NUEVO EMPLEADO</a></li>
                     <li><a href="lista_empleados.php">LISTA DE EMPLEADOS</a></li>
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a></li>
</ul>
</div>

<div class="contenedor">
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_back"><a href="lista_empleados.php"><img src="../imagenes/back.png"/></a></div>
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>MODIFICAR DATOS</strong></div>

</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">

<div>

<?php
$cve_persona=$_GET['emp_cue'];
$cDatos=mysql_query("
SELECT
A.ID_PERSONA,
/*A.CUE,*/
A.AP_PATERNO,
A.AP_MATERNO,
A.NOMBRE,
DATE_FORMAT(A.FECHA_NAC,'%d') AS DN,
DATE_FORMAT(A.FECHA_NAC,'%m') AS MN,
DATE_FORMAT(A.FECHA_NAC,'%Y') AS YN,
A.TELEFONO,
A.E_MAIL,
B.TIPO_TELEFONO,
C.TIPO_PERSONA,
DATE_FORMAT(A.FECHA_INGRESO,'%d') AS DI,
DATE_FORMAT(A.FECHA_INGRESO,'%m') AS MI,
DATE_FORMAT(A.FECHA_INGRESO,'%Y') AS YI
FROM persona A
INNER JOIN cat_tipo_telefono B
ON A.ID_TIPO_TELEFONO = B.ID_TIPO_TELEFONO
INNER JOIN cat_tipo_empleado C
ON A.ID_TIPO_PERSONA=C.ID_TIPO_PERSONA
WHERE CUE='$cve_persona';")
or die("No se pudo hacer la consulta de los datos. <br/>".mysql_error());
$datos=mysql_fetch_array($cDatos)

?>
<form id="fields-in-call" name="form1" method="post" action="update_empleado.php" enctype="multipart/form-data">

<fieldset>
<legend><strong>DATOS PERSONALES</strong></legend>

<table width="100%" border="0">
  <tr>
    <td width="209" align="left">NOMBRE:<br/><input type="text" value="<?php echo $datos['NOMBRE']; ?>" name="nombre"  class="required" id="nombre" onchange="javascript:this.value=this.value.toUpperCase();"  />   </td>
    <td width="319" rowspan="2" align="center"> </td>
    <td width="114" align="left"></td>
    <td width="139" rowspan="3" align="left" valign="bottom">&nbsp;</td>
    <td width="195" rowspan="3" align="left" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td height="43" align="left" valign="middle">APELLIDO PATERNO:<input type="text" value="<?php echo $datos['AP_PATERNO']; ?>" name="ap_pat" id="ap_pat" class="required" onchange="javascript:this.value=this.value.toUpperCase();"  />   </td>
    <td align="left" valign="middle">    </td>
    </tr>
  <tr>
    <td align="left">APELLIDO MATERNO:<input type="text" value="<?php echo $datos['AP_MATERNO']; ?>" name="ap_mat" id="ap_mat" onchange="javascript:this.value=this.value.toUpperCase();"/></td>
    <td align="left">&nbsp;</td>
    <td align="left"></td>
  </tr>
  </table>                         



<table width="100%" border="0">
  <tr>
    <td width="30%">FECHA DE NACIMIENTO:</td>
    <td width="19%">TELÉFONO:</td>
    <td width="30%" rowspan="2">
      TIPO DE TELÉFONO:
      <br/>
      <label>
        <input name="tipo_tel_1" type="radio" id="RadioGroup1_0" value="1" <?php if($datos['TIPO_TELEFONO']=='FIJO'){?> checked="checked" <?php } ?> />
        FIJO</label>
      <br />
      <label>
        <input  name="tipo_tel_1" type="radio" id="RadioGroup1_1" value="2" <?php if($datos['TIPO_TELEFONO']=='MOVIL'){?> checked="checked" <?php } ?> />
        CELULAR</label>
      
    </td>
    <td width="21%">CORREO ELECTRÓNICO:</td>
  </tr>
  <tr>
    <td>
      <input name="dia_nac" type="number" id="dia_nac"  size="3" maxlength="2" placeholder="DÍA" min="1" max="31" required="required"  onkeypress="return justNumbers(event);" value="<?php echo $datos['DN']; ?>"/>
      <select name="mes_nac" id="mes_nac">
        <option value="1" <?php if($datos['MN']==1){ ?> selected="selected" <?php } ?> >ENERO</option>
        <option value="2" <?php if($datos['MN']==2){ ?> selected="selected" <?php } ?>>FEBRERO</option>
        <option value="3" <?php if($datos['MN']==3){ ?> selected="selected" <?php } ?>>MARZO</option>
        <option value="4" <?php if($datos['MN']==4){ ?> selected="selected" <?php } ?>>ABRIL</option>
        <option value="5" <?php if($datos['MN']==5){ ?> selected="selected" <?php } ?>>MAYO</option>
        <option value="6" <?php if($datos['MN']==6){ ?> selected="selected" <?php } ?>>JUNIO</option>
        <option value="7" <?php if($datos['MN']==7){ ?> selected="selected" <?php } ?>>JULIO</option>
        <option value="8" <?php if($datos['MN']==8){ ?> selected="selected" <?php } ?>>AGOSTO</option>
        <option value="9" <?php if($datos['MN']==9){ ?> selected="selected" <?php } ?>>SEPTIEMBRE</option>
        <option value="10" <?php if($datos['MN']==10){ ?> selected="selected" <?php } ?>>OCTUBRE</option>
        <option value="11" <?php if($datos['MN']==11){ ?> selected="selected" <?php } ?>>NOVIEMBRE</option>
        <option value="12" <?php if($datos['MN']==13){ ?> selected="selected" <?php } ?>>DICIEMBRE</option>
        </select>
      <input name="anio_nac" type="number" id="anio_nac" size="4" maxlength="4" placeholder="AÑO" min="1930" max="3000" required="required"  onkeypress="return justNumbers(event);"value="<?php echo $datos['YN']; ?>" />
      </td>
    <td><input name="telefono_1" type="number" class="required" id="telefono_1" value="<?php echo $datos['TELEFONO']; ?>" size="10" maxlength="10"  placeholder="1234567890"  onkeypress="return justNumbers(event);" /></td>
    <td><input type="email" name="e_mail" id="e_mail" value="<?php echo $datos['E_MAIL']; ?>" /></td>
  </tr>
  <tr>
    <td>FECHA DE INGRESO:</td>
    <td>TIPO DE EMPLEADO:</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="dia_ingreso" type="number" id="dia_ingreso" size="3" maxlength="2" placeholder="DÍA" min="1" max="31"  onkeypress="return justNumbers(event);"  value="<?php echo $datos['DI']; ?>" />
      <select name="mes_ingreso" id="mes_ingreso">
        <option value="1" <?php if($datos['MI']==1){ ?> selected="selected" <?php } ?>>ENERO</option>
        <option value="2" <?php if($datos['MI']==2){ ?> selected="selected" <?php } ?>>FEBRERO</option>
        <option value="3" <?php if($datos['MI']==3){ ?> selected="selected" <?php } ?>>MARZO</option>
        <option value="4" <?php if($datos['MI']==4){ ?> selected="selected" <?php } ?>>ABRIL</option>
        <option value="5" <?php if($datos['MI']==5){ ?> selected="selected" <?php } ?>>MAYO</option>
        <option value="6" <?php if($datos['MI']==6){ ?> selected="selected" <?php } ?>>JUNIO</option>
        <option value="7" <?php if($datos['MI']==7){ ?> selected="selected" <?php } ?>>JULIO</option>
        <option value="8" <?php if($datos['MI']==8){ ?> selected="selected" <?php } ?>>AGOSTO</option>
        <option value="9" <?php if($datos['MI']==9){ ?> selected="selected" <?php } ?>>SEPTIEMBRE</option>
        <option value="10" <?php if($datos['MI']==10){ ?> selected="selected" <?php } ?>>OCTUBRE</option>
        <option value="11" <?php if($datos['MI']==11){ ?> selected="selected" <?php } ?>>NOVIEMBRE</option>
        <option value="12" <?php if($datos['MI']==12){ ?> selected="selected" <?php } ?>>DICIEMBRE</option>
      </select>
      <input name="anio_ingreso" type="number" id="anio_ingreso"  size="4" maxlength="4" placeholder="AÑO" min="1930" max="3000" required="required"  onkeypress="return justNumbers(event);"  value="<?php echo $datos['YN']; ?>" /></td>
    <td><select name="id_t_p" id="id_t_p">
      <?php $tPersona=mysql_query("
								 SELECT ID_TIPO_PERSONA, TIPO_PERSONA FROM cat_tipo_empleado ;
								 ")
	  or die("No se pudo consultar los datos de los tipos de persona. <br/>".mysql_error());
	  while($dtPer=mysql_fetch_array($tPersona)){
	  ?>
      <option value="<?php echo $dtPer['ID_TIPO_PERSONA']; ?>"   <?php if($dtPer['TIPO_PERSONA']==$datos['TIPO_PERSONA']){ ?> selected="selected" <?php } ?> ><?php echo $dtPer['TIPO_PERSONA']; ?></option>
      <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

</fieldset>
<p></p>


<p></p>



<div align="center">
  <input class="boton_verde" style="height:35px; width:200px;" name="boton" type="submit" value="ACTUALIZAR" />
  <script type="text/javascript">
		$('#fields-in-call').ketchup({}, {
		  '.required'    : 'required',              //all fields in the form with the class 'required'
		  //'#nombre': 'username', //one field in the form with the id 'fic-username'
		  //'#ap_pat': 'username, minlength(3)',
		  '#telefono_1': 'digits',
		  '#anio_nac': 'min(4),digits',
		  '#anio_ingreso': 'min(4),digits'
		  //'#calle': 'username, minlength(3)',
		  //'#num_exter': 'username, minlength(3)',
		  //'#num_inter': 'username, minlength(3)'
		});
    </script>
      <input name="emp_id" type="hidden" id="emp_id" value="<?php echo $datos['ID_PERSONA'] ?>" />
      <input type="hidden" name="id_loc_aux" id="id_loc_aux" value=" <?php echo $datos['ID_LOCALIDAD']; ?>" />
</div>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>

<!-- ************************** Inicio de info del establecimiento y usuario que inició sesión ********************** -->

<div class="esp_mod">
<?php if($_SESSION['SESSION_GRUPO']=="SUPER ADMINISTRADOR"){ 
echo' 
		<div class="bot_mod mod_seleccionado">USUARIOS</div>
	<a href="../PUNTOVENTA/">
    	<div class="bot_mod">PUNTO DE VENTA</div>
	</a>	
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
