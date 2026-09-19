<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentenciasAperturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sentencias de Apertura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentencias-apertura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Sentencia de Apertura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sentencia',
            'atributo',
            'habilidad',
            'subhabilidad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
