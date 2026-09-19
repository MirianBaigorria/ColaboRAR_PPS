<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cuestionariosconflicto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cuestionariosconflictos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuestionariosconflicto-view">

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
            'nc1',
            'nc2',
            'nc3',
            'nc4',
            'nc5',
            'nc6',
            'nc7',
            'nc8',
            'cc1',
            'cc2',
            'cc3',
            'cc4',
            'cc5',
            'cc6',
            'cc7',
            'cc8',
            'cc9',
            'cc10',
            'cc11',
            'cc12',
            'cc13',
            'cc14',
            'cc15',
            'cc16',
            'cc17',
            'cc18',
            'cc19',
            'cc20',
            'sentencias_id',
        ],
    ]) ?>

</div>
