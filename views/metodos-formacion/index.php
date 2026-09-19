<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MetodosFormacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Metodos de Formación de Grupos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodos-formacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar Método', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
