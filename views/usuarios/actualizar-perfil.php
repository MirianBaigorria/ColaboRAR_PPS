<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$completarEstiloAprendizaje = false;
$completarTestPersonalidad = false;

$usuario = Yii::$app->user->identity->id;
$oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
$rolesUsuario = Yii::$app->authManager->getRolesByUser($usuario);
$parametrot = array_key_exists('profesor', $rolesUsuario) ? 'a' : 'u';


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


$this->title = 'Actualización de datos';


?>
<div class="usuarios-update">

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
<h2 class="perfil-title">Actualizar datos de <span>Perfil.</span></h2>
<p style="font-size:16px;">Mantén tu perfil al día. Actualiza tu información, sube una nueva foto de perfil y muestra tu mejor versión📋✨</p>


    <?=
    $this->render('_form', [
        'model' => $model,
        'operacion' => 'edicion',
    ])
    ?>

</div>