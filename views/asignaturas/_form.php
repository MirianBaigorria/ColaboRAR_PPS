<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignaturas-form">

    <?php $form = ActiveForm::begin(); ?>
    <p><span style="font-weight:600; color:#38928D;;">Nota:</span> Colocar siempre las iniciales de la <span style="font-weight:600; color:#FD8916;">Asignatura</span> en <span style="font-weight:600; color:#FD8916;">Mayusculas</span>.</p>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'year')->textInput() ?>
    <?= $form->field($model, 'carreras_id')->dropDownList([
        1 => 'Licenciatura en Sistemas de Información',
        2 => 'Ingeniería en Informática',
    ], ['prompt' => 'Seleccione una carrera']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
