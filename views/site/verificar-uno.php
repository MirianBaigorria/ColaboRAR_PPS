<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<div class="site-login">
    <h1>Recuperación de usuario y/o contrase&ntilde;a:</h1>

    <?php if (strlen($mensajeError) > 0): ?>
        <div style="background-color: #F5D1C9; padding: 20px; margin-bottom: 5px;">
            <?= $mensajeError ?>
        </div>
    <?php endif ?>

    <?php
    $form = ActiveForm::begin([
                'id' => 'verificar-uno-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ])
    ?>
    <?= $form->field($model, 'dni') ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

