<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SentenciasApertura */

$this->title = 'Crear Sentencia de Apertura';
$this->params['breadcrumbs'][] = ['label' => 'Sentencias Aperturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentencias-apertura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
