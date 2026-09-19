<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);

$this->title = 'Actualizar Tarea';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index', 'asigid' => Yii::$app->security->encryptByPassword($model->asignaturas_id, $oUser->password)]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tareas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'asignaturaYear'=>$asignaturaYear,
        'asigid'=>$asigid,
    ]) ?>

</div>
