<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

if (!isset(Yii::$app->user->identity->id)) {
    $this->title = "Completa el siguiente formulario";
} else {    
    $tipoUsuario = ($tipo == 'a') ? 'Alumnos' : (($tipo == 'd') ? 'Docentes' : 'Administradores');
    $this->title = "Crear $tipoUsuario";
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index', 't' => $tipo]];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div style="margin:20px 0; padding: 30px; text-align: justify; background-color: #dfe4e5">
        
        <h3>Aviso de Privacidad</h3>
        <p>Los datos personales que proporcionen tanto docentes como estudiantes sólo serán usados con 
            fines académicos y de investigación, particularmente, para la generación de artículos científicos.</p>
        <p>Estos datos quedarán bajo la responsabilidad de los docentes integrantes del Proyecto de investigación 
            23/C226-A-2026 “Desarrollos tecnológicos para apoyar el aprendizaje y la enseñanza en grupos colaborativos” perteneciente al 
            Instituto de Investigación en Informática y Sistemas de Información (IIISI) de
            la Universidad Nacional de Santiago del Estero (Argentina).</p>
        <p>Si usted no desea que sus datos sean utilizados con los fines expuestos, por favor, envíe un correo electrónico a: 
            rosanna@unse.edu.ar (email perteneciente a la Directora del Proyecto mencionado). En caso contrario, se entenderá que otorga su consentimiento.</p>
        <p>Asimismo, se informa que no se realizarán transferencias a terceros de los datos recabados 
            y que nunca se expondrán nombres y apellidos de docentes y/o de estudiantes en las 
            publicaciones que se realicen a partir de los datos recabados.</p>
        
    </div>
    


    <?=
    $this->render('_form', [
        'model' => $model,
        'operacion' => 'alta',
    ])
    ?>

</div>
