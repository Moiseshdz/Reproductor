SyncTube: Sincronización de Videos en Tiempo Real
Descripción
WatchTogether es una aplicación web desarrollada con Node.js que permite a múltiples usuarios ver videos de YouTube de forma sincronizada y en tiempo real. Es la solución perfecta para ver videos con amigos o familiares que se encuentran a distancia. La aplicación utiliza la API de YouTube para buscar videos directamente desde la interfaz, creando una experiencia fluida y centralizada.

✨ Características Principales
Sincronización en Tiempo Real: Reproducción, pausa y búsqueda en la línea de tiempo del video se sincronizan instantáneamente entre todos los participantes de una sala.

Creación de Salas: Genera salas privadas para compartir con quien tú quieras.

Búsqueda Integrada: Utiliza la API de YouTube para buscar y seleccionar videos sin salir de la aplicación.

Comunicación Eficiente: Construido con WebSockets (Socket.IO) para una comunicación de baja latencia entre el servidor y los clientes.

Interfaz Sencilla: Un diseño limpio e intuitivo para que la experiencia sea lo más agradable posible.

🛠️ Tecnologías Utilizadas
Backend:

Node.js

Express.js para el servidor web.

Socket.IO para la comunicación en tiempo real.

Frontend:

HTML5, CSS3, JavaScript (Vanilla JS).

YouTube IFrame Player API para controlar el reproductor de video.

API Externa:

YouTube Data API v3 para la búsqueda de videos.

🚀 Instalación y Puesta en Marcha
Sigue estos pasos para ejecutar el proyecto en tu entorno local.

Prerrequisitos
Tener instalado Node.js y npm (v16 o superior).

Obtener una API Key de la Plataforma de Google Cloud con acceso a la "YouTube Data API v3".

Pasos
Clonar el repositorio:

git clone https://github.com/tu-usuario/watch-together.git
cd watch-together

Instalar las dependencias del proyecto:

npm install

Configurar las variables de entorno:
Crea un archivo .env en la raíz del proyecto y añade tu API Key de YouTube.

# .env
YOUTUBE_API_KEY="AQUI_VA_TU_API_KEY_DE_YOUTUBE"

Iniciar el servidor:

npm start

Abrir la aplicación:
Abre tu navegador y ve a http://localhost:3000 (o el puerto que hayas configurado).

📖 ¿Cómo se usa?
Crea una Sala: Al entrar en la página principal, tendrás la opción de crear una nueva sala. Esto generará un enlace único.

Comparte el Enlace: Envía el enlace de la sala a las personas con las que quieres ver videos.

Busca un Video: Utiliza la barra de búsqueda para encontrar cualquier video en YouTube.

Disfruta en Sincronía: Al seleccionar un video, se cargará para todos en la sala. Cualquier acción (play, pausa, etc.) que realices se reflejará en las pantallas de los demás. ¡Así de simple!

📄 Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.
