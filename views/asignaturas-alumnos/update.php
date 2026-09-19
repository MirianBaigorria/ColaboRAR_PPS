<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasAlumnos */

$this->title = 'Actualización de los datos del alumno asociado a ' . \app\models\Asignaturas::findOne(['id' => $model->asignaturas_id])->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Asociar Alumnos', 'url' => ['index', 'asigid' => $model->asignaturas_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="asignaturas-alumnos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
