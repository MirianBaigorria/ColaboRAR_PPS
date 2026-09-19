<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasDocentes */

$this->title = 'Actualización de Docentes por Asignatura';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asignaturas-docentes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
