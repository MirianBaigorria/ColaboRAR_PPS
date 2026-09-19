<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TareasAlumno */

$this->title = 'Create Tareas Alumno';
$this->params['breadcrumbs'][] = ['label' => 'Tareas Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
