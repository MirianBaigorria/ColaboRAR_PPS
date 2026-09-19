<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MetodosFormacion */

$this->title = 'Crear Método de Formación de Grupo';
$this->params['breadcrumbs'][] = ['label' => 'Metodos Formacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodos-formacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
