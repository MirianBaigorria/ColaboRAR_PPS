<?php
use yii\helpers\Html;

$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
$esProfesor = array_key_exists('profesor', $rolesUsuario);

foreach ($respuestas as $resp):
    $color = $resp['tipo_evento'] === 'pregunta' ? '#FFF9E3' : '#E3F0FF'; // Amarillo pálido para pregunta, celeste para debate
    $icono = $resp['tipo_evento'] === 'pregunta' ? '/images/eventos/evento-pregunta.png' : '/images/eventos/evento-debate.png';
?>
<div class="respuesta-card" style="background:<?= $color ?>;">
    <div class="respuesta-header">
        <img src="<?= $icono ?>" class="evento-icon" alt="<?= $resp['tipo_evento'] ?>" />
        <div class="evento-titulos">
            <span class="evento-tipo"><?= ucfirst($resp['tipo_evento']) ?> en curso</span>
            <span class="evento-id">ID Evento: <?= $resp['evento_id'] ?></span>
        </div>
        <div class="usuario-nombre">
            <?= Html::img($resp['foto_perfil'] ?: '/images/default-user.png', ['class'=>'foto-usuario']) ?>
            <span><b><?= Html::encode($resp['nombre'] . ' ' . $resp['apellido']) ?></b></span>
        </div>
    </div>
    <div class="respuesta-body">
        <?php if ($resp['tipo_evento'] === 'pregunta'): ?>
            <div class="evento-label"><b>Respuesta:</b></div>
            <div class="evento-texto"><?= Html::encode($resp['respuesta']) ?></div>
        <?php elseif ($resp['tipo_evento'] === 'debate'): ?>
            <div class="evento-label"><b>Opinión:</b></div>
            <div class="evento-texto"><?= Html::encode($resp['respuesta']) ?></div>
        <?php endif; ?>
    </div>
    <?php if ($esProfesor): ?>
        <div class="respuesta-puntuar">
            <button class="btn-puntuar" 
                data-evento-id="<?= $resp['evento_id'] ?>"
                data-usuario-id="<?= $resp['usuario_id'] ?>"
                data-tipo="<?= $resp['tipo_evento'] ?>"
                title="Puntuar <?= $resp['tipo_evento'] === 'pregunta' ? 'respuesta' : 'opinión' ?>">
                <span class="icono-puntuar">★</span>
            </button>
        </div>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<style>
.respuesta-card {
    border-radius: 12px;
    margin: 18px 0;
    padding: 18px 24px 12px 24px;
    box-shadow: 0 3px 16px 0 rgba(38, 42, 69, 0.08);
    border: 1px solid #eee;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.2s;
}
.respuesta-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.evento-icon {
    width: 48px; height: 48px; border-radius: 10px; margin-right: 16px; box-shadow: 0 2px 8px #ececec;
    background: #fff;
}
.evento-titulos { flex-grow: 1; margin-left: 8px; }
.evento-tipo { font-weight: bold; color: #4285F4; font-size: 17px; margin-right: 8px;}
.evento-id { color: #aaa; font-size: 12px; margin-left: 4px; }
.usuario-nombre { display: flex; align-items: center; }
.foto-usuario { width: 32px; height: 32px; border-radius: 50%; margin-right: 8px; border: 2px solid #fff; box-shadow: 0 2px 4px #ddd; }
.respuesta-body { margin-top: 12px; padding-left: 5px; }
.evento-label { font-weight: bold; color: #7d7d7d; font-size: 15px; }
.evento-texto { font-size: 15.5px; margin-top: 5px; color: #313131; }
.respuesta-puntuar {
    display: flex; justify-content: flex-end; align-items: center; margin-top: 10px;
}
.btn-puntuar {
    background: linear-gradient(90deg, #fee300, #ffd400);
    border: none;
    border-radius: 50%;
    padding: 10px 16px;
    box-shadow: 0 1px 5px #ececec;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
    outline: none;
    transition: box-shadow 0.18s;
}
.btn-puntuar:hover { box-shadow: 0 2px 12px #ffd40044; background: #fee300; }
.icono-puntuar { font-size: 22px; color: #fa6e00; }
</style>
