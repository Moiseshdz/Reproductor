const socket = io();
let selectedVideoUrl = '';
let selectedVideoTitle = '';
let userName = '';
let userColors = {}; // Objeto para almacenar colores por usuario
let roomName = ''; // Variable para almacenar el nombre de la sala
let pausedTime = 0; // Variable para almacenar el tiempo de pausa
let isPaused = false; // Variable para almacenar el estado de pausa

// Obtener el nombre de la sala desde la URL
const urlParams = new URLSearchParams(window.location.search);
roomName = urlParams.get('room');

// Unirse a la sala
if (roomName) {
    socket.emit('joinRoom', roomName);
}

// Función para obtener una cookie por su nombre
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null; // Retornar null si la cookie no existe
}

// Obtener el nickname de la cookie
const nickname = getCookie('nickname');

// Ocultar el formulario de nombre y mostrar el chat si el nickname existe
if (nickname) {
    userName = nickname; // Asignar el nickname a la variable userName
    document.getElementById('nameForm').style.display = 'none'; // Ocultar el formulario de nombre
    document.getElementById('chatContainer').style.display = 'block'; // Mostrar el chat
} else {
    // Si no hay nickname en la cookie, mostrar el formulario de nombre
    document.getElementById('nameForm').style.display = 'block';
}

// Generar color aleatorio
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Manejar mensajes de chat
socket.on('chatMessage', (data) => {
    const messagesContainer = document.getElementById('messages');
    const messageElement = document.createElement('div');
    
    // Obtener color para el usuario
    let userColor = userColors[data.userName];
    if (!userColor) {
        userColor = getRandomColor();
        userColors[data.userName] = userColor;
    }

    messageElement.innerHTML = `<span style="color: ${userColor}; font-weight: bold;">${data.userName}:</span> ${data.message}`;
    messagesContainer.appendChild(messageElement);
    messagesContainer.scrollTop = messagesContainer.scrollHeight; // Desplazar hacia abajo
});

// Manejar envío de mensajes de chat
document.getElementById('chatForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const messageInput = document.getElementById('chatMessage');
    const message = messageInput.value;
    if (message.trim() !== '') {
        socket.emit('chatMessage', { roomName, message: { userName, message } });
        messageInput.value = '';
    }
});

// Mostrar el formulario de chat y ocultar el de nombre (opcional)
function setName() {
    userName = document.getElementById('nameInput').value.trim();
    if (userName) {
        document.getElementById('nameForm').style.display = 'none';
        document.getElementById('chatContainer').style.display = 'block';
    } else {
        alert('Por favor ingresa un nombre.');
    }
}

// Manejar resultados de búsqueda de música
socket.on('searchResults', (data) => {
    const tableBody = document.querySelector('#searchResults tbody');
    tableBody.innerHTML = '';
    data.forEach(video => {
        const row = document.createElement('tr');

        // Crear el elemento de miniatura con iframe
        const thumbnailCell = document.createElement('td');
        const iframe = document.createElement('iframe');
        const videoId = new URL(video.url).searchParams.get('v');
        iframe.src = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&controls=1`;
        iframe.loading = "lazy"; // Optimizar la carga del iframe
        iframe.title = video.title;
        iframe.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
        iframe.allowfullscreen = true;
        thumbnailCell.appendChild(iframe);

        // Crear el texto del título
        const titleCell = document.createElement('td');
        const title = document.createElement('span');
        title.textContent = video.title;
        titleCell.appendChild(title);

        row.appendChild(thumbnailCell);
        row.appendChild(titleCell);

        // Al hacer clic en un video, se lanza automáticamente
        row.onclick = () => {
            selectedVideoUrl = video.url;
            selectedVideoTitle = video.title;
            const titleElement = document.getElementById('selectedVideoTitle');
            titleElement.textContent = `${selectedVideoTitle}`;

            // Emitir el evento de cambio de video al servidor
            socket.emit('changeVideo', { roomName, videoUrl: selectedVideoUrl });
        };

        tableBody.appendChild(row);
    });
});

// Manejar cambio de video desde el servidor
socket.on('changeVideo', (videoUrl) => {
    const videoId = new URL(videoUrl).searchParams.get('v');
    player.loadVideoById(videoId); // Cargar el video en el reproductor
    player.playVideo(); // Reproducir el video automáticamente
});

// Cargar la API de YouTube IFrame
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
var interval;

// Función de throttle para limitar la frecuencia de los eventos
function throttle(func, limit) {
    let lastFunc;
    let lastRan;
    return function() {
        const context = this;
        const args = arguments;
        if (!lastRan) {
            func.apply(context, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(function() {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}

// Ejemplo de uso con la función de sincronización
const throttledSync = throttle(function(currentTime) {
    socket.emit('play', { roomName, currentTime });
}, 5000); // Sincroniza cada 5 segundos

function onYouTubeIframeAPIReady() {
    player = new YT.Player('videoPlayer', {
        height: '360',
        muted: true,
        width: '640',
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

function onPlayerReady(event) {
    console.log("El reproductor está listo");

    // Escuchar eventos de interacción del usuario
    player.addEventListener('onStateChange', function(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            startTimer();
            throttledSync(player.getCurrentTime()); // Usar throttle para sincronizar
        } else if (event.data == YT.PlayerState.PAUSED) {
            clearInterval(interval);
            socket.emit('pause', { roomName, currentTime: player.getCurrentTime() });
        } else if (event.data == YT.PlayerState.ENDED) {
            clearInterval(interval);
        }
    });
}

function startTimer() {
    var timeElement = document.getElementById('time');

    // Actualizar el contador cada segundo
    interval = setInterval(function() {
        var currentTime = player.getCurrentTime();
        timeElement.textContent = "" + formatTime(currentTime);
    }, 1000);
}

function formatTime(seconds) {
    var minutes = Math.floor(seconds / 60);
    var secs = Math.floor(seconds % 60);
    return minutes + ":" + (secs < 10 ? "0" : "") + secs; // Formato MM:SS
}

function onPlayerStateChange(event) {
    // Actualizar el tiempo cuando el video se pausa, adelanta o retrocede
    if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.PLAYING) {
        var currentTime = player.getCurrentTime();
        document.getElementById('time').textContent = "Transcurrido: " + formatTime(currentTime);
    }
}

// Manejar cambio de video
socket.on('changeVideo', (data) => {
    const videoId = new URL(data.videoUrl).searchParams.get('v');
    player.loadVideoById(videoId); // Cargar el video en el reproductor
    player.playVideo(); // Reproducir el video
});

// Manejar reproducción de video
socket.on('play', (data) => {
    player.seekTo(data.currentTime, true); // Sincronizar el tiempo
    player.playVideo(); // Reproducir el video
});

// Manejar pausa de video
socket.on('pause', (data) => {
    player.seekTo(data.currentTime, true); // Sincronizar el tiempo
    player.pauseVideo(); // Pausar el video
});

// Función de búsqueda de música
function searchMusic() {
    const query = document.getElementById('searchQuery').value;
    socket.emit('search', query);
}

// función para mostrar notificaciones
function showNotification(message, type = 'is-white') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Agregar la notificación al cuerpo del documento
    document.body.appendChild(notification);

    // Eliminar la notificación después de 3 segundos
    setTimeout(() => {
        document.body.removeChild(notification);
    }, 3000);
}

// Escuchar evento de nuevo usuario (esto debe ser emitido desde el servidor)
socket.on('userJoined', (nickname) => {
    showNotification(`${nickname} se ha unido a la sala`, 'is-link');
});

// ------------------------------------------------------------------
// -----------------------------------------------------------------
// Funciones para el manejo de la interfaz de usuario

// Función que se ejecuta cuando el DOM está completamente cargado
window.onload = function () {
    var urlParams = new URLSearchParams(window.location.search);
    var userType = urlParams.get('userType');
    var room = urlParams.get('room');
    var roomid = urlParams.get('room');

    if (room) {
        room = room.replace(/[\d-]+/g, '').trim(); // Elimina números y guiones
    }

    // Obtener los elementos del DOM
    var roomTitleElement = document.getElementById("room-title");
    var cookieInfoElement = document.getElementById("cookie-info");
    var roomTitleElementid = document.getElementById("room-title-id");

    // Verificar si los elementos existen y luego manipular su contenido
    if (roomTitleElement) {
        roomTitleElement.innerText = "Sala: " + (room ? room : "Sin nombre");
    }

    if (roomTitleElementid) {
        roomTitleElementid.innerHTML = "Id: " + (roomid ? roomid : "Sin nombre") +
            "<button id='copyButton' class='button subtitle is-small is-ghost' style='color:white; font-size:15px;'>Copiar</button>";

        // Definir la función para copiar el room ID
        document.getElementById('copyButton').addEventListener('click', function () {
            var textToCopy = roomid ? roomid : "Sin nombre";

            // Crea un elemento temporal de texto
            var textarea = document.createElement('textarea');
            textarea.value = textToCopy;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Crear la notificación flotante
            var notification = document.createElement('div');
            notification.style.textAlign = 'center';
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.width = '70%';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.backgroundColor = 'rgba(0, 128, 0, 0.8)';
            notification.style.color = 'white';
            notification.style.padding = '10px 20px';
            notification.style.borderRadius = '5px';
            notification.style.fontSize = '16px';
            notification.style.zIndex = '1000';
            notification.innerHTML = "ID copiado: " + textToCopy;

            // Añadir la notificación al body
            document.body.appendChild(notification);

            // Eliminar la notificación después de 3 segundos
            setTimeout(function () {
                notification.style.transition = 'opacity 0.5s';
                notification.style.opacity = '0';
                setTimeout(function () {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
        });
    }

    // Definir el rol de usuario si no existe
    var Rol = userType ? userType : "Invitado";

    // Asegúrate de que el elemento 'cookie-info' exista antes de intentar modificarlo
    if (cookieInfoElement) {
        if (Rol === "Admin") {
            cookieInfoElement.innerText = "Admin: " + (nickname ? nickname : "No definido");
        } else {
            cookieInfoElement.innerText = "Invitado: " + (nickname ? nickname : "No definido");
        }
    } else {
        console.log("Elemento 'cookie-info' no encontrado.");
    }
};