<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Resultado - Test de Estilo de Aprendizaje';
?>
<div class="alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ya has realizado el Test de Estilos de Aprendizaje. A continuación se muestra tu resultado:</p>

    <div class="panel panel-default" style="max-width: 600px;">
        <div class="panel-heading">
            <strong>Tu estilo de aprendizaje (Modelo Felder-Silverman)</strong>
        </div>
        <div class="panel-body">
            <?php if (!empty($model->estiloaprendizaje)): ?>
                <h3 style="text-align: center; margin-top: 10px;"><?= Html::encode($model->estiloaprendizaje) ?></h3>
                <p style="text-align: center; color: #666;">Resultado guardado en tu perfil</p>
            <?php else: ?>
                <p>No se encontró resultado registrado.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
