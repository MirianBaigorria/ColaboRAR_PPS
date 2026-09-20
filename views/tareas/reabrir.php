<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */

$this->title = 'Reabrir actividad';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="perfil-title">Reabrir actividad: <?= Html::encode($model->nombre_t) ?><span>.</span></h2>

<div class="alert alert-info">
    La actividad ya venció. Para reabrirla debe indicar la nueva fecha de finalización.
</div>

<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_fin')->input('date', ['required' => true])->label('Nueva fecha de finalización') ?>

    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Reabrir actividad', ['class' => 'button-g2']) ?>
        <?= Html::a('Cancelar', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>