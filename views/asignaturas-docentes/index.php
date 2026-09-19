<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsignaturasDocentesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes por Asignatura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-docentes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar Docente a una Asignatura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'asignaturas_id',
                'label' => 'Asignatura',
                'value' => function($data) {
                    return app\models\Asignaturas::getNombrePorId($data->asignaturas_id);
                },
            ],
            [
                'attribute' => 'usuarios_id',
                'label' => 'Docente',
                'value' => function($data) {
                    return app\models\Usuarios::getNombrePorId($data->usuarios_id);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
