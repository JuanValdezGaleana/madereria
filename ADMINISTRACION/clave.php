<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../imagenes/logo_small.png" type="image/x-icon" rel="shortcut icon"/>
  <script type="text/javascript">      
			function jsselect(){
				document.getElementById('cue').focus();
				}
        </script>
</head>

<body onload="jsselect()">

<form id="form1" name="form1" method="post" action="alta_usuario.php">
<table width="100%" border="0">
  <tr>
    <td align="center" valign="middle" class="bgtabla"><span style="color:#FFFFFF">INGRESA LA CLAVE DEL EMPLEADO<br/>
       A QUIEN QUIERES ASIGNAR</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
    <p></p>
    <input name="cue" type="text" id="cue" maxlength="10" onchange="javascript:this.value=this.value.toUpperCase();" />
    <p>
      <input type="submit" name="button" id="button" value="BUSCAR" />
    </p>    </td>
  </tr>
</table>
</form>
</body>
</html>
