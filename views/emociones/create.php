<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Emociones */

$this->title = 'Create Emociones';
$this->params['breadcrumbs'][] = ['label' => 'Emociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emociones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
