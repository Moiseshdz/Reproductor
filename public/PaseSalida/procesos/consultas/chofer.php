<?php
    include "../conn/conn.php";
    $sql = "SELECT * FROM choferes ORDER BY id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    ?>

    <div class="popup-overlay" id="popup-overlay-chefer"></div>
    <div class="popup-content" id="popup-content-chefer">
        <span class="close-btn" onclick="cerrarPopupChefer()">x</span>
        <!-- Contenido del popup -->
        <h3>Seleccione un Chofer:</h3>
        <input type="text" id="search-input-chefer" placeholder="Buscar Chofer..." 
        style="width: 250px;">
        <button onclick="buscarChefer()">Buscar</button>
        <div class="result">
        <ul id="chefer-list">
            <?php
            while($row = $result->fetch_assoc()) {
                // Aquí se generan dinámicamente los elementos <li> del popup con los datos de los choferes de departamento
                $nombre = $row['nombre'];
                $ficha = $row['ficha'];
                $no_licencia = $row['no_licencia'];
            ?>
            <li onclick="seleccionarChofer('<?=$nombre;?>', '<?=$ficha;?>', '<?=$no_licencia;?>')"><?=$nombre; ?></li><br>
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
    // Función para mostrar el popup de choferes de departamento
    function mostrarPopupChefer() {
        document.getElementById('popup-overlay-chefer').style.display = 'block';
        document.getElementById('popup-content-chefer').style.display = 'block';
 
    }

    // Función para cerrar el popup de choferes de departamento
    function cerrarPopupChefer() {
        document.getElementById('popup-overlay-chefer').style.display = 'none';
        document.getElementById('popup-content-chefer').style.display = 'none';
    
    }

    // Función para seleccionar un chofer de departamento
    function seleccionarChofer(nombre, ficha, no_licencia) {
        document.querySelector('input[name="responsable_nombre"]').value = nombre;
        document.querySelector('input[name="responsable_ficha"]').value = ficha;
        document.querySelector('input[name="responsable_licencia"]').value = no_licencia;

        // Ocultar el popup después de seleccionar el chofer de departamento
        cerrarPopupChefer();
    }

    // Función para buscar choferes de departamento
    function buscarChefer() {
        var input = document.getElementById('search-input-chefer').value.toUpperCase();
        var ul = document.getElementById("chefer-list");
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
