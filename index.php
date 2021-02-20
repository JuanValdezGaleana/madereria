<!DOCTYPE HTML>

<html>
	<head>
		<title>PUNTO DE VENTA</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
        <link href="imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
        <link rel="stylesheet" href="css/estilosinicio.css" media="screen">

<!--<script type="text/javascript">

var vid = document.getElementById("bgvid");
var pauseButton = document.querySelector("#polina button");

function vidFade() {
  vid.classList.add("stopfade");
}

vid.addEventListener('ended', function()
{
// only functional if "loop" is removed 
vid.pause();
// to capture IE10
vidFade();
}); 


pauseButton.addEventListener("click", function() {
  vid.classList.toggle("stopfade");
  if (vid.paused) {
    vid.play();
    pauseButton.innerHTML = "Pause";
  } else {
    vid.pause();
    pauseButton.innerHTML = "Paused";
  }
})


</script>-->

	</head>
    
    
    
    
<body>
<div style="width:100%; height:100%;">


<div class="esp_menu">
  <div class="logomenu"><img src="imagenes/caja.png"></div>
  <div class="tituloMenu">SITIS PV</div>
</div>

<div class="frase">
Tu punto de venta de confianza
</div>



<div class="esp_iconos"> 
   <div class="cont_ic">
     <div class="esp_ic">
      <img src="imagenes/icono1.png">
     </div>
     <div class="esp_letras">
     Ventas
     </div>
  </div>
  <div class="cont_ic">
     <div class="esp_ic">
      <img src="imagenes/icono1.png">
     </div>
     <div class="esp_letras">
     Almacen
     </div>
  </div>
  <div class="cont_ic">
     <div class="esp_ic">
      <img src="imagenes/icono1.png">
     </div>
     <div class="esp_letras">
     Proveedores
     </div>
  </div> 
  
     
</div>






<div class="esp_login">
<div class=" cont_login">
 <form name="form1" method="post" action="direccionar.php">
          <table width="200" border="0">
            <tr>
              <td colspan="2" align="center" valign="middle">Ingresa aquí</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle" ><?
                          // Mostrar error de Autentificaci&oacute;n.
                          include ("aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                              $error=$_GET['error_login'];
                         /* echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000' >Error: $error_login_ms[$error]";*/
						  ?>
						  
                          <script language="javascript"> 
							alert
							('<?php echo "$error_login_ms[$error]"; ?>'); 
							location.href = "index.php";
							</script>
                          
                          <?php
                          }
                         ?>
                         
                         
                  </td>
            </tr>
            <tr>
              <td align="right" valign="middle">Usuario:</td>
              <td align="center" valign="middle" ><input type="text" name="user" size="15" class="imputbox imput_transparente"  autofocus ></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Contraseña:</td>
              <td align="center" valign="middle"><input type="password" name="pass" size="15" class="imputbox imput_transparente"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="middle">
                <input name=submit type=submit value="Entrar" class="boton_transparente">
              </td>
            </tr>
          </table>
        </form> 
</div>
</div>



<div class="espacio_video" id="bgvid" >

<video autoplay poster="../imagenes/nubes.jpg" loop>
  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
<!--<source src="//demosthenes.info/assets/videos/polina.webm" type="video/webm">-->
<source src="videobg.mp4" type="video/mp4">
</video>

</div>	

<div class="footer">
	<div class="contenido_footer">
    Desarrollado por <a target="_blank" href="http://sitis.mx/"> <img src="imagenes/small_sitis.png" width="22" height="24" alt="SITIS" longdesc="http://sitis.mx"></a></div></div></div>
</body>
</html>