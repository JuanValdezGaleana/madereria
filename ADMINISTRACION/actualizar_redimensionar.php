<?php
	//echo "ENTRA A REDIMENSIONAR.PHP<br>";
							////////redimencionar.php
							
					

/*### ESTE SCRIPT ES PARA IMAGENES JPG, GIF, PNG###*/
$ruta_imagen= "$ruta_completa";
//echo"ruta_imagen: $ruta_imagen";
//este es el acho maximo el alto es proporcional para no distorcionar la imagen
$medida = "120";
//aqui vamos a obtener los datos de la imagen en el caso de no estar buena la imagen por alguna razon dara este mensaje 

 if($tamanio[0]>5000||$tamanio[1]>5000){ // Se verifica si excede el tamaño en pixeles permitidos
        								 // El máximo de pixeles permitidos es 5000px
   unlink($ruta_imagen);
	?>  
<script language="javascript" type="text/javascript">
alert
('La foto no puede exceder mas de 5,000 pixeles de ancho o alto'); 
history.back();
</script> 
    <?php
	
  }else{ // Si la imagen no excede el máximo de pixeles, se continua con la redimensión de la imagen

switch ($tamanio[2])
      {
      case 1: $imagen= @imagecreatefromgif($ruta_imagen) or die ("<center><br /><br /><strong>la imagen esta da&ntilde;ada o <br />tiene un formato no valido GIF</strong></center>");
       break;
      case 2: $imagen= @imagecreatefromjpeg($ruta_imagen) or die ("<center><br /><br /><strong>la imagen esta da&ntilde;ada o <br />tiene un formato no valido JPG</strong></center>");
       break;
      case 3: $imagen= @imagecreatefrompng($ruta_imagen) or die ("<center><br /><br /><strong>la imagen esta da&ntilde;ada o <br />tiene un formato no valido PNG</strong></center>");
	  }
//obtenemos el tamaño de la imagen
   $ancho = @imagesx ($imagen);
   $alto = @imagesy ($imagen);
   
   //aqui compruebo si el ancho de la imagen es mayor que el establesido como limite de ser menor no se ejecuta el escript de redimencionar de ser mayor se procede a ajustarla a la medida
   
   //////////////////////////////////////////////   REDIMENCIONAR CON ANCHO DE FOTO  ////////////////////////////
 /*  if ($ancho > $medida){ 
   if($ancho>=$alto)
   {
      $nuevo_alto = round($alto * $medida / $ancho,0);  
      $nuevo_ancho=$medida;
   }
   else
   {
      $nuevo_ancho = round($ancho * $medida / $alto,0);
      $nuevo_alto =$medida;   
   }*/
   ///////////////////FIN REDIMENCIONAR ANCHO/////////////////////
   
   
  ///////////////////   REDIMENCIONAR CON EL ALTO DE LA FOTO   //////////////////////// 
    if ($alto > $medida){ 
   if($alto>=$alto)
   {
      $nuevo_ancho = round($ancho * $medida / $alto,0);  
      $nuevo_alto=$medida;
   }
   else
   {
      $nuevo_alto = round($alto * $medida / $ancho,0);
      $nuevo_ancho =$medida;   
   }
   
   
   
   
   
   
   
   
   
   
   //aqui se guarda en la bbdd la ruta y los datos que necesitemos
   // require("aut_config.inc.php");
   $ruta_ruta_1 = "$ruta_completa";

/*$consulta_insertar = "INSERT INTO tb_fotos (nom_foto,descrip_ft,fecha,id_album) 
                                    VALUES ('$name','$descrip_ft',current_date,'$id_album')";
mysql_query($consulta_insertar,$enlace ) or die("No se pudo insertar los datos en la base de datos. redimensionar.php ln 57. ".mysql_error());
if(isset ($_SESSION['ID_FOTO'])){
}else{
  $strConsulta2 = "SELECT id_foto from tb_fotos  where fecha=current_date order by id_foto desc LIMIT 1;";
		$listo2 = mysql_query($strConsulta2);
	$fila2 = mysql_fetch_array($listo2);
	$_SESSION['ID_FOTO']=$fila2['id_foto'];
	}*/
   $imagen_nueva = @imagecreatetruecolor($nuevo_ancho, $nuevo_alto); 
   @imagecopyresampled($imagen_nueva, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
   @imagejpeg($imagen_nueva, "$ruta_imagen");
   @imagedestroy($imagen_nueva);
   @imagedestroy($imagen);
 


//esto se ejecuta si la imagen es menor que el ancho estrablecido
}else{ 
 

$imagen_nueva = @imagecreatetruecolor($ancho, $alto);
   
@imagecopyresampled($imagen_nueva, $imagen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);
@imagejpeg($imagen_nueva, "$ruta_imagen", 90);
@imagedestroy($imagen_nueva);
@imagedestroy($imagen);

 
//aqui se guarda en la bbdd la ruta y los datos que necesitemos
/*    require("aut_config.inc.php");
$ruta_ruta_1 = "$ruta_completa";
 $id_inmueble=$_SESSION['ID_CARAC'];
		$id_inm_esp=$_SESSION['ID_INM_ESP'];
$consulta_insertar = "INSERT INTO tb_fotos (nom_foto,descrip_ft,fecha,id_album) 
                                    VALUES ('$name','$descrip_ft',current_date,'$id_album')";
mysql_query($consulta_insertar,$enlace ) or die("No se pudo insertar los datos en la base de datos. redimensionar.php ln 92. ".mysql_error());
if(isset ($_SESSION['ID_FOTO'])){
}else{

	}*/
}

//PARA CREAR LOS THUMBNAILS
//require("crear_thumb.php");


}//fin else de  if($ancho>2548||$alto>5000||$alto>1911||$alto>5000)

include("update_empleado.php");


?>