<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GruposAlumnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-alumnos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuarios_id')->textInput() ?>

    <?= $form->field($model, 'grupos_formados_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
