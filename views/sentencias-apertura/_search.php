<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SentenciasAperturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sentencias-apertura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sentencia') ?>

    <?= $form->field($model, 'atributo') ?>

    <?= $form->field($model, 'habilidad') ?>

    <?= $form->field($model, 'subhabilidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
