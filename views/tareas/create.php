<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tareas */
/* @var $tipoactividad string */

$this->title = 'Crear actividad ' . $tipoactividad;
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-create">

    <h2 class="perfil-title"><?= Html::encode($this->title) ?><span>.</span></h2>

    <?php
    // Selecciona qué formulario renderizar
    $formulario = ($tipoactividad == 'gamificado') ? '_form_gamificado' : '_form';
    ?>

    <?= $this->render($formulario, [
        'model' => $model,
        'tipoactividad' => $tipoactividad,
        'asigid' => $asigid,
        'asignaturaYear' => $asignaturaYear,
    ]) ?>

</div>
