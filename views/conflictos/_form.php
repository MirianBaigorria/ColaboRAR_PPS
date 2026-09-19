<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Conflictos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conflictos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'chats_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
