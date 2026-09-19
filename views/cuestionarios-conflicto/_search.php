<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CuestionariosconflictoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuestionariosconflicto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nc1') ?>

    <?= $form->field($model, 'nc2') ?>

    <?= $form->field($model, 'nc3') ?>

    <?= $form->field($model, 'nc4') ?>

    <?php // echo $form->field($model, 'nc5') ?>

    <?php // echo $form->field($model, 'nc6') ?>

    <?php // echo $form->field($model, 'nc7') ?>

    <?php // echo $form->field($model, 'nc8') ?>

    <?php // echo $form->field($model, 'cc1') ?>

    <?php // echo $form->field($model, 'cc2') ?>

    <?php // echo $form->field($model, 'cc3') ?>

    <?php // echo $form->field($model, 'cc4') ?>

    <?php // echo $form->field($model, 'cc5') ?>

    <?php // echo $form->field($model, 'cc6') ?>

    <?php // echo $form->field($model, 'cc7') ?>

    <?php // echo $form->field($model, 'cc8') ?>

    <?php // echo $form->field($model, 'cc9') ?>

    <?php // echo $form->field($model, 'cc10') ?>

    <?php // echo $form->field($model, 'cc11') ?>

    <?php // echo $form->field($model, 'cc12') ?>

    <?php // echo $form->field($model, 'cc13') ?>

    <?php // echo $form->field($model, 'cc14') ?>

    <?php // echo $form->field($model, 'cc15') ?>

    <?php // echo $form->field($model, 'cc16') ?>

    <?php // echo $form->field($model, 'cc17') ?>

    <?php // echo $form->field($model, 'cc18') ?>

    <?php // echo $form->field($model, 'cc19') ?>

    <?php // echo $form->field($model, 'cc20') ?>

    <?php // echo $form->field($model, 'sentencias_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
