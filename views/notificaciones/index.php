<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\LinkPager;
use app\models\Notificaciones;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Notificaciones';
$this->params['breadcrumbs'][] = $this->title;

$noLeidas = Notificaciones::contarNoLeidas(Yii::$app->user->id);

$models = $dataProvider->getModels();
$pagination = $dataProvider->getPagination();
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

    <?php if (empty($models)): ?>
        <p class="text-muted">No tenés notificaciones.</p>
    <?php endif; ?>

    <ul class="list-group">
        <?php foreach ($models as $model): ?>
            <li class="list-group-item <?= $model->leido ? '' : 'list-group-item-danger' ?>">
                <div>
                    <?= Html::a(
                        Html::encode($model->titulo),
                        ['ver', 'id' => $model->id],
                        ['style' => 'font-weight:' . ($model->leido ? 'normal' : 'bold') . ';']
                    ) ?>
                    <?php if ($model->descripcion): ?>
                        <div class="text-muted">
                            <?= Html::encode(StringHelper::truncate($model->descripcion, 120)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="clearfix">
                    <small class="text-muted"><?= Html::encode($model->creado_en) ?></small>
                    <span class="pull-right">
                        <span class="label label-info"><?= Html::encode(Notificaciones::getEtiquetaTipo($model->tipo)) ?></span>
                        <?php if (!$model->leido): ?>
                            <?= Html::a('Marcar leída', ['marcar-leida', 'id' => $model->id], [
                                'class' => 'btn btn-link btn-xs',
                                'data' => ['method' => 'post'],
                            ]) ?>
                        <?php endif; ?>
                    </span>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>