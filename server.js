require('dotenv').config(); // Cargar variables de entorno

const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const axios = require('axios');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

const YOUTUBE_API_KEY = process.env.YOUTUBE_API_KEY;
const YOUTUBE_API_URL = 'https://www.googleapis.com/youtube/v3/search';

app.use(express.static('public')); // Servir archivos estáticos

io.on('connection', (socket) => {
    console.log('Un usuario se ha conectado');

 // Unirse a una sala específica
 socket.on('joinRoom', (roomName) => {
    socket.join(roomName);
    console.log(`Usuario se unió a la sala: ${roomName}`);

    // Obtener el nickname del usuario desde la cookie (esto debe ser manejado en el cliente)
    const nickname = socket.handshake.headers.cookie?.split('nickname=')[1]?.split(';')[0] || 'Anónimo';

    // Emitir evento de nuevo usuario
    io.to(roomName).emit('userJoined', nickname);
});

// ------------------------------

    // Manejar búsqueda de videos
    socket.on('search', async (query) => {
        try {
            const response = await axios.get(YOUTUBE_API_URL, {
                params: {
                    part: 'snippet',
                    q: query,
                    type: 'video',
                    key: YOUTUBE_API_KEY,
                    maxResults: 10
                }
            });

            const videos = response.data.items.map(item => ({
                title: item.snippet.title,
                url: `https://www.youtube.com/watch?v=${item.id.videoId}`
            }));

            socket.emit('searchResults', videos);
        } catch (error) {
            console.error('Error en la búsqueda:', error.message);
            socket.emit('error', 'Error al buscar el video. Intenta nuevamente.');
        }
    });

    // Manejar eventos de reproducción, pausa, búsqueda y chat dentro de la sala
    socket.on('play', (data) => {
        const { roomName, videoUrl } = data;
        io.to(roomName).emit('play', videoUrl);
    });

    socket.on('pause', (roomName) => {
        io.to(roomName).emit('pause');
    });

    socket.on('seek', (data) => {
        const { roomName, time } = data;
        io.to(roomName).emit('seek', time);
    });

    socket.on('chatMessage', (data) => {
        const { roomName, message } = data;
        io.to(roomName).emit('chatMessage', message);
    });
});

const PORT = process.env.PORT || 4000;
server.listen(PORT, () => console.log(`Servidor en http://localhost:${PORT}`));