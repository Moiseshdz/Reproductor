<?php
// Inicia la sesión (si no está iniciada)
session_start();

// Destruye todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

header("location:../index.php");
?>