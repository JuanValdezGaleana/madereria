<?php require("../aut_verifica.inc.php"); 
$opc=base64_decode($_GET['opc']);
$i=base64_decode($_GET['i']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="imagenes/error.png" type="image/x-icon" rel="shortcut icon"/>
<title>Confirmación</title>
</head>



<?php switch($opc){ 

      case 'presentacion': ?>
    <body onload="confirmar1()">
    <script language="Javascript">
    function confirmar1(){
    confirmar=confirm("¿Realmente deseas eliminar el tipo de presentacion?");
    if (confirmar){
    location.href = "dellista.php?opc=<?php echo base64_encode($opc); ?>&i=<?php echo base64_encode($i); ?>";
    }
    else{
        history.back(1);
    }
    }
    </script>
    </body>
<?php break;

case 'medida': ?>
    <body onload="confirmar2()">
    <script language="Javascript">
    function confirmar2(){
    confirmar=confirm("¿Realmente deseas eliminar el tipo de medida?");
    if (confirmar){
    location.href = "dellista.php?opc=<?php echo base64_encode($opc); ?>&i=<?php echo base64_encode($i); ?>";
    }
    else{
        history.back(1);
    }
    }
    </script>
    </body>
<?php break;

case 'producto': ?>
    <body onload="confirmar3()">
    <script language="Javascript">
    function confirmar3(){
    confirmar=confirm("¿Realmente deseas eliminar el tipo de producto?");
    if (confirmar){
    location.href = "dellista.php?opc=<?php echo base64_encode($opc); ?>&i=<?php echo base64_encode($i); ?>";
    }
    else{
        history.back(1);
    }
    }
    </script>
    </body>
<?php break;

 } ?>







</html>