<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-form">

    <h2 class="perfil-title">Por favor, seleccione un grupo para el cual desea crear la actividad<span>.</span></h2>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'grupos_id')->dropDownList(app\models\Grupos::getListaGrupos($asigid), ['id' => 'grupos_id']) ?>
  
    <div class="form-group">
        <?= Html::submitButton('Siguiente', ['class' => 'button-g2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>