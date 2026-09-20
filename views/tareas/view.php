<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Tareas */

$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);

$this->title = 'Actividad Correspondiente a ' . app\models\Asignaturas::findOne(['id' => $model->asignaturas_id])->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-view">

    <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>
    <p>En esta sección, podrás visualizar todos los detalles relacionados con la actividad seleccionada. Aquí se incluye
        la información clave, como la consigna, el tipo de tarea, el año y si la actividad permite el uso de
        herramientas adicionales como reportes de estado de ánimo o conflictos. También encontrarás el puntaje asignado
        a la tarea, lo que te ayudará a planificar mejor tu participación y trabajo.

        Además, se muestra una lista de los grupos asociados a esta actividad, donde podrás clasificar individualmente a
        los miembros o gestionar las actividades grupales. </p>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar esta tarea?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'nombre_t',
                'label' => 'Actividad',
            ],
            'consigna',
            'descripcion',
            'year',
            [
                'attribute' => 'usar_sentencias_apertura',
                'label' => 'Usa Sentencias de Apertura',
                'value' => function ($data) {
                    return ($data->usar_sentencias_apertura) ? 'Sí' : 'No';
                },
            ],
            [
                'attribute' => 'reportar_estado_animo',
                'label' => 'Permite Reportar Estado de Ánimo',
                'value' => function ($data) {
                    return ($data->reportar_estado_animo) ? 'Sí' : 'No';
                },
            ],
            [
                'attribute' => 'reportar_conflicto',
                'label' => 'Permite Reportar Conflictos',
                'value' => function ($data) {
                    return ($data->reportar_conflicto) ? 'Sí' : 'No';
                },
            ],
            [
                'attribute' => 'actividad_gamificada',
                'label' => 'Permite Actividad Gamificacada 🏆',
                'value' => function ($data) {
                    return ($data->actividad_gamificada) ? 'Sí' : 'No';
                },
            ],
            'puntaje_tarea',
            'tipo_tarea',
        ],
    ]) ?>

    <?php
    $chatsxGrupo = app\models\Chats::getChatsGrupos($model->id);
    $grupos = app\models\GruposFormados::getDetalleGrupos($model->grupos_id);
    // R2: se obtienen las notificaciones sin leer del usuario actual (docente)
    // agrupadas por grupo para esta actividad. El método devuelve un arreglo
    // del tipo [grupos_formados_id => cantidad], consultando la tabla notificaciones
    // (tipo 'mensaje', estado sin leer, con grupo cargado y de esta actividad).
    $noLeidasPorGrupo = \app\models\Notificaciones::contarNoLeidasPorGrupo($usuario, $model->id);
    ?>

    <h2 class="perfil-title">Chats asociados a los grupos <span>.</span></h2>
    <p>En cada asignatura, existe la posibilidad de crear configuraciones de grupo con un código específico. Estas
        configuraciones permiten crear varios grupos bajo una misma asignatura, lo cual se gestiona desde el menú
        "Manejar Grupos" dentro de la sección de la asignatura.

        Posteriormente, cuando se crea una actividad, se asigna a uno de esos códigos de configuración de grupo. Esta
        acción genera automáticamente un chat para cada grupo asociado a esa configuración. En esta sección, podrás
        visualizar los chats correspondientes a los grupos para cada actividad, interactuar con los integrantes y
        gestionar el progreso y participación dentro del grupo.</p>

    <?php if ($model->actividad_gamificada): ?>
            <h2 class="perfil-title">Que elementos tengo en una actividad gamificada<span>?</span></h2>
        <div class="info-evento">
            <p><strong>Evento:</strong> Son interacciones especiales que ocurren dentro de las <span
                    style="color:#FD8916; font-weight: bold;">actividades</span> y que fomentan la participación inmediata y activa. Los eventos
                incluyen cuestionarios en tiempo real, juegos o debates, donde los estudiantes responden preguntas o
                interactúan directamente. Estos eventos suelen tener un carácter más dinámico y permiten que los estudiantes
                obtengan puntos adicionales para mejorar su posición en la tabla de clasificación (leaderboard). <strong>eventos
                están diseñados para hacer el aprendizaje más interactivo y entretenido</strong> </p>
            <p>Existen diferentes tipos de eventos:</p>
            <ul>
                <li><span style="color:#FD8916; font-weight: bold;">Preguntas</span>: Permiten a los alumnos responder a ciertas inquietudes y a los profesores puntuar sus respuestas. No se califican en sentido tradicional, sino que se asignan puntos como recompensa a la participación y calidad de la respuesta.</li>
                <li><span style="color:#FD8916; font-weight: bold;">Debates</span>: Los alumnos pueden debatir sobre temas relacionados con la actividad. Expresar una opinión en estos eventos brinda un total de +150 puntos, incentivando la argumentación y el intercambio de ideas.</li>
                <li><span style="color:#FD8916; font-weight: bold;">Actividades externas</span>: Son actividades que se realizan fuera de la plataforma, como un juego en Kahoot, un cuestionario en Google o un video de YouTube. Generalmente no otorgan puntos en la plataforma, pero sirven para complementar el aprendizaje y se puede registrar la participación.</li>
               <!-- <li><span style="color:#FD8916; font-weight: bold;">Juego de Verdadero o Falso</span>: Consiste en una dinámica rápida y sencilla donde los alumnos deben responder si una afirmación propuesta por el profesor es verdadera o falsa. Si la respuesta es correcta, el sistema asigna puntos automáticamente, incentivando la atención, la participación activa y el aprendizaje lúdico. Este evento otorga +250 puntos.</li> -->

            </ul>
                <p><strong>Puntuación:</strong> Reflejan la participación y el avance en las actividades gamificadas. La nota que se asigne, ya sea al alumno o al grupo, se multiplicará por el puntaje establecido al momento de crear la actividad.</p> 
            <p style="padding-bottom: 10px;"><strong>Leaderboard<span style="color:#FD8916;"> (Tabla de posiciones)</span></strong> Es una herramienta visual y motivacional que muestra la posición de cada alumno en función de los puntos obtenidos por su participación y desempeño en las diferentes actividades de la plataforma. Para los alumnos, representa un incentivo para involucrarse activamente y superarse a sí mismos y a sus compañeros, promoviendo un entorno de sana competencia. Para el profesor, el leaderboard se convierte en un recurso de seguimiento fundamental, ya que permite identificar fácilmente el grado de participación, compromiso y constancia de cada estudiante, facilitando la toma de decisiones pedagógicas, el reconocimiento de logros y la detección temprana de quienes requieren mayor acompañamiento o motivación.</p>
        </div>



        <?= Html::button('Crear Evento interactivo dentro de chat 🎮', [
            'class' => 'button-g2',
            'style' => 'border:none; background:#FD8916;',
            'id' => 'open-modal-btn',
            'data-toggle' => 'modal',
            'data-target' => '#createEventModal'
        ]) ?>

        <?= Html::a('Tabla de puntuación de actividad gamificada 🎯', ['/leaderboard/index', 'tarea_id' => $model->id], [
            'class' => 'button-g2',
        ]) ?>

    <?php endif; ?>


    <div class="grupos-container">
        <?php foreach ($chatsxGrupo as $alumno): ?>
            <?php
            $usuario = Yii::$app->user->identity->id;
            $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
            $varID = Yii::$app->security->encryptByPassword($alumno["grupos_formados_id"], $oUser->password);
            $tareas_id = $model->id;

            // Cantidad de interacciones nuevas sin leer del grupo actual. Si el grupo
            // no tiene notificaciones pendientes (no está en el arreglo) la cantidad
            // queda en 0 y no se muestra el badge.
            $cantidadNoLeidas = isset($noLeidasPorGrupo[$alumno['grupos_formados_id']]) ? $noLeidasPorGrupo[$alumno['grupos_formados_id']] : 0;

            // Filtrar los alumnos de acuerdo al grupo actual
            $integrantesDelGrupo = array_filter($grupos, function ($gr) use ($alumno) {
                return $gr['id'] == $alumno['grupos_formados_id'];
            });
            ?>

            <div class="grupo-card">
                <h3 class="grupo-title">Grupo <?= Html::encode($alumno["grupos_formados_id"]) ?>
                    <?php // Si el grupo tiene interacciones nuevas sin leer se muestra
                    // un badge naranja con la cantidad junto al título del grupo (R2). ?>
                    <?php if ($cantidadNoLeidas > 0): ?>
                        <span class="badge badge-grupo" title="Nuevas interacciones sin leer"><?= $cantidadNoLeidas ?> nuevas</span>
                    <?php endif; ?>
                </h3>
                <div class="grupo-content">
                    <ul>
                        <?php foreach ($integrantesDelGrupo as $gr): ?>
                            <li><?= Html::encode($gr['nombreAlumno']) . ' ' . $gr['apellidoAlumno'] . ' (ID: ' . Html::encode($gr['alumnoId']) . ')' . ' ' . Html::a('Calificar individual', ['tareas-alumno/asignar-nota', 'tareas_id' => $tareas_id, 'alumno_id' => $gr['alumnoId']])  ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="grupo-actions">
                        <?= Html::a('ver chat', ['chats/grupo', 'chatid' => Yii::$app->security->encryptByPassword($alumno["id"], $oUser->password)], ['class' => 'btn btn-info']) ?>
                        <?= Html::a('Calificar Grupo', ['grupos-formados/clasificar', 'id' => $varID, 'tareas_id' => $tareas_id], ['class' => 'btn btn-info']) ?>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- Modal para Crear Evento -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Crear Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'create-event-form',
                    'action' => ['tareas/create-evento', 'asigid' => $model->asignaturas_id],
                    'options' => ['enctype' => 'multipart/form-data'],
                ]); ?>

                <?= $form->field($modelEvento, 'tipo_evento')->dropDownList([
                    'pregunta' => 'Pregunta (Respuesta Abierta)',
                    // 'juego' => 'Juego (Verdadero/Falso)',
                    'actividad' => 'Actividad Externa (Kahoot, Google Forms, etc.)',
                    'debate' => 'Debate (Opinión)',
                ], ['prompt' => 'Selecciona el tipo de evento', 'id' => 'tipoEvento'])->label('Tipo de Evento') ?>

                <?= $form->field($modelEvento, 'id_tarea')->dropDownList(
                    ArrayHelper::map([$model], 'id', 'nombre_t'),
                    ['prompt' => 'Seleccionar la actividad en la que quiere crear el evento']
                )->label('Actividad Relacionada') ?>

                <!-- Bloque para JUEGO Verdadero/Falso -->
                <div id="juegoVFfields" style="display: none;">
                    <?= $form->field($modelEvento, 'titulo')->textInput(['maxlength' => true])->label('Sentencia') ?>
                    <?= $form->field($modelEvento, 'descripcion')->dropDownList([
                        'verdadero' => 'Verdadero',
                        'falso' => 'Falso',
                    ], ['prompt' => 'Seleccionar'])->label('Esta sentencia es') ?>
                    <?= $form->field($modelEvento, 'descripcion_pregunta')->textarea(['rows' => 2])->label('Explicación (opcional, en el caso de que elija la incorrecta).') ?>
                </div>

                <!-- Bloque para Actividad o Debate o Juego externo -->
                <div id="kahootOtroFields" style="display: none;">
                    <?= $form->field($modelEvento, 'titulo')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelEvento, 'descripcion')->textarea(['rows' => 3]) ?>
                    <?= $form->field($modelEvento, 'link')->textInput(['maxlength' => true]) ?>
                    <!-- <?= $form->field($modelEvento, 'imagen')->fileInput() ?> -->
                </div>

                <!-- Bloque para Pregunta -->
                <div id="cuestionarioFields" style="display: none;">
                    <?= $form->field($modelEvento, 'pregunta')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelEvento, 'descripcion_pregunta')->textarea(['rows' => 3]) ?>
                    <!-- <?= $form->field($modelEvento, 'imagen')->fileInput() ?> -->
                </div>

                <?php ActiveForm::end(); ?>
                <p><strong> Nota: Una vez guardado el evento ingrese al chat para verlo activo. 💬</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="save-event-btn">Guardar Evento</button>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function toggleFields(tipoEvento) {
    // Deshabilita todos los inputs de todos los bloques
    $('#juegoVFfields :input').prop('disabled', true);
    $('#kahootOtroFields :input').prop('disabled', true);
    $('#cuestionarioFields :input').prop('disabled', true);

    // Oculta todos los bloques
    $('#juegoVFfields').hide();
    $('#kahootOtroFields').hide();
    $('#cuestionarioFields').hide();

    // Muestra y habilita solo el bloque seleccionado
    if (tipoEvento === 'juego') {
        $('#juegoVFfields').show();
        $('#juegoVFfields :input').prop('disabled', false);
    } else if (tipoEvento === 'pregunta') {
        $('#cuestionarioFields').show();
        $('#cuestionarioFields :input').prop('disabled', false);
    } else if (tipoEvento === 'debate' || tipoEvento === 'actividad') {
        $('#kahootOtroFields').show();
        $('#kahootOtroFields :input').prop('disabled', false);
    }
}

$('#tipoEvento').on('change', function() {
    toggleFields($(this).val());
});

$(document).ready(function() {
    // Al cargar la página, activa los campos correctos
    toggleFields($('#tipoEvento').val());
});

$('#save-event-btn').on('click', function() {
    var form = $('#create-event-form');
    var formData = new FormData(form[0]);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#createEventModal').modal('hide');
                location.reload();
            } else {
                var errorMsg = response.errors ? JSON.stringify(response.errors) : 'Error desconocido';
                alert('Error al guardar el evento: ' + errorMsg);
            }
        },
        error: function() {
            alert('Error al guardar el evento');
        }
    });
});
JS;

$this->registerJs($script);
?>

<style>
    .grupos-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .grupo-card {
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        padding: 20px;

        transition: transform 0.2s;
    }

    .grupo-card:hover {
        transform: translateY(-5px);
    }

    .grupo-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    /* estilo del badge de nuevas interacciones sin leer por grupo
       (fondo naranja #e67e22, texto blanco, borde redondeado) */
    .badge-grupo {
        background-color: #e67e22;
        color: #fff;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .grupo-content ul {
        list-style-type: none;
        padding-left: 0;
    }

    .grupo-content ul li {
        margin-bottom: 5px;
    }

    .grupo-actions {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-info {
        background-color: #3498db;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #2980b9;
    }
</style>