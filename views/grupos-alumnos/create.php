<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GruposAlumnos */

$this->title = 'Create Grupos Alumnos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-alumnos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
