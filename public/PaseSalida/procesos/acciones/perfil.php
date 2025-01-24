<?php

if(isset($_POST['btnImg'])){

    // Obtiene el nombre y la ubicación temporal del archivo de imagen enviado
    @$ficha = $_POST['ficha'];
    $img = $_FILES['img']['name']; 
    $imagen_temp = $_FILES['img']['tmp_name']; 

    // Incluye el archivo de conexión a la base de datos
    include "../conn/conn.php";

    // Define la ruta de destino para guardar la imagen
    $ruta_imagen = "img/".$img;

    // Mueve el archivo de imagen cargado a la ruta de destino
    if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
        
        // Construye la consulta de actualización para actualizar la ruta de imagen del usuario en la base de datos
        $updateQuery = "UPDATE user SET img='$ruta_imagen' WHERE ficha = '$ficha'";
        
        // Ejecuta la consulta de actualización y muestra un mensaje de éxito si es exitoso
        if ($conn->query($updateQuery) === TRUE) {
            echo '<center>
            <div id="successMessage" class="alert success">
                La foto se ha actualizado correctamente.
            </div>
            </center>';
            echo '<meta http-equiv="refresh" content="3;url=reporte.php?ficha='.$ficha.'">';
        } else {
            // Muestra un mensaje de error si la consulta de actualización falla
            echo "Error al actualizar la foto: " . $conn->error;
        }
    } else {
       #echo "Error al mover el archivo.";
    }
    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha enviado el formulario, se omite el procesamiento y no se muestra ningún mensaje
    // echo "Error: No se han recibido datos del formulario.";
}

// Verificar si se ha enviado el formulario
if (isset($_POST['btnE'])) {
    // Recoger los datos del formulario
    @$ficha = $_POST['ficha'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $num = $_POST['num'];
    $email = $_POST['email'];
    

    // Validar los datos si es necesario

    // Realizar la conexión a la base de datos
    include "../conn/conn.php";

    // Definir la ruta de destino para guardar la imagen
    $ruta_imagen = "img/".$img;

    // Mover la imagen a la ubicación permanente

        // Sentencia SQL para actualizar los datos del perfil, incluyendo la imagen
        $updateQuery = "UPDATE user SET nombre='$nombre', apellido='$apellido', num='$num', email='$email' WHERE ficha = '$ficha'";

        // Ejecutar la consulta
        if ($conn->query($updateQuery) === TRUE) {
            echo '<center>
            <div id="successMessage" class="alert success">
                Los datos se han actualizado correctamente.
            </div>
            </center>';
            echo '<meta http-equiv="refresh" content="3;url=reporte.php?ficha='.$ficha.'">';
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
   
    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // echo "Error: No se han recibido datos del formulario.";
}
?>

<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .success {
        color: white;
        background-color: #4CAF50;
        border-color: #c3e6cb;
        width: 50%;
  
    }
</style>

<script>
    document.getElementById("successMessage").style.display = "block";
</script>
