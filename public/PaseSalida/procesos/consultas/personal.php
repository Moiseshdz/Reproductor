<?php
include "../conn/conn.php";
$sql = "SELECT * FROM personal ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>

<div class="popup-overlay" id="popup-overlay-personal"></div>
<div class="popup-content" id="popup-content-personal">
    <span class="close-btn" onclick="cerrarPopupPersonal()">x</span>
    <!-- Contenido del popup -->
    <h3>Seleccione un Personal:</h3>
    <input type="text" id="search-input-personal" placeholder="Buscar Personal..." 
    style="width:  250px;">
    <button onclick="buscarPersonal()">Buscar</button>
    <div class="result">
        <ul id="personal-list">
            <?php
            while($row = $result->fetch_assoc()) {
                // Aquí se generan dinámicamente los elementos <li> del popup con los datos del personal
                $nombre = $row['nombre'];
                $ficha = $row['ficha'];
            ?>
            <!-- Agregar checkbox para seleccionar el personal -->
            <li>
            <input type="checkbox" name="personal_checkbox" value="<?php echo $nombre; ?>" data-ficha="<?php echo $ficha; ?>" onclick="actualizarCampos()">

                <?php echo $nombre; ?>
            </li><br>
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
    // Función para mostrar el popup de personal
    function mostrarPopupPersonal() {
        document.getElementById('popup-overlay-personal').style.display = 'block';
        document.getElementById('popup-content-personal').style.display = 'block';
    }

    // Función para cerrar el popup de personal
    function cerrarPopupPersonal() {
        document.getElementById('popup-overlay-personal').style.display = 'none';
        document.getElementById('popup-content-personal').style.display = 'none';
    }

    // Función para buscar personal
    function buscarPersonal() {
        var input = document.getElementById('search-input-personal').value.toUpperCase();
        var ul = document.getElementById("personal-list");
        var li = ul.getElementsByTagName('li');

        for (var i = 0; i < li.length; i++) {
            var textValue = li[i].innerText.toUpperCase();
            if (textValue.indexOf(input) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

// Función para actualizar los campos según la selección de personal
function actualizarCampos() {
    var checkboxList = document.getElementsByName('personal_checkbox');
    var inputsDiv = document.getElementById('inputs');
    inputsDiv.innerHTML = ''; // Limpiar cualquier contenido anterior
    
    // Recorrer la lista de checkboxes para agregar los campos correspondientes
    for (var i = 0; i < checkboxList.length; i++) {
        if (checkboxList[i].checked) {
            var nombre = checkboxList[i].value;
            var ficha = checkboxList[i].dataset.ficha; // Obtener el valor de la ficha desde el atributo de datos
            var container = document.createElement('div'); // Crear un contenedor div para cada par de elementos

            var nameLabel = document.createElement('label'); // Crear el label para el nombre
            nameLabel.textContent = 'Nombre: '; // Establecer el texto del label

            var nameInput = document.createElement('input'); // Crear el input para el nombre
            nameInput.type = 'text'; // Establecer el tipo de input
            nameInput.name = 'nombre_' + i; // Asignar un nombre único al campo de nombre
            nameInput.value = nombre; // Establecer el valor del input

            var fichaLabel = document.createElement('label'); // Crear el label para la ficha
            fichaLabel.textContent = 'Ficha: '; // Establecer el texto del label

            var fichaInput = document.createElement('input'); // Crear el input para la ficha
            fichaInput.type = 'number'; // Establecer el tipo de input
            fichaInput.name = 'ficha_' + i; // Asignar un nombre único al campo de ficha
            fichaInput.value = ficha; // Establecer el valor de la ficha

            // Establecer estilos CSS para los elementos creados
            container.style.display = 'flex'; // Usar flexbox para alinear elementos en una línea
            container.style.alignItems = 'center'; // Centrar elementos verticalmente

            // Agregar los elementos al contenedor div
            container.appendChild(nameLabel);
            container.appendChild(nameInput);
            container.appendChild(fichaLabel);
            container.appendChild(fichaInput);

            // Agregar el contenedor al div principal
            inputsDiv.appendChild(container);
        }
    }
}
</script>

<style>
    .popup-content {
        overflow-y: 100px;
        max-width: 70%;
    }
</style>
