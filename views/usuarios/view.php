<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
$parametrot = array_key_exists('profesor', $rolesUsuario) ? 'a' : 'u';

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index', 't' => $parametrot]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que quiere eliminar este usuario?',
                'method' => 'post',
            ],
        ])
        ?>
        <?php
        $usuario = Yii::$app->user->identity->id;
        $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
        ?>
        <?= (array_key_exists('administrador', $rolesUsuario)) ? Html::a('Promover a Docente', ['promover-docente', 'id' => Yii::$app->security->encryptByPassword($model->id, $oUser->password)], ['class' => 'btn btn-success']) : '' ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'nombre',
            'apellido',
            'fechanacimiento',
            'tipo:boolean',
            'estiloaprendizaje',
            [
                'attribute' => 'personalidad',
                'label' => 'Personalidad',
                'format' => 'html',
                'value' => function($data) {
                    $personalidad = '';
                    if (isset($data->personalidad) && strlen($data->personalidad) > 0) {
                        list($extra, $agrea, $consc, $neuro, $openn) = explode(",", $data->personalidad);
                        $extra = explode(':', $extra);
                        $agrea = explode(':', $agrea);
                        $consc = explode(':', $consc);
                        $neuro = explode(':', $neuro);
                        $openn = explode(':', $openn);
                        $personalidad = "Extroversión: " . $extra[1] . "<br/>";
                        $personalidad .= "Afabilidad: " . $agrea[1] . "<br/>";
                        $personalidad .= "Excrupulosidad: " . $consc[1] . "<br/>";
                        $personalidad .= "Neuroticismo: " . $neuro[1] . "<br/>";
                        $personalidad .= "Apertura: " . $openn[1] . "<br/>";
                    }

                    return $personalidad;
                },
            ],
            'email',
        ],
    ])
    ?>

</div>
