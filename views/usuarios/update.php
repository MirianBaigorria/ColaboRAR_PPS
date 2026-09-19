<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
$rolesUsuario = Yii::$app->authManager->getRolesByUser($usuario);
$parametrot = array_key_exists('profesor', $rolesUsuario) ? 'a' : 'u';

$this->title = 'Actualización de datos';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index', 't' => $parametrot]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'operacion' => 'edicion',
    ])
    ?>

</div>
