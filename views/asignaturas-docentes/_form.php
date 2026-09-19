<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasDocentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignaturas-docentes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuarios_id')->dropDownList(app\models\Usuarios::getListaDocentes())->label('Docente'); ?>

    <?= $form->field($model, 'asignaturas_id')->dropDownList(app\models\Asignaturas::getListaAsignaturas())->label('Asignatura') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
