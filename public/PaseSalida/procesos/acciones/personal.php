<?php
include "../../conn/conn.php";

// Manejo de la eliminación de registros
if (isset($_GET['id'])) {
    eliminarRegistro($_GET['id']);
}

// Función para eliminar un registro
function eliminarRegistro($id) {
    global $conn;
    $sql = "DELETE FROM personal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '
        <center>
        <div class="alert1">
            <span class="closebtn">&times;</span>
            <strong>Dato eliminado correctamente!</strong>
        </div>
        </center>';
        echo "<meta http-equiv='refresh' content='3;URL=personal.php'>";

    }
}

// Manejo de la inserción de registros
if (isset($_POST['btnAgg'])) {
    agregarRegistro($_POST['nombre'], $_POST['ficha']);
}

// Función para agregar un registro
function agregarRegistro($nombre, $ficha) {
    global $conn;
    $sql = "INSERT INTO personal (nombre, ficha) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $ficha);
    if ($stmt->execute()) {
        echo '<center><div class="alert">
            <span class="closebtn">&times;</span>
            <strong>Registro agregado correctamente!</strong>
            </div></center>';
            echo "<meta http-equiv='refresh' content='3;URL=personal.php'>";

    } else {
        echo '<center><div class="alert1">
            <span class="closebtn">&times;</span>
            <strong>Error al agregar el registro!</strong>
            </div></center>';
            echo "<meta http-equiv='refresh' content='3;URL=personal.php'>";

    }
}

// Manejo de la actualización de registros
if (isset($_POST['btnEditar'])) {
    editarRegistro($_POST['id'], $_POST['nombre'], $_POST['ficha']);
}

// Función para editar un registro
function editarRegistro($id, $nombre, $ficha) {
    global $conn;
    $sql = "UPDATE personal SET nombre=?, ficha=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $ficha, $id);
    if ($stmt->execute()) {
        echo '
        <center>
        <div class="alert">
            <span class="closebtn">&times;</span>
            <strong>Dato actualizado correctamente!</strong>
        </div>
        </center>';
        echo "<meta http-equiv='refresh' content='3;URL=personal.php'>";

    } else {
        echo '
        <center>
        <div class="alert1">
            <span class="closebtn">&times;</span>
            <strong>Error al actualizar el dato!</strong>
        </div>
        </center>';
        echo "<meta http-equiv='refresh' content='3;URL=personal.php'>";

    }
}

// Consulta inicial de datos
$ficha_session = isset($_COOKIE['ficha_cookie']) ? $_COOKIE['ficha_cookie'] : '';
date_default_timezone_set('America/Mexico_City');
$sql = "SELECT * FROM personal ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows <= 0) {
    $error = "<br>NO HAY RESULTADOS";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/personal.css">
    <title>Reporte de Salida</title>
</head>
<body>
    <div class="caja">
    <img src="../../logo/logo.jpg" style="width: 130px;">
        <a href="../reporte.php?ficha_sesion=<?=$ficha_session?>"> <span class="menu" style="font-size:30px;cursor:pointer; color:black;">&#9776; Inicio</span></a>
        <br><br>
      
        <a class="agg" href="javascript:void(0);" onclick="mostrarPopup()"><button>Agregar</button></a>
        <br><br>

        <div id="popupAgregar" class="popup2">
            <form id="formAgregar" action="#" method="POST">
                <h2>Agregar Nuevo Registro</h2>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="ficha">Ficha:</label>
                <input  style="width: 100%;" type="number" id="ficha"  name="ficha"  required><br><br>
                <input type="submit" name="btnAgg" value="Guardar">
                <a href="javascript:void(0);" class="cerrar" onclick="cerrarPopup()">&times;</a>
            </form>
        </div>

        <center style="font-weight: bold;">PERSONAL</center>
               <div style="overflow-x:auto; overflow-y:auto; height: 380px;">
            <table>
                <tr>
                    <th>#</th>
                    <th style="position: relative; left:-30px"  >NOMBRE</th>
                    <th>FICHA</th>
                    <th>ACTIVO</th>
                    <th colspan="2">ACCIONES</th>
                </tr>
                <?php $count = 0; ?>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                <td><?php echo ++$count; ?></td>
                  <form action="#"  method="post">

                    <input type="text" name="id" value="<?php echo $row['id']?>" hidden>
                    <td><input style="width: 300px; position: relative; left:-20px" 
                    type="text" name="nombre" value="<?php echo $row['nombre']?>"></td>

                    <td><input style="width: 70px; " 
                    type="text" name="ficha" value="<?php echo $row['ficha']?>"></td>
                    <td><i class="fa fa-check"></i></td>

                    <td><input type="submit" name="btnEditar" value="Guardar"></td>
                    </form>
                    <td><a href="#" onclick="preguntar(<?php echo $row['id']?>)" style="color: black;"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                </tr>
                <?php } ?>
            </table>
        
            <?=@$error?>
        </div>
    </div>
</body>
</html>


<script type="text/javascript">
    function preguntar(id) {
        if (confirm('¿Estás seguro que deseas eliminar esto?')) {
            window.location.href = "personal.php?id=" + id;
        }
    }

    function mostrarFormularioEdicion(ficha) {
        var formId = 'form_' + ficha;
        document.getElementById(formId).style.display = 'block';
    }

        function mostrarPopup() {
            document.getElementById("popupAgregar").style.display = "block";
        }

        function cerrarPopup() {
            document.getElementById("popupAgregar").style.display = "none";
        }
    </script>
