<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use app\models\Grupos;

// Cargamos los grupos disponibles para el dropdown de grupos.
$listaGrupos = Grupos::getListaGrupos();

$this->title = 'Crear Cuestionario Individual Evaluativo';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tareas-crear-cuestionario">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelTarea, 'nombre_t')->textInput(['maxlength' => true])->label('Nombre de la Tarea') ?>

    <?= $form->field($modelTarea, 'grupos_id')->dropDownList($listaGrupos, ['prompt' => 'Seleccionar grupo'])->label('Cod. Grupo') ?>

    <?= $form->field($modelTarea, 'descripcion')->textarea(['rows' => 3])->label('Descripción') ?>

    <div id="preguntas-container">
        <h3>Preguntas</h3>

        <!-- Aquí renderizamos cada pregunta -->
        <?php foreach ($preguntas as $index => $pregunta): ?>
            <div class="pregunta-item">
                <h4>Pregunta #<?= ($index + 1) ?></h4>
                <?= $form->field($pregunta, "[$index]pregunta")->textInput(['maxlength' => true])->label('Texto de la Pregunta') ?>
                
                <?= $form->field($pregunta, "[$index]es_multiple_choice")->checkbox(['class' => 'multiple-choice-toggle'])->label('¿Es Multiple Choice?') ?>

                <?= $form->field($pregunta, "[$index]archivo")->fileInput()->label('Subir archivo (opcional)') ?>

                <div class="multiple-choice-options" style="display: none;">
                    <h5>Opciones Multiple Choice</h5>

                    <?php foreach ($multipleChoice as $i => $opcion): ?>
                        <div class="multiple-choice-opcion">
                            <?= $form->field($opcion, "[$index][$i]opcion")->textInput(['maxlength' => true])->label('Opción') ?>
                            <?= $form->field($opcion, "[$index][$i]es_correcta")->checkbox()->label('¿Esta es la correcta?') ?>
                        </div>
                    <?php endforeach; ?>

                    <!-- Botón para añadir más opciones -->
                    <button type="button" class="btn btn-secondary add-opcion" data-pregunta="<?= $index ?>">Añadir opción</button>
                </div>
                <?php if ($index > 0): ?>
                    <!-- Botón para borrar pregunta -->
                    <button type="button" class="btn btn-danger borrar-pregunta" data-pregunta="<?= $index ?>">Borrar pregunta</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Botón para añadir más preguntas -->
    <div class="form-group">
        <?= Html::button('Añadir nueva pregunta', ['class' => 'btn btn-success', 'id' => 'add-pregunta']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar Cuestionario', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
   var preguntaIndex = $('#preguntas-container .pregunta-item').length;  // Inicializar con el número de preguntas ya existentes

// Función para mostrar/ocultar opciones multiple choice
function toggleMultipleChoice(container) {
    var multipleChoiceContainer = container.find('.multiple-choice-options');
    if (container.find('.multiple-choice-toggle').is(':checked')) {
        multipleChoiceContainer.show();
    } else {
        multipleChoiceContainer.hide();
    }
}

// Aplicar la funcionalidad a las preguntas ya existentes al cargar la página
$('.pregunta-item').each(function() {
    toggleMultipleChoice($(this));
});

// Funcionalidad para mostrar/ocultar las opciones multiple choice cuando se selecciona el checkbox
$(document).on('change', '.multiple-choice-toggle', function() {
    var container = $(this).closest('.pregunta-item');
    toggleMultipleChoice(container);
});

// Funcionalidad para añadir nuevas preguntas
$('#add-pregunta').on('click', function() {
    preguntaIndex++; // Incrementar el contador de preguntas

    // Crear nuevo HTML de pregunta
    var newPreguntaHtml = `
        <div class="pregunta-item" id="pregunta-\${preguntaIndex}">
            <h4>Pregunta #\${preguntaIndex}</h4>
            <div class="form-group">
                <label for="pregunta-\${preguntaIndex}">Texto de la Pregunta</label>
                <input type="text" id="pregunta-\${preguntaIndex}" class="form-control" name="Preguntas[\${preguntaIndex}][pregunta]" maxlength="255">
            </div>
            <div class="form-group">
                <input type="checkbox" id="multiple-choice-\${preguntaIndex}" name="Preguntas[\${preguntaIndex}][es_multiple_choice]" class="multiple-choice-toggle">
                <label for="multiple-choice-\${preguntaIndex}">¿Es Multiple Choice?</label>
            </div>
            <div class="multiple-choice-options" style="display:none;">
                <h5>Opciones Multiple Choice</h5>
                <div class="multiple-choice-opcion">
                    <label>Opción</label>
                    <input type="text" class="form-control" name="MultipleChoice[\${preguntaIndex}][0][opcion]" maxlength="255">
                    <label>¿Esta es la correcta?</label>
                    <input type="checkbox" name="MultipleChoice[\${preguntaIndex}][0][es_correcta]">
                </div>
                <button type="button" class="btn btn-secondary add-opcion" data-pregunta="\${preguntaIndex}">Añadir opción</button>
            </div>
            <!-- Botón para borrar pregunta -->
            <button type="button" class="btn btn-danger borrar-pregunta" data-pregunta="\${preguntaIndex}">Borrar pregunta</button>
        </div>
    `;

    $('#preguntas-container').append(newPreguntaHtml);
});

// Funcionalidad para borrar preguntas
$(document).on('click', '.borrar-pregunta', function() {
    var preguntaId = $(this).data('pregunta');
    $('#pregunta-' + preguntaId).remove();  // Eliminar la pregunta correspondiente
});

// Funcionalidad para añadir opciones adicionales de multiple choice
$(document).on('click', '.add-opcion', function() {
    var preguntaIndex = $(this).data('pregunta');
    var opcionIndex = $(this).closest('.multiple-choice-options').find('.multiple-choice-opcion').length;

    var newOpcionHtml = `
        <div class="multiple-choice-opcion">
            <label>Opción</label>
            <input type="text" class="form-control" name="MultipleChoice[\${preguntaIndex}][\${opcionIndex}][opcion]" maxlength="255">
            <label>¿Esta es la correcta?</label>
            <input type="checkbox" name="MultipleChoice[\${preguntaIndex}][\${opcionIndex}][es_correcta]">
        </div>
    `;

    $(this).before(newOpcionHtml);
});

JS;

$this->registerJs($script, \yii\web\View::POS_READY);
?>
