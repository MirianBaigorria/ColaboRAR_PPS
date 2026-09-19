<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\RecursosAumentados */

$this->params['breadcrumbs'][] = ['label' => 'Recursos Aumentados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//Registrar los archivos JS para generar el QR y el canvas
$this->registerJsFile("https://unpkg.com/@intosoft/qrcode@0.1.1/dist/iife/index.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/rgbcolor.min.js", ['position' => \yii\web\View::POS_HEAD]);


if($model->r_musica!=null){
    $music="true";
}else{
    $music="false";
}

?>
<div class="recursos-aumentados-view">

    <h1><?= Html::encode($this->title) ?></h1>

        <div id="svg-container" style="margin: 0 auto; width: fit-content; text-align: center;">
        <!--Data attributes para enviar datos a JS-->
        <span id="archivo"
            data-tipoar="<?php echo $model->tipoar?>"
            data-music="<?php echo $music?>"
            data-marker="<?php echo  \yii\helpers\Url::to('@web/' . $model->marker) ?>"
            data-pattern="<?php echo $model->pattern?>"
            data-musica="<?php echo $model->r_musica ?>"
            data-archivo1="<?php echo $model->r_archivo1 ?>"
            data-archivo2="<?php echo $model->r_archivo2 ?>"
        ></span>
        </div>
        <!--Boton para imprimir y descargar el marcador(en caso de que se use con webcam)-->
        <div id="boton-download-reproducir" style="margin: 0 auto; width: fit-content; text-align: center;">
        <button type="button" class="btn btn-info" id="descargapng">Descargar marcador</button>
        <!--Boton para reproducir en PC-->
        <?php
        //$url = 'https://chat.fce.unse.edu.ar/chat/web/index.php?r=recursos-aumentados/reproducir-recurso&' . http_build_query([
        //'tipoar' => $model->tipoar,
        //'music' => $music,
        //'pattern' => $model->pattern,
        //'archivo1' => $model->r_archivo1,
        //'archivo2' => $model->r_archivo2,
        //'musica' => $model->r_musica,
        //]);
        ?>
       <!-- <a id="reproducir-recurso" href="//$url" class="btn btn-info" target="_blank">Reproducir Recurso</a>-->
    </div>


    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este recurso aumentado?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion',
            'tipoar',
        ],
    ]) ?>

</div>

<?php
//JS para generar el qr
  $this->registerJs("

  //Pasamos a JS los valores de los Data attributes
  let archivo=document.getElementById('archivo');
  let tipoar=archivo.dataset.tipoar;
  let music=archivo.dataset.music;
  let marker=archivo.dataset.marker;
  let pattern=archivo.dataset.pattern;
  let archivo1=archivo.dataset.archivo1;
  let archivo2=archivo.dataset.archivo2;
  let musica=archivo.dataset.musica;

  console.log('tipoar: '+tipoar);
  console.log('music: '+music);
  console.log('marker: '+marker);
  console.log('pattern: '+pattern);
  console.log('archivo1: '+archivo1);
  console.log('archivo2: '+archivo2);
  console.log('musica: '+musica);


  var valueURL = 'https://chat.fce.unse.edu.ar/chat/web/index.php?r=recursos-aumentados/reproducir-recurso&' +
               'tipoar=' + encodeURIComponent(tipoar) +
               '&music=' + encodeURIComponent(music) +
               '&pattern=' + encodeURIComponent(pattern) +
               '&archivo1=' + encodeURIComponent(archivo1) +
               '&archivo2=' + encodeURIComponent(archivo2) +
               '&musica=' + encodeURIComponent(musica);

  const config = {
    'length': 500,
    'padding': 20,
    'errorCorrectionLevel': 'H',
    'value': valueURL, //Url hacia donde se va a dirigir
    'logo': {
        'url': marker, //Marcador
        'size': 30,
        'removeBg': true
    },
    'shapes': {
        'eyeFrame': 'square',
        'body': 'square',
        'eyeball': 'body'
    },
    'colors': {
        'background': 'rgb(255, 255, 255)',
        'body': 'rgb(3, 3, 3)',
        'eyeFrame': {
            'topLeft': 'body',
            'topRight': 'body',
            'bottomLeft': 'body'
        },
        'eyeball': {
            'topLeft': 'body',
            'topRight': 'body',
            'bottomLeft': 'body'
        }
    }
  }

  const svgString = window.qrcode.generateSVGString(config);
  console.log(svgString);
  document.getElementById('svg-container').innerHTML = svgString;

  let svg=document.querySelector('svg');
  svg.id='idsvg';

  ", View::POS_READY);


  //JS para descargar el marcador
  $this->registerJs("

  function svgToPngAndDownload(svgElement, filename) {
      // Obtener el contenido del SVG como XML
      var svgXml = (new XMLSerializer()).serializeToString(svgElement);

      // Crear un elemento canvas oculto
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');

      // Tamaño del canvas igual al tamaño del SVG
      canvas.width = svgElement.clientWidth;
      canvas.height = svgElement.clientHeight;

      // Usar canvg para renderizar el SVG en el canvas
      canvg(canvas, svgXml, {
          ignoreMouse: true,
          ignoreAnimation: true,
          ignoreDimensions: true,
          renderCallback: function () {
              // Obtener el PNG como base64
              var pngDataUrl = canvas.toDataURL('image/png');

              // Crear un enlace <a> para descargar el PNG
              var link = document.createElement('a');
              link.download = filename; // Nombre del archivo a descargar
              link.href = pngDataUrl;
              link.click();

          }
      });
  }

  // Main
  var svgElement = document.getElementById('idsvg');
  var boton = document.getElementById('descargapng');

  boton.addEventListener('click', function() {
      svgToPngAndDownload(svgElement, 'marker.png');
  });

  ", View::POS_READY);

?>