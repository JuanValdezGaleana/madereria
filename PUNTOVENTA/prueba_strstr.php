<?php 

$email = "sterling@designmultimedia.com";
$dominio = strstr ($email, '@');
print $dominio; // imprime @designmultimedia.com

echo "<br/>/////////////////////////////////////<br/>";
$i=0;
$arreglo[5];
$cadena = "Esta es una cadena de ejemplo";
$tok = strtok ($cadena," ");
while ($tok) {

echo "Palabra=$tok<br>";
$arreglo[$i]=$tok;
$tok = strtok (" ");

echo "Arreglo posicion ".$i." es: ".$arreglo[$i]."<br/>";

$i++;
}

?>