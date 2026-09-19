<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */

$this->title = 'Update Grupos: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grupos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'operacion' => 'modificacion',
    ]) ?>

</div>
