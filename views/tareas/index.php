<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Tareas;
use yii\widgets\ActiveForm;

$this->title = 'Actividades de ' . app\models\Asignaturas::findOne(['id' => $asigid])->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['asignaturas/index', 'asigid' => $asigid]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tareas-index">

    <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>
    <p>En esta sección, podrás crear y gestionar actividades y eventos para tus asignaturas. Cada actividad puede ser utilizada para promover la participación en clase, fomentar la colaboración en grupo y reforzar los conceptos clave de la materia. </p>
    <p><strong>Actividad:</strong> Las actividades son tareas o trabajos asignados a los estudiantes con el fin de reforzar el aprendizaje y evaluar su comprensión. Estas pueden incluir trabajos prácticos, ejercicios de investigación o discusiones en clase.</p>


    <!-- <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?> -->


    <div class="btns-tareas-index">
 
   <!--<?= Html::a('Crear Actividad', ['create', 'asigid' => $asigid, 'tipoactividad' => 'grupal'], ['class' => 'button-g2']) ?>-->

  <?= Html::a('Crear Actividad', ['elegir-actividad', 'asigid' => $asigid], ['class' => 'button-g2']) ?> 

    </div>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'nombre_t',
                'label' => 'Actividad',
            ],
            'consigna',
            'descripcion',
            'year',
            [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    // Verificamos si el modelo tiene tipo_tarea = 'realidadaumentada'
                    if ($model->tipo_tarea === 'realidadaumentada') {
                        return \yii\helpers\Url::to(['view-ra', 'id' => $model->id]);
                    } else {
                        return \yii\helpers\Url::to(['view', 'id' => $model->id]);
                    }
                }
                if ($action === 'update') {
                    if ($model->tipo_tarea === 'realidadaumentada') {
                        return \yii\helpers\Url::to(['update-ra', 'id' => $model->id]);
                    } else {
                        return \yii\helpers\Url::to(['update', 'id' => $model->id]);
                    }
                }

                // Para delete siguen siendo normales
                return \yii\helpers\Url::to([$action, 'id' => $model->id]);
            },
            ],
        ],
    ]); ?>
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
                    'action' => ['tareas/create-evento', 'asigid' => $asigid],
                    'options' => ['enctype' => 'multipart/form-data'],
                ]); ?>

                <?= $form->field($modelEvento, 'tipo_evento')->dropDownList([
                    'Pregunta' => 'pregunta',
                    'Juego' => 'juego',
                    'Actividad' => 'actividad',
                    'Debate' => 'debate',
                ], ['prompt' => 'Selecciona el tipo de evento', 'id' => 'tipoEvento'])->label('Tipo de Evento') ?>

                <?= $form->field($modelEvento, 'id_tarea')->dropDownList(
                    ArrayHelper::map($tareas, 'id', 'nombre_t'),
                    ['prompt' => 'Seleccionar actividad relacionada']
                )->label('Actividad Relacionada') ?>

                <div id="kahootOtroFields" style="display: none;">
                    <?= $form->field($modelEvento, 'titulo')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelEvento, 'descripcion')->textarea(['rows' => 3]) ?>
                    <?= $form->field($modelEvento, 'link')->textInput(['maxlength' => true]) ?>
                    <!-- <?= $form->field($modelEvento, 'imagen')->fileInput() ?> -->
                </div>

                <div id="cuestionarioFields" style="display: none;">
                    <?= $form->field($modelEvento, 'pregunta')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelEvento, 'descripcion_pregunta')->textarea(['rows' => 3]) ?>
                    <!-- <?= $form->field($modelEvento, 'imagen')->fileInput() ?> -->
                </div>

                <?php ActiveForm::end(); ?>
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
$('#tipoEvento').on('change', function() {
    var tipoEvento = $(this).val();
    if (tipoEvento === 'Juego' || tipoEvento === 'Actividad' || tipoEvento === 'Debate') {
        $('#kahootOtroFields').show();
        $('#cuestionarioFields').hide();
    } else if (tipoEvento === 'Pregunta') {
        $('#cuestionarioFields').show();
        $('#kahootOtroFields').hide();
    } else {
        $('#kahootOtroFields, #cuestionarioFields').hide();
    }
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
