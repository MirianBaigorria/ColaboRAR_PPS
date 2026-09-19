<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChatsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$miembrosChat = app\models\Chats::getMiembrosChat($grupo_id);
$usuarioid = Yii::$app->user->identity->id;
$esgamificado = $tarea->actividad_gamificada;
// URLs para hacer llamados AJAX
$recuperarChat = Yii::$app->urlManager->createUrl([
    'chats/recuperar-chat',
    'chatid' => $chatid,
    'esgamificado' => $esgamificado
]);
$recuperarEventosUrl = Yii::$app->urlManager->createUrl(['evento/recuperar-eventos', 'chatid' => $chatid]);


$recuperarUltimaSentenciaChat = Yii::$app->urlManager->createUrl([
    'chats/recuperar-ultima-sentencia-chat',
    'chatid' => $chatid,
    'esgamificado' => $esgamificado
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

$base = Yii::$app->request->baseUrl;

// Define las variables PHP primero
$username = Yii::$app->user->identity->username;
$puntos = Yii::$app->user->identity->puntaje;

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
        var eventosMostrados = new Set(); // Conjunto para almacenar los IDs de eventos mostrados
        var ultimoEventoId = null; // Almacena el último ID de evento cargado

        // Variables PHP en JavaScript
        var username = "$username"; // Asigna el nombre de usuario desde PHP
        var puntos = "$puntos"; // Asigna los puntos del usuario desde PHP

        // Función para procesar y agregar eventos únicos al chat
        function agregarEventosUnicos(eventosHtml) {
            $(eventosHtml).each(function(index, eventoHtml) {
                var eventoId = $(eventoHtml).data("evento-id");
                if (eventoId && !eventosMostrados.has(eventoId)) {
                    $('#evento-chat-up').append(eventoHtml); 
                    eventosMostrados.add(eventoId); 
                    ultimoEventoId = eventoId;
                    var objDiv = document.getElementById("evento-chat-up");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
        }

        // Cargar eventos iniciales y actualizar el último evento ID cargado
        function cargarEventosIniciales() {
            $.ajax({
                url: "$recuperarEventosUrl",
                method: "GET"
            }).done(function(data) {
                console.log("Eventos iniciales cargados:", data); 
                agregarEventosUnicos(data); 
                if ($(data).length > 0) {
                    ultimoEventoId = $(data).last().data("evento-id");
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar eventos iniciales:", textStatus, errorThrown);
            });
        }

        // Verificar si hay nuevos eventos comparando con el último evento cargado
        function verificarNuevosEventos() {
            $.ajax({
                url: "$recuperarEventosUrl",
                method: "GET"
            }).done(function(data) {
                var nuevoEventoId = $(data).last().data("evento-id");
                if (nuevoEventoId && nuevoEventoId !== ultimoEventoId) {
                    $('#nuevoEvento').show();
                    console.log("Nuevo evento detectado.");
                }
            });
        }
        
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
        cargarEventosIniciales();
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

        // Verificar nuevos eventos cada 10 segundos
        setInterval(verificarNuevosEventos, 10000);

        // Manejar el clic en el botón para cargar el nuevo evento
        $('#btnNuevoEvento').click(function() {
            $.ajax({
                url: "$recuperarEventosUrl",
                method: "GET"
            }).done(function(data) {
                agregarEventosUnicos(data); 
                $('#nuevoEvento').hide(); 
            });
        });

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
    <?php if ($tarea->actividad_gamificada): ?>
        <h1 style="padding-top:10px; padding-bottom:10px; font-weight:700;">¡Estás participando en una actividad gamificada!</h1>
        <p>
            💬 Participa activamente en el chat y comparte tus ideas para ayudar a tu equipo a llegar más lejos. Cada mensaje que envíes cuenta para completar la actividad, así que asegúrate de seguir la consigna y aportar contenido útil y relevante.<br><br>
            🤝 <strong>¡No dejes pasar los debates y preguntas!</strong> Son una excelente oportunidad para aprender, descubrir diferentes puntos de vista y saber qué piensan tus compañeros. Cuanto más participes, más vas a enriquecer tus conocimientos y tu experiencia en el grupo.<br><br>
            🚀 Recuerda: <strong>¡Cada mensaje suma puntos!</strong> Aporta, colabora y verás cómo tu puntaje sube en el <a href="<?= \yii\helpers\Url::to(['/leaderboard/index', 'tarea_id' => $tarea->id]) ?>" style="color:#FD8916;font-weight:600;text-decoration:none;">Leaderboard 🎯</a>. 🏆 Cuanto más participes, más oportunidades tendrás de desbloquear logros y ganar recompensas especiales.<br><br>
            🌟 <strong>CADA MENSAJE QUE ENVÍES SUMA +10 PUNTOS.</strong> ¡Tu participación hace la diferencia! <br><br>
            🧐 <strong>¿Queres ver como es tu progreso en las actividades gamificada?</strong> <a href="<?= \yii\helpers\Url::to(['/mis-logros-y-desafios/index']) ?>" style="color:#FD8916;font-weight:600;text-decoration:none;margin-left:10px;">
        👉 Ingresá aquí para ver tu avance y desafios para subir tu rango en collab 👈
    </a> 
        
        </p>
        <p>
            <span style="color:#EB6500;">Nota:</span> Las actividades externas dentro del chat no otorgan puntaje, pero son oportunidades extras para interactuar, aprender y divertirte.
        </p>
        <p>
            👀 Ten en cuenta que el profesor podrá ver tus respuestas y tu nivel de participación, ¡así que demuestra tu motivación y compromiso en cada mensaje!
        </p>
        <p style="font-size:13px;color:#888;margin-top:-7px; padding-bottom: 10px;">(Al recargar la página, puede que las preguntas o debates aparezcan arriba de la notificación del evento).</p>

        <div id="evento-chat-up"></div>

    <?php endif; ?>
    <h1>💬 CHAT <span style="color:#EB6500;">.</span></h1>
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
                        'url' => Yii::$app->urlManager->createUrl(['chats/grupo', 'chatid' => Yii::$app->security->encryptByPassword($chatid, $oUser->password)]),
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
    <!-- <?php if ($tarea->actividad_gamificada): ?> -->
    <!-- 
        <div class="perfil-leaderboard">
            <h2 class="perfil-title leader"><span>Leader</span>board<span>.</span></h2>
            <p>
                ¡La cima te espera! 💥 Escalar en el leaderboard no solo es un desafío, es una oportunidad para demostrar tu
                habilidad, dedicación y esfuerzo. Cada punto que sumas, cada desafío que completas, te acerca más a la cima
                y al reconocimiento de toda la comunidad. ¡Imagina ver tu nombre en los primeros lugares, destacando entre
                los mejores! 🚀

                No importa dónde estés ahora, lo importante es tu determinación para avanzar. ¡Sigue completando tareas,
                gana puntos, sube de rango y demuestra lo que puedes lograr! 💪 ¡El camino al éxito comienza ahora!

                ¿Listo para conquistar la cima? Revisa tu tabla de puntuacion de cada actividad.
            </p>
            <div style="margin-top: 15px;">
                <?= Html::a('Ver tabla de puntuacion 🎯', ['/leaderboard/index', 'tarea_id' => $tarea->id], [
                    'class' => 'button-g2',
                ]) ?>
            </div>


        </div> -->

    <!-- <div class="perfil-logros">
            <h2 class="perfil-title"><span>¿Como consigo</span> puntos? 🎯</h2>
            <p>¡Ganar puntos en la plataforma es muy sencillo y está en tus manos! 💪 A medida que participas y te
                involucras en las actividades, tus puntos irán creciendo. Aquí te mostramos cómo puedes acumular puntos y
                destacar en la tabla de posiciones:</br>
                <strong>1. Participación en el chat:</strong> Cada mensaje que envíes te otorga +10 puntos. ¡No dudes en interactuar y colaborar
                con tu equipo!</br>
                <strong>2. Completando desafíos:</strong> Cada desafío que completes te acercará a nuevos logros y te recompensará con
                puntos.</br>
                <strong>3. Actividades individuales y grupales:</strong> Realiza tanto tareas individuales como en equipo para ganar puntos por
                tu esfuerzo.</br>
                <strong>4. Notas en tareas:</strong> Las notas que obtengas en tus tareas se multiplicarán por 100 y se sumarán a tu puntaje
                total. ¡Así que da lo mejor de ti en cada trabajo!</br>
                <strong>5. Eventos especiales:</strong> Ya sea respondiendo preguntas, participando en actividades especiales o en juegos
                asignados, cada evento te recompensará con puntos adicionales.
                </br>
                </br>
                ¡Participa, suma puntos y escala hasta la cima! 🎉
            </p>
        </div> -->

    <!-- <?php endif; ?> -->


</div>






<!-- Modal para responder eventos -->
<!-- Modal minimalista -->
<div class="modal fade" id="modalResponderEvento" tabindex="-1" role="dialog" aria-labelledby="modalResponderEventoLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-minimal">
            <div class="modal-header">
                <div class="modal-header-flex">
                    <img id="modalIconoEvento" src="" alt="Evento Icono" class="modal-evento-icon">
                    <div>
                        <h4 class="modal-title" id="modalResponderEventoLabel">Responder Evento</h4>
                        <span id="modalTipoBadge" class="modal-tipo-badge">ID: --</span>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong id="modalEtiquetaPregunta">Pregunta / Título:</strong> <span id="modalPregunta"></span></p>
                <p><strong>Descripción:</strong> <span id="modalDescripcion"></span></p>
                <textarea id="modalRespuesta" class="form-control modal-textarea" rows="4" placeholder="✍️ Escribí tu respuesta..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-flat" data-dismiss="modal">❌ Cerrar</button>
                <button type="button" class="btn btn-dark btn-flat" id="btnEnviarRespuesta">🚀 Enviar</button>
            </div>
        </div>
    </div>
</div>

<!-- Fin del modal para responder eventos -->


<div class="modal fade" id="modalRespuestasEvento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respuestas del evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalRespuestasEventoBody">
                <p>Cargando respuestas...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<?php
// Variables necesarias para JS
$esProfesor = Yii::$app->user->can('profesor') ? 1 : 0;
$userId = Yii::$app->user->identity->id;
$chatId = $chatid;
$urlEnviarSentencia = $enviarSentencia;
$urlResponderVF = Yii::$app->urlManager->createUrl(['chats/responder-vf']);

$baseT = Yii::$app->request->baseUrl;
$this->registerJs("window.appBaseUrl = '$baseT';", yii\web\View::POS_HEAD);
$this->registerJs(<<<JS
// Abrir respuestas del evento (solo UNA VEZ este event handler)
$(document).on('click', '.btn-ver-respuestas-evento', function() {
    var eventoId = $(this).data('evento-id');
    $('#modalRespuestasEventoBody').html('<p>Cargando respuestas...</p>');
    $('#modalRespuestasEvento').modal('show');
    var esProfesor = $esProfesor == 1;
    $.ajax({
        url: 'index.php?r=chats/respuestas-evento',
        data: { evento_id: eventoId },
        success: function(resp) {
            if (resp.success) {
                if (resp.respuestas.length === 0) {
                    $('#modalRespuestasEventoBody').html('<p>No hay respuestas para este evento.</p>');
                } else {
                    var html = '<ul class="list-group">';
                    resp.respuestas.forEach(function(item) {
                        html += '<li class="list-group-item" style="margin-bottom:14px;">';
                        html += '<div style="display:flex;justify-content:space-between;align-items:center;">';
                        html += '<div>';
                        html += '<b>' + item.usuario + '</b>';
                        html += '<span style="font-size:12px;color:#888; margin-left:10px;">' + item.fecha + '</span>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="respuesta-contenido" style="margin:8px 0 10px 0;">' + item.respuesta + '</div>';
                        if (esProfesor && !item.ya_puntuado) {
                            html += '<div class="btn-group" role="group">';
                            html += '<button type="button" class="btn btn-warning btn-puntuar-evento" data-usuario-id="' + item.usuario_id + '" data-evento-id="' + eventoId + '" data-puntaje="150" style="font-weight:600; border-radius:7px; margin-right:8px;">⭐ Brindar +150</button>';
                            html += '<button type="button" class="btn btn-primary btn-puntuar-evento" data-usuario-id="' + item.usuario_id + '" data-evento-id="' + eventoId + '" data-puntaje="100" style="font-weight:600; border-radius:7px; margin-right:8px;">Otorgar 100</button>';
                            html += '<button type="button" class="btn btn-success btn-puntuar-evento" data-usuario-id="' + item.usuario_id + '" data-evento-id="' + eventoId + '" data-puntaje="50" style="font-weight:600; border-radius:7px;">Otorgar 50</button>';
                            html += '</div>';
                        } else if (item.ya_puntuado) {
                            html += '<span class="badge badge-success" style="float:right;">✅ Ya puntuado</span>';
                        }
                        html += '</li>';
                    });
                    html += '</ul>';
                    $('#modalRespuestasEventoBody').html(html);
                }
            } else {
                $('#modalRespuestasEventoBody').html('<p>Error al cargar respuestas.</p>');
            }
        },
        error: function() {
            $('#modalRespuestasEventoBody').html('<p>Error de conexión.</p>');
        }
    });
});

// Puntuar respuesta evento
$(document).on('click', '.btn-puntuar-evento', function() {
    var btn = $(this);
    var puntaje = btn.data('puntaje');
    var eventoId = btn.data('evento-id');
    var usuarioId = btn.data('usuario-id');
    var oldText = btn.text();
    btn.prop('disabled', true).text('Asignando...');
    $.ajax({
        url: 'index.php?r=chats/puntuar-evento',
        type: 'POST',
        data: {
            evento_id: eventoId,
            usuario_id: usuarioId,
            puntaje: puntaje,
            _csrf: yii.getCsrfToken()
        },
        success: function(resp) {
            if (resp.success) {
                btn.closest('li').find('.btn-group').remove();
                btn.closest('li').append('<span class="badge badge-success" style="float:right;">✅ Puntuado</span>');
            } else {
                alert(resp.message || 'Ya se puntuó a este usuario');
                btn.prop('disabled', false).text(oldText);
            }
        },
        error: function(){
            alert('Error de conexión.');
            btn.prop('disabled', false).text(oldText);
        }
    });
});
 // Esto te da "/chat/web"

// Modal responder evento (pregunta o debate)
$(document).on('click', '.btn-responder-evento', function() {
    var tipoEvento = $(this).data('tipo');
    var titulo = $(this).data('titulo');
    var descripcion = $(this).data('descripcion');
    var eventoId = $(this).data('id');
     var icono = window.appBaseUrl + '/images/eventos/evento-' + tipoEvento + '.png';


    $('#modalIconoEvento').attr('src', icono);
    $('#modalResponderEventoLabel').text(tipoEvento === 'debate' ? 'Opinar en Debate' : 'Responder Pregunta');
    $('#modalTipoBadge').text('ID: ' + eventoId);
    $('#modalPregunta').text(titulo);
    $('#modalDescripcion').text(descripcion);
    $('#modalResponderEvento').data('tipo-evento', tipoEvento);
    $('#modalRespuesta').val('');
    $('#modalResponderEvento').modal('show');
});

// Enviar respuesta del modal
$('#btnEnviarRespuesta').on('click', function() {
    var respuesta = $('#modalRespuesta').val().trim();
    var tipoEvento = $('#modalResponderEvento').data('tipo-evento');
    var eventoId = $('#modalTipoBadge').text().replace('ID: ', '').trim();
    if (respuesta.length === 0) {
        alert('Por favor, escribí tu respuesta.');
        return;
    }
    $.ajax({
        url: '$urlEnviarSentencia',
        method: 'POST',
        data: {
            usuarios_id: $userId,
            chats_id: $chatId,
            sentencia: respuesta,
            tipo_respuesta: tipoEvento,
            evento_id: eventoId
        },
        success: function() {
            $('#modalResponderEvento').modal('hide');
            $('#modalRespuesta').val('');
        },
        error: function(xhr) {
            alert('Error al enviar la respuesta. ' + (xhr.responseText || ''));
        }
    });
});

// Responder verdadero/falso
$(document).on('click', '.btn-responder-vf', function() {
    var btn = $(this);
    var card = btn.closest('.evento-card');
    var eventoId = btn.data('id');
    var valorElegido = btn.data('valor');
    var correcto = btn.data('correcto');
    var feedbackDiv = card.find('.feedback-vf');
    card.find('.btn-responder-vf').prop('disabled', true);
    if (card.data('respondido')) return;
    card.data('respondido', true);
    $.ajax({
        url: '$urlResponderVF',
        method: 'POST',
        dataType: 'json',
        data: {
            evento_id: eventoId,
            respuesta: valorElegido
        },
        success: function(resp) {
            if (resp.success === false && resp.msg) {
                feedbackDiv.html('<div class="alert alert-danger">Error: ' + resp.msg + '</div>');
            } else if (resp.ya_respondio) {
                feedbackDiv.html('<div class="alert alert-warning">Ya respondiste este juego.</div>');
            } else if (resp.correcta) {
                feedbackDiv.html('<div class="alert alert-success">¡Respuesta correcta! <b>+250 puntos</b> 🎉</div>');
            } else if (resp.correcta === false) {
                feedbackDiv.html('<div class="alert alert-danger">Respuesta incorrecta. Era <b>' + correcto.charAt(0).toUpperCase() + correcto.slice(1) + '</b>.</div>');
            } else {
                feedbackDiv.html('<div class="alert alert-warning">No se recibió respuesta válida del servidor.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText, status, error);
            feedbackDiv.html('<div class="alert alert-warning">Error al enviar respuesta. Detalles en consola. <br>' +
                             '<small>' + (xhr.responseText || error || status) + '</small></div>');
        }
    });
});
JS
);
?>

<?php
$this->registerCss(<<<CSS
.evento-box {
    background: linear-gradient(145deg, #fff3e0, #ffe0b2) !important;
    border-radius: 12px !important;
    padding: 15px 20px !important;
    margin: 20px 0 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1) !important;
    font-family: 'Segoe UI', sans-serif !important;
    max-width: 100% !important;
}

.evento-header {
    font-weight: 600 !important;
    font-size: 18px !important;
    color: #d35400 !important;
    margin-bottom: 10px !important;
}

.evento-body p {
    margin: 4px 0 !important;
    font-size: 14px !important;
}

.evento-tipo {
    background: #ffb74d !important;
    padding: 2px 8px !important;
    border-radius: 5px !important;
    color: white !important;
}

.btn-responder-vf {
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 8px;
    font-size: 16px;
    margin-right: 6px;
}
.feedback-vf .alert {
    margin-top: 8px;
    font-size: 15px;
    border-radius: 7px;
}

#modalRespuestasEventoBody .btn-group .btn {
    min-width: 120px;
    font-size: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all .18s;
}
#modalRespuestasEventoBody .btn-puntuar-evento:disabled {
    opacity: 0.7;
}
.respuesta-contenido {
    padding-left: 8px;
    font-size: 16px;
}

.modal-minimal {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px;
    border: none;
    font-family: 'Segoe UI', sans-serif;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}
.modal-header-flex {
    display: flex;
    align-items: center;
    gap: 15px;
}
.modal-evento-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: contain;
}
.modal-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}
.modal-tipo-badge {
    font-size: 13px;
    color: #fff;
    background: #111827;
    padding: 4px 10px;
    border-radius: 20px;
    margin-top: 5px;
    display: inline-block;
}
.modal-textarea {
    margin-top: 15px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 10px 15px;
    font-size: 15px;
    resize: none;
    box-shadow: none;
}
.modal-footer .btn-flat {
    border-radius: 8px;
    font-size: 14px;
    padding: 8px 18px;
    transition: all 0.3s ease;
}
.modal-footer .btn-light {
    background: #f3f4f6;
    border: 1px solid #d1d5db;
}
.modal-footer .btn-light:hover {
    background: #e5e7eb;
}
.modal-footer .btn-dark {
    background: #1f2937;
    color: #fff;
    border: none;
}
.modal-footer .btn-dark:hover {
    background: #111827;
}

.btn-like {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #F5F5F5;
    border: none;
    border-radius: 18px;
    color: #888;
    font-weight: 600;
    cursor: pointer;
    padding: 4px 16px;
    transition: background 0.2s, color 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}
.btn-like .fa-star {
    color: #d3c300;
    transition: color 0.2s;
}
.btn-like:hover:not(:disabled), .btn-like:focus-visible {
    background: #E6F7E6;
    color: #00a651;
}
.btn-like--active {
    background: #FFE066;
    color: #AD9000;
    cursor: not-allowed;
}
.btn-like--active .fa-star {
    color: #FFBF00;
}
.btn-like:disabled {
    opacity: 0.7;
}

.respuesta-card {
    background: #fff;
    border: 1.5px solid #eee;
    border-radius: 12px;
    margin: 18px 0 8px 0;
    padding: 16px 18px;
    box-shadow: 0 2px 8px rgba(230, 180, 120, 0.10);
    max-width: 85%;
}
.respuesta-card.respuesta-pregunta { border-left: 5px solid rgb(198, 187, 92); }
.respuesta-card.respuesta-debate   { border-left: 5px solid #29323c; /* o poné tu gradiente con pseudo-elemento */ }
.respuesta-header { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 7px; }
.respuesta-tipo   { font-weight: 600; color:rgb(255, 255, 255); }
.respuesta-pregunta .respuesta-tipo { color:rgb(255, 255, 255); }
.respuesta-fecha  { color: #fff; font-size: 12px; }
.respuesta-user   { display: flex; align-items: center; margin-bottom: 8px; }
.respuesta-user-avatar { margin-right: 7px; font-size: 20px; }
.respuesta-username { font-weight: 600; }
.respuesta-contenido { font-size: 16px; margin-bottom: 7px; }
.btn-puntuar {
    float: right;
    margin-top: -10px;
    margin-bottom:10px;
    border-radius: 10px;
    background:#EB6500;
    color: #fff;
    border: none;
    width: 300px;
    height: 50px;
    font-size: 14px;
    cursor: pointer;
    transition: background .2s;
}
.btn-puntuar:hover { background: #d35400; }
.respuesta-card.respuesta-actividad {
    background: #222 !important;
    border-left: 5px solid #00c6a7;
    color: #fff;
}
.respuesta-card.respuesta-actividad .respuesta-header,
.respuesta-card.respuesta-actividad .respuesta-tipo,
.respuesta-card.respuesta-actividad .respuesta-body {
    color: #fff !important;
}
CSS
);
?>
