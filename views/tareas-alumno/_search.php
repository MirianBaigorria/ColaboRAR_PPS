<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TareasAlumnoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-alumno-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tareas_id') ?>

    <?= $form->field($model, 'usuarios_id') ?>

    <?= $form->field($model, 'nota') ?>

    <?= $form->field($model, 'fecha_entrega') ?>

    <?php // echo $form->field($model, 'comentarios') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
