<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demostración del Proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
             background:#212F3C  ;
        }

        .video-container {
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            overflow: hidden;
        }

        video {
            width: 100%;
            display: block;
        }

        .controls {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .controls button {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
        }

        .progress-bar {
            width: 100%;
            height: 5px;
            background-color: #ccc;
            margin-top: 10px;
            position: relative;
        }

        .progress {
            height: 100%;
            background-color: #4caf50;
            width: 0%;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video id="video" >
            <source src="video.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
        <div class="controls">
            <button id="play-pause">&#9658;</button>
            <button id="mute">&#128266;</button>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <button id="fullscreen">&#8597;</button>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const playPauseButton = document.getElementById('play-pause');
        const muteButton = document.getElementById('mute');
        const fullscreenButton = document.getElementById('fullscreen');
        const progressBar = document.querySelector('.progress');

        playPauseButton.addEventListener('click', function() {
            if (video.paused || video.ended) {
                video.play();
                playPauseButton.innerHTML = '&#10074;&#10074;'; // Pause icon
            } else {
                video.pause();
                playPauseButton.innerHTML = '&#9658;'; // Play icon
            }
        });

        muteButton.addEventListener('click', function() {
            video.muted = !video.muted;
            if (video.muted) {
                muteButton.innerHTML = '&#128266;'; // Muted icon
            } else {
                muteButton.innerHTML = '&#128266;'; // Unmuted icon
            }
        });

        fullscreenButton.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                video.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable full-screen mode: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        });

        video.addEventListener('timeupdate', function() {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.style.width = `${progress}%`;
        });
    </script>
</body>
</html>
