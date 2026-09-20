<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Notificaciones;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Notificaciones';
$this->params['breadcrumbs'][] = $this->title;

$noLeidas = Notificaciones::contarNoLeidas(Yii::$app->user->id);
?>
<div class="notificaciones-index">

    <h1><?= Html::encode($this->title) ?>
        <?php if ($noLeidas > 0): ?>
            <small><span class="label label-warning"><?= $noLeidas ?> sin leer</span></small>
        <?php endif; ?>
    </h1>

    <p>
        <?php if ($noLeidas > 0): ?>
            <?= Html::beginForm(['marcar-todas-leidas'], 'post', ['style' => 'display:inline;']) ?>
                <?= Html::submitButton('Marcar todas como leídas', ['class' => 'btn btn-warning']) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            return $model->leido ? ['class' => 'success'] : ['style' => 'font-weight: bold;'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->titulo), ['ver', 'id' => $model->id]);
                },
            ],
            [
                'attribute' => 'tipo',
                'value' => function ($model) {
                    return Notificaciones::getEtiquetaTipo($model->tipo);
                },
                'filter' => Notificaciones::getEtiquetasTipo(),
            ],
            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
            ],
            'creado_en',
            [
                'attribute' => 'leido',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->leido
                        ? '<span class="label label-success">Leída</span>'
                        : '<span class="label label-warning">Nueva</span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver} {view} {marcar-leida}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-new-window"></span>', ['ver', 'id' => $model->id], [
                            'title' => 'Abrir',
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                            'title' => 'Ver',
                        ]);
                    },
                    'marcar-leida' => function ($url, $model) {
                        if ($model->leido) {
                            return '';
                        }
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['marcar-leida', 'id' => $model->id], [
                            'title' => 'Marcar como leída',
                            'data' => ['method' => 'post'],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>