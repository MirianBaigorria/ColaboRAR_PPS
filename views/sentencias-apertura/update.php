<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SentenciasApertura */

$this->title = 'Update Sentencias Apertura: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sentencias Aperturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sentencias-apertura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
