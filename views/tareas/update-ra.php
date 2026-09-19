<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Crear actividad con Realidad Aumentada';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


//JS y CSS de select2
$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://unpkg.com/sweetalert/dist/sweetalert.min.js', ['position' => View::POS_HEAD]);

?>

<h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h1>
<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'nombre_t')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'consigna')->textarea() ?>

    <?= $form->field($model, 'descripcion')->textarea() ?>

    <?= $form->field($model, 'year')->textInput(['value' => $asignaturaYear, 'readonly' => true]) ?>

    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Guardar', ['class' => 'button-g2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
