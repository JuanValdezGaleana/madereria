<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ALTA DE EMPLEADO</title>
<link rel="stylesheet" href="../PUNTOVENTA/css/1estilos.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />	
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

<script type="text/javascript" src="../select_dependientes.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="../validador/css/jquery.ketchup.css" />
<script type="text/javascript" src="../select_dependientes.js"></script>
<script type="text/javascript" src="../validador/assets/js/jquery.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.validations.js"></script>
<script type="text/javascript" src="../validador/jquery.ketchup.helpers.js"></script>
<script type="text/javascript" src="../validador/docs/js/scaffold.js"></script>

<script>
function bloquea() {
if (document.form1.opcioningreso[0].checked) {
document.form1.dia_ingreso.disabled = true
document.form1.mes_ingreso.disabled = true
document.form1.anio_ingreso.disabled = true
}

if (document.form1.opcioningreso[1].checked) {
document.form1.dia_ingreso.disabled = false
document.form1.mes_ingreso.disabled = false
document.form1.anio_ingreso.disabled = false

}
}
</script>

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


<!--<script language="JavaScript" type="text/javascript" src="js/jquery-2.0.2.js" charset="utf-8"></script>-->
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

<script type="text/javascript">
function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
</script>
		
</head>
<?php

if ($_SESSION['SESSION_CGRU_GRUPO']=="USUARIO DE CAPTURA" ){
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
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a> </li>
</ul>
</div>

<div class="contenedor">

<div class="surtir_espacio">
  <div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>INGRESAR NUEVO EMPLEADO</strong></div>
<div class="espacio_calendario">

</div>
</div>
</div>
<div class="pagina" style="height:calc(100% - 50px); overflow:auto;">

<div >

<p>&nbsp;</p>

<form id="fields-in-call" name="form1" method="post" action="insert_empleado.php" enctype="multipart/form-data">


<fieldset>
<legend><strong>DATOS PERSONALES</strong></legend>

<table width="100%" border="0">
  <tr>
    <td width="205" align="left">NOMBRE:
      <input type="text" name="nombre" id="nombre" class="required" onchange="javascript:this.value=this.value.toUpperCase();" autofocus="autofocus"/></td>
    <td width="324" rowspan="2" align="center">&nbsp;</td>
    <td width="131" align="left">&nbsp;</td>
    <td width="129" rowspan="2" align="left" valign="middle">&nbsp;</td>
    <td width="187" rowspan="2" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">APELLIDO PATERNO:
      <input type="text" name="ap_pat" id="ap_pat" class="required" onchange="javascript:this.value=this.value.toUpperCase();" /></td>
    <td align="left" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td align="left">APELLIDO MATERNO:
      <input type="text" name="ap_mat" id="ap_mat" onchange="javascript:this.value=this.value.toUpperCase();"/></td>
    <td align="left"><br/></td>
    <td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="3000000" /></td>
    <td colspan="2" align="left" valign="top">ORIENTACIÓN DE LA FOTO</td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td colspan="2" align="center">
      </td>
    <td colspan="2" align="center" valign="bottom">&nbsp;</td>
    </tr>
</table>                         

<table width="100%" border="0">
  <tr>
    <td width="34%">FECHA DE NACIMIENTO:</td>
    <td width="22%">TELÉFONO:</td>
    <td width="22%" rowspan="2">TIPO DE TELÉFONO:
      <br/>
      <label>
        <input name="tipo_tel_1" type="radio" id="RadioGroup1_0" value="1" checked="checked" />
        PARTICULAR</label>
      <br />
      <label>
        <input  name="tipo_tel_1" type="radio" id="RadioGroup1_1" value="2" />
        CELULAR</label>
      </td>
    <td width="22%">CORREO ELECTRÓNICO:</td>
    </tr>
  <tr>
    <td width="34%" valign="top">
      <input name="dia_nac" type="number" id="dia_nac"  size="3" maxlength="2" placeholder="DÍA" min="1" max="31" required="required"  onkeypress="return justNumbers(event);"/>
      <select name="mes_nac" id="mes_nac">
        <option value="1" selected="selected">ENERO</option>
        <option value="2">FEBRERO</option>
        <option value="3">MARZO</option>
        <option value="4">ABRIL</option>
        <option value="5">MAYO</option>
        <option value="6">JUNIO</option>
        <option value="7">JULIO</option>
        <option value="8">AGOSTO</option>
        <option value="9">SEPTIEMBRE</option>
        <option value="10">OCTUBRE</option>
        <option value="11">NOVIEMBRE</option>
        <option value="12">DICIEMBRE</option>
        </select>
      <input name="anio_nac" type="number" id="anio_nac" size="4" maxlength="4" placeholder="AÑO" min="1930" max="3000" required="required"  onkeypress="return justNumbers(event);" />
      
      
      </td>
    <td valign="top">
      <input name="telefono_1" type="number" class="required" id="telefono_1" size="10" maxlength="10"  placeholder="1234567890"  onkeypress="return justNumbers(event);" /></td>
    <td width="22%" valign="top"><input type="email" name="e_mail" id="e-mail" /></td>
  </tr>
  <tr>
    <td valign="top">CALLE:</td>
    <td valign="top">NÚMERO:</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><label>
      <input type="text" name="calle" id="calle" required="required" onchange="javascript:this.value=this.value.toUpperCase();"/>
    </label></td>
    <td valign="top"><label>
      <input name="numero" type="number" id="numero" size="4" required="required" onkeypress="return justNumbers(event);"/>
    </label></td>
    <td>

    </td>
    <td valign="top">  </td>
  </tr>
  <tr>
    <td>FECHA DE INGRESO:</td>
    <td>TIPO DE EMPLEADO:</td>
    <td><p>&nbsp;</p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <input name="dia_ingreso" type="number" id="dia_ingreso" size="3" maxlength="2" placeholder="DÍA" min="1" max="31"  onkeypress="return justNumbers(event);"/>
      <select name="mes_ingreso" id="mes_ingreso">
        <option value="1" selected="selected">ENERO</option>
        <option value="2">FEBRERO</option>
        <option value="3">MARZO</option>
        <option value="4">ABRIL</option>
        <option value="5">MAYO</option>
        <option value="6">JUNIO</option>
        <option value="7">JULIO</option>
        <option value="8">AGOSTO</option>
        <option value="9">SEPTIEMBRE</option>
        <option value="10">OCTUBRE</option>
        <option value="11">NOVIEMBRE</option>
        <option value="12">DICIEMBRE</option>
      </select>
      <input name="anio_ingreso" type="number" id="anio_ingreso"  size="4" maxlength="4" placeholder="AÑO" min="1930" max="3000" required="required"  onkeypress="return justNumbers(event);" />
    
    </td>
    <td>
      <select name="id_t_p" id="id_t_p">
      <?php $tPersona=mysql_query("
								 SELECT ID_TIPO_PERSONA, TIPO_PERSONA FROM cat_tipo_empleado ;
								 ")
	  or die("No se pudo consultar los datos de los tipos de persona. <br/>".mysql_error());
	  while($dtPer=mysql_fetch_array($tPersona)){
	  ?>
        <option value="<?php echo $dtPer['ID_TIPO_PERSONA']; ?>"><?php echo $dtPer['TIPO_PERSONA']; ?></option>
      <?php } ?>  
      </select>

    </td>
    <td> </td>
    <td>&nbsp;</td>
  </tr>
  </table>


</fieldset>
<div align="center">
  <table width="100%" border="0">
    <tr>
      <td width="26%">&nbsp;</td>
      <td width="48%" align="center"><input class="boton_verde" style="height:35px; width:200px;" name="boton" type="submit" value="GUARDAR" /></td>
      <td width="26%">&nbsp;</td>
    </tr>
  </table>
    <p>&nbsp;</p>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
  <script type="text/javascript">
		$('#fields-in-call').ketchup({}, {
		  '.required'    : 'required',              //all fields in the form with the class 'required'
		  //'#nombre': 'username', //one field in the form with the id 'fic-username'
		  //'#ap_pat': 'username, minlength(3)',
		  '#telefono_1': 'digits'
		  //'#anio_nac': 'min(4),digits'
		  //'#calle': 'username, minlength(3)',
		  //'#num_exter': 'username, minlength(3)',
		  //'#num_inter': 'username, minlength(3)'
		});
    </script>
</div>
</form>
</div>

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
