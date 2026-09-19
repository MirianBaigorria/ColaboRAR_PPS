<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecursosAumentadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recursos-aumentados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'tipoar') ?>

    <?= $form->field($model, 'marker') ?>

    <?php // echo $form->field($model, 'pattern') ?>

    <?php // echo $form->field($model, 'r_archivo1') ?>

    <?php // echo $form->field($model, 'r_archivo2') ?>

    <?php // echo $form->field($model, 'r_musica') ?>

    <?php // echo $form->field($model, 'id_asignatura') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
