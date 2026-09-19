<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Emociones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emociones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valencia')->textInput() ?>

    <?= $form->field($model, 'activacion')->textInput() ?>

    <?= $form->field($model, 'dominancia')->textInput() ?>

    <?= $form->field($model, 'chats_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
