require('dotenv').config();

const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const axios = require('axios');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

const YOUTUBE_API_KEY = process.env.YOUTUBE_API_KEY;
const YOUTUBE_API_URL = 'https://www.googleapis.com/youtube/v3/search';

app.use(express.static('public'));

let lastState = {}; // Guardar el estado de cada sala
let lastActionTime = {}; // Guardar la última acción de cada sala

io.on('connection', (socket) => {
    console.log('Un usuario se ha conectado');

    socket.on('joinRoom', (roomName) => {
        socket.join(roomName);
        console.log(`Usuario se unió a la sala: ${roomName}`);
        
        const nickname = socket.handshake.headers.cookie?.split('nickname=')[1]?.split(';')[0] || 'Anónimo';
        io.to(roomName).emit('userJoined', nickname);
    });

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

    socket.on('changeVideo', (data) => {
        const { roomName, videoUrl } = data;
        io.to(roomName).emit('changeVideo', videoUrl);
    });

    socket.on('play', (data) => {
        const { roomName, currentTime } = data;
        if (!roomName) return;

        const now = Date.now();
        if (lastActionTime[roomName] && now - lastActionTime[roomName] < 1000) {
            return; // No enviar eventos si han pasado menos de 1 segundo
        }

        if (lastState[roomName]?.state === 'play' && Math.abs(lastState[roomName]?.currentTime - currentTime) < 1) {
            return; // Evita enviar si ya está en play y el tiempo es similar
        }

        console.log(`Play en sala ${roomName}, tiempo: ${currentTime}`);
        lastState[roomName] = { state: 'play', currentTime };
        lastActionTime[roomName] = now;
        io.to(roomName).emit('play', { currentTime });
    });

    socket.on('pause', (data) => {
        const { roomName, currentTime } = data;
        if (!roomName) return;

        const now = Date.now();
        if (lastActionTime[roomName] && now - lastActionTime[roomName] < 1000) {
            return;
        }

        if (lastState[roomName]?.state === 'pause') {
            return; // Evita enviar si ya está en pausa
        }

        console.log(`Pause en sala ${roomName}, tiempo: ${currentTime}`);
        lastState[roomName] = { state: 'pause', currentTime };
        lastActionTime[roomName] = now;
        io.to(roomName).emit('pause', { currentTime });
    });

    socket.on('chatMessage', (data) => {
        const { roomName, message } = data;
        io.to(roomName).emit('chatMessage', message);
    });

    socket.on('disconnect', () => {
        console.log('Un usuario se ha desconectado');
    });
});

const PORT = process.env.PORT || 4000;
server.listen(PORT, () => console.log(`Servidor en http://localhost:${PORT}`));