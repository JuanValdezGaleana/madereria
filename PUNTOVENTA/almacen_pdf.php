<?php

require_once('../pdf/class.ezpdf.php');
include('../pdf/class.backgroundpdf.php'); 

		
 
$pdf = new backgroundPDF('letter', 'portrait', 'image', array('img' => ''));  
$pdf->selectFont('../fonts/Times-Roman.afm');
$pdf->ezSetCmMargins(1,1,1,5);

// función para convertir los puntos en centimetros
function puntos_cm ($medida, $resolucion=72){
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}
//INSERTAR IMAGEN      ruta imagen                     posX           posY           tamañoX        tamañoY
$pdf->addJpegFromFile('images/desti_small.jpg', puntos_cm(16), puntos_cm(25),puntos_cm(4.5),puntos_cm(2));
require("../aut_verifica.inc.php");


$id_escuela=$_POST['id_escuela'];
$grado=$_POST['grado'];
$grupo=$_POST['grupo'];

/*$conexion = mysql_connect("localhost", "root", "1234567");
mysql_select_db("bd_ingles", $conexion);*/


/*SE SACA EL NÚMERO DE REGISTROS QUE SEAN RECARGA PARA PODER DIVIDIR LA SUMA DE LA CANTITAD TOTOAL DISPONIBLE ENTRE EL NÚMERO DE REGISTROS*/
		$num=mysql_query("
						SELECT
						COUNT(A.DESCRIPCION) AS DIVI
						FROM productos A
						INNER JOIN cat_tipos_producto B
						ON A.ID_TIPO_PRODUCTO=B.ID_TIPO_PRODUCTO
						WHERE B.TIPO_PRODUCTO='RECARGAS'
						;
						 ")
		or die("No se pudo consultar la cantidad de registros de recargas. <br>".mysql_error());
		$dNum=mysql_fetch_array($num);
		$dividir=$dNum['DIVI'];






$queEmp = "
SELECT
					C.ID_TIPO_PRODUCTO,
					C.TIPO_PRODUCTO,
                    COUNT(NOMBRE_PRODUCTO) AS CANT,
					/*A.NOMBRE_PRODUCTO,*/
					/*A.PRECIO_FINAL,*/
		  		/*B.CANTIDAD_ACTUAL,*/   /* */
          /*D.TIPO_PRES_PROD,*/
          SUM(
           IF(D.TIPO_PRES_PROD='A GRANEL',((B.CANTIDAD_ACTUAL)/(A.PRECIO_FINAL)),
                IF(D.TIPO_PRES_PROD='RECARGA',((B.CANTIDAD_ACTUAL)/(A.PRECIO_FINAL))/$dividir,
                      A.PRECIO_FINAL*B.CANTIDAD_ACTUAL
                   )
                                          )
              )
            AS SUMA_TIPO
					/*SUM(A.PRECIO_FINAL*CANTIDAD_ACTUAL) AS SUMA_TIPO*/
					FROM productos A
					INNER JOIN inventario B
					ON A.ID_PRODUCTO=B.ID_PRODUCTO
					INNER JOIN cat_tipos_producto C
					ON A.ID_TIPO_PRODUCTO=C.ID_TIPO_PRODUCTO
          INNER JOIN cat_tipo_pres_prod D
          ON A.ID_TIPO_PRES_PROD=D.ID_TIPO_PRES_PROD
					WHERE A.ID_ESTABLECIMIENTO=1
					GROUP BY C.TIPO_PRODUCTO;
";
$resEmp = mysql_query($queEmp, $enlace) or die(mysql_error());



$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}



$titles = array(
				
				'TIPO_PRODUCTO'=>'<b>N.L</b>',
				'CANT'=>'<b>NOMBRE</b> ',
				'SUMA_TIPO'=>'<b>B1</b>'
			);
$options = array(
				
				'xPos' =>'300',
				'showHeadings'=>1,
				'shaded'=>1,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500,
				'showLines'=>2,
				'rowGap' => 3
			    
			);
//COLOCAR NÚMEROS DE PÁGINAS EN PDF
//                         posicion X     posicion Y   tamaño       1er numero
$pdf->ezStartPageNumbers(puntos_cm(11.5),puntos_cm(.3),  10  ,'','',    1    );		



//            posX  posY  tam
$pdf->addText(156,  464,  10, "tEXTO DE PRUEBA",0);
$texto="HOLASSSS";
//            posX  posY  tam  texto  angulo
$pdf->addText(260,  550,  10,  $texto,   0  );
$pdf->addText(546,547,10,"JJJJJJJJJ",-45);

$txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
$txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
//            texto  tamaño
$pdf->ezText($txttit,  16  );

//HACER LINEAS
//                 grosor
$pdf->setLineStyle(  3  ,'round');
//      color        R G B
$pdf->setStrokeColor(0,0,205);
//           posX ini      posY ini      posX fin       posY fin
$pdf->line(puntos_cm(1),puntos_cm(25),puntos_cm(20.5),puntos_cm(25));


$pdf->setLineStyle(3,'round');
$pdf->setStrokeColor(0,191,255);
$pdf->line(puntos_cm(2),puntos_cm(24.5),puntos_cm(19.5),puntos_cm(24.5));

$pdf->ezText("\n\n", 10);
$pdf->ezTable($data, $titles, 'TITULO DE LA TABLA', $options );
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
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