<?php require("../aut_verifica.inc.php"); 
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
$id_persona=$_GET['id_persona'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EMPLEADOS</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/estilos_venta.css" type="text/css"> 
<link rel="stylesheet" href="../PUNTOVENTA/css/surtir.css" type="text/css"> 
<link rel="stylesheet" href="../css/transicionesCSS.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />	
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>


<style type="text/css">
.iconos{
	display:block;}
.eliminar{
	background:url(../imagenes/eliminar.png)top center no-repeat;
	display:block;}
.eliminar:hover{
	background:url(../imagenes/eliminarcolor.png)top center no-repeat;
	}
</style>

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
			
			$("#BUSCAR_NOM").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_AREA").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_CUE").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
			
			$("#BUSCAR_PUESTO").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});
		});
	</script>
<!--FIN FANCYBOX-->
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


<body>
<div class="espacio_menu">
<ul id="menu">
        
        <li>ADMINISTRACIÓN </li>
        
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
    
    
    
    <li class="menu_right"><a class="drop">NOMINA</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
           
            
            <div class="col_1">
    
                <ul class="greybox">
                    <li><a href="#">VER NÓMINA</a></li>
                    
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    <li class="menu_right"><a href="asistencia.php" class="drop">ASISTENCIA</a> </li>
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a><!-- Begin 3 columns Item -->   </li>
 
</ul>
</div>

<div class="cabecera">

<div class="fotografia">
 <img src="../fotos_empleados/<?php echo $_SESSION['SESSION_FOTO']; ?>"  />

</div>

<div class="datos_sesion">
 <div class='nombre_empleado'><?php echo "<label><strong>".$_SESSION['SESSION_NOMBRE'] ." ".$_SESSION['SESSION_AP_PATERNO']." ".$_SESSION['SESSION_AP_MATERNO']."</strong></label><br/>"; ?> </div>
    <?php

$nombre=mysql_query("SELECT
CONCAT(AP_PATERNO,' ',AP_MATERNO,' ',NOMBRE) AS NOM
FROM persona
WHERE ID_PERSONA=$id_persona
AND ID_ESTABLECIMIENTO=$id_establecimiento;
					")
or die("No se pudo consultar los datos del empleado. <br/>".mysql_error());

$dNombre=mysql_fetch_array($nombre);




  ?>
 
  </div>
  
</div>
<div class="surtir_espacio">
<div class="surtir_menu">
<div class="surtir_logo stretchRight"><img src="../imagenes/+usuario.png"/></div>
<div class="surtir_tit stretchRight"><strong>ASIGNAR DIAS DE TRABAJO A <?php echo $dNombre['NOM'];  ?></strong></div>

</div>
</div>
<div class="pagina">
<p></p>
<form  method="post" action="insert_horario.php">
  <table width="100%" border="0">
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="16%">DIA DE ENTRADA</td>
    <td colspan="2">HORA DE ENTRADA</td>
    <td width="15%">DIA DE SALIDA</td>
    <td colspan="2">HORA DE SALIDA</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <select name="dia_entrada" id="dia_entrada">
      <?php 
	  $cDias=mysql_query("SELECT ID_DIA, DIA FROM cat_semana")
	  or die("No se pudieron consultar los dias. <br/>".mysql_error());
	  while($dDias=mysql_fetch_array($cDias)){
	  ?>
        <option <?php if($dDias['ID_DIA']==1){ echo  'selected="selected"';} ?> value="<?php echo $dDias['ID_DIA']; ?>"><?php echo $dDias['DIA']; ?></option>
        
        <?php } ?>
      </select>
    </label></td>
    <td width="15%"><label>
      <input style="text-align:center;" name="h_entrada" type="number" id="h_entrada" onkeypress="return justNumbers(event);" size="3" maxlength="2" placeholder="1-12" min="1" max="12" required="required"  />
      </label>
    :
    <label>
    <input  style="text-align:center;" name="m_entrada" type="number" id="m_entrada" onkeypress="return justNumbers(event);" size="3" maxlength="2" placeholder="00-59" min="0" max="59" required="required" value="00"/>
    </label>
            
      </td>
    <td width="15%">
     <label>
          <input type="radio"  name="ampmEntrada" value="AM"  id="ampmEntrada"checked="checked" />
          AM</label>
     <br/>
        <label>
          <input type="radio"  name="ampmEntrada" value="PM"  id="ampmEntrada" />
          PM</label>
    </td>
    <td>
    <label>
      <select name="dia_salida" id="dia_salida">
      <?php 
	  $cDias=mysql_query("SELECT ID_DIA, DIA FROM cat_semana")
	  or die("No se pudieron consultar los dias. <br/>".mysql_error());
	  while($dDias=mysql_fetch_array($cDias)){
	  ?>
        <option <?php if($dDias['ID_DIA']==1){ echo  'selected="selected"';} ?>  value="<?php echo $dDias['ID_DIA']; ?>"><?php echo $dDias['DIA']; ?></option>
        
        <?php } ?>
      </select>
    </label>
    </td>
    <td width="15%"><label>
      <input style="text-align:center;" name="h_salida" type="number" id="h_salida" onkeypress="return justNumbers(event);" size="3" maxlength="2" placeholder="1-12" min="1" max="12" required="required"  />
      </label>
    :
    <label>
    <input  style="text-align:center;" name="m_salida" type="number" id="m_salida" onkeypress="return justNumbers(event);" size="3" maxlength="2" placeholder="0-59" min="0" max="59" required="required" value="00" />
    </label></td>
    <td width="18%">
      
        <label>
          <input name="ampmSalida" type="radio" id="RadioGroup1_0" value="AM" checked="checked" />
          AM</label>
     <br/>
        <label>
          <input type="radio" name="ampmSalida" value="PM" id="RadioGroup1_1" />
          PM</label>
       
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="id_persona" type="hidden" value="<?php echo $id_persona; ?>" />
        <input name="ID_ESTABLECIMIENTO" type="hidden" value="<?php echo $id_establecimiento; ?>" /></td>
    <td colspan="4" align="center" height="40px"><input class="boton_verde" name="" type="submit"value="GUARDAR" /></td>
    <td>&nbsp;</td>
  </tr>
</table>

 </form> 

<p></p>
<p></p>

<table width="100%" border="0">
  <tr class="bgtabla">
    <td colspan="2">ENTRADA</td>
    <td colspan="2">SALIDA</td>
    <td>&nbsp;</td>
    </tr>
  <?php 
  $cHorario=mysql_query("
						SELECT
						C.ID_ASOC_HOR_PERS AS HP,
						B.DIA,
						DATE_FORMAT(C.HORA_ENTRADA,'%H:%i') AS HORA_ENT ,
						if(D.DIA=B.DIA,'',D.DIA)AS DIA_SAL,
						DATE_FORMAT(C.HORA_SALIDA,'%H:%i') AS HORA_SAL 						
						FROM persona A
						INNER JOIN asoc_horarios_persona C
						ON A.ID_PERSONA=C.ID_PERSONA
						INNER JOIN cat_semana B
						ON C.ID_DIA_ENTRADA=B.ID_DIA
						INNER JOIN cat_semana D
						ON C.ID_DIA_SALIDA=D.ID_DIA
						WHERE A.ID_PERSONA=$id_persona
						ORDER BY  B.ID_DIA ASC
						;
						")
  or die("No se puieron consultar los horarios. <br/>".mysql_error());
  
  while($dHorario=mysql_fetch_array($cHorario)){
  ?>
  <tr class="hover_lista">
    <td bgcolor="#D0FCC9"><?php echo $dHorario['DIA']; ?></td>
    <td bgcolor="#D0FCC9"><?php echo $dHorario['HORA_ENT']; ?></td>
    <td bgcolor="#FFD9D9" width="14%"><?php echo $dHorario['DIA_SAL']; ?></td>
    <td bgcolor="#FFD9D9" width="29%"><?php echo $dHorario['HORA_SAL']; ?></td>
    <td width="22%">
     <a style="text-decoration:none" href="confirmar_quitar.php?hp=<?php echo $dHorario['HP']; ?>&p=<?php echo "$id_persona"; ?>">
     <div class="eliminar"> &nbsp; </div>
     </a>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</div>


</body>
</html>
