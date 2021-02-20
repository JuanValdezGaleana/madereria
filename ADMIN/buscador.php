<?php require("../aut_verifica.inc.php");
require("../aut_config.inc.php");
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
/* REFRESCA LA PAGINA CADA CIERTOS SEGUNDOS EN ESTE CASO 10 SEGUNDOS
$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
header("refresh:10; url=$self"); //Refrescamos cada 300 segundos
*/
$clave_venta=$_GET['clave_venta'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nom_negocio;  ?></title> 
<link rel="stylesheet" href="css/formulario.css" type="text/css">
<link rel="stylesheet" href="css/ordenlistas.css" type="text/css">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />

<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

<!--INICIO ARCHIVOS DEL BUSCADOR-->
<link rel="stylesheet" href="buscador/pagination.css" media="screen">
<link rel="stylesheet" href="buscador/style.css" media="screen">
<script src="buscador/include/buscador.js" type="text/javascript" language="javascript"></script>
<!--FIN ARCHIVOS DEL BUSCADOR-->

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
				document.getElementById('q').focus();
				}
        </script>
	
</head>


<body>
<div class="contenedor">
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
                     <<?php if($_SESSION['SESSION_GRUPO']=='SUPER ADMINISTRADOR'){ ?>
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
  
  <div class="pagina">

<?php

 
/* echo "CLAVE DE VENTA: $clave_venta";*/
 
require('buscador/config.php');
require('buscador/include/conexion.php');
require('buscador/include/funciones.php');
require('buscador/include/pagination.class.php');

echo "CLAVE DE VENTA: $clave_venta";


$items = 10;
$page = 1;

if(isset($_GET['page']) and is_numeric($_GET['page']) and $page = $_GET['page'])
		$limit = " LIMIT ".(($page-1)*$items).",$items";
	else
		$limit = " LIMIT $items";

if(isset($_GET['q']) and !eregi('^ *$',$_GET['q'])){
		$q = sql_quote($_GET['q']); //para ejecutar consulta
		
		$busqueda = htmlentities($q); //para mostrar en pantalla

		$sqlStr = "SELECT * FROM productos WHERE DESCRIPCION LIKE '%$q%'";
		$sqlStrAux = "SELECT count(*) as total FROM productos WHERE DESCRIPCION LIKE '%$q%'";
	}else{
		$sqlStr = "SELECT * FROM productos";
		$sqlStrAux = "SELECT count(*) as total FROM productos";
	
	}

$aux = Mysql_Fetch_Assoc(mysql_query($sqlStrAux,$link));
$query = mysql_query($sqlStr.$limit, $link);
?>
	<form action="index.php" onsubmit="return buscar()">
      <label>Buscar</label> <input type="text" id="q" name="q" value="<?php if(isset($q)) echo $busqueda;?>" onKeyUp="return buscar(<?php echo $clave_venta; ?>)">
      <input type="submit" value="Buscar" id="boton">
      <span id="loading"></span>
    </form>
    
    <div id="resultados">
	<p><?php
		if($aux['total'] and isset($busqueda)){
				echo "{$aux['total']} Resultado".($aux['total']>1?'s':'')." que coinciden con tu b&uacute;squeda \"<strong>$busqueda</strong>\".";
			}elseif($aux['total'] and !isset($q)){
				echo "Total de registros: {$aux['total']}";
			}elseif(!$aux['total'] and isset($q)){
				echo"No hay registros que coincidan con tu b&uacute;squeda \"<strong>$busqueda</strong>\"";
			}
	?></p>

	<?php 
		if($aux['total']>0){
			$p = new pagination;
			$p->Items($aux['total']);
			$p->limit($items);
			if(isset($q))
					$p->target("buscador.php?q=".urlencode($q));
				else
					$p->target("buscador.php");
			$p->currentPage($page);
			$p->show();
		/*	echo "\t<table class=\"registros\">\n";
			echo "<tr class=\"titulos\"><td>Titulo</td></tr>\n";*/
			?>
			<table width="100%" border="0">
              <tr class="bgtabla">
                <td>CLAVE</td>
                <td>DESCRIPCIÓN</td>
                <td>PRECIO</td>
              </tr>
		<?php	
			$r=0;
			while($row = mysql_fetch_array($query)){
         /* echo "\t\t<tr class=\"row$r\"><td><a href=\"http://www.mis-algoritmos.com/?p={$row['ID_PRODUCTO']}\" target=\"_blank\">".htmlentities($row['DESCRIPCION']." ".$row['PRECIO_VENTA']." ".$row['DESCUENTO']." ".$row['PRECIO_FINAL'])."</a></td></tr>\n";*/
		 ?>
        
          <tr class="hover_lista_b" style="cursor:pointer;"> 
            <td><a class="lista_busq" href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO'] ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo $row['CVE_PRODUCTO']; ?></a></td>
            <td><a class="lista_busq" href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO'] ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo $row['DESCRIPCION']; ?></a></td>
            <td><a class="lista_busq" href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO'] ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo $row['PRECIO_FINAL']; ?></a></td>
          </tr>
         
		 <?php
		 
          
        }
			/*echo "\t</table>\n";*/
			?>
            </table>
            <?php 
			$p->show();
		}
	?>
    </div>






</div>
  
  
  
  
  
  
  
  
</div> <!--FIN DEL DIV CONTENEDOR class="contenedor"-->
</body>
</html>
