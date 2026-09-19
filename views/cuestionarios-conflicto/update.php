<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cuestionariosconflicto */

$this->title = 'Update Cuestionariosconflicto: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionariosconflictos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cuestionariosconflicto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
