<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Desafios */

$this->title = 'Create Desafios';
$this->params['breadcrumbs'][] = ['label' => 'Desafios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desafios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
