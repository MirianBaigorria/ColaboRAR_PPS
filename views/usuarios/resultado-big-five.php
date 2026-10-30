<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Resultado - Test de Personalidad';
?>
<div class="alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ya has realizado el Test de Personalidad (Big Five). A continuación se muestra tu resultado:</p>

    <div class="panel panel-default" style="max-width: 600px;">
        <div class="panel-heading">
            <strong>Tu personalidad (Modelo Big Five)</strong>
        </div>
        <div class="panel-body">
            <?php if (!empty($model->personalidad)): ?>
                <pre style="background: #f9f9f9; border: 1px solid #eee; padding: 15px; font-size: 14px;"><?= Html::encode($model->personalidad) ?></pre>
                <p style="color: #666;">Resultado guardado en tu perfil</p>
            <?php else: ?>
                <p>No se encontró resultado registrado.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
