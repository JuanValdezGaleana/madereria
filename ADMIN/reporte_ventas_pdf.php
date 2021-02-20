<?php require("../aut_verifica.inc.php");
require_once('../class.ezpdf.php');
$id_establecimiento=$_SESSION['SESSION_ID_ESTABLECIMIENTO'];
// función para convertir los puntos en centimetros
function puntos_cm ($medida, $resolucion=72){
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}
header('Content-Type: text/html; charset=iso-8859-1');
// don't want any warnings turning up in the pdf code if the server is set to 'anal' mode.
//error_reporting(7);
error_reporting(E_ALL);
set_time_limit(1800);

class Creport extends Cezpdf {
var $reportContents = array();
	function Creport($p,$o,$t,$op){
	  $this->Cezpdf($p,$o,$t,$op);
	}
function rf($info){
  // this callback records all of the table of contents entries, it also places a destination marker there
  // so that it can be linked too
  $tmp = $info['p'];
  $lvl = $tmp[0];
  $lbl = rawurldecode(substr($tmp,1));
  $num=$this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
  $this->reportContents[] = array($lbl,$num,$lvl );
  $this->addDestination('toc'.(count($this->reportContents)-1),'FitH',$info['y']+$info['height']);
}
}// FIN (class Creport extends Cezpdf)



$pdf = new Creport('letter','portrait','color',array(0.8,0.8,0.8));
//$pdf -> ezSetMargins(50,70,50,50); <-ejemplo
//     ezSetMargins(top,bottom,left,right)
$pdf->ezSetCmMargins(1.5,  1.5,   2,   2);//margenes en centimetros
$pdf->selectFont('../fonts/Arial.afm'); //Fuente de la letra
//COLOCAR NÚMEROS DE PÁGINAS EN PDF
//                         posicion X     posicion Y   tamaño            formato de numeración            1er numero
$pdf->ezStartPageNumbers(580,30,  10  ,'',$pattern=utf8_encode('Página').' {PAGENUM} de {TOTALPAGENUM}',    1    );

$fInicio=$_POST['fInicio'];
$fFin=$_POST['fFin'];

$pdf->ezText("REPORTE DE VENTAS", 12,array('justification'=>'left'));
$pdf->ezText("DE ".date("d-m-Y", strtotime($fInicio))." AL ".date("d-m-Y", strtotime($fFin)), 12,array('justification'=>'left'));
$pdf->ezText("\n", 8,array('justification'=>'center'));

$qventas=mysql_query("
SELECT
A.CVE_VENTA,
A.FECHA,
C.NOMBRE,
C.AP_PATERNO,
C.AP_MATERNO,
B.DESCRIPCION,
A.PRECIO_VENTA,
D.ESTATUS_VENTA
FROM ventas_salidas A
INNER JOIN productos B
ON A.ID_PRODUCTO=B.ID_PRODUCTO
INNER JOIN PERSONA C
ON A.ID_PERSONA=C.ID_PERSONA
INNER JOIN cat_estatus_venta D
ON A.ID_ESTATUS_VENTA=D.ID_ESTATUS_VENTA
WHERE A.FECHA
BETWEEN '".$fInicio."'
AND '".$fFin."'
AND A.ID_ESTABLECIMIENTO = $id_establecimiento
ORDER BY A.ID_VENTA_SALIDA ;")
or die("No se pudo hacer la consulta.<br/>".mysql_error());

$counter=0;
$table=array();

$suma1=0;

while($dventas=mysql_fetch_array($qventas))
{
	$suma1=$suma1+$dventas['PRECIO_VENTA'];
	$counter++;
	$table[]=array("CLAVE"=>$dventas['CVE_VENTA'],
				   "FECHA"=>date("d-m-Y H:i:s", strtotime($dventas['FECHA'])),
				   "NOMBRE"=>$dventas['NOMBRE'].' '.$dventas['AP_PATERNO'].' '.$dventas['AP_MATERNO'],
				   utf8_encode('DESCRIPCIÓN')=>$dventas['DESCRIPCION'],
				   "ESTATUS"=>$dventas['ESTATUS_VENTA'],
				   "VENTA"=>"$ ".$dventas['PRECIO_VENTA']
				   
				   );
}
$options = array('shadeCol'=>array(0.9,0.9,0.9), 'xOrientation'=>'center','shaded' =>1,'showLines'=>1, 'width'=>510,'showHeadings'=>1, 'fontSize' => 7, 'cols' => array(
																			'CLAVE'=> array('justification'=>'centre'),
																			'FECHA'=> array('width'=>78,'justification'=>'centre'),
																			'NOMBRE'=> array('justification'=>'left'),
																utf8_encode('DESCRIPCIÓN')=> array('justification'=>'left'),
																			'VENTA'=>array('justification'=>'right'),
																			'VENTA'=> array('width'=>60,'justification'=>'right')
																														  ));
$pdf->ezTable($table, "", "",$options);//aquí se construye la tabla
/* ----------------------------------  Definimos la tabla  ------------------------------- */
$titles = array('id1'=>'','id2'=>''); 
$data = 
array(
array('id1'=>'TOTAL', 'id2'=>"$ ".number_format($suma1,2))
);
//Aqui definimos las opciones de la tabla
$options = array('width'=>510, 'fontSize' => 7,'shaded' => 2,'showLines'=>2,'showHeadings'=>0,'cols' => array(
																			  'id1'=> array('justification'=>'right'),
																			  'id2'=> array('width'=>60,'justification'=>'right')
																			  ));
$pdf->ezTable($data, $titles, '', $options);//aquí se construye la tabla
/* ---------------------------------------------------------------------------------------- */


//CREA UNA NUEVA PÁGINA
//$pdf->ezNewPage();

//MOSTRAR LA PAGINA EN PDF
$pdf->ezStream();

//GUARDAR LA PAGINA EN PDF
//EN LA RUTA ESPECIFICADA
/*$documento_pdf = $pdf->ezOutput();
$fichero = fopen('prueba.pdf','wb');
fwrite ($fichero, $documento_pdf);
fclose ($fichero);
*/

?>