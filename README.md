# SyncTube — Reproducción de Video Sincronizada en Tiempo Real

Aplicación web desarrollada con **Node.js, Express y Socket.IO** para reproducir videos de YouTube de forma sincronizada entre múltiples usuarios conectados a una misma sala.

## Tecnologías

- Node.js
- Express.js
- Socket.IO
- HTML5
- CSS3
- JavaScript
- YouTube IFrame Player API
- YouTube Data API v3

## Funcionalidades

- Creación de salas privadas
- Sincronización en tiempo real de reproducción, pausa y posición
- Búsqueda de videos desde la aplicación
- Comunicación bidireccional mediante WebSockets
- Interfaz web ligera y responsiva

## Instalación

```bash
git clone https://github.com/Moiseshdz/synctube-realtime-video-sync.git
cd synctube-realtime-video-sync
npm install
```

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

Agrega tu propia clave de YouTube Data API en `.env` y ejecuta:

```bash
npm start
```

## Seguridad

Las credenciales y claves de API no deben almacenarse en el repositorio. El proyecto incluye `.env.example` para documentar las variables necesarias sin publicar secretos.

## Autor

**Moisés García**  
Ingeniero en Sistemas Computacionales / Desarrollo Web

GitHub: [@Moiseshdz](https://github.com/Moiseshdz)
