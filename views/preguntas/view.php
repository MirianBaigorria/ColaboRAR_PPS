<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Preguntas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preguntas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'tareas_id',
            'pregunta:ntext',
            'es_multiple_choice',
            'archivo',
            'created_at',
        ],
    ]) ?>

</div>
