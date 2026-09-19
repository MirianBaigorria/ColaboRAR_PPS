<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'grupos_formados_id')->textInput() ?>

    <?= $form->field($model, 'tareas_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
