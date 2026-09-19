<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TareasAlumno */

$this->title = 'Update Tareas Alumno: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tareas Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tareas-alumno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
