<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GruposFormados */

$this->title = 'Update Grupos Formados: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Formados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grupos-formados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
