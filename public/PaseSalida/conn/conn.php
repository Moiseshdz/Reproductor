<?php 
// Conexión a la base de datos (modifica los valores según tu configuración)
$servername = "localhost";
$username = "midycode_reportesalida";
$password = "reportesalida129907#";
$dbname = "midycode_reportesalida";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    echo "Conexión fallida: A la base de datos";
}else{
   // echo "<p style='font-size:10px'>Conexión estable</p>";
}
$url = "https://midycode.com";
?>