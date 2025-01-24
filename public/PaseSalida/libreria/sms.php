<?php
// Incluir el archivo autoloader de Composer
require 'vendor/autoload.php';

// Importar las clases de PHPMailer al espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si se ha enviado el formulario
if (isset($_POST['btnR'])) {
    // Incluir el archivo de conexión a la base de datos
    include "conn/conn.php";

    // Obtener la ficha del formulario enviado
    $ficha = $_POST['ficha'];

    // Consultar la base de datos para verificar si la ficha existe
    $sql = "SELECT * FROM user WHERE ficha = '$ficha'";
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener la ficha de la base de datos
        while ($row = $result->fetch_assoc()) {
            $fichaNum = $row['ficha'];
            $num = $row['num'];
            $email = $row['email']; 
            $nombreDestinatario = $row['nombre']; 
        }

        // Verificar si la ficha ingresada coincide con la ficha de la base de datos
        if ($ficha == $fichaNum) {
            // Ficha encontrada, enviar el correo electrónico

            try {
                // Crear una instancia de PHPMailer
                $mail = new PHPMailer(true);

                // Configuración del servidor SMTP
                $mail->isSMTP(); // Indicar que se enviará usando SMTP
                $mail->Host = 'mail.midycode.com'; // Especificar el servidor SMTP
                $mail->SMTPAuth = true; // Habilitar la autenticación SMTP
                $mail->Username = 'pemex_recuperacion@midycode.com'; // Tu dirección de correo electrónico SMTP
                $mail->Password = 'Moises129907'; // Tu contraseña SMTP
                $mail->SMTPSecure = 'tls'; // Habilitar cifrado TLS
                $mail->Port = 587; // Puerto TCP para conectar

                // Remitente y destinatario
                $mail->setFrom('pemex_recuperacion@midycode.com', '=?UTF-8?B?' . base64_encode('Pemex_Recuperación_Contraseña') . '?=');
                $mail->addAddress($email, $nombreDestinatario); // Usar los valores obtenidos de la consulta SQL

                // Configurar la zona horaria a la Ciudad de México
                date_default_timezone_set('America/Mexico_City');

                // Obtener la fecha y hora actual en formato UNIX timestamp
                $current_time = time();

                // Agregar 24 horas al tiempo actual para definir la caducidad del enlace (en este caso, 24 horas después)
                $expires = $current_time + (1 * 60 * 60); // 24 horas * 60 minutos * 60 segundos

                // Contenido del correo
                $mail->isHTML(true); // Establecer el formato del correo como HTML
                $mail->Subject = '=?UTF-8?B?' . base64_encode('RECUPERACION DE CONTRASEÑA') . '?=';

                // Construir el cuerpo del correo con el enlace
               $url = 'https://midycode.com/PaseSalida/procesos/contraseña.php?ficha=' . urlencode($ficha) . '&expires=' . urlencode($expires);
               $mail->Body = 'Recuperación de contraseña. Click en el enlace: <a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($url) . '</a>';


                // Enviar el correo
                $mail->send();
                 $msj = 'Correo enviado a: '.$email;
            } catch (Exception $e) {
                 $msj = "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            // La ficha ingresada no coincide con la ficha registrada en la base de datos
            $msj = "La ficha ingresada no coincide con la ficha registrada en la base de datos.<br><br>";
        }
    } else {
        // No se encontraron resultados en la base de datos para la ficha ingresada
        $msj = "No se encontró ninguna coincidencia en la base de datos para la ficha ingresada.<br><br>";
    }
}
?>