<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Grupos */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);

$this->title = 'Creación de Grupos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index', 'asigid' => Yii::$app->security->encryptByPassword($asigid, $oUser->password)]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'operacion' => 'alta',
        'asigid' => $asigid,
        'asignaturaNombre'=>$asignaturaNombre,
        'asignaturaYear'=>$asignaturaYear,
        'cantidadGrupos'=>$cantidadGrupos,
    ]) ?>

</div>
