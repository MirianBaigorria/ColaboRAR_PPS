<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TareasAlumnoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tareas Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-alumno-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tareas Alumno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tareas_id',
            'usuarios_id',
            'nota',
            'fecha_entrega',
            //'comentarios:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
