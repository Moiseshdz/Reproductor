<?php
include "../conn/conn.php";
$sql = "SELECT * FROM unidad ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>

<div class="popup-overlay" id="popup-overlay"></div>
<div class="popup-content" id="popup-content">
    <span class="close-btn" onclick="cerrarPopup()">x</span>
    <!-- Contenido del popup -->
    <h3>Seleccione una unidad:</h3>
    <input type="text" id="search-input" placeholder="Buscar unidad..."  style="width:  250px;">
    <button onclick="buscarUnidad()">Buscar</button>

    <div class="result">
    <ul id="unidad-list">
        <?php
        while($row = $result->fetch_assoc()) {
            // Aquí se generan dinámicamente los elementos <li> del popup con los datos de las unidades
            $tipo = $row['tipo'];
            $inventario1 = $row['No_inventario1'];
            $inventario2 = $row['No.inventario2'];
            $placa = $row['placa']; // Cambio de $placas a $placa
        ?>
        <li onclick="seleccionarUnidad('<?php echo $tipo; ?>', '<?php echo $inventario1; ?>', '<?php echo $inventario2; ?>', '<?php echo $placa; ?>')">
        <?="No: ".$inventario1." - ".$tipo ?></li><br>
        <?php
        }
        ?>
    </ul>
    </div>
</div>

<?php
} else {
    #echo "0 resultados";
}
?>
<script>
// Función para mostrar el popup
function mostrarPopup() {
    document.getElementById('popup-overlay').style.display = 'block';
    document.getElementById('popup-content').style.display = 'block';
    document.body.classList.add('popup-active');
}

// Función para cerrar el popup
function cerrarPopup() {
    document.getElementById('popup-overlay').style.display = 'none';
    document.getElementById('popup-content').style.display = 'none';
    document.body.classList.remove('popup-active');
}

// Función para seleccionar una unidad
function seleccionarUnidad(unidad, inventario1, inventario2, placa) {
    document.querySelector('input[name="tipo_vehiculo"]').value = unidad;
    document.querySelector('input[name="no_inventario"]').value = inventario1;
    document.querySelector('input[name="no_inventario_2"]').value = inventario2;
    document.querySelector('input[name="placa"]').value = placa;

    // Ocultar el popup después de seleccionar la unidad
    cerrarPopup();
}

// Función para buscar unidades
function buscarUnidad() {
    var input = document.getElementById('search-input').value.toUpperCase();
    var ul = document.getElementById("unidad-list");
    var li = ul.getElementsByTagName('li');

    // Iterar sobre cada elemento <li> y ocultar los que no coincidan con la búsqueda
    for (var i = 0; i < li.length; i++) {
        var textValue = li[i].innerText.toUpperCase();
        if (textValue.indexOf(input) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>
<style>
    li{
        text-transform: uppercase;
    }
    li:hover {
        color: green;
        cursor: pointer;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
</style>
