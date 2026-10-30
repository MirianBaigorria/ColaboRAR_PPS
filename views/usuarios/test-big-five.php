<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Test de Personalidad';
/*$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="alumno-create">

    <?php if (!empty($model->personalidad)): ?>
        <?= $this->render('resultado-big-five', [
            'model' => $model,
        ]) ?>
    <?php else: ?>

        <h1><?= Html::encode($this->title) ?></h1>
        
        <p>Este cuestionario ha sido dise&ntilde;ado para identificar su personalidad acorde con las categor&iacute;as establecidas por el test Big Five. Si bien no hay l&iacute;mite de tiempo para contestar, no le ocupar&aacute; m&aacute;s de 15 minutos hacerlo. Tenga en cuenta que no hay respuestas correctas o err&oacute;neas, y que el resultado ser&aacute; &uacute;til en la medida en que Ud. sea sincero/a en sus respuestas.</p>

        <?= $this->render('_form_big_five', [
            'model' => $model,
        ]) ?>

    <?php endif; ?>

</div>