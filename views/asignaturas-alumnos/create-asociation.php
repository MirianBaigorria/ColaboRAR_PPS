<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasAlumnos */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);

$this->title = 'Asociación en Asignaturas';
//$this->params['breadcrumbs'][] = ['label' => 'Asociar Alumnos', 'url' => ['asignaturas-alumnos/index', 'asigid' => Yii::$app->security->encryptByPassword($asigid, $oUser->password)]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-alumnos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_alta', [
        'model' => $model,
    ]) ?>

</div>
