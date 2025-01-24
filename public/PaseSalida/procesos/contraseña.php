<?php
   // Conexión a la base de datos
   include "../conn/conn.php"; // Asegúrate de incluir el archivo que contiene la conexión a tu base de datos
   
   // Obtener ficha y marca de tiempo de expiración de la URL
   $ficha = $_GET['ficha'];
   $expires = $_GET['expires'];
   
   // Verificar si la URL ha caducado
   if (time() > $expires) {
       // La URL ha caducado, mostrar un mensaje de error o redirigir a una página de error
       ?> 
<br><br>
<center>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';"></span> 
      <strong>   El enlace ha caducado.!</strong>
   </div>
   <meta http-equiv='refresh' content='5;url=../index.php'>
</center>
<style>
   .alert {
   padding: 20px;
   background-color: #f44336;
   color: white;
   width: 70%;
   font-size:14px;
   font-family:"arial";
   }
   .closebtn {
   margin-left: 15px;
   color: white;
   font-weight: bold;
   float: right;
   font-size: 22px;
   line-height: 20px;
   cursor: pointer;
   transition: 0.3s;
   }
   .closebtn:hover {
   color: black;
   }
</style>
<?php 
   exit; // Salir del script para evitar continuar con el procesamiento
   }
   
   // Verificar si se ha enviado el formulario
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Recoger los datos del formulario
   $password = $_POST['password'];
   $password_verify = $_POST['password_verify'];
   
   // Verificar si las contraseñas coinciden
   if ($password === $password_verify) {
       // Hash de la contraseña
       $hashed_password = password_hash($password, PASSWORD_BCRYPT);
   
       // Actualizar la contraseña en la base de datos
       $sql = "UPDATE user SET password = '$hashed_password' WHERE ficha = '$ficha'";
   
       if ($conn->query($sql) === TRUE) {
           $msj = "<strong style='color:green;'>Contraseña actualizada correctamente.</strong>";
           echo "<meta http-equiv='refresh' content='2;url=../index.php'> ";
       } else {
           $msj = "<strong style='color:red;'>Error al actualizar la contraseña: </strong>" . $conn->error;
       }
   } else {
       $msj = "<strong style='color:red;'>Las contraseñas no coinciden.</strong>";
   }
   }
   ?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Recuperar Contraseña</title>
      <style>
         body {
         font-family: Arial, sans-serif;
         background-color: #f2f2f2;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         }
         .container {
         background-color: #ffffff;
         border-radius: 8px;
         box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
         padding: 20px;
         width: 300px;
         text-align: center;
         }
         h2 {
         margin-bottom: 20px;
         color: #333333;
         }
         input[type="email"],
         input[type="password"] {
         width: 100%;
         padding: 10px;
         margin: 8px 0;
         border: 1px solid #ccc;
         border-radius: 4px;
         box-sizing: border-box;
         }
         input[type="submit"] {
         background-color: #4CAF50;
         color: white;
         padding: 14px 20px;
         margin: 8px 0;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         width: 100%;
         }
         input[type="submit"]:hover {
         background-color: #45a049;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <h2>Recuperar Contraseña</h2>
         <form action="#" method="POST">
            <input type="text" name="ficha" value="<?=$ficha?>" hidden>
            <input type="password" id="password" name="password"        placeholder="Nueva Contraseña" required><br>
            <input type="password" id="password" name="password_verify" placeholder="Verificar Contraseña" required>
            <input type="submit" value="Recuperar Contraseña">
         </form>
         <br>
         <?=@$msj?>
      </div>
   </body>
</html>