<?php require("../aut_verifica.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACTUALIZAR</title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>

</head>

<body>
<?php



if($HTTP_POST_FILES["userfile"]["name"]==""&&$_POST['foto']!=""){
	$op=1;
}
if($HTTP_POST_FILES["userfile"]["name"]!=""){
	$op=2;
}


switch($op){
	case 1:
	//echo "Entra a case 1<br>";
		$nombre_archivo=$_POST['foto'];
		include("update_empleado.php");
		//echo "Nombree: $nombre_archivo";
	break;
	
	
	case 2:
		//echo "Entra a case 2<br>";
			 //Se obtienen os datos de la foto
    $nombre_archivo = $HTTP_POST_FILES["userfile"]["name"];  
	$tipo_archivo = $HTTP_POST_FILES["userfile"]["type"];  
	$tamano_archivo = $HTTP_POST_FILES["userfile"]["size"]; 
	//echo "nombre> $nombre_archivo<br>";
	$emp_cue=$_POST['emp_cue'];
	$foto=$_POST['foto'];
	
	
	
	//query para saber si ya existe un registro con el mismo nombre
	$consulta=mysql_query("SELECT COUNT(FOTO)
	FROM persona WHERE FOTO='$nombre_archivo'")or die("Error al contar la existencia de fotos. ".mysql_error());
	$c=mysql_fetch_array($consulta);
	$c1=$c['COUNT(FOTO)'];
	//$C1=$f['EMP_FOTO'];
	
	
		
		if($c1>=1){
				$opcion=1;
		}
		if($c1==0){
				$opcion=2;
		}
			
		
		
		
		switch($opcion){
		
			case 1:
				?>
				<script language="javascript">
				alert
				('Ya existe un registro de una foto con el mismo nombre.\n Intenta cambiando el nombre de archivo de la foto.\n Nombre: <?php echo "$nombre_archivo"; ?>' );
				location.href = "modificar_empleado.php?emp_cue=<?php echo "$emp_cue"; ?>";
				<!--history.back(1);-->
				</script>
				<?php
			break;
			case 2:
			 
			     //require("aut_config.inc.php");
						//$nombre_archivo = $HTTP_POST_FILES["userfile"]["name"];
					/*echo "entra al else<br>";
					echo "tipo> $tipo_archivo<br>";
					echo "tam> $tamano_archivo<br>";*/
				ini_set("memory_limit","128M");
					
						
											///////////imagenes.php
				if (!(strpos($tipo_archivo, "jpeg") && (    $tamano_archivo < 5242880))) 
				/*                                                               ^
																	  1 Mb => 1048576 Bytes
																	  2 Mb => 2097152 Bytes
																	  3 Mb => 3145728 Bytes
																	  4 Mb => 4194304 Bytes
																	  5 Mb => 5242880 Bytes
																	  6 Mb => 6291456 Bytes
																	  7 Mb => 7340032 Bytes
				*/
				{  
				?>    
				<script language="javascript" type="text/javascript">
				alert
				('\u00BB La extensi\363n o el tama\361o del archivo no es correcta.\n  \u00BB S\363lo se permiten archivos .jpg\n  \u00BB S\363lo se permiten archivos de 5 Mb como m\341ximo.'); 
				history.back(1);
				</script>  
				  <?php   
				} 
				else 
				{ 
				
				//echo "Segundo else <br>";
				 $mensaje_error="La extensi&#65533;n o el tama&#65533;o de los archivos no es correcta. $tipo_archivo <br><br><table><tr><td><li>Se permiten archivos .gif, .png o .jpg 1<br><li>se permiten archivos de 2 Mb m&#65533;ximo.</td></tr></table>";
				 
				 //Se obtienen os datos de la foto
				 
				 $tmp_name = $HTTP_POST_FILES["userfile"]["tmp_name"];
				// $tamano_archivo = $HTTP_POST_FILES["userfile"]['size'];
				 //$name = $HTTP_POST_FILES["userfile"]["name"];
				 
				 $name=$nombre_archivo;
 
 //aqui le damos un nombre nuevo al archivo            
 $nombre = $name;
 //aqui le marcamos la extencion asi sea gif o png ya que al terminar el script seran jpg 
 $tipo = ".JPG";
				 //la carpeta donde guardara la imagen
				 //$carpeta = "imagenes/";
				 $carpeta = "../fotos_empleados/";
				 
				 //el nombre nuevo completo de la imagen
				 $nombreconpleto=$nombre;
				 //la ruta donde se guardara el archivo
				 $ruta_completa = $carpeta.$nombreconpleto;
				   /*  esto para determinar si realmente es un archivo jpg, gif o png ya que pueden enviar algun archivo con alguna de estas extenciones y si no se comprueba la funcion getimagesize podrian subirlo */
				   $tamanio = getimagesize($tmp_name);
					
					//echo "verifica tamanio $tamanio";
				   if ($tamanio[2]==true){
					
				   switch ($tamanio[2])
					  {
					 
					  /*############################# AQUI COMIENZA EL GIF #######################################*/    
					  case 1:  //aqui comprobamos si el archivo llego a los temporales si no damos el mensaje de error 
					  if (is_uploaded_file($tmp_name))
					  { //aqui comprobamos que el archivo no sea mayor de 2Mb aunque al redimencionar el archivo no sera mayor de 60 kb 
						//de ser mayor mandamos el mensaje de error
				
							 if (copy($tmp_name,"$ruta_completa")){ 
							 include('actualizar_redimensionar.php');
							 
							 }else{
								 print "Error en transferencia de archivo.";
								 exit();
							   }
				
					}else{ 
					//este es el mensaje de error del if (is_uploaded_file($tmp_name))
					echo $mensaje_error;}
				/*#################################### AQUI CIERRA EL GIF ##########################################*/    
					  break;
				/*#################################### AQUI COMIENZA EL PNG ##########################################*/       
					  case 2: 
					  //aqui comprobamos si el archivo llego a los temporales si no damos el mensaje de error 
					  if (is_uploaded_file($tmp_name))
					  { //aqui comprobamos que el archivo no sea mayor de 2Mb aunque al redimencionar el archivo no sera mayor de 60 kb 
						//de ser mayor mandamos el mensaje de error
				
							 if (copy($tmp_name,"$ruta_completa")){ 
							 include('actualizar_redimensionar.php');
							
							 }else{
								 print "Error en transferencia de archivo.";
								 exit();
							   }
					
					}else{ 
					//este es el mensaje de error del if (is_uploaded_file($tmp_name))
					echo $mensaje_error;}
					
				/*#################################### AQUI CIERRA EL JPG ##########################################*/        
					  break;
					  /*#################################### AQUI COMIENZA EL JPG ##########################################*/    
					   case 3: 
						 //aqui comprobamos si el archivo llego a los temporales si no damos el mensaje de error 
					  if (is_uploaded_file($tmp_name))
					  { //aqui comprobamos que el archivo no sea mayor de 2Mb aunque al redimencionar el archivo no sera mayor de 60 kb 
						//de ser mayor mandamos el mensaje de error
				
							 if (copy($tmp_name,"$ruta_completa")){ 
							 include('actualizar_redimensionar.php');
							
							 }else{
								 print "Error en transferencia de archivo.";
								 exit();
							   }
					}else{ 
					//este es el mensaje de error del if (is_uploaded_file($tmp_name))
					echo $mensaje_error;}
				/*#################################### AQUI CIERRA EL JPG ##########################################*/             
					   break;
					   /*#################### todos los demas es para cualquier otro tipo de archivos  y de el mensaje de error indicando que no es un archivo no valido ####################*/    
					
					  } 
					 
					}
				 
				
					  }// FIN if (!(strpos($tipo_archivo, "jpeg") && (    $tamano_archivo < 2050000)))
			 
			 break;
			
		
		}//fin switch($opcion)
		

	
	break;

} //fin switch($opc)


	
         
?>
</body>
</html>
