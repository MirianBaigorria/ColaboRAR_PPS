<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GruposAlumnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-alumnos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Grupos Alumnos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuarios_id',
            'grupos_formados_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
