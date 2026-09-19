<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CuestionariosconflictoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuestionariosconflictos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuestionariosconflicto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cuestionariosconflicto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nc1',
            'nc2',
            'nc3',
            'nc4',
            //'nc5',
            //'nc6',
            //'nc7',
            //'nc8',
            //'cc1',
            //'cc2',
            //'cc3',
            //'cc4',
            //'cc5',
            //'cc6',
            //'cc7',
            //'cc8',
            //'cc9',
            //'cc10',
            //'cc11',
            //'cc12',
            //'cc13',
            //'cc14',
            //'cc15',
            //'cc16',
            //'cc17',
            //'cc18',
            //'cc19',
            //'cc20',
            //'sentencias_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
