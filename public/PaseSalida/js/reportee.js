function mostrarInputs() {
  var numeroSeleccionado = document.getElementById("numero").value;
  var inputsDiv = document.getElementById("inputs");
  inputsDiv.innerHTML = ""; // Limpiar cualquier contenido anterior
  
  // Mostrar los inputs según la selección
  for (var i = 1; i <= numeroSeleccionado; i++) {
    var container = document.createElement("div"); // Crear un contenedor div para cada par de elementos

    var nameLabel = document.createElement("label"); // Crear el label para el nombre
    nameLabel.textContent = "Nombre " + i + ": "; // Establecer el texto del label

    var nameInput = document.createElement("input"); // Crear el input para el nombre
    nameInput.type = "text"; // Establecer el tipo de input

    var fichaLabel = document.createElement("label"); // Crear el label para la ficha
    fichaLabel.textContent = "Ficha " + i + ": "; // Establecer el texto del label

    var fichaInput = document.createElement("input"); // Crear el input para la ficha
    fichaInput.type = "number"; // Establecer el tipo de input

    // Establecer estilos CSS para los elementos creados
    container.style.display = "flex"; // Usar flexbox para alinear elementos en una línea
    container.style.alignItems = "center"; // Centrar elementos verticalmente

    // Agregar los elementos al contenedor div
    container.appendChild(nameLabel);
    container.appendChild(nameInput);
    container.appendChild(fichaLabel);
    container.appendChild(fichaInput);

    // Agregar el contenedor al div principal
    inputsDiv.appendChild(container);
  }
}


// selecccion de unidad
/*
function mostrarPopup() {
    document.getElementById('popup-overlay').style.display = 'block';
    document.getElementById('popup-content').style.display = 'block';
}

function seleccionarUnidad(unidad, inventario1, inventario2, placa) {
    document.querySelector('input[name="tipo_vehiculo"]').value = unidad;
    document.querySelector('input[name="no_inventario"]').value = inventario1;
    document.querySelector('input[name="no_inventario_2"]').value = inventario2;
    document.querySelector('input[name="placa"]').value = placa;

    // Ocultar el popup después de seleccionar la unidad
    document.getElementById('popup-overlay').style.display = 'none';
    document.getElementById('popup-content').style.display = 'none';
}
*/

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}



function salir() {
    // Mostrar una ventana emergente de confirmación
    var confirmacion = confirm("¿Estás seguro de que quieres cerrar sesión?");
    
    // Redirigir solo si se confirma la acción
    if (confirmacion) {
        window.location.href = "salir.php";
    } else {
        // Si el usuario cancela, no hacemos nada
        return false;
    }
}


    // Función para abrir el popup
    document.getElementById("openPopup").addEventListener("click", function() {
        document.getElementById("profilePopup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    });

    // Función para cerrar el popup
    document.getElementById("closePopup").addEventListener("click", function() {
        document.getElementById("profilePopup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    });
