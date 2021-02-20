<?php
header('Content-Type: text/html; charset=iso-8859-1'); 
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
SELECT A.EMP_ID,  A.EMP_FOTO,
A.EMP_CUE,           A.EMP_NOM,        A.EMP_APAT,         A.EMP_AMAT,        A.EMP_FECHA_NAC, EMP_FECHA_FIN,
A.EMP_CURP,          A.EMP_RFC,        A.EMP_CVEIMSS,      B.TEL_TELEFONO,    C.CTT_TIPO_TEL, 
D.CTC_TIPO_CONTACTO, E.DIR_CALLE,      E.DIR_NUM_EXT,      E.DIR_NUM_INT,     E.DIR_REFERENCIA, 
F.CLO_LOCALIDAD,     G.CMU_MUNICIPIO,  H.CCP_CODIGO_POSTAL, A.EMP_FECHA_INICIO
FROM EMPLEADOS A
INNER JOIN TELEFONOS B ON A.EMP_ID = B.EMP_ID
INNER JOIN CAT_TIPOS_TELEFONO C ON B.CTT_ID = C.CTT_ID
INNER JOIN CAT_TIPOS_CONTACTO D ON B.CTC_ID = D.CTC_ID
INNER JOIN DIRECCIONES E ON A.EMP_ID = E.DIR_ID
INNER JOIN CAT_LOCALIDADES F ON E.CLO_ID = F.CLO_ID
INNER JOIN CAT_MUNICIPIOS G ON F.CMU_ID = G.CMU_ID
INNER JOIN CAT_CODIGOS_POSTALES H ON F.CCP_ID = H.CCP_ID
WHERE A.EMP_CUE = '$emp_cue'
";

$query2=mysql_query("
SELECT D.CAR_AREA, E.CPU_PUESTO
FROM EMPLEADOS_CARGO A
INNER JOIN EMPLEADOS B ON A.EMP_ID = B.EMP_ID
INNER JOIN ASOC_AREAS_PUESTOS C ON A.AAP_ID = C.AAP_ID
INNER JOIN CAT_AREAS D ON C.CAR_ID = D.CAR_ID
INNER JOIN CAT_PUESTOS E ON C.CPU_ID = E.CPU_ID
INNER JOIN CAT_ESTATUS_ACTIVO F ON C.CEA_ID = F.CEA_ID
INNER JOIN CAT_ESTATUS_ACTIVO G ON B.CEA_ID = G.CEA_ID
WHERE EMP_CUE =  '$emp_cue'
")
or dir("Error en la consulta de los datos. ".mysql_error());
$datos2=mysql_fetch_array($query2);

$resEmp = mysql_query($queEmp) or die(mysql_error());

$datos=mysql_fetch_array($resEmp);

$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}




//COLOCAR NÚMEROS DE PÁGINAS EN PDF
//                         posicion X     posicion Y   tamaño            formato de numeración            1er numero
$pdf->ezStartPageNumbers(puntos_cm(11.9),puntos_cm(2),  10  ,'',$pattern='HOJA {PAGENUM} DE {TOTALPAGENUM}',    1    );		


$all = $pdf->openObject();
$pdf->saveState();

//TEXTO               posX             posY        tam           texto                   angulo
$pdf->addText(puntos_cm(8),  puntos_cm(25.4),  16, "<b>CLINICA SAN CARLOS</b>\n",   0  );
$pdf->addText(puntos_cm(8),  puntos_cm(24.4),  14, "DATOS DEL EMPLEADO\n",   0  );

//INSERTAR IMAGEN      ruta imagen                       posX           posY         tamañoX       tamañoY
$pdf->addJpegFromFile('../imagenes/logoizq.jpg', puntos_cm(3), puntos_cm(24.2),puntos_cm(3)/*,puntos_cm(2)*/);


//$txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
//$txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
//            texto  tamaño
//$pdf->ezText($txttit,  16  );


//HACER LINEAS
//                 grosor
$pdf->setLineStyle(  3  ,'round');
//      color        R G B
$pdf->setStrokeColor(0,0,0);
//           posX ini      posY ini      posX fin       posY fin
$pdf->line(puntos_cm(3),puntos_cm(24),puntos_cm(18.7),puntos_cm(24));

$pdf->setLineStyle(2,'round');
$pdf->setStrokeColor(0,0,0);
$pdf->line(puntos_cm(3),puntos_cm(23.8),puntos_cm(18.7),puntos_cm(23.8));
//LINEA DEL FONDO
$pdf->setLineStyle(1,'ROUND');
$pdf->setStrokeColor(0,0,0,1);
//POSICIÓN DE LA LÍNEA DEL FONDO 
//                   X1            Y1             X2             Y2
$pdf->line(puntos_cm(3),puntos_cm(2.5),puntos_cm(18.7),puntos_cm(2.5));


$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all,'all');
//FOTO DEL EMPLEADO
if($datos[1]!=""){
//INSERTAR IMAGEN            ruta imagen                           posX           posY         tamañoX       tamañoY
$pdf->addJpegFromFile('../fotos_empleados/'.$datos['EMP_FOTO'].'', puntos_cm(3), puntos_cm(20.5),puntos_cm(3)/*,puntos_cm(2.5)*/); //Se comenta tamañoY para que se redimensione automáticamente lo alto de la imagen
}else{
		if($datos[1]=="")
		$pdf->addJpegFromFile('../fotos_empleados/SIN_FOTO.JPG', puntos_cm(3), puntos_cm(20.5),puntos_cm(4)/*,puntos_cm(2.5)*/); 
}

//$pdf->ezText("\n\n", 10);
//$pdf->ezTable($data, $titles, '<b>T&Iacute;TULO DE LA TABLA</b>', $options);

//TEXTO               posX           posY   tam           texto                                    angulo
$pdf->addText(puntos_cm(7.3),  puntos_cm(22),  12,utf8_decode( "<b>NOMBRE: $datos[EMP_NOM] $datos[EMP_APAT] $datos[EMP_AMAT]</b>" ),   0  );
$pdf->addText(puntos_cm(7.3),  puntos_cm(21.3),  12, "<b>CUE: $datos[EMP_CUE]</b>",   0  );

$pdf->addText(puntos_cm(3),  puntos_cm(19.2),  12, "<b>DATOS PERSONALES</b>",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(18.3),  12, "FECHA DE NACIMIENTO: $datos[EMP_FECHA_NAC]",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(17.7),  12, utf8_decode("DIRECCI&Oacute;N: $datos[DIR_CALLE], NO. EXTERIOR $datos[DIR_NUM_EXT], NO. INTERIOR $datos[DIR_NUM_INT]"),   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(17.1),  12, utf8_decode("$datos[CLO_LOCALIDAD], $datos[CMU_MUNICIPIO], C.P. $datos[CCP_CODIGO_POSTAL]"),   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(16.5),  12, "TEL&Eacute;FONO: $datos[TEL_TELEFONO], $datos[CTT_TIPO_TEL], $datos[CTC_TIPO_CONTACTO]",   0  );
$pdf->ezSetY(puntos_cm(16.4)); $pdf->ezText(utf8_decode("REFERENCIA: $datos[DIR_REFERENCIA]"), 12,array('justification'=>'full'));
$pdf->addText(puntos_cm(3),  puntos_cm(14.4),  12, "CURP: $datos[EMP_CURP]",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(13.8),  12, "RFC: $datos[EMP_RFC]",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(13.2),  12, "CLAVE IMSS: $datos[EMP_CVEIMSS]",   0  );


$pdf->addText(puntos_cm(3),  puntos_cm(12),  12, "<b>DATOS DE TRABAJO</b>",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(11.1),  12, "FECHA DE INGRESO: $datos[EMP_FECHA_INICIO]",   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(10.5),  12, "&Aacute;REA DE TRABAJO:".utf8_decode(" $datos2[CAR_AREA]"),   0  );
$pdf->addText(puntos_cm(3),  puntos_cm(9.9),  12,utf8_decode( "PUESTO: $datos2[CPU_PUESTO]"),   0  );

$pdf->addText(puntos_cm(3),  puntos_cm(9),  12, "FECHA BAJA: $datos[EMP_FECHA_FIN]",   0  );



$pdf->ezSetY(150);// ezSetY() Pone el puntero rn una nueva posición en Y en el docmento
//$pdf->ezText("NOMBRE: $datos[3] $datos[4] $datos[5] EZTEXTTTT", 12);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n", 10);
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
