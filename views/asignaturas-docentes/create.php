<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasDocentes */

$this->title = 'Alta de Docentes en Asignaturas';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-docentes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
