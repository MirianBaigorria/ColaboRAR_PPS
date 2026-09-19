<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chats */

$this->title = 'Create Chats';
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
