<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_t')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consigna')->textarea() ?>

    <?= $form->field($model, 'descripcion')->textarea() ?>

    <?= $form->field($model, 'year')->textInput(['value' => $asignaturaYear, 'readonly' => true]) ?>

    <?= $form->field($model, 'usar_sentencias_apertura')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>


    <?= $form->field($model, 'reportar_estado_animo')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

    <?= $form->field($model, 'reportar_conflicto')->radioList(['1' => 'Sí', '0' => 'No'], ['value' => '0']) ?>

   

    <?= $form->field($model, 'grupos_id')->dropDownList(app\models\Grupos::getListaGrupos($asigid)) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'button-g2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

