<?php
require("../../aut_verifica.inc.php");
$datos=array();

$op=$_GET['op'];

switch($op){
    case 1:
        $q_lp=mysql_query('SELECT ID_PRODUCTO,DESCRIPCION FROM productos ORDER BY DESCRIPCION ASC;') or die('Error en la consulta: '.mysql_error());
        while($d_lp=mysql_fetch_array($q_lp)){
            $datos[]=array('id_producto'=>$d_lp['ID_PRODUCTO'],'descripcion'=>$d_lp['DESCRIPCION']);
        }
        
    break;
    case 2:
        $descripcion=$_POST['descripcion'];
        $q_lp=mysql_query('SELECT A.ID_PRODUCTO,A.CVE_PRODUCTO,B.CANTIDAD_ACTUAL,A.PRECIO_VENTA FROM productos A
        INNER JOIN inventario B
        ON A.ID_PRODUCTO=B.ID_PRODUCTO
        WHERE A.DESCRIPCION="'.$descripcion.'";') or die('Error en la consulta: '.mysql_error());
        while($d_lp=mysql_fetch_array($q_lp)){
            $datos[]=array('id_producto'=>$d_lp['ID_PRODUCTO'],'cve_producto'=>$d_lp['CVE_PRODUCTO'],'cantidad'=>$d_lp['CANTIDAD'],'precio_venta'=>$d_lp['PRECIO_VENTA']);
        }
    break;
    
    /*case 3:
        $qprodFarm=mysql_query('SELECT B.DESCRIPCION,A.CANTIDAD_ACTUAL
        FROM inventario A
        INNER JOIN productos B
        ON A.ID_PRODUCTO=B.ID_PRODUCTO
        WHERE A.CANTIDAD_ACTUAL>=1;')or die('No se pudo hacer la consulta de los productos de farmacia<br>'.mysql_error());
        while($dProdFarm=mysql_fetch_array($qprodFarm)){
            $datos[]=array('descripcion'=>$dProdFarm['DESCRIPCION'],'cantidad_actual'=>$dProdFarm['CANTIDAD_ACTUAL']);
        }
    break;
    case 4:
        $descripcion=$_POST['descripcion'];
        $q_lp=mysql_query('SELECT A.CVE_PRODUCTO,B.CANTIDAD FROM productos A
        INNER JOIN almacen B
        ON A.ID_PRODUCTO=B.ID_PRODUCTO
        WHERE A.DESCRIPCION="'.$descripcion.'";') or die('Error en la consulta: '.mysql_error());
        while($d_lp=mysql_fetch_array($q_lp)){
            $datos[]=array('cve_producto'=>$d_lp['CVE_PRODUCTO'],'cantidad'=>$d_lp['CANTIDAD']);
        }
    break;*/
}
echo json_encode($datos);



?>