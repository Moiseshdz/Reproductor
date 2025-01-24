<?php

// Contador unico 
$archivo_contador = 'contador.txt';
if (file_exists($archivo_contador)) {

    $contador = (int) file_get_contents($archivo_contador);
    $contador++;
} else {
  
    $contador = 1;
}
file_put_contents($archivo_contador, $contador);


// Función para generar un folio único
function generarFolio($longitud = 10) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $folio = '';

    for ($i = 0; $i < $longitud; $i++) {
        $folio .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $folio;
}
$folio = generarFolio();
  


$token =  'Folio: '.$folio;



?>