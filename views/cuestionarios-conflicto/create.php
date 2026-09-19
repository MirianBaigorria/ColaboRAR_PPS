<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cuestionariosconflicto */

$this->title = 'Create Cuestionariosconflicto';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionariosconflictos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuestionariosconflicto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
