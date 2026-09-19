<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TareasAlumno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-alumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tareas_id')->textInput() ?>

    <?= $form->field($model, 'usuarios_id')->textInput() ?>

    <?= $form->field($model, 'nota')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_entrega')->textInput() ?>

    <?= $form->field($model, 'comentarios')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
