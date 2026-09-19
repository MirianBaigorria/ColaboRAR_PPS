<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TareasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$asignatura = app\models\Asignaturas::findOne(['id' => $asigid])->nombre;
$this->title = "Actividades";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tareas-index">

    <h2 class="perfil-title"><?= Html::encode($asignatura) ?><span>.</span></h2>
    <h3><?= Html::encode($this->title) ?></h3>
    <p>En esta sección, podrás visualizar todas las actividades y tareas asociadas a la asignatura seleccionada. Puedes ingresar al chat de cada actividad para interactuar con los demás miembros de tu grupo. ¡Mantente al tanto de tus tareas y actividades colaborativas!</p>

    <div class="actividades-container">
        <?php foreach ($dataProvider->models as $actividad): ?>
        <div class="actividad-card">
            <h3 class="actividad-title"><?= Html::encode($actividad->nombre_t) ?></h3>
            <p><strong>Consigna:</strong> <?= Html::encode($actividad->consigna) ?></p>
            <p><strong>Año:</strong> <?= Html::encode($actividad->year) ?></p>
            
            <?php
            // Lógica para obtener el ID del chat de la actividad correspondiente al usuario actual
            $usuario = Yii::$app->user->identity->id;
            $oUser = \app\models\Usuarios::findOne(['id' => $usuario]);
            $chats = \app\models\Chats::find()->where(['tareas_id' => $actividad->id])->all();
            $idChat = 0;
            foreach ($chats as $ch) {                            
                $grupo = \app\models\GruposAlumnos::findOne(['grupos_formados_id' => $ch->grupos_formados_id, 'usuarios_id' => $usuario]);
                if ($grupo){
                    $idChat = $ch->id;
                } 
            }
            ?>
            
            <div class="actividad-actions">

            <?php if ($actividad->tipo_tarea === "realidadaumentada"): ?>
                <?= Html::a('Ingresar a Chat', ['chats/grupo-ra', 'chatid' => Yii::$app->security->encryptByPassword($idChat, $oUser->password)], ['class' => 'btn btn-info']) ?>
            <?php else: ?>
                <div class="actividad-actions">
                    <?= Html::a('Ingresar a Chat', ['chats/grupo', 'chatid' => Yii::$app->security->encryptByPassword($idChat, $oUser->password)], ['class' => 'btn btn-info']) ?>
                    <?php if ($actividad->actividad_gamificada == '1'): ?>
                        <?= Html::a('Ver Leaderboard', ['leaderboard/index', 'tarea_id' => $actividad->id], ['class' => 'btn btn-success']) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.actividades-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.actividad-card {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    padding: 20px;
    transition: transform 0.2s;
}

.actividad-card:hover {
    transform: translateY(-5px);
}

.actividad-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.actividad-actions {
    margin-top: 10px;
}

.btn {
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}

.btn-info {
    background-color: #3498db;
    color: #fff;
}

.btn-info:hover {
    background-color: #2980b9;
}
</style>
