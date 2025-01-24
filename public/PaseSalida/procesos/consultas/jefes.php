<?php
include "../conn/conn.php";
$sql = "SELECT * FROM jefe_depto ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>

<div class="popup-overlay" id="popup-overlay-jefe"></div>
<div class="popup-content" id="popup-content-jefe">
    <span class="close-btn" onclick="cerrarPopupJefe()">x</span>
    <!-- Contenido del popup -->
    <h3>Seleccione un Jefe de depto:</h3>
    <input type="text" id="search-input-jefe" placeholder="Buscar Jefe de depto..." 
    style="width:  250px;">
    <button onclick="buscarJefe()">Buscar</button>
    <div class="result">
    <ul id="jefe-list">
        <?php
        while($row = $result->fetch_assoc()) {
            // Aquí se generan dinámicamente los elementos <li> del popup con los datos de los jefes de departamento
            $nombre = $row['nombre'];
            $dep = $row['dep'];
        ?>
        <li onclick="seleccionarJefe('<?='ING. '.$nombre; ?>','<?=$dep;?>')"><?='ING. '.$nombre; ?></li><br>
        <?php
        }
        ?>
    </ul>
</div>
</div>
<?php
} else {
   # echo "0 resultados";
}
?>
<script>
// Función para mostrar el popup de jefes de departamento
function mostrarPopupJefe() {
    document.getElementById('popup-overlay-jefe').style.display = 'block';
    document.getElementById('popup-content-jefe').style.display = 'block';
    document.body.classList.add('popup-active');
}

// Función para cerrar el popup de jefes de departamento
function cerrarPopupJefe() {
    document.getElementById('popup-overlay-jefe').style.display = 'none';
    document.getElementById('popup-content-jefe').style.display = 'none';
    document.body.classList.remove('popup-active');
}

// Función para seleccionar un jefe de departamento
function seleccionarJefe(jefe,dep) {
    document.querySelector('input[name="orden_de"]').value = jefe;
    document.querySelector('input[name="orden_de_2"]').value = dep;

    // Ocultar el popup después de seleccionar el jefe de departamento
    cerrarPopupJefe();
}

// Función para buscar jefes de departamento
function buscarJefe() {
    var input = document.getElementById('search-input-jefe').value.toUpperCase();
    var ul = document.getElementById("jefe-list");
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
    .opup-content{
        overflow-y:100px;  
    }
</style>