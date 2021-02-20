<?php
include('conect.php');
//require("../../aut_verifica.inc.php");
$op=$_GET['op'];
switch($op){
    case 1:
        $cod=trim($_POST['cod']);

    /* Verificamos si existe un registro en la tabla almacen, si no existe lo creamos */
        $consIdProd='SELECT ID_PRODUCTO FROM productos WHERE CVE_PRODUCTO="'.$cod.'";';
        $dConsIdProd=$conexion->query($consIdProd);
        $datIdProd=$dConsIdProd->fetch_assoc();
        $id_producto=$datIdProd['ID_PRODUCTO'];
        if($consIdProd->errno)die("(10):::".$dConsIdProd->error);

        if($id_producto=="" || $id_producto==NULL ){
            /* Si no se encuentra un registro con el código a buscar no se hace nada */
            $datos[]=array('');
        }else{

                 /*$consIdProd2='SELECT COUNT(ID_PRODUCTO) AS NUM_REG_ALM FROM inventario WHERE ID_PRODUCTO='.$id_producto.';';
                $dConsIdProd2=$conexion->query($consIdProd2);
                $datIdProd2=$dConsIdProd2->fetch_assoc();
                $count_prod_alm=$datIdProd2['NUM_REG_ALM'];
                if($consIdProd2->errno)die("(11):::".$dConsIdProd2->error);*/

                /*if($count_prod_alm==0){
                    $conexion->query("INSERT INTO almacen VALUES(".$id_producto.",'',0,NOW(),'0000-00-00 00:00:00',".$id_persona.",0,0);");
                    if($conexion->errno)die('(12):::'.$conexion->error);
                }*/
                $cons='SELECT
                ID_PRODUCTO,CVE_PRODUCTO,DESCRIPCION,PRECIO_VENTA
                 /*,
                IFNULL(C.CAD_FECHA,"0000-00-00") AS FECHA_PROX_CADUC*/
                FROM productos
                /*LEFT OUTER JOIN caducidades C
                ON B.ID_PRODUCTO=C.ID_PRODUCTO*/
                WHERE CVE_PRODUCTO = "'.$cod.'";';
                $datos=array();
                $consulta=$conexion->query($cons);
                if($cons->errno)die("(1):::".$consulta->error);

                while($row=$consulta->fetch_array()){
                    $datos[]=array('id_producto'=>$row['ID_PRODUCTO'],
                    'cve_producto'=>$row['CVE_PRODUCTO'],
                    'descripcion'=>$row['DESCRIPCION'],
                    'precio_venta'=>$row['PRECIO_VENTA']
                );
                }
        }

    break;
    case 2:

        $idProd=$_POST['idProd'];
        $numFact=$_POST['numFact'];
        $cantidad=$_POST['cantidad'];
        $tipoFact=$_POST['tipoFact'];
        $precUnitCompra=$_POST['precUnitCompra'];
        $precUnitVenta=$_POST['precUnitVenta'];

            /* Consultamos la cantidad actual en inventario */
            $consInv='SELECT CANTIDAD_ACTUAL FROM inventario WHERE ID_PRODUCTO='.$idProd.';';
            $consultaInv=$conexion->query($consInv);
                if($consultaInv->errno)die("(1):::".$consultaInv->error);

                while($row=$consultaInv->fetch_array()){
                    $suma=$row['CANTIDAD_ACTUAL']+$cantidad;
                }

            /* Aumentamos al inventario la cantidad ingresada */
            $updInv='UPDATE inventario SET CANTIDAD_ACTUAL='.$suma.' WHERE ID_PRODUCTO='.$idProd.';';
            $consultaInvUpd=$conexion->query($updInv);
            if($consultaInvUpd->errno)die("(1):::".$consultaInvUpd->error);

            /* Actualizamos el precio de venta */
            $updVent='UPDATE productos SET PRECIO_VENTA='.$precUnitVenta.',PRECIO_FINAL='.$precUnitVenta.'  WHERE ID_PRODUCTO='.$idProd.';';
            $consultaVentUpd=$conexion->query($updVent);
            if($consultaVentUpd->errno)die("(1):::".$consultaVentUpd->error);

            /* Guardamos los datos de la factura */
            $conexion->query("INSERT INTO inventario_mov (INM_ID,INM_NUM_FACTURA,INM_CANTIDAD,INM_FECHA_ALTA,ID_FACTURACION,ID_PRODUCTO,INM_PRECIO_COMPRA,INM_PRECIO_VENTA) VALUES('','".$numFact."',".$cantidad.",NOW(),".$tipoFact.",".$idProd.",".$precUnitCompra.",".$precUnitVenta.");");
            if($conexion->errno)die('(12):::'.$conexion->error);

            $datos[]=array('stat'=>1);

    break;

    case 3:
        
        $cons='SELECT A.INM_ID,A.ID_PRODUCTO,A.INM_NUM_FACTURA,B.CVE_PRODUCTO,B.DESCRIPCION,A.INM_FECHA_ALTA FROM inventario_mov A INNER JOIN productos B ON A.ID_PRODUCTO=B.ID_PRODUCTO ORDER BY DESCRIPCION ASC';
                //$datos=array();
                $consulta=$conexion->query($cons);
                if($cons->errno)die("(1):::".$consulta->error);

                while($row=$consulta->fetch_array()){
                    $datos[]=array('inm_id'=>$row['INM_ID'],
                    'id_producto'=>$row['ID_PRODUCTO'],
                    'inm_num_factura'=>$row['INM_NUM_FACTURA'],
                    'cve_producto'=>$row['CVE_PRODUCTO'],
                    'descripcion'=>$row['DESCRIPCION'],
                    'fecha_alta'=>$row['INM_FECHA_ALTA']
                );
                }

        

    break;
    case 4:

        $inm_id=$_POST['inm_id'];

        $cons='SELECT A.INM_ID,A.ID_PRODUCTO,A.INM_NUM_FACTURA,B.CVE_PRODUCTO,B.DESCRIPCION,A.INM_CANTIDAD,A.ID_FACTURACION,A.INM_PRECIO_COMPRA,A.INM_PRECIO_VENTA FROM inventario_mov A INNER JOIN productos B ON A.ID_PRODUCTO=B.ID_PRODUCTO WHERE INM_ID='.$inm_id.' ORDER BY DESCRIPCION ASC';
        //$datos=array();
        $consulta=$conexion->query($cons);
        if($cons->errno)die("(1):::".$consulta->error);

        while($row=$consulta->fetch_array()){
            $datos[]=array('inm_id'=>$row['INM_ID'],
            'id_producto'=>$row['ID_PRODUCTO'],
            'inm_num_factura'=>$row['INM_NUM_FACTURA'],
            'cve_producto'=>$row['CVE_PRODUCTO'],
            'descripcion'=>$row['DESCRIPCION'],
            'inm_cantidad'=>$row['INM_CANTIDAD'],
            'id_facturacion'=>$row['ID_FACTURACION'],
            'inm_precio_compra'=>$row['INM_PRECIO_COMPRA'],
            'inm_precio_venta'=>$row['INM_PRECIO_VENTA']
        );
        }
    break;

    default:
    break;
}
    
    echo json_encode($datos);

?>