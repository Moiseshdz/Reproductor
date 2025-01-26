const socket = io();
let selectedVideoUrl = '';
let selectedVideoTitle = '';
let userName = '';
let userColors = {}; // Objeto para almacenar colores por usuario

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
        socket.emit('chatMessage', { userName: userName, message: message });
        messageInput.value = '';
    }
});

// Mostrar el formulario de chat y ocultar el de nombre
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

        row.onclick = () => {
            selectedVideoUrl = video.url;
            selectedVideoTitle = video.title;
            const titleElement = document.getElementById('selectedVideoTitle');
            titleElement.textContent = `Canción seleccionada: ${selectedVideoTitle}`;
            const videoId = new URL(video.url).searchParams.get('v');
            const embedUrl = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&controls=1`;
            const player = document.getElementById('videoPlayer');
            player.src = embedUrl;
        };

        tableBody.appendChild(row);
    });
});

// Manejar reproducción de video
socket.on('play', (videoUrl) => {
    const videoId = new URL(videoUrl).searchParams.get('v');
    const embedUrl = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&controls=1&autoplay=1&mute=1`; 
    const player = document.getElementById('videoPlayer');
    player.src = embedUrl;

    player.onload = () => {
        player.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
    };
});

// Manejar pausa de video
socket.on('pause', () => {
    const player = document.getElementById('videoPlayer');
    if (player) {
        player.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
    }
});



// Manejar búsqueda de tiempo
socket.on('seek', (time) => {
    console.log('Buscando:', time);
    // Aquí podrías enviar un mensaje para buscar el tiempo en el video si fuera necesario
});

// Función de búsqueda de música
function searchMusic() {
    const query = document.getElementById('searchQuery').value;
    socket.emit('search', query);
}

// Función de reproducción de música
function playMusic() {
    if (selectedVideoUrl) {
        socket.emit('play', selectedVideoUrl);
        const videoId = new URL(selectedVideoUrl).searchParams.get('v');
        const embedUrl = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&controls=1&autoplay=1&mute=1`;
        const player = document.getElementById('videoPlayer');
        player.src = embedUrl;
        setTimeout(() => {
            player.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
        }, 1000);
    } else {
        console.log('No se ha seleccionado ningún video.');
    }
}

// Función de pausa de música
function pauseMusic() {
    socket.emit('pause');
}

// Función de búsqueda de tiempo
function seekMusic(time) {
    socket.emit('seek', time);
}
