<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PreguntasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preguntas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preguntas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Preguntas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tareas_id',
            'pregunta:ntext',
            'es_multiple_choice',
            'archivo',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
