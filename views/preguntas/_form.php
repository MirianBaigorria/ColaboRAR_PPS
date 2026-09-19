<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preguntas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preguntas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tareas_id')->textInput() ?>

    <?= $form->field($model, 'pregunta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'es_multiple_choice')->textInput() ?>

    <?= $form->field($model, 'archivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
