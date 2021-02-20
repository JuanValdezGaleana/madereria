<?php
require('buscador/config.php');
require('buscador/include/conexion.php');
require('buscador/include/funciones.php');
require('buscador/include/pagination.class.php');


$clave_venta=$_GET['clave_venta'];
$palabras=$_GET['q'];

echo "CLAVE DE VENTA: $clave_venta<br/>";
echo "PALABRAS: $palabras<br/>";

$items = 10;
$page = 1;

if(isset($_GET['page']) and is_numeric($_GET['page']) and $page = $_GET['page'])
		$limit = " LIMIT ".(($page-1)*$items).",$items";
	else
		$limit = " LIMIT $items";

if(isset($_GET['q']) and !eregi('^ *$',$_GET['q'])){
		$q = sql_quote(utf8_decode($_GET['q'])); //para ejecutar consulta
		$busqueda = htmlentities($q); //para mostrar en pantalla

		$sqlStr = "SELECT * FROM productos WHERE DESCRIPCION LIKE '%$q%'";
		$sqlStrAux = "SELECT count(*) as total FROM productos WHERE DESCRIPCION LIKE '%$q%'";
	}else{
		$sqlStr = "SELECT * FROM productos";
		$sqlStrAux = "SELECT count(*) as total FROM productos";
	}

$aux = Mysql_Fetch_Assoc(mysql_query($sqlStrAux,$link));
$query = mysql_query($sqlStr.$limit, $link);
?>	<p><?php
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
			/*echo "\t<table class=\"registros\">\n";
			echo "<tr class=\"titulos\"><td>Titulo</td></tr>\n";*/
			?>
			<table width="100%" border="0">
              <tr class="bgtabla">
                <td>CLAVE</td>
                <td>DESCRIPCI&Oacute;N</td>
                <td>PRECIO</td>
              </tr>         
            
            <?php
			$r=0;
			while($row = mysql_fetch_array($query)){
        /*echo "\t\t<tr class=\"row$r\"><td><a href=\"http://www.mis-algoritmos.com/?p={$row['ID_PRODUCTO']}\" target=\"_blank\">".htmlentities($row['DESCRIPCION']." ".$row['PRECIO_VENTA']." ".$row['DESCUENTO']." ".$row['PRECIO_FINAL'])."</a></td></tr>\n";*/
		 ?>
          <tr class="hover_lista_b" style="cursor:pointer;"> 
            <td><a class="lista_busq"  href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO']  ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo htmlentities($row['CVE_PRODUCTO']); ?></a></td>
            <td><a class="lista_busq"  href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO']  ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo htmlentities($row['DESCRIPCION']); ?></a></td>
            <td><a class="lista_busq"  href="insert_venta.php?entra_c=<?php echo $row['CVE_PRODUCTO']  ?>&clave_venta=<?php echo $clave_venta; ?>"><?php echo htmlentities($row['PRECIO_FINAL']); ?></a></td>
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