<?php require("../aut_verifica.inc.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NÓMINA</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css"> 
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
		
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
        
        <li>NÓMINA</li>
        
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
    
    
    <li class="menu_right"><a class="drop">EMPLEADOS</a><!-- Begin 3 columns Item -->
    
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
    
    
    
    <li class="menu_right menu_activo"><a class="drop">NOMINA</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_3columns align_right"><!-- Begin 3 columns container -->
           
            
            <div class="col_1">
    
                <ul class="greybox">
                    <li><a href="nomina.php">VER NÓMINA</a></li>
                    
                </ul>   
            </div>
        </div><!-- End 3 columns container -->
    </li>
    
    <li class="menu_right"><a href="index.php" class="drop">INICIO</a><!-- Begin 3 columns Item -->   </li>
 
</ul>
</div>

<div class="cabecera">

<div class="fotografia">
 <img src="../fotos_empleados/<?php echo $_SESSION['SESSION_FOTO']; ?>"  />

</div>

<div class="datos_sesion">
 <div class='nombre_empleado'><?php echo "<label><strong>".$_SESSION['SESSION_NOMBRE'] ." ".$_SESSION['SESSION_AP_PATERNO']." ".$_SESSION['SESSION_AP_MATERNO']."</strong></label><br/>"; ?> </div>

 
  </div>
  
</div>
<div class="pagina">
  
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><br/>
  </p>
</div>


</body>
</html>
