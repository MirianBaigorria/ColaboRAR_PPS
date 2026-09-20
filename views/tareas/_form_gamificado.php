<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_t')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consigna')->textarea() ?>

    <?= $form->field($model, 'descripcion')->textarea() ?>

    <?= $form->field($model, 'year')->textInput(['value' => $asignaturaYear, 'readonly' => true]) ?>

    <?= $form->field($model, 'usar_sentencias_apertura')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>


    <?= $form->field($model, 'reportar_estado_animo')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

    <?= $form->field($model, 'reportar_conflicto')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

    <?= $form->field($model, 'actividad_gamificada')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '1']) ?>

    <?= $form->field($model, 'fecha_inicio')->input('date') ?>

    <?= $form->field($model, 'fecha_fin')->input('date') ?>

    <div id="puntaje-tarea-container">
        <?= $form->field($model, 'puntaje_tarea')->textInput(['type' => 'number']) ?>
        <p>
            <strong>Nota:</strong> Asigne un puntaje estimativo de acuerdo al grado de dificultad de la tarea.
            <span style="font-weight:600; color:#FD8916;">
                Se recomienda un valor entre 100 y 1000 puntos. </span>Este puntaje será utilizado posteriormente para otorgar una mayor cantidad de puntos a los alumnos como incentivo y motivación por su participación en la actividad gamificada.

        </p>
    </div>

    <?= $form->field($model, 'grupos_id')->dropDownList(app\models\Grupos::getListaGrupos($asigid)) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'button-g2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    // Lógica para mostrar/ocultar el campo puntaje_tarea según la selección de actividad_gamificada
    document.addEventListener('DOMContentLoaded', function() {
        const actividadGamificadaRadios = document.querySelectorAll('input[name="Tareas[actividad_gamificada]"]');
        const puntajeTareaContainer = document.getElementById('puntaje-tarea-container');

        function togglePuntajeTarea() {
            const selectedRadio = document.querySelector('input[name="Tareas[actividad_gamificada]"]:checked');
            if (selectedRadio && selectedRadio.value === '1') {
                puntajeTareaContainer.style.display = 'block';
            } else {
                puntajeTareaContainer.style.display = 'none';
            }
        }

        // Inicializar al cargar la página
        togglePuntajeTarea();

        // Escuchar cambios en los radios
        actividadGamificadaRadios.forEach(radio => {
            radio.addEventListener('change', togglePuntajeTarea);
        });
    });
</script>