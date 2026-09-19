<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
?>

<?php $form = ActiveForm::begin([
    'id' => 'carga-form',
    'layout' => 'default',
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>


<!-- Solo habilitados: nombre y descripción -->
<?= $form->field($model, 'nomb')->textInput([
    'id' => 'nombre',
    'value' => $model->nombre,  // <-- fuerza el valor del input con $model->nombre
])->label('Nombre') ?>

<?= $form->field($model, 'desc')->textarea([
    'id' => 'descripcion',
    'value' => $model->descripcion,  // <-- fuerza el valor del textarea con $model->descripcion
])->label('Descripción') ?>


<!-- Botón de envío -->
<div class="form-group">
    <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
