# SyncTube: Sincronización de Videos en Tiempo Real

## Descripción

WatchTogether es una aplicación web desarrollada con Node.js que permite a múltiples usuarios ver videos de YouTube de forma sincronizada y en tiempo real.  
Es la solución perfecta para ver videos con amigos o familiares que se encuentran a distancia.

La aplicación utiliza la API de YouTube para buscar videos directamente desde la interfaz, creando una experiencia fluida y centralizada.

---

## Características Principales

### Sincronización en Tiempo Real
La reproducción, pausa y búsqueda en la línea de tiempo del video se sincronizan instantáneamente entre todos los participantes de una sala.

### Creación de Salas
Genera salas privadas para compartir con quien tú quieras.

### Búsqueda Integrada
Utiliza la API de YouTube para buscar y seleccionar videos sin salir de la aplicación.

### Comunicación Eficiente
Construido con WebSockets (Socket.IO) para una comunicación de baja latencia entre el servidor y los clientes.

### Interfaz Sencilla
Un diseño limpio e intuitivo para que la experiencia sea lo más agradable posible.

---

## Tecnologías Utilizadas

### Backend
- Node.js
- Express.js para el servidor web.
- Socket.IO para la comunicación en tiempo real.

### Frontend
- HTML5
- CSS3
- JavaScript (Vanilla JS).
- YouTube IFrame Player API para controlar el reproductor de video.

### API Externa
- YouTube Data API v3 para la búsqueda de videos.

---

## Instalación y Puesta en Marcha

Sigue estos pasos para ejecutar el proyecto en tu entorno local.

### Prerrequisitos
- Tener instalado Node.js y npm (v16 o superior).
- Obtener una API Key de la Plataforma de Google Cloud con acceso a la **YouTube Data API v3**.

---

### Pasos

#### Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/watch-together.git
cd watch-together
