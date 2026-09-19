<?php
/* @var $this yii\web\View */
$this->title = 'Realidad Aumentada';


//Archivos JS de A-Frame y AR.js
$this->registerJsFile("https://aframe.io/releases/1.0.4/aframe.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/gh/AR-js-org/AR.js@3.3.0/aframe/build/aframe-ar.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/gh/donmccurdy/aframe-extras@6.0.1/dist/aframe-extras.loaders.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/gh/AR-js-org/studio-backend@master/src/modules/marker/tools/gesture-detector.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/gh/AR-js-org/studio-backend@master/src/modules/marker/tools/gesture-handler.js", ['position' => \yii\web\View::POS_HEAD]);

//Script JS para video
$this->registerJs(
    "
    var m = document.querySelector('a-marker');

    // Detectar marcador y reproducir video
    m.addEventListener('markerFound', function(e) {
        console.log('found');
        var v = document.querySelector('#video');
        v.play();
    });

    // Detener video cuando el marcador se pierde
    m.addEventListener('markerLost', function(e) {
        console.log('lost');
        var v = document.querySelector('#video');
        v.pause();
    });

    // Botón de Play para video
    document.getElementById('play-video').addEventListener('click', function(e) {
        var v = document.querySelector('#video');
        v.play();
    });

    // Botón de Pause para video
    document.getElementById('pause-video').addEventListener('click', function(e) {
        var v = document.querySelector('#video');
        v.pause();
    });

    // Botón de Play Sound
    document.getElementById('play-sound').addEventListener('click', function(e) {
        var v = document.querySelector('#video');
        v.muted = false;
    });

    // Botón de Stop Sound
    document.getElementById('stop-sound').addEventListener('click', function(e) {
        var v = document.querySelector('#video');
        v.muted = true;
    });
    ",
    \yii\web\View::POS_READY // Esto asegura que el script se ejecute una vez que el DOM haya sido cargado
);



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" type="image/png" href="<?= \yii\helpers\Url::to('@web/images/faviconra.png') ?>">
    <title><?= $this->title ?></title>
</head>
<body style='margin: 0; padding: 0; border: 0; overflow: hidden; box-sizing: border-box;'>
<div id="botones" style='position: sticky; top: 10px; width:100%; display: flex; justify-content: center; z-index: 1;'>
        <button type="button" class="btn btn-secondary" id="play-video" style="background-color: #38928D"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
          </svg></button>
        <button type="button" class="btn btn-secondary" id="pause-video" style="background-color: #38928D"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-fill" viewBox="0 0 16 16">
            <path d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5"/>
          </svg></button>
        
        <button type="button" class="btn btn-secondary" id="play-sound" style="background-color: #38928D"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-up-fill" viewBox="0 0 16 16">
            <path d="M11.536 14.01A8.47 8.47 0 0 0 14.026 8a8.47 8.47 0 0 0-2.49-6.01l-.708.707A7.48 7.48 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303z"/>
            <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.48 5.48 0 0 1 11.025 8a5.48 5.48 0 0 1-1.61 3.89z"/>
            <path d="M8.707 11.182A4.5 4.5 0 0 0 10.025 8a4.5 4.5 0 0 0-1.318-3.182L8 5.525A3.5 3.5 0 0 1 9.025 8 3.5 3.5 0 0 1 8 10.475zM6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06"/>
            </svg></button>
        <button type="button" class="btn btn-secondary" id="stop-sound" style="background-color: #38928D"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-mute-fill" viewBox="0 0 16 16">
            <path d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06m7.137 2.096a.5.5 0 0 1 0 .708L12.207 8l1.647 1.646a.5.5 0 0 1-.708.708L11.5 8.707l-1.646 1.647a.5.5 0 0 1-.708-.708L10.793 8 9.146 6.354a.5.5 0 1 1 .708-.708L11.5 7.293l1.646-1.647a.5.5 0 0 1 .708 0"/>
            </svg></button>
        </div>

    <!--Contenido de realidad aumentada-->
        <a-scene
            vr-mode-ui="enabled: false;"
            loading-screen="enabled: false;"
            renderer="logarithmicDepthBuffer: true;"
            arjs="trackingMethod: best; sourceType: webcam; debugUIEnabled: false;"
            id="scene"
            gesture-detector
        >

                <a-assets>
                <!--Este es el video-->
                <video id="video" src="<?= \yii\helpers\Url::to('@web/'. $archivo1) ?>"></video>
                </a-assets>

        <!-- Marcador Personalizado -->
        <a-marker
            id="marker"
            type="pattern"
            raycaster="objects: .clickable"
            emitevents="true"
            cursor="fuse: false; rayOrigin: mouse";
            url="<?= \yii\helpers\Url::to('@web/' . $pattern) ?>"
        >

            <!--MP4 -->
            <a-video
            width="6" 
            height="3" 
            position="0 0 0" 
            rotation="270 0 0" 
            gesture-handler 
            scale="0.50334182666102167 0.50334182666102167 0.50334182666102167"
            src="#video"
            ></a-video>

        </a-marker>

        <!--Camara -->
        <a-entity camera></a-entity>
    </a-scene>

</body>
</html>
