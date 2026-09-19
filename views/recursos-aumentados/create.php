<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecursosAumentados */

$this->title = 'Cargar Recursos Aumentados';
$this->params['breadcrumbs'][] = ['label' => 'Recursos Aumentados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recursos-aumentados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
