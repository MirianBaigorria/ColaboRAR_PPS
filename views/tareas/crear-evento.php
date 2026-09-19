<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tareas;

/* @var $this yii\web\View */
/* @var $model app\models\Evento */
/* @var $form yii\widgets\ActiveForm */
/* @var $asigid int */
?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Título del Evento') ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])->label('Descripción') ?>

    <!-- Select para seleccionar actividad -->
    <?= $form->field($model, 'tarea_id')->dropDownList(
        ArrayHelper::map(Tareas::find()->where(['asignaturas_id' => $asigid])->all(), 'id', 'nombre_t'),
        ['prompt' => 'Seleccionar actividad relacionada']
    )->label('Actividad Relacionada') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
