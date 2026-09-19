<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChatsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$miembrosChat = app\models\Chats::getMiembrosChat($grupo_id);
$usuarioid = Yii::$app->user->identity->id;


//Obtener multiples recursos para el chat
$chat = \app\models\Chats::findOne($chatid);
$cantidad = $chat->cantidad_recursos_au;

$recursos = [];
for ($i = 1; $i <= $cantidad; $i++) {
    $campo = "recursoau_$i";
    $recurso = \app\models\RecursosAumentados::findOne($chat->$campo);
    if ($recurso) {
        $recursos[] = [
            'tipoar' => $recurso->tipoar,
            'music' => $recurso->r_musica != null ? 'true' : 'false',
            'marker' => \yii\helpers\Url::to('@web/' . $recurso->marker),
            'pattern' => $recurso->pattern,
            'musica' => $recurso->r_musica,
            'archivo1' => $recurso->r_archivo1,
            'archivo2' => $recurso->r_archivo2,
        ];
    }
}




// URLs para hacer llamados AJAX
$recuperarChat = Yii::$app->urlManager->createUrl([
    'chats/recuperar-chat',
    'chatid' => $chatid,
]);



$recuperarUltimaSentenciaChat = Yii::$app->urlManager->createUrl([
    'chats/recuperar-ultima-sentencia-chat',
    'chatid' => $chatid,
]);
$enviarSentencia = Yii::$app->urlManager->createUrl(['sentencias/crear-con-ajax']);
$enviarReporteEstadoAnimo = Yii::$app->urlManager->createUrl(['emociones/crear-con-ajax']);
$sentenciasApertura = Yii::$app->urlManager->createUrl(['sentencias-apertura/recuperar-sentencias']);
$rEstadoAnimo = ($tarea->reportar_estado_animo) ? 1 : 0;
$rConflicto = ($tarea->reportar_conflicto) ? 1 : 0;
$enviarReporteConflicto = Yii::$app->urlManager->createUrl(['conflictos/crear-con-ajax']);
$urlUploads = Yii::$app->request->baseUrl . "/uploads/$directorio/";
$this->title = $asignatura . " - " . $tarea->nombre_t . " / Grupo " . $miembrosChat[0]["grupos_formados_id"] . " - " . $miembrosChat[0]["alumnos"];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/jquery.rateyo.min.js', ['depends' => [\yii\jui\JuiAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/emoji-picker/js/config.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/emoji-picker/js/util.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/emoji-picker/js/jquery.emojiarea.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl . '/emoji-picker/js/emoji-picker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);




//Registrar los archivos JS para generar el QR y el canvas
$this->registerJsFile("https://unpkg.com/@intosoft/qrcode@0.1.1/dist/iife/index.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/rgbcolor.min.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css");
$this->registerJsFile("https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js", ['position' => \yii\web\View::POS_END]);


$base = Yii::$app->request->baseUrl;


$script = <<< JS
    function enviarArchivo(nombreArchivo){        
        sentenciaEnviar = "<a href='$urlUploads" + nombreArchivo + "' target='_blank'>" + nombreArchivo + "</a>";
        $.ajax({
            method: 'POST',
            url: "$enviarSentencia",
            data: {sentencia: sentenciaEnviar, usuarios_id: $usuarioid, chats_id: $chatid},
        }).done(function (data) {           
            return true;
        });         
    }
        
    $(function () {
        var bSeleccionSentencia = 0;
        var rEstadoAnimo = $rEstadoAnimo;
        var rConflicto = $rConflicto;
        var scrollTopBefore = 0;
        var lastScrollHeight = 0;
        var ultimaSentencia = "";
        
        // Cargar sentencias del chat
       // Cargar sentencias del chat
       $.ajax({
    url: "$recuperarChat",
    beforeSend: function () {
        $('#chatLoading').show().html("Cargando chat... 🌨️");
    }
}).done(function (data) {
    const contenido = $.trim(data);
    if (contenido === '') {
        $('#chatLoading').html("Todavía no hay mensajes en el chat. ¡Sé el primero en participar! ✍️");
    } else {
        $('#chatLoading').remove();
        $('#divChat').append(data);
        var objDiv = document.getElementById("divChat");
        objDiv.scrollTop = objDiv.scrollHeight;
        lastScrollHeight = objDiv.scrollHeight;
    }
});



        $('#divChat').scroll(function(){
            var objDiv = document.getElementById("divChat");
            scrollTopBefore = objDiv.scrollTop;
        });
        
        $('#btnGoBottom').click(function(){
            var objDiv = document.getElementById("divChat");
            objDiv.scrollTop = objDiv.scrollHeight;
            lastScrollHeight = objDiv.scrollHeight;
            $('#goBottom').hide();
        });
        
        $.ajax({
            url: "$recuperarUltimaSentenciaChat",
        }).done(function (data) {
            ultimaSentencia = data;                    
        });
        
        setInterval(function(){
            $.ajax({
                url: "$recuperarUltimaSentenciaChat",
            }).done(function (data) {
                if (ultimaSentencia !== data){
                    var objDiv = document.getElementById("divChat");
                    $('#divChat').append(data);
                    ultimaSentencia = data;  
                    diferencia = objDiv.scrollHeight - scrollTopBefore;
                    if( diferencia > 300 && diferencia < 790 ){
                        objDiv.scrollTop = objDiv.scrollHeight;                    
                        lastScrollHeight = objDiv.scrollHeight;
                    } else {                        
                        objDiv.scrollTop = scrollTopBefore;
                        if (lastScrollHeight < objDiv.scrollHeight){
                            $('#goBottom').show();
                        }                        
                    }
                }           
            });
        }, 1000);


        $('#cbxSubhabilidad').change(function () {
            $.ajax({
                url: "$sentenciasApertura",
                data: {idsubhab: $('#cbxSubhabilidad').val()},
            }).done(function (data) {
                sentencias = JSON.parse(data);        
                string = "";
                for(var i = 0; i < sentencias.length; i++){
                    string +='<option value="' + sentencias[i].id + '">' + sentencias[i].sentencia +'</option>'                
                }
                $('#cbxSentencias').html(string);            
            });
        });         
            
        $('#cbxSentencias').change(function(){
            bSeleccionSentencia = 1;
            $('#txtSentencia').prop('disabled', false);
        });      
        
 $('#frmChat').submit(function (e) {
    e.preventDefault();

    if ($('#txtSentencia').val().length != 0) {
        var sentenciaApertura = '';
        if (bSeleccionSentencia == 1){                    
            sentenciaApertura = '<b>' + $('#cbxSentencias :selected').text() + '</b> ';
        }
        var idhidden = $('#txtSentencia').data('id');
        var raw = ($("*[data-id=" + idhidden + "]").val());        
        var sentenciaEnviar = sentenciaApertura + raw;

        // Crear el formato del mensaje sin incluir el nombre de usuario ni los puntos
        var mensajeFormateado = sentenciaEnviar; // Solo envía el contenido del mensaje

        // Se envía el mensaje
        $.ajax({
            method: 'POST', // <-- CAMBIA A POST
            url: "$enviarSentencia",
            data: {
                sentencia: mensajeFormateado,
                usuarios_id: $usuarioid,
                chats_id: $chatid
            },
        }).done(function (data) {
            $('#txtSentencia').val('');
            $('.emoji-wysiwyg-editor').html("");  
            return true;
        });        
    }        
});

$('#txtSentencia').keypress(function (e) {
    if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        $('#frmChat').submit();
        $(this).val('');
        $('.emoji-wysiwyg-editor').html('');
    }
});
$(document).on('keypress', '.emoji-wysiwyg-editor', function(e) {
    if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();

        let contenido = $(this).text().trim();

        if (contenido.length > 0) {
            $('#txtSentencia').val(contenido); // lo pasamos al input oculto
            $('#frmChat').submit();             // enviamos
            $(this).html('');                   // limpiamos el editor
            $('#txtSentencia').val('');         // limpiamos el input real
        }
    }
});



           
        
        if (rEstadoAnimo == 1){
            if ($('#lblEmocionSeleccionada').html().length == 0){
                $('#pleasure').val('0.000');
                $('#arousal').val('0.000');
                $('#dominance').val('0.000');
                $('#imgEmocionSeleccionada').attr('class', 'neutral');
                $('#lblEmocionSeleccionada').html('Neutral');
            }
        
            $('input[type="button"].btnEmociones').click(function(){
                $('#pleasure').val($(this).data('pleasure'));
                $('#arousal').val($(this).data('arousal'));
                $('#dominance').val($(this).data('dominance'));
                $('#imgEmocionSeleccionada').attr('class', $(this).attr('class'));
                $('#lblEmocionSeleccionada').html($(this).data('emocion'));

                $.ajax({
                    method: 'GET',
                    url: "$enviarReporteEstadoAnimo",
                    data: {id: $chatid, valence: $('#pleasure').val(), arousal: $('#arousal').val(), dominance: $('#dominance').val(), usuarios_id: $usuarioid},
                }).done(function () {
                    return true;
                });   
            });                
        }   
        
        if (rConflicto == 1){
            $('#btnReporteConflicto').click(function () {
                $.ajax({
                    method: 'GET',
                    url: "$enviarReporteConflicto",
                    data: {idChat: $chatid, usuarios_id: $usuarioid},
                }).done(function () {
                    return true;
                });
            });        
        }        
        
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '$base/emoji-picker/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });                             
JS;

$this->registerJs($script, yii\web\View::POS_END);
$sentenciaApertura = new app\models\SentenciasApertura();
?>

<div class="chats-index">
    <div class="consPointsNote">
        <div class="chat-tarea">
            <h1 class="chat-first-p"><span>Actividad a realizar:</span><br /></h1>
            <p class="tareaConsigna"><?= $tarea->nombre_t ?></p>
            <p class="tareaConsigna"><?= $tarea->consigna ?></p>
        </div>
    </div>

    <h1>💬 CHAT <span style="color:#EB6500;">.</span></h1>

        <div id="recursos">
    <div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php foreach ($recursos as $index => $recurso): ?>
        <div class="swiper-slide">
            <span class="archivo-recurso" 
                data-index="<?= $index ?>"
                data-tipoar="<?= $recurso['tipoar'] ?>"
                data-music="<?= $recurso['music'] ?>"
                data-marker="<?= $recurso['marker'] ?>"
                data-pattern="<?= $recurso['pattern'] ?>"
                data-musica="<?= $recurso['musica'] ?>"
                data-archivo1="<?= $recurso['archivo1'] ?>"
                data-archivo2="<?= $recurso['archivo2'] ?>">
            </span>
            <div class="svg-slide-container" style="text-align: center;"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Flechas -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    </div>

    <!-- Botones de accion -->
    <div id="boton-download-reproducir" style="text-align: center; margin-top: 20px;">
        <button type="button" class="btn btn-info" id="descargapng">Descargar marcador</button>
      <!--  <a id="reproducir-recurso" class="btn btn-info" target="_blank">Reproducir Recurso</a>-->
    </div>
    </div>









    <div class="chats-events-emotions">
        <div id='divChat' style=" height: 400px; overflow-y: scroll;">
            <div id="chatLoading" style="text-align: center; padding: 20px;">Cargando chat...🌨️🌨️</div>
        </div> <br />
        <div id="goBottom" style="margin: 0 auto; width: 200px; display: none;">
            <input id="btnGoBottom" type="button" style="background-color: #FEE300;  text-align: center; padding: 5px;"
                value="Tienes nuevos mensajes" />
        </div>
        <div id="nuevoEvento" style="margin: 0 auto; width: 200px; display: none;">
            <input id="btnNuevoEvento" type="button"
                style="background-color: #BDE5F8; text-align: center; padding: 5px;" value="Tienes un nuevo evento" />
        </div>

        <form id="frmChat">
            <?php if ($tarea->usar_sentencias_apertura == 1): ?>
                <label><b>Empeza tu aporte con alguna de estas frases:</b></label><br />
                <label for="cbxSubhabilidades">Tipo de aporte:</label>
                <select id="cbxSubhabilidad" name="cbxSubhabilidades">
                    <?php foreach ($sentenciaApertura->a_subhabilidad as $id => $subhabilidad): ?>
                        <option value="<?php echo $id; ?>"><?php echo $subhabilidad; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select><br />
                <label>Frases disponibles:</label>
                <select id="cbxSentencias" name="cbxSentencias">
                </select><br />
            <?php endif; ?>
            <p class="lead emoji-picker-container">
                <input id="txtSentencia" name="txtSentencia" value=""
                    <?php echo ($tarea->usar_sentencias_apertura == 1) ? 'disabled="disabled"' : ''; ?>
                    class="form-control" style="height: 60px; width: 100px;" data-emojiable="true" />
            </p>
            <div class="input-drop">
                <input type="submit" id="btnEnviar" name="btnEnviar" value="Enviar Mensaje" />
                <?php
                $userid = Yii::$app->user->identity->id;
                $oUser = \app\models\Usuarios::findOne(['id' => $userid]);
                echo \kato\DropZone::widget([
                    'options' => [
                        'url' => Yii::$app->urlManager->createUrl(['chats/grupo-ra', 'chatid' => Yii::$app->security->encryptByPassword($chatid, $oUser->password)]),
                        'maxFilesize' => '2',
                        'dictDefaultMessage' => "Coloque aquí los archivos para compartir",
                    ],
                    'clientEvents' => [
                        'complete' => "function(file){console.log(file); if (file.status!='error') enviarArchivo(file.name);}",
                        'removedfile' => "function(file){alert(file.name + ' is removed')}"
                    ],
                ]);
                ?>
            </div>

        </form>
    </div>


    <div style=" width:70%; margin:20px 0px;">


        <?php if ($tarea->reportar_estado_animo == 1): ?>
            <h1>Estado de Animo <span style="color:#EB6500;">.</span></h1>
            <div class="texto-estado-animo">
                <p class="texto-estado-animo-p"> Selecciona tu estado de ánimo para expresar cómo te sientes durante la actividad. 🎭 Esto ayudará a tu equipo a comprender mejor tu perspectiva y promoverá un ambiente de colaboración más efectivo. ¡Cada emoción cuenta!</p>
                <p class="estado-seleccionado"><img id='imgEmocionSeleccionada'
                        style="border:0px;" /> <label id='lblEmocionSeleccionada'></label></p>
            </div>
            <b class="estado-b">¿Cómo te sientes?</b>
            <br />
            <div class="btns-emociones">
                <input type="button" id="btnNeutral" class='btnEmociones neutral' data-arousal="0" data-pleasure="0"
                    data-dominance="0" data-emocion='Neutral' title="Neutral" />
                <input type="button" id="btnAngry" class='btnEmociones angry' data-arousal="0.59" data-pleasure="-0.51"
                    data-dominance="0.25" data-emocion='Enojado' title="Enojado" />
                <input type="button" id="btnFear" class='btnEmociones fear' data-arousal="0.60" data-pleasure="-0.64"
                    data-dominance="-0.43" data-emocion='Preocupado' title="Preocupado" />
                <input type="button" id="btnJoy" class='btnEmociones joy' data-arousal="0.2" data-pleasure="0.4"
                    data-dominance=0.1 data-emocion='Alegre' title="Alegre" />
                <input type="button" id="btnSadness" class='btnEmociones sadness' data-arousal="-0.2" data-pleasure="-0.4"
                    data-dominance="-0.1" data-emocion='Cansado' title="Cansado" />
                <input type="button" id="btnSurprise" class='btnEmociones surprise' data-arousal="0.59" data-pleasure="0.87"
                    data-dominance="-0.87" data-emocion='Sorprendido' title="Sorprendido" />
                <input id="pleasure" type="hidden" value="0" min="-1" max="1" step="0.05" size="4" />
                <input id="arousal" type="hidden" value="0" min="-1" max="1" step="0.05" />
                <input id="dominance" type="hidden" value="0" min="-1" max="1" step="0.05" />
                <br /><br />
            <?php endif; ?>
            </div>

            <?php if ($tarea->reportar_conflicto == 1): ?>
                <h1>Estado de Animo del grupo<span style="color:#EB6500;">.</span></h1>
                <p class="texto-estado-animo-p">Descubre cómo se siente tu grupo para mejorar la dinámica de trabajo en equipo. 👥💬 Conoce el estado de ánimo general y trabaja en conjunto para resolver cualquier conflicto o potenciar la motivación. ¡La clave del éxito está en cómo nos sentimos y colaboramos!</p>
                <div>
                    <input type="button" id="btnReporteConflicto" name="btnReporteConflicto"
                        value="Siento que estamos con diferencias en el grupo"
                        style="background-color: #FCE9C3; padding:10px;" /><br />
                </div>
            <?php endif; ?>


    </div>


</div>



<?php
//JS para generar el qr
 $this->registerJs("
// Inicializar Swiper
let swiper = new Swiper('.mySwiper', {
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on: {
        slideChange: function () {
            actualizarRecurso(swiper.realIndex);
        }
    }
});

// Obtener todos los recursos del DOM
let recursos = document.querySelectorAll('.archivo-recurso');

// Función que actualiza el recurso mostrado (QR + botón)
function actualizarRecurso(index) {
    const archivo = recursos[index];
    let tipoar = archivo.dataset.tipoar;
    let music = archivo.dataset.music;
    let marker = archivo.dataset.marker;
    let pattern = archivo.dataset.pattern;
    let archivo1 = archivo.dataset.archivo1;
    let archivo2 = archivo.dataset.archivo2;
    let musica = archivo.dataset.musica;

    let valueURL = 'https://chat.fce.unse.edu.ar/chat/web/index.php?r=recursos-aumentados/reproducir-recurso&' +
        'tipoar=' + encodeURIComponent(tipoar) +
        '&music=' + encodeURIComponent(music) +
        '&pattern=' + encodeURIComponent(pattern) +
        '&archivo1=' + encodeURIComponent(archivo1) +
        '&archivo2=' + encodeURIComponent(archivo2) +
        '&musica=' + encodeURIComponent(musica);

    const config = {
        length: 500,
        padding: 20,
        errorCorrectionLevel: 'H',
        value: valueURL,
        logo: {
            url: marker,
            size: 30,
            removeBg: true
        },
        shapes: {
            eyeFrame: 'square',
            body: 'square',
            eyeball: 'body'
        },
        colors: {
            background: 'rgb(255, 255, 255)',
            body: 'rgb(3, 3, 3)',
            eyeFrame: {
                topLeft: 'body',
                topRight: 'body',
                bottomLeft: 'body'
            },
            eyeball: {
                topLeft: 'body',
                topRight: 'body',
                bottomLeft: 'body'
            }
        }
    };

    // Generar SVG QR y agregar al contenedor del slide
    const svgString = window.qrcode.generateSVGString(config);
    document.querySelectorAll('.svg-slide-container')[index].innerHTML = svgString;

   // Reemplazar contenido del contenedor
    document.querySelectorAll('.svg-slide-container')[index].innerHTML = svgString;

    //Eliminar cualquier otro ID 'idsvg'
    document.querySelectorAll('svg').forEach(svg => {
    svg.removeAttribute('id');
    });

    // Asignar el ID solo al SVG actual
    const currentSvg = document.querySelectorAll('.svg-slide-container')[index].querySelector('svg');
    currentSvg.setAttribute('id', 'idsvg');

    // Actualizar link de reproduccion
    //document.getElementById('reproducir-recurso').href = valueURL;
}

// Descargar SVG como PNG
document.getElementById('descargapng').addEventListener('click', () => {
    let svg = document.getElementById('idsvg');
    let svgXml = (new XMLSerializer()).serializeToString(svg);
    let canvas = document.createElement('canvas');
    let context = canvas.getContext('2d');
    canvas.width = svg.clientWidth;
    canvas.height = svg.clientHeight;

    canvg(canvas, svgXml, {
        ignoreMouse: true,
        ignoreAnimation: true,
        ignoreDimensions: true,
        renderCallback: function () {
            let pngDataUrl = canvas.toDataURL('image/png');
            let link = document.createElement('a');
            link.download = 'marker.png';
            link.href = pngDataUrl;
            link.click();
        }
    });
});

// Mostrar primer recurso al cargar
actualizarRecurso(0);
", View::POS_READY);



$this->registerCss("
.swiper-button-next,
.swiper-button-prev {
    color: #000;  /* o el color que quieras */
    width: 40px;
    height: 40px;
    background-color: rgba(18, 243, 232, 0.7);
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px;
}
");




?>