<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RangosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rangos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rangos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rangos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'nivel',
            'descripcion',
            'imagen',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
