<?php
require("../../aut_verifica.inc.php");
$id_establecimiento=1;

$tipoVenta=$_POST['tipoVenta'];

if($_GET['fInicio']==''){
	$fInicio=$_POST['fInicio'];
	}elseif($_POST['fInicio']==''){
		$fInicio=$_GET['fInicio'];
		}
		
if($_POST['fFin']==''){
	$fFin=$_GET['fFin'];
	}elseif($_GET['fFin']==''){
		$fFin=$_POST['fFin'];
        }

$qventas=mysql_query("
SELECT
A.ID_VENTA_SALIDA,
A.FECHA,
A.CANTIDAD_VEN,
B.DESCRIPCION,
A.PRECIO_VENTA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO

INNER JOIN cat_estatus_venta D
ON A.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
WHERE A.FECHA
BETWEEN '".$fInicio."'
AND '".$fFin."'
AND A.ID_ESTATUS_VENTA=".$tipoVenta."
AND ID_ENVIADO=0
ORDER BY A.ID_VENTA_SALIDA ;")
or die("No se pudo hacer la consulta.<br/>".mysql_error());
        
switch ($tipoVenta) {
    case 1:
        $strTipoVenta="NORMAL";
    break;

    case 4:
        $strTipoVenta="CONTABLE";
    break;
    
    default:
        # code...
        break;
}

$nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $telefono=$_POST['telefono'];
        $mensaje=$_POST['mensaje'];

        $destinatario='eime2417@outlook.com';
        /*/////////////////////////////////////////////////////////////////////////////////////////////*/
                /*HACEMOS EL SCRIPT PARA MANDAR POR CORREO 	EL MENSAJE*/
                /*/////////////////////////////////////////////////////////////////////////////////////////////*/

                $correo=$correo;//correo de la persona quien manda el mensaje
                $asunto="Corte de ventas";
                /*$comentario=$_POST['mensaje'];*/

                /*$e_mail=$mail;*///correo a quien se le manda el mensaje

                /*$comentario = wordwrap($comentario, 70);*/ //Divide la cadena en filas de un valor dado
                $seEnvio;      //Para determinar si se envio o no el correo
                
                $destinatario =$destinatario; //destino

                /*$asunto = $nombre." ".$apellidos." Te ha mandado un mensaje.";*/

                //Establecer cabeceras para la funcion mail()
                //version MIME
                $cabeceras = "MIME-Version: 1.0\r\n";
                //Tipo de info
                $cabeceras .= "Content-type: text/html; charset=utf8_unicode_ci\r\n";
                //direccion del remitente
        
                $cabeceras .= "From:Corte de ventas<noreplay@mail.com>";
        
                $cuerpomsg ='
                <!doctype html>
                <html>
                <head>
                <meta charset="utf-8">
                <title>Corte</title>
                </head>
                
                <body>
                    <div style="font-family:Arial, Helvetica, sans-serif">
                        <div style="width:100%; line-height:50px; background: #333; color:#FFF; text-align:center;">CORTE DE VENTA '.$strTipoVenta.'</div>
                            <div style="background:#EEE; color:#000; width:80%; height:auto; padding:1% 10% 1% 10%;" >
                                
                                <table border="0">
                                    <tr>
                                        <th>FECHA/HORA</th>
                                        <th>DESCRIPCION</th>
                                        <th>PRECIO UNIT</th>
                                        <th>CANTIDAD</th>
                                        <th>IMPORTE</th>
                                    </tr>';
                while ($dventas=mysql_fetch_array($qventas)) {

                      $importe=$dventas['PRECIO_VENTA']*$dventas['CANTIDAD_VEN'];
                      $cuerpomsg .='<tr>
                                        <td>'.$dventas['FECHA'].'</td>
                                        <td>'.$dventas['DESCRIPCION'].'</td>
                                        <td>'.$dventas['PRECIO_VENTA'].'</td>
                                        <td>'.$dventas['CANTIDAD_VEN'].'</td>
                                        <td>'.$importe.'</td>
                                    </tr>';
                      $total=$total+$importe; 
                      
                      $updIdEnv=mysql_query('UPDATE ventas_salidas SET ID_ENVIADO=1 WHERE ID_VENTA_SALIDA='.$dventas['ID_VENTA_SALIDA'].';')or die("No se pudo actualizar el envio. <br>".mysql_error());

                }
                                    
                 $cuerpomsg .= '   <tr>
                                        <td colspan="4" align="right">TOTAL</td>
                                        <td align="right">'.$total.'</td>
                                   </tr>
                                </table>
                             </div>
                        </div>
                    </div>
                </body>
                </html>
                ';
                
                if(mail($destinatario,$asunto,$cuerpomsg,$cabeceras)){
                    $seEnvio = true;
                }else{
                    $seEnvio = false;
                }

                if($seEnvio==true){
                    $datos[]=array('resp'=>1);
                }else{
                    //echo 'error de envio';
                    $datos[]=array('resp'=>0);
                }

                header('Location:../corte_diario_t.php');

?> 