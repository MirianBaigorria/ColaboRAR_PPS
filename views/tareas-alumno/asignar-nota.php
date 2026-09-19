<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $tarea app\models\Tareas */
/* @var $alumno app\models\Usuarios */
/* @var $tareaAlumno app\models\TareasAlumnos */

$this->title = 'Asignar Nota: ' . $tarea->nombre_t;
?>

<div class="asignar-nota">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Tarea: <?= Html::encode($tarea->nombre_t) ?></p>
    <p>Alumno: <?= Html::encode($alumno->nombre . ' ' . $alumno->apellido) ?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($tareaAlumno, 'nota')->textInput(['type' => 'number']) ?>
    <?= $form->field($tareaAlumno, 'comentarios')->textarea(['rows' => 6]) ?>

    <?= Html::submitButton('Guardar Nota', ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
