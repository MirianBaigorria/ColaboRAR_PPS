<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GruposFormados $model */
/** @var app\models\Tareas $tarea */
/** @var app\models\GrupoTareaCalificacion $calificacion */

$this->title = 'Calificar Grupo: ' . $model->id;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="grupos-formados-clasificar">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>Consigna:</strong> <?= Html::encode($tarea->consigna) ?></p>
    <p><strong>Descripción:</strong> <?= Html::encode($tarea->descripcion) ?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($calificacion, 'nota')->textInput(['type' => 'number', 'step' => '0.1']) ?>
    <?= $form->field($calificacion, 'descripcion_nota')->textarea(['rows' => 4]) ?>

    <?php if ($calificacion->estado_calificacion === 'C'): ?>
        <div class="alert alert-info">
            Esta tarea ya ha sido calificada. Si modificás la nota, no se volverá a otorgar puntaje.
        </div>
    <?php endif; ?>

    <?= Html::submitButton('Guardar Clasificación', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
