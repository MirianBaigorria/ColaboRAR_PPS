<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SentenciasApertura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sentencias-apertura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sentencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atributo')->textInput() ?>

    <?= $form->field($model, 'habilidad')->textInput() ?>

    <?= $form->field($model, 'subhabilidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
