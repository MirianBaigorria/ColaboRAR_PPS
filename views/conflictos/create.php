<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Conflictos */

$this->title = 'Create Conflictos';
$this->params['breadcrumbs'][] = ['label' => 'Conflictos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conflictos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
