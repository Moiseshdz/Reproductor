<?php

// Incluir archivo de conexión a la base de datos y archivo de mensajes de error
include "libreria/sms.php";
include "conn/conn.php";

// Definir una variable para el mensaje de alerta
$alert = "";

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['btnL'])) {
    // Obtener los datos del formulario
    $ficha = $_POST["ficha"];
    $password = $_POST["password"];

    // Consultar la base de datos para buscar el usuario por ficha
    $sql = "SELECT * FROM user WHERE ficha = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $ficha);
    $statement->execute();
    $statement->store_result();

    // Verificar si se encontró un usuario con esa ficha
    if ($statement->num_rows == 1) {
        // Vincular las columnas del resultado a variables
        $statement->bind_result($id, $ficha_result, $nombre_result, $apellido_result, $password_result, $num_result, $email_result, $img_result);
        // Obtener los valores de las columnas
        $statement->fetch();
        // Verificar si la contraseña coincide utilizando password_verify()
        if (password_verify($password, $password_result)) {
            // Iniciar sesión y redirigir al usuario
            session_start();
            $_SESSION["ficha"] = $ficha_result;
            $tiempoExpiracion = time() + (14 * 24 * 60 * 60);
            setcookie("ficha_cookie", $ficha_result, $tiempoExpiracion, "/");
            header("Location: procesos/reporte.php?ficha_sesion=".$ficha_result);
            exit;
        } else {
            // Si la contraseña no coincide, establecer el mensaje de error
            $msj = "<p style='color:red'>Datos incorrectos. Por favor, inténtalo de nuevo.</p>";
        }
    } else {
        // Si no se encuentra ningún usuario con esa ficha, establecer el mensaje de error
        $msj = "<p style='color:red'>Usuario no encontrado. Por favor, inténtalo de nuevo.</p>";
    }
}

// Verificar si se ha enviado el formulario de registro
if(isset($_POST['btnAgg'])) {
  // Obtener los datos del formulario
  $ficha = $_POST['ficha'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $num = $_POST['num'];
  $email = $_POST['email'];
  $img = $_FILES['img'];

  // Validar si todos los campos requeridos están presentes
  if(empty($ficha) || empty($nombre) || empty($apellido) || empty($password) || empty($num) || empty($email) || empty($img)) {
      $alert = "Por favor, complete todos los campos.";
      exit;
  }

  // Verificar si la ficha ya está en uso
  $sql = "SELECT * FROM user WHERE ficha = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $ficha);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->num_rows > 0) {
      $alert = "<p style='color:red'>La ficha ingresada ya está en uso.</p>";
  } else {
      // Verificar si se cargó correctamente el archivo de imagen
      if($img['error'] !== UPLOAD_ERR_OK) {
          $alert = "Error al cargar la imagen.";
          exit;
      }

      // Obtener la extensión del archivo de imagen
      $extension = pathinfo($img['name'], PATHINFO_EXTENSION);

      // Definir la ruta de destino para guardar la imagen
      $ruta_imagen = "procesos/img/" .  $img['name'] . ".$extension";
      $rutaSql = "img/" . $img['name'] . ".$extension";

      // Mover la imagen a la ruta de destino
      if (!move_uploaded_file($img['tmp_name'], $ruta_imagen)) {
          $alert = "Error al mover el archivo.";
          exit;
      }

      // Preparar la consulta SQL utilizando sentencias preparadas
      $insertQuery = "INSERT INTO user (ficha, nombre, apellido, password, num, email, img) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $statement = $conn->prepare($insertQuery);
      // Vincular parámetros
      $statement->bind_param("issssss", $ficha, $nombre, $apellido, $password, $num, $email, $rutaSql);

      // Ejecutar la consulta
      if ($statement->execute()) {
          $alert = "<p style='color:green'>Usuario registrado correctamente!</p>";
      } else {
          $alert = "Error al registrar el usuario: " . $conn->error;
      }

      // Cerrar la conexión a la base de datos
      $statement->close();
  }

  $conn->close();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/indexx.css">
  <link rel="shortcut icon" href="logo/icon.png" type="image/png">
  <title>Inicio</title>
</head>
<body>

  <div class="login-container">
 
  <center style="color:green;">
  <?=@$msj?><?=@$alert ?></center>
 
    <form class="login-form" method="POST">
    <center> <img src="logo/logo.jpg" alt="" width="250px"></center>
      <label for="username">Usuario:</label>
      <input type="number" id="username" name="ficha" value="<?=$_COOKIE['ficha_cookie'];?>" required>
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>
      <button type="submit" name="btnL">Iniciar sesión</button>
    </form>
    <br>
    <a href="#" onclick="togglePopupR()">Registrarse</a>
    <hr>
    <a href="#" onclick="togglePopup()">Recuperar Contraseña</a><br>


   
  </div>

<!-- Overlay del popup -->
<a class="popup-overlay""></a>

<a class="popup-overlayR"></a>

<!-- Contenido del popup -->
<div class="popup-content">
  <form action="#" method="POST">
    <span class="close-popup-button" onclick="togglePopup()">x</span>
    <input type="number"   name="ficha"    placeholder="FICHA" required><br>
    <input style=" background-color: #4CAF50; color:white" type="submit" value="Recuperar" name="btnR">
   </form>
</div>



<div class="popup-contentR">
  <form action="#" method="POST" enctype="multipart/form-data">
    <span class="close-popup-button" onclick="togglePopupR()">x</span>
    <input type="number"   name="ficha" placeholder="FICHA"><br>
    <input type="text"     name="nombre"   placeholder="NOMBRE" required><br>
    <input type="text"     name="apellido" placeholder="APELLIDO" required><br>
    <input type="password" name="password" placeholder="CONTRASEÑA" required><br>
    <input type="num"      name="num"      placeholder="TELEFONO" required><br>
    <input type="email"    name="email"    placeholder="CORREO" required><br>
    <input type="file"     name="img"  required style="width: 170px;"><br>
    <input style=" background-color: #4CAF50; color:white" type="submit" value="Registrar" name="btnAgg">
   </form>
</div>


</body>
</html>

<script>
function togglePopup() {
        var overlay = document.querySelector('.popup-overlay');
        var popup = document.querySelector('.popup-content');
        
        overlay.style.display = (overlay.style.display === 'block') ? 'none' : 'block';
        popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
    }


    function togglePopupR() {
        var overlayR = document.querySelector('.popup-overlayR');
        var popup = document.querySelector('.popup-contentR');
        
        overlayR.style.display = (overlayR.style.display === 'block') ? 'none' : 'block';
        popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
    }
</script>

<style>
.alert {
  padding: 20px;
  background-color: #4CAF50;
  color: white;
}
.alert2 {
  padding: 20px;
  background-color: #E74C3C ;
  color: white;
}
</style>

