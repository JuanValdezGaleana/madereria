<?php
include('conect.php');
//require("../../aut_verifica.inc.php");
$op=$_GET['op'];
switch($op){
    
    case 1:
        
        $cons='SELECT A.ID_PRODUCTO,A.CVE_PRODUCTO,A.DESCRIPCION,A.PRECIO_VENTA,B.CANTIDAD_ACTUAL FROM productos A INNER JOIN inventario B ON A.ID_PRODUCTO=B.ID_PRODUCTO ORDER BY A.DESCRIPCION ASC;';
                //$datos=array();
                $consulta=$conexion->query($cons);
                if($cons->errno)die("(1):::".$consulta->error);

                while($row=$consulta->fetch_array()){
                    $datos[]=array('id_producto'=>$row['ID_PRODUCTO'],
                    'cve_producto'=>$row['CVE_PRODUCTO'],
                    'descripcion'=>$row['DESCRIPCION'],
                    'precio_venta'=>$row['PRECIO_VENTA'],
                    'cantidad_actual'=>$row['CANTIDAD_ACTUAL'],
                );
                }

    break;
    case 2:

        $id_producto=$_POST['id_producto'];

        $cons='SELECT A.ID_PRODUCTO,A.CVE_PRODUCTO,A.NOMBRE_PRODUCTO,A.DESCRIPCION,A.PRECIO_VENTA,B.CANTIDAD_ACTUAL FROM productos A INNER JOIN inventario B ON A.ID_PRODUCTO=B.ID_PRODUCTO WHERE B.ID_PRODUCTO='.$id_producto.';';
        //$datos=array();
        $consulta=$conexion->query($cons);
        if($cons->errno)die("(1):::".$consulta->error);

        while($row=$consulta->fetch_array()){
            $datos[]=array(
            'id_producto'=>$row['ID_PRODUCTO'],
            'nombre_producto'=>$row['NOMBRE_PRODUCTO'],
            'cve_producto'=>$row['CVE_PRODUCTO'],
            'descripcion'=>$row['DESCRIPCION'],
            'precio_venta'=>$row['PRECIO_VENTA'],
            'cantidad_actual'=>$row['CANTIDAD_ACTUAL']
        );
        }
    break;
    case 3:

        $idProd=$_POST['idProd'];
        
        $codBarras=$_POST['codBarras'];
        $nomProd=$_POST['nomProd'];
        $descripcion=$_POST['descripcion'];

        $precUnitVenta=$_POST['precUnitVenta'];
        $cantidad=$_POST['cantidad'];

        $conexion->query("UPDATE productos A
                        INNER JOIN inventario B
                        ON A.ID_PRODUCTO=B.ID_PRODUCTO
                        SET A.PRECIO_VENTA=".$precUnitVenta.",A.PRECIO_FINAL=".$precUnitVenta.",B.CANTIDAD_ACTUAL=".$cantidad.",A.NOMBRE_PRODUCTO='".$nomProd."',A.DESCRIPCION='".$descripcion."',A.CVE_PRODUCTO='".$codBarras."'
                        WHERE A.ID_PRODUCTO=".$idProd.";");
        if($conexion->errno)die('(12):::'.$conexion->error);

        $datos[]=array('stat'=>1,
        'idProd'=>$idProd,
        'precUnitVenta'=>$precUnitVenta,
        'cantidad'=>$cantidad,
        'codBarras'=>$codBarras,
        'descripcion'=>$descripcion);
        

    break;
    case 4:

        $cons='SELECT A.ID_PRODUCTO,A.CVE_PRODUCTO,A.DESCRIPCION,A.PRECIO_VENTA,B.CANTIDAD_ACTUAL,A.ID_TIPO_PRES_PROD,
        (A.PRECIO_VENTA*B.CANTIDAD_ACTUAL) AS MONTOPROD FROM productos A INNER JOIN inventario B ON A.ID_PRODUCTO=B.ID_PRODUCTO WHERE B.CANTIDAD_ACTUAL!=0 ORDER BY A.DESCRIPCION ASC;';
        //$datos=array();
        $consulta=$conexion->query($cons);
        if($cons->errno)die("(1):::".$consulta->error);

        while($row=$consulta->fetch_array()){
            if($row['ID_TIPO_PRES_PROD']==7){
                $precFinal=$row['PRECIO_VENTA']/1000;
                $totalPrec=$row['CANTIDAD_ACTUAL']*$precFinal;
            }else{
                $precFinal=$row['PRECIO_VENTA'];
                $totalPrec=$row['CANTIDAD_ACTUAL']*$precFinal;
            }

            $datos[]=array(
            'id_producto'=>$row['ID_PRODUCTO'],
            'cve_producto'=>strval($row['CVE_PRODUCTO']),
            'descripcion'=>$row['DESCRIPCION'],
            'precio_venta'=>$precFinal,
            'cantidad_actual'=>$row['CANTIDAD_ACTUAL'],
            'total'=>$totalPrec
        );
        $sumaMontos=$sumaMontos+$totalPrec;
        }
        $datos[]=array(
            'id_producto'=>'',
            'cve_producto'=>'',
            'descripcion'=>'',
            'precio_venta'=>'',
            'cantidad_actual'=>'',
            'total'=>''
        );
        $datos[]=array(
            'id_producto'=>'',
            'cve_producto'=>'',
            'descripcion'=>'',
            'precio_venta'=>'',
            'cantidad_actual'=>'SUMATORIA TOTAL',
            'total'=>$sumaMontos
        );




    break;

    default:
    break;
}
    
    echo json_encode($datos);

?>