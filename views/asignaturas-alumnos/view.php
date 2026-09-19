<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasAlumnos */
$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
$this->title = 'Detalle de Alumno Asociado a ' . \app\models\Asignaturas::findOne(['id' => $asigid])->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Asociar Alumnos', 'url' => ['index', 'asigid' => Yii::$app->security->encryptByPassword($asigid, $oUser->password)]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-alumnos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea eliminar este alumno de la asignatura?',
                'method' => 'post',
            ],
        ])
        ?>
        <?= Html::a('Inscribir Otro Alumno', ['create', 'asigid' => Yii::$app->security->encryptByPassword($asigid, $oUser->password)], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'usuarios_id',
                'label' => 'Alumno',
                'value' => function($data) {
                    return app\models\Usuarios::getNombrePorId($data->usuarios_id);
                },
            ],
            'year',
        ],
    ])
    ?>

</div>
