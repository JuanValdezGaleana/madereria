<?php
require("../aut_verifica.inc.php"); 

if($_GET['f1']=='' && $_GET['f2']==''){
$fInicioAx=$_POST['fecha_inicio']."00:00:00";
$fFinAx=$_POST['fecha_fin']." 23:59:59";
}
if($_GET['f1']!='' && $_GET['f2']!=''){
	$fInicioAx=$_GET['f1'];
	$fFinAx=$_GET['f2'];
	
}



$fInicio = date("Y-m-d H:i:s", strtotime($fInicioAx));
$fFin = date("Y-m-d H:i:s", strtotime($fFinAx));


/*CONSULTAMOS EL NOMBRE DEL PRESTADOR*/
$cRepo=mysql_query("
				    SELECT
					A.CVE_VENTA,
					A.FECHA,
					SUM( A.CANTIDAD_VEN ) AS PROD_VENDIDOS,
					SUM( A.PRECIO_VENTA ) AS TOT,
					C.NOMBRE,
					C.AP_PATERNO,
					C.AP_MATERNO,
					
					D.ESTATUS_VENTA
					FROM ventas_salidas A
					INNER JOIN productos B
					ON A.ID_PRODUCTO = B.ID_PRODUCTO
					INNER JOIN persona C
					ON A.ID_PERSONA=C.ID_PERSONA
					INNER JOIN cat_estatus_venta D
					ON D.ID_ESTATUS_VENTA=A.ID_ESTATUS_VENTA
					
					WHERE A.FECHA
					BETWEEN  '$fInicio'
					AND  '$fFin'
					AND A.ID_ESTABLECIMIENTO = 1
					GROUP BY A.CVE_VENTA

					;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());

$desti="pintusayer.santiagot@gmail.com";
$correo="marcos.mata@sitis.mx";//correo de la persona quien manda el mensaje
$asunto="REPORTE DE VENTAS";

/*$e_mail=$_POST['e_mail'];*/ //correo a quien se le manda el mensaje
$seEnvio;      //Para determinar si se envio o no el correo
$destinatario = $desti; //destino
 
//Establecer cabeceras para la funcion mail()
//version MIME
$cabeceras = "MIME-Version: 1.0\r\n";
//Tipo de info
$cabeceras .= "Content-type: text/html; charset=utf8_unicode_ci\r\n";
//direccion del remitente   
$cabeceras .= "From: SISTEMA DE PUNTO DE VENTA<".$correo.">";


$cuerpomsg1 ='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $nom_negocio;  ?></title>
<link rel="stylesheet" href="css/1estilos.css" media="screen">
<link rel="stylesheet" href="css/surtir.css" type="text/css">
<link rel="stylesheet" href="css/ordenlistas.css" type="text/css">
<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="css/estilo_iconos.css" type="text/css"> 
<!--INICIO VALIDADOR DE CAMPOS -->

<script type="text/javascript" src="js/lv.js"></script>

<table width="100%" >
 <tr>
 <td colspan="4" style="background:rgba(13,119,132,1.00); color:#FFF;">
 REPORTE DE VENTAS POR FECHA
 </td>
 </tr>
  <tr class="bgtabla" style="background:rgba(13,119,132,0.70)">
    <td width="18%" align="center" valign="middle">VENTA</td>
    <td width="31%" align="center" valign="middle">FECHA</td>
    <td width="26%" align="center" valign="middle">CANTIDAD DE PRODUCTOS</td>
    <td width="25%" align="center" valign="middle">TOTAL DE VENTA</td>
  </tr>';
  
 while($rDat=mysql_fetch_array($cRepo)){ 
	 $cve=$rDat['CVE_VENTA'];
 $var1.='
    <tr class="hover_lista" style="background:rgba(13,119,132,0.30)">
    <td>'.$rDat['CVE_VENTA'].'</td>
	<td>'.$rDat['FECHA'].'</td>
	<td>'.$rDat['PROD_VENDIDOS'].'</td>
    <td align="right">$'.number_format($rDat['TOT'], 2, ".", ",").'</td>
    
  </tr>
  
  ';
	 $cRepo1=mysql_query("
				    SELECT
					B.DESCRIPCION,
					B.NOMBRE_PRODUCTO,
					A.CANTIDAD_VEN,
					A.PRECIO_VENTA
					FROM ventas_salidas A
					INNER JOIN productos B
					ON A.ID_PRODUCTO = B.ID_PRODUCTO
					INNER JOIN persona C
					ON A.ID_PERSONA=C.ID_PERSONA
					INNER JOIN cat_estatus_venta D
					ON D.ID_ESTATUS_VENTA=A.ID_ESTATUS_VENTA
					WHERE CVE_VENTA='$cve'
					;
				   ")
or die("No se pudo hacer la consulta. </br>".mysql_error());
	 
	 $var1.='
    <tr class="hover_lista">
    <td>----></td>
	<td>PRODUCTO</td>
	<td>CANTIDAD VEND.</td>
    <td align="right">PRECIO</td>
    
  </tr>
  
  ';
	 while($rDat1=mysql_fetch_array($cRepo1)){ 
	  $var1.='
    <tr class="hover_lista">
	<td></td>
    <td>'.$rDat1['NOMBRE_PRODUCTO'].' '.$rDat1['DESCRIPCION'].'</td>
	<td>'.$rDat1['CANTIDAD_VEN'].'</td>
    <td align="right">$'.number_format($rDat1['PRECIO_VENTA'], 2, ".", ",").'</td>
    
  </tr>
  
  ';
	 }
	  $sumaAux=$sumaAux+$rDat['TOT'];
 }
$cuerpomsg3='<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td align="right" class="bgtabla"><strong>SUMA TOTAL $'.number_format($sumaAux, 2, ".", ",").'</strong></td>
    
  </tr>
</table>
';


$msjcompleto=$cuerpomsg1.$var1.$cuerpomsg3;

	 if(mail($destinatario,$asunto,$msjcompleto,$cabeceras))
        $seEnvio = true;
    else
        $seEnvio = false;
//Enviar el estado del envio (por metodo GET ) y redirigir navegador al archivo comentario.html
        if($seEnvio == true)
    {
		        
		?>
        <script language="javascript"> 
alert
('Se ha mandado la notificaci\u00F3n de aceptaci\u00F3n de documentos'); 
location.href = "index.php?f1=<?php echo $fInicio;?>&f2=<?php echo $fFin;?>";
</script>
        <?php
    }
    else
    {
       
	   ?>
        <script language="javascript"> 
alert
('Ocurri\u00F3 un error al mandar tu mensaje'); 
 history.back();
</script>
       <?php
	   
    }
?>

