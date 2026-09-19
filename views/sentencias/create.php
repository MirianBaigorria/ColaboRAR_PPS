<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sentencias */

$this->title = 'Create Sentencias';
$this->params['breadcrumbs'][] = ['label' => 'Sentencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentencias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
