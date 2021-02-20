<?php
require("../aut_verifica.inc.php");


/*echo "ID DEL HOSPITAL: $id_establecimiento <br/>";
echo "DIVIDIR: $dividir<br/>";*/

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Almacen_tipo_prod_".date("Y:m:d H:i:s").".xls");
header("Pragma: no-cache");
header("Expires: 0");

class Alumno{
    private $datos;
    public function __construct(){
        $this->datos=array(); 
    }

 public function listarTodos(){
	 $id_establecimiento=$_GET['h'];
$dividir=$_GET['d'];
        //$sql="SELECT EMP_CUE,EMP_NOM,EMP_APAT,EMP_AMAT FROM EMPLEADOS;";
		$sql="
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
					WHERE A.ID_ESTABLECIMIENTO=$id_establecimiento
					GROUP BY C.TIPO_PRODUCTO;
		";
		
		
        $res=  mysql_query($sql);
        while($reg=  mysql_fetch_assoc($res)){
            $this->datos[]=$reg;
        }
        return $this->datos;
    }
}
$alumnos=new Alumno();
$reg_alumnos=$alumnos->listarTodos();
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
    <body>
    <?php 
	$bgcelda='style="color:#FFF; background-color: #13BF00;font-size:24px;"';
	?>
    
     <table width="100%" border="1">
         <thead>
  <tr>
    <td <?php echo $bgcelda; ?> width="39%" align="center" valign="middle"><strong>TIPO DE PRODUCTO</strong></td>
    <td <?php echo $bgcelda; ?> width="34%" align="center" valign="middle"><strong>CANTIDAD</strong></td>
    <td <?php echo $bgcelda; ?> width="27%" align="center" valign="middle"><strong>TOTAL</strong></td>
    
  </tr>
         </thead>
         <tfoot></tfoot>
         
         <tbody>
             <?php
             if(isset($reg_alumnos)){
                 
                 for($i=0; $i< count($reg_alumnos);$i++){
                     
					
					 
					 ?>
                     
                     
                     
             <tr>
                     <td align="left" valign="top"> <?php echo $reg_alumnos[$i]["TIPO_PRODUCTO"]; ?> </td>
                     <td align="right" valign="top"> <?php echo $reg_alumnos[$i]["CANT"] ;?> </td>
                     <td align="right" valign="top"> <?php echo "$ ".number_format($reg_alumnos[$i]["SUMA_TIPO"], 2, ".", ","); ?> </td>                                  
                                                  
           </tr>
            
              <?php       
			  $sumaProd=$sumaProd+$reg_alumnos[$i]["CANT"];
			  $sumaPrec=$sumaPrec+$reg_alumnos[$i]["SUMA_TIPO"];
                 }
             }
             ?>
             
         </tbody>
  
            <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td <?php echo $bgcelda; ?> align="right" valign="top"><?php echo $sumaProd." PRODUCTOS"; ?></td>
               <td <?php echo $bgcelda; ?> align="right" valign="top"><?php echo "SUMA TOTAL $".number_format($sumaPrec, 2, ".", ",");  ?></td>
             </tr>
  
</table>
      
      
      
    </body>
</html>
