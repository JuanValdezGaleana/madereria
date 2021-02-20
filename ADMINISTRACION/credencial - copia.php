<?php

$emp_cue=$_GET['emp_cue'];

// don't want any warnings turning up in the pdf code if the server is set to 'anal' mode.
//error_reporting(7);
error_reporting(E_ALL);
set_time_limit(1800);

include '../class.ezpdf.php';

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

// función para convertir los puntos en centimetros
function puntos_cm ($medida, $resolucion=72){
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}

                                                   
$pdf = new Creport('letter','portrait','color',array(0.8,0.8,0.8));
//$pdf -> ezSetMargins(50,70,50,50); <-ejemplo
//     ezSetMargins(top,bottom,left,right)
$pdf->ezSetCmMargins(2.5,  2.5,   3,   3);//margenes en centimetros
$pdf->selectFont('../fonts/Times-Roman.afm'); //Fuente de la letra

require("../aut_verifica.inc.php");

$queEmp = "
SELECT A.ID_PERSONA,  A.FOTO,
A.CUE,A.NOMBRE,A.AP_PATERNO,A.AP_MATERNO,        
A.TELEFONO,  A.E_MAIL, C.TIPO_TELEFONO 
FROM persona A
INNER JOIN cat_tipo_telefono C
WHERE A.ID_TIPO_TELEFONO=C.ID_TIPO_TELEFONO
AND A.CUE='$emp_cue'";

$query2=mysql_query("
SELECT D.AREA, E.PUESTO
FROM empleados_cargo A
INNER JOIN persona B ON A.ID_PERSONA = B.ID_PERSONA
INNER JOIN asoc_areas_puestos C ON A.asoc_area_puesto = C.asoc_area_puesto
INNER JOIN cat_areas D ON C.ID_AREA = D.ID_AREA
INNER JOIN cat_puesto E ON C.ID_PUESTO = E.ID_PUESTO
INNER JOIN cat_estatus_activo F ON C.ID_ESTATUS_ACTIVO = F.ID_ESTATUS_ACTIVO
INNER JOIN cat_estatus_activo G ON B.ID_ESTATUS_ACTIVO = G.ID_ESTATUS_ACTIVO
WHERE CUE = '$emp_cue'
")
or dir("Error en la consulta de los datos. ".mysql_error());
$datos2=mysql_fetch_array($query2);

$resEmp = mysql_query($queEmp) or die("Ha ocurrido un error. ".mysql_error());

$datos=mysql_fetch_array($resEmp);

$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}




$all = $pdf->openObject();
$pdf->saveState();

//INSERTAR IMAGEN      ruta imagen                       posX           posY         tamañoX       tamañoY
$pdf->addJpegFromFile('../barras/'.$emp_cue.'.jpg', puntos_cm(11.5), puntos_cm(24),puntos_cm(6.5)/*,puntos_cm(2)*/);


$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all');
//INSERTAR IMAGEN      ruta imagen                       posX           posY         tamañoX       tamañoY
$pdf->addJpegFromFile('../imagenes/credencial1.jpg', puntos_cm(2.0), puntos_cm(25.7),puntos_cm(8.5)/*,puntos_cm(2)*/);




//FOTO DEL EMPLEADO
if($datos[1]!=""){
//INSERTAR IMAGEN            ruta imagen                            posX               posY    tamañoX   tamañoY
		$pdf->addJpegFromFile('../fotos_empleados/'.$datos['FOTO'].'', puntos_cm(2.5), puntos_cm(23),100/*,puntos_cm(2.5)*/); //Se comenta tamañoY para que se redimensione automáticamente lo alto de la imagen
}else{
		if($datos[1]=="")
		$pdf->addJpegFromFile('../fotos_empleados/SIN_FOTO.JPG', puntos_cm(2.5), puntos_cm(23),puntos_cm(3)/*,puntos_cm(2.5)*/); 
}

//INSERTAR IMAGEN      ruta imagen                       posX           posY         tamañoX       tamañoY
$pdf->addJpegFromFile('../imagenes/credencial_fondo.jpg', puntos_cm(6.5), puntos_cm(22.6),puntos_cm(3.4)/*,puntos_cm(2)*/);


//rectángulo de credencial parte de ENFRENTE
$pdf->rectangle(puntos_cm(2), puntos_cm(22),puntos_cm(8.5), puntos_cm(5.4));
//rectángulo de credencial parte de ATRAS
$pdf->rectangle(puntos_cm(10.53), puntos_cm(22),puntos_cm(8.5), puntos_cm(5.4));
//$pdf->ezText("\n\n", 10);
//$pdf->ezTable($data, $titles, '<b>T&Iacute;TULO DE LA TABLA</b>', $options);

//utf8_decode("cadena"); quita la codificación UTF8

//TEXTO               posX           posY   tam           texto                                    angulo
$pdf->addText(puntos_cm(6.5),  puntos_cm(25.5),  9, "NOMBRE:",   0  );
$pdf->addText(puntos_cm(6.5),  puntos_cm(25.2),  10,utf8_decode("<b>$datos[NOMBRE]</b>"),   0  );
$pdf->addText(puntos_cm(6.5),  puntos_cm(24.9),  10,utf8_decode("<b>$datos[AP_PATERNO]</b>"),   0  );
$pdf->addText(puntos_cm(6.5),  puntos_cm(24.6),  10,utf8_decode("<b>$datos[AP_MATERNO]</b>"),   0  );

$pdf->addText(puntos_cm(6.5),  puntos_cm(24.1),  9, "&Aacute;REA DE TRABAJO:",   0  );
$pdf->addText(puntos_cm(6.5),  puntos_cm(23.8),  10,utf8_decode("<b>$datos2[AREA]</b>"),   0  );

$pdf->addText(puntos_cm(6.5),  puntos_cm(23.3),  9, "CLAVE:",   0  );
$pdf->addText(puntos_cm(6.5),  puntos_cm(23),  10, "<b>$datos[CUE]</b>",   0  );
//TEXTO               posX           posY   tam           texto                       angulo
/*$pdf->addText(puntos_cm(2.5),  puntos_cm(22.4),  10, "<b>INICIO: $datos[EMP_FECHA_INICIO] </b>",   0  );
$pdf->addText(puntos_cm(6),  puntos_cm(22.4),  10, "<b>IMSS: $datos[EMP_CVEIMSS] </b>",   0  );*/


//HACER LINEAS
//                 grosor
$pdf->setLineStyle(  1 );
//      color        R G B
$pdf->setStrokeColor(0,0,0);
//           posX ini      posY ini      posX fin       posY fin
$pdf->line(puntos_cm(11.8),puntos_cm(22.5),puntos_cm(17.8),puntos_cm(22.5));
$pdf->addText(puntos_cm(14.3),  puntos_cm(22.2),  9, "FIRMA",   0  );



//require("../codigo_barras/barcode.php");

//CREA UNA NUEVA PÁGINA
//$pdf->ezNewPage();

//MOSTRAR LA PAGINA EN PDF
$pdf->ezStream();

//GUARDAR LA PAGINA EN PDF
//EN LA RUTA ESPECIFICADA
/*
$documento_pdf = $pdf->output();
$fichero = fopen('prueba.pdf','wb');
fwrite ($fichero, $documento_pdf);
fclose ($fichero);
*/

?>
