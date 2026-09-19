<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TareasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>
    
    <?= $form->field($model, 'nombre_t') ?>
    
    <?= $form->field($model, 'consigna') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'asignaturas_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
