<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GruposFormados */

$this->title = 'Create Grupos Formados';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Formados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-formados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
