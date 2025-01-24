const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const axios = require('axios');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

const YOUTUBE_API_KEY = 'AIzaSyDENbXjDvV4CA9oXdAvAzD1foN32eRSYIw'; // Reemplaza con tu API Key
const YOUTUBE_API_URL = 'https://www.googleapis.com/youtube/v3/search';

app.use(express.static('public')); // Sirve archivos estáticos desde la carpeta 'public'

io.on('connection', (socket) => {
    console.log('Un usuario se ha conectado');

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
                url: `https://www.youtube.com/watch?v=${item.id.videoId}` // URL para incrustar en el iframe
            }));
            socket.emit('searchResults', videos);
        } catch (error) {
            socket.emit('error', 'Error al buscar el video');
        }
    });

    socket.on('play', (videoUrl) => {
        io.emit('play', videoUrl); // Enviar a todos los clientes conectados
    });

    socket.on('pause', () => {
        io.emit('pause');
    });

    socket.on('seek', (time) => {
        io.emit('seek', time);
    });

    // Manejar mensajes de chat
    socket.on('chatMessage', (message) => {
        io.emit('chatMessage', message); // Enviar a todos los clientes conectados
    });
});

const port = process.env.PORT || 4000; // Usa el puerto de la variable de entorno
server.listen(port, () => {
    console.log(`Servidor escuchando en el puerto ${port}`);
});
