<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rangos */

$this->title = 'Create Rangos';
$this->params['breadcrumbs'][] = ['label' => 'Rangos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rangos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
