<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cuestionariosconflicto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuestionariosconflicto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nc1')->textInput() ?>

    <?= $form->field($model, 'nc2')->textInput() ?>

    <?= $form->field($model, 'nc3')->textInput() ?>

    <?= $form->field($model, 'nc4')->textInput() ?>

    <?= $form->field($model, 'nc5')->textInput() ?>

    <?= $form->field($model, 'nc6')->textInput() ?>

    <?= $form->field($model, 'nc7')->textInput() ?>

    <?= $form->field($model, 'nc8')->textInput() ?>

    <?= $form->field($model, 'cc1')->textInput() ?>

    <?= $form->field($model, 'cc2')->textInput() ?>

    <?= $form->field($model, 'cc3')->textInput() ?>

    <?= $form->field($model, 'cc4')->textInput() ?>

    <?= $form->field($model, 'cc5')->textInput() ?>

    <?= $form->field($model, 'cc6')->textInput() ?>

    <?= $form->field($model, 'cc7')->textInput() ?>

    <?= $form->field($model, 'cc8')->textInput() ?>

    <?= $form->field($model, 'cc9')->textInput() ?>

    <?= $form->field($model, 'cc10')->textInput() ?>

    <?= $form->field($model, 'cc11')->textInput() ?>

    <?= $form->field($model, 'cc12')->textInput() ?>

    <?= $form->field($model, 'cc13')->textInput() ?>

    <?= $form->field($model, 'cc14')->textInput() ?>

    <?= $form->field($model, 'cc15')->textInput() ?>

    <?= $form->field($model, 'cc16')->textInput() ?>

    <?= $form->field($model, 'cc17')->textInput() ?>

    <?= $form->field($model, 'cc18')->textInput() ?>

    <?= $form->field($model, 'cc19')->textInput() ?>

    <?= $form->field($model, 'cc20')->textInput() ?>

    <?= $form->field($model, 'sentencias_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
