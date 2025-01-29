// Función para obtener una cookie
function getCookie(name) {
    let cookies = document.cookie.split('; ');
    for (let cookie of cookies) {
        let [key, value] = cookie.split('=');
        if (key === name) return decodeURIComponent(value);
    }
    return null;
}

// Función para establecer una cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
}

// Función para mostrar notificaciones flotantes
function showNotification(message, type) {
    const notificationContainer = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    notification.classList.add('notification', `is-${type}`);
    notification.innerHTML = `
        <button class="delete"></button>
        ${message}
    `;
    notificationContainer.appendChild(notification);

    // Eliminar la notificación después de 5 segundos
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

document.addEventListener("DOMContentLoaded", () => {
    let nickname = getCookie("nickname");
    let userNicknameSpan = document.getElementById("userNickname");
    
    // Mostrar el modal de nickname si no está definido
    if (!nickname) {
        document.getElementById("nicknameModal").classList.add("is-active");
    } else {
        userNicknameSpan.textContent = nickname;
    }

    // Guardar el nickname cuando se hace clic en el botón "Guardar"
    document.getElementById("saveNickname").addEventListener("click", () => {
        let inputNick = document.getElementById("nicknameInput").value.trim();
        if (inputNick) {
            setCookie("nickname", inputNick, 30); // Guardar el nickname en una cookie
            userNicknameSpan.textContent = inputNick;
            document.getElementById("nicknameModal").classList.remove("is-active"); // Cerrar el modal
        } else {
            showNotification("Por favor, ingresa un nickname válido.", "danger");
        }
    });

    // Cerrar el modal al hacer clic en el fondo
    document.querySelector(".modal-background").addEventListener("click", () => {
        document.getElementById("nicknameModal").classList.remove("is-active");
    });

    // Crear sala
    document.getElementById("createRoomBtn").addEventListener("click", () => {
        let idSala = Math.floor(Math.random() * 9000000) + 1000000; // Generar un ID de sala aleatorio
        let userType = "Admin"; // El creador de la sala será el administrador

        let roomName = document.getElementById("roomNameInput").value.trim();
        if (roomName) {
            // Redirigir a la sala con el nombre y el ID generado
            window.location.href = `../../lobby.html?room=${encodeURIComponent(roomName)}-${idSala}&userType=${userType}`;
        } else {
            showNotification("Por favor, escribe un nombre para la sala.", "danger");
        }
    });

    // Unirse a sala
    document.getElementById("joinRoomBtn").addEventListener("click", () => {
        let roomId = document.getElementById("roomIdInput").value.trim();
        if (roomId) {
            // Redirigir a la sala con el ID proporcionado
            window.location.href = `../../lobby.html?room=${encodeURIComponent(roomId)}&userType=Invitado`;
        } else {
            showNotification("Por favor, escribe un ID de sala válido.", "danger");
        }
    });
});