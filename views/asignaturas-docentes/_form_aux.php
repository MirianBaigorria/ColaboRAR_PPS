<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasDocentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignaturas-docentes-form">

    <?php $form = ActiveForm::begin(); ?>


    <!-- Mostrar el nombre de la asignatura en un campo solo lectura (solo para visualización) -->
    <?= Html::tag('div', $asignatura->nombre, ['class' => 'form-control', 'readonly' => true]); ?>

    <!-- Este campo oculto es el que guarda el id real de la asignatura -->
    <?= $form->field($model, 'asignaturas_id')->hiddenInput(['value' => $asignatura->id])->label(false); ?>
  
    <?php //var_dump($asignatura->id);  // Verifica si el valor de $asignatura->id es correcto ?>
    
    <?= $form->field($model, 'usuarios_id')->dropDownList(app\models\Usuarios::getListaDocentes())->label('Docente'); ?>

   

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
