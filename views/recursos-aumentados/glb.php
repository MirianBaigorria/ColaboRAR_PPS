<?php
/* @var $this yii\web\View */
$this->title = 'Realidad Aumentada';


//Archivos JS de A-Frame y AR.js
$this->registerJsFile("https://aframe.io/releases/1.0.4/aframe.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/donmccurdy/aframe-extras/master/dist/aframe-extras.loaders.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-detector.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://raw.githack.com/AR-js-org/studio-backend/master/src/modules/marker/tools/gesture-handler.js", ['position' => \yii\web\View::POS_HEAD]);
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

        </a-marker>

        <!--Camara -->
        <a-entity camera></a-entity>
    </a-scene>

</body>
</html>
