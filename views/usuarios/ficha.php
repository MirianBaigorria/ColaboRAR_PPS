<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
$parametrot = array_key_exists('profesor', $rolesUsuario) ? 'a' :'u';

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index', 't' => $parametrot]];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'nombre',
            'apellido',
            //Agregado para mostrar el dni
            'dni',
            'institucion',
            [
                'attribute' => 'fechanacimiento',
                'label' => 'Fecha de Nacimiento',
                'value' => function($data) {
                    list($year, $mes, $dia) = explode("-", $data->fechanacimiento);
                    return substr($dia, 0, 2) . "/$mes/$year";
                },
            ],
            'estiloaprendizaje',
            'email', 
            [
                'attribute' => 'foto_perfil',  // El atributo del modelo que guarda la ruta de la imagen
                'format' => 'raw',  // Permite que se renderice HTML
                'value' => function($model) {
                    // Verifica si hay una imagen cargada
                    return $model->foto_perfil ? Html::img(Yii::getAlias('@web') . '/' . $model->foto_perfil, ['width' => '100px']) : 'No image';
                },
                'label' => 'Foto de Perfil',  // Etiqueta personalizada
            ],           
        ],
    ]) ?>

</div>
