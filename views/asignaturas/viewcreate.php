<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que quiere eliminar esta asignatura?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'year',
        ],
    ]) ?>
            <div style='margin: 0px auto 20px auto; width: 35%; text-align: center;padding: 10px;'>
                <?= Html::a('Volver a Asignaturas', ['asignaturas/index'], ['class' => 'btn btn-primary', 'style' =>'background-color: #38928D']) ?>
            </div>
</div>
