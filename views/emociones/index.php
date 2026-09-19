<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmocionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emociones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emociones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Emociones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'valencia',
            'activacion',
            'dominancia',
            'chats_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
