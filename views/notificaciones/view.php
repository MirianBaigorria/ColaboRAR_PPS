<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Notificaciones;

/* @var $this yii\web\View */
/* @var $model app\models\Notificaciones */

$this->title = Html::encode($model->titulo);
$this->params['breadcrumbs'][] = ['label' => 'Mis Notificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notificaciones-view">

    <h1><?= Html::encode($model->titulo) ?></h1>

    <p>
        <?= Html::a('Abrir', ['ver', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'titulo',
            [
                'attribute' => 'tipo',
                'value' => Notificaciones::getEtiquetaTipo($model->tipo),
            ],
            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
            ],
            'creado_en',
            [
                'attribute' => 'leido',
                'value' => $model->leido ? 'Sí' : 'No',
            ],
            [
                'label' => 'Actividad',
                'value' => $model->tareas ? Html::a(Html::encode($model->tareas->nombre_t), ['tareas/view', 'id' => $model->tareas_id]) : null,
                'format' => 'raw',
            ],
        ],
    ]) ?>
</div>