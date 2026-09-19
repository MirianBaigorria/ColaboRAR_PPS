<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'ColaborAR';
$completarEstiloAprendizaje = false;
$completarTestPersonalidad = false;

if (isset(Yii::$app->user->identity->id)) {
    $rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
} else {
    $rolesUsuario = [];
}

if (array_key_exists('estudiante', $rolesUsuario)) {
    // Se verifica si el usuario completo el test de estilos de aprendizaje
    $objEstudiante = \app\models\Usuarios::findOne(['id', Yii::$app->user->identity->id]);
    if (empty($objEstudiante->estiloaprendizaje)) {
        $completarEstiloAprendizaje = true;
    }
    if (empty($objEstudiante->personalidad)) {
        $completarTestPersonalidad = true;
    }
    
}
?> 
<!--Bloque cambiado-->
<div class="row">
            <div class="col-lg-12">
                <?php if ($completarEstiloAprendizaje || $completarTestPersonalidad){ 
                    if($completarEstiloAprendizaje==true && $completarTestPersonalidad==true){?>
                    <div style='margin: 0px auto 20px auto; width: 35%; text-align: center;padding: 10px; border:#FDD900 1px solid; background-color: #FF7124'>
                        <p style='color: #002432'>Recuerda completar los test de estilos de aprendizaje y personalidad para tener un perfil completo en el sistema.</p>
                        <?= Html::a('Completar ahora...', ['usuarios/test-felder-silverman'], ['class' => 'btn btn-primary', 'style' =>'background-color: #38928D']) ?>
                    </div> <?php }?>
                    <?php if($completarEstiloAprendizaje==true && $completarTestPersonalidad==false){?>
                        <div style='margin: 0px auto 20px auto; width: 35%; text-align: center;padding: 10px; border:#FDD900 1px solid; background-color: #FF7124'>
                        <p style='color: #002432'>Recuerda completar el test de estilos de aprendizaje para tener un perfil completo en el sistema.</p>
                        <?= Html::a('Completar ahora...', ['usuarios/test-felder-silverman'], ['class' => 'btn btn-primary', 'style' =>'background-color: #38928D']) ?>
                    </div> <?php }?>
                    <?php if($completarEstiloAprendizaje==false && $completarTestPersonalidad==true){?>
                        <div style='margin: 0px auto 20px auto; width: 35%; text-align: center;padding: 10px; border:#FDD900 1px solid; background-color: #FF7124'>
                        <p style='color: #002432'>Recuerda completar el test de personalidad para tener un perfil completo en el sistema.</p>
                        <?= Html::a('Completar ahora...', ['usuarios/test-big-five'], ['class' => 'btn btn-primary', 'style' =>'background-color: #38928D']) ?>
                    </div> <?php }?>

                <?php }?>
         </div>
  </div>
  <!--Fin de bloque cambiado-->
<div class="site-index">
    <div class="site-hero">
        <div class="hero-text">
            <h1>ColaborAR</h1>
            <h2>¡Bienvenidos a ColaborAR!</h2>
            <h2>Esta es una herramienta que permite la comunicación y el trabajo en equipo para dar soporte al 
            Aprendizaje Colaborativo Soportado por Computadora(ACSC).</h2>
            <br>
            
            <?php if (array_key_exists('estudiante', $rolesUsuario) || array_key_exists('profesor', $rolesUsuario) ): ?>
            <div class="hero-buttons">

            <!-- <?= Html::a('Ir a mis asignaturas', ['asignaturas/index'], ['class' => 'button-g2']) ?> -->
           
            </div>
        <?php else: ?>
            <div class="hero-create">
            <?= Html::a('Crea una cuenta', ['usuarios/create', 't' => 'a'], ['class' => 'button-g']) ?>
            </div>
       
        <?php endif; ?>
        </div>
        <div class="hero-img">
            <img src="<?= Yii::$app->request->baseUrl . "/images/perfil-collab.webp" ?>" class="img-hero" />
        </div>



    </div>

    <div class="site-aviso">
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

</div>