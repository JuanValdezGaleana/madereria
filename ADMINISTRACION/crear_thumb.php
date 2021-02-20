<?php
//directorio donde queremos guardar las previsualizaciones.

$ancho_preview = 100;  
//$directorio = "imagenes/";  //Directorio de donde va a tomar la imagen a redimensionar
 if($n_alb==""){
 $directorio = "imagenes/";
 }else{
 		if($n_alb!=""){
 			$directorio = "imagenes/$n_alb/"; 

 		}
 }
$extensiones = array("gif","jpg","png");  
//$directorioGuardar = "thumbs/";  //Directorio en donde se va a guardar la nueva imagen redimensionada

 if($n_alb==""){
 $directorioGuardar = "thumbs/"; 
 }else{
 		if($n_alb!=""){
 			$directorioGuardar = "thumbs/$n_alb/"; 
 		}
 }

//A continuación haremos algunas comprobaciones básicas para verificar que el directorio existe y que se puede abrir.
 
if(is_dir($directorio) && $dir = opendir($directorio)){  

  //while (($nombre_archivo = readdir($dir)) !== false){  // Para recorrer todos los archivos del
  														  //directorio de la veriable $directorio
	$archivo = pathinfo($directorio.$nombre); 
	 
    if (in_array(strtolower($archivo['extension']),$extensiones))  
    {  
      //if(strtolower($archivo['extension'])=="gif"){ 
//          $img = imagecreatefromgif($directorio.$nombre);  
//      }else 
	  		if(strtolower($archivo['extension'])=="jpg"){
          		$img = imagecreatefromjpeg($directorio.$nombre);  
      		}//else 
//				if(strtolower($archivo['extension'])=="png"){
//          			$img = imagecreatefrompng($directorio.$nombre);  
//      }  
	  
      $ancho = imagesx($img);  
      $altura = imagesy($img);  
      $ancho_nuevo = $ancho_preview;  
      $nueva_altura = floor($altura*($ancho_preview/$ancho));  
      $tmp_img = imagecreatetruecolor($ancho_nuevo,$nueva_altura);  
      imagecopyresized($tmp_img,$img,0,0,0,0,$ancho_nuevo,$nueva_altura,$ancho,$altura);  
      if(strtolower($archivo['extension'])=="gif"){  
          imagegif( $tmp_img,$directorioGuardar.$nombre);  
      }else if(strtolower($archivo['extension'])=="jpg"){
          imagejpeg( $tmp_img,$directorioGuardar.$nombre);  
      }else if(strtolower($archivo['extension'])=="png"){ 
          imagepng( $tmp_img,$directorioGuardar.$nombre);  
      }  //7
    } //1 
// } //fin while
} else{echo "El directorio no existe";} // if
closedir($dir); 

 ?>