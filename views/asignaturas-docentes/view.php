<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasDocentes */

$this->title = 'Asociación de Docente en Asignatura';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-docentes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'asignaturas_id',
                'label' => 'Asignatura',
                'value' => function($data) {
                    return app\models\Asignaturas::getNombrePorId($data->asignaturas_id);
                },
            ],
            [
                'attribute' => 'usuarios_id',
                'label' => 'Docente',
                'value' => function($data) {
                    return app\models\Usuarios::getNombrePorId($data->usuarios_id);
                },
            ],
        ],
    ]) ?>

</div>
