<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $alumno app\models\Usuarios */
/* @var $gruposDisponibles app\models\GruposFormados[] */
/* @var $grupoActual app\models\GruposFormados */
/* @var $dynamicModel yii\base\DynamicModel */

$this->title = 'Cambiar de Grupo a Alumno: ' . $alumno->nombre . ' ' . $alumno->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $grupoActual->nombre, 'url' => ['view', 'id' => $grupoActual->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="cambiar-alumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($alumno, 'id') ?>

    <?= $form->field($alumno, 'nombre')->textInput(['readonly' => true]) ?>

    <?= $form->field($alumno, 'apellido')->textInput(['readonly' => true]) ?>

    <?= $form->field($dynamicModel, 'nuevo_grupo_formado_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($gruposDisponibles, 'id', 'nombre'),
        ['prompt' => 'Seleccione un nuevo grupo']
    )->label('Nuevo Grupo') ?>

    <div class="form-group">
        <?= Html::submitButton('Cambiar de Grupo', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
