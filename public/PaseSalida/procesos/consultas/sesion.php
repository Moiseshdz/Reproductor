<?php 
session_start();

include "../conn/conn.php";

// Verificar si la sesión está activa
if(isset($_SESSION['ficha'])) {
    // Obtener el valor de la ficha de la sesión
    $ficha_session = $_SESSION['ficha'];

    // Preparar la consulta SQL utilizando una declaración preparada para evitar inyecciones SQL
    $sql = "SELECT * FROM user WHERE ficha = ?";
    
    // Preparar la declaración SQL
    $stmt = $conn->prepare($sql);
    
    // Vincular los parámetros
    $stmt->bind_param("s", $ficha_session);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Almacenar el resultado en el servidor
    $stmt->store_result();

    // Verificar si se encontraron filas
    if ($stmt->num_rows > 0) {
        // Obtener los datos del usuario
        $stmt->bind_result($id, $ficha_session, $nombre_sesion, $apellido_sesion, $password, $num, $email, $img);
        $stmt->fetch();
    } else {
        // Si la sesión está activa pero no se encuentra el usuario, redirigir al usuario al formulario de inicio de sesión
        header("Location: ../index.php");
        exit; // Asegurar que el script se detenga después de la redirección
    }
} else {
    // Si la sesión no está activa, redirigir al usuario al formulario de inicio de sesión
    header("Location: ../index.php");
    exit; // Asegurar que el script se detenga después de la redirección
}
?>
