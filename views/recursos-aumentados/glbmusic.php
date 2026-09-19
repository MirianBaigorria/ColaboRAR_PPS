<?php
/* @var $this yii\web\View */
$this->title = 'Realidad Aumentada';


//Archivos JS de A-Frame y AR.js
$this->registerJsFile("https://aframe.io/releases/1.0.4/aframe.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/donmccurdy/aframe-extras/master/dist/aframe-extras.loaders.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-detector.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-handler.js", ['position' => \yii\web\View::POS_HEAD]);

// Script JS para la musica
$this->registerJs(
    "
    // Cuando el marcador es detectado
    var m = document.querySelector('a-marker');
    m.addEventListener('markerFound', function(e) {
        console.log('found');
        var sound = document.querySelector('a-sound').components.sound;
        sound.playSound();
    });

    // Reproducir sonido al hacer clic en el botón de Play
    document.getElementById('play-music').addEventListener('click', function(e) {
        var sound = document.querySelector('a-sound').components.sound;
        sound.playSound();
    });

    // Pausar sonido al hacer clic en el botón de Pause
    document.getElementById('pause-music').addEventListener('click', function(e) {
        var sound = document.querySelector('a-sound').components.sound;
        sound.pauseSound();
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
    <!--Botones musica-->
    <div id="botones" style='position: sticky; top: 10px; width:100%; display: flex; justify-content: center; z-index: 1;'>
        <button type="button" class="btn btn-secondary" id="play-music" style="background-color: #38928D">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
          </svg></button>
        <button type="button" class="btn btn-secondary" id="pause-music" style="background-color: #38928D">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-fill" viewBox="0 0 16 16">
                <path d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5"/>
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
                <!--Glb/Gltf-->
                <a-assets-item id="glb" src="<?= \yii\helpers\Url::to('@web/'. $archivo1) ?>"></a-assets-item>
                <!--Audio-->
                <audio id="music" loop src="<?= \yii\helpers\Url::to('@web/' . $musica) ?>"></audio>
                </a-assets>



        <!-- Marcador-->
        <a-marker
            id="marker"
            type="pattern"
            raycaster="objects: .clickable"
            emitevents="true"
            cursor="fuse: false; rayOrigin: mouse";
            url="<?= \yii\helpers\Url::to('@web/' . $pattern) ?>"
        >


            <!--GLB/GLTF -->
            <a-entity
                gesture-handler 
                position="0 0 0"
                scale="0.37334182666102167 0.37334182666102167 0.37334182666102167"
                class="clickable"
                animation-mixer="loop: repeat"
                gltf-model="#glb"
            ></a-entity>


        <!--MP3-->
        <a-sound src="#music" loop></a-sound>

        </a-marker>

        <!--Camara -->
        <a-entity camera></a-entity>
    </a-scene>
</body>
</html>
